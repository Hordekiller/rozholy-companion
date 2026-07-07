<?php
defined( 'ABSPATH' ) || exit;

add_action( 'rest_api_init', 'rozholy_companion_otp_routes' );
function rozholy_companion_otp_routes() {
	register_rest_route(
		'rozholy-companion/v1',
		'/otp/request',
		array(
			'methods'             => 'POST',
			'callback'            => 'rozholy_companion_otp_request',
			'permission_callback' => '__return_true',
			'args'                => array(
				'phone' => array(
					'required'          => true,
					'sanitize_callback' => 'sanitize_text_field',
					'validate_callback' => function ( $v ) {
						return (bool) preg_match( '/^09\d{9}$/', $v );
					},
				),
			),
		)
	);

	register_rest_route(
		'rozholy-companion/v1',
		'/otp/verify',
		array(
			'methods'             => 'POST',
			'callback'            => 'rozholy_companion_otp_verify',
			'permission_callback' => '__return_true',
			'args'                => array(
				'phone' => array(
					'required'          => true,
					'sanitize_callback' => 'sanitize_text_field',
				),
				'code'  => array(
					'required'          => true,
					'sanitize_callback' => 'sanitize_text_field',
					'validate_callback' => function ( $v ) {
						return (bool) preg_match( '/^\d{6}$/', $v );
					},
				),
			),
		)
	);
}

function rozholy_companion_send_sms( $phone, $message ) {
	$sms = get_option( 'rozholy_companion_sms', array() );
	if ( empty( $sms['api_key'] ) || empty( $sms['sender'] ) ) {
		return new WP_Error( 'rozholy_companion_not_initialized', esc_html__( 'تنظیمات پیامک انجام نشده است.', 'rozholy-companion' ) );
	}

	$response = wp_remote_post(
		'https://api.sms.ir/v1/send/bulk',
		array(
			'headers' => array(
				'Content-Type' => 'application/json',
				'X-API-KEY'    => $sms['api_key'],
			),
			'body'    => wp_json_encode(
				array(
					'sender'   => $sms['sender'],
					'receptor' => array( $phone ),
					'message'  => $message,
				)
			),
			'timeout' => 15,
		)
	);

	if ( is_wp_error( $response ) ) {
		return new WP_Error( 'rozholy_companion_data_unavailable', esc_html__( 'ارسال پیامک با خطا مواجه شد.', 'rozholy-companion' ) );
	}

	$body = json_decode( wp_remote_retrieve_body( $response ), true );
	if ( empty( $body['status'] ) || 1 !== (int) $body['status'] ) {
		return new WP_Error( 'rozholy_companion_data_unavailable', esc_html__( 'خطا از سرویس پیامک.', 'rozholy-companion' ) );
	}

	return true;
}

function rozholy_companion_otp_request( $request ) {
	$phone = $request->get_param( 'phone' );

	$rate_key = 'rozholy_otp_rate_' . sanitize_key( $phone );
	$attempts = (int) get_transient( $rate_key );

	if ( $attempts >= 5 ) {
		return new WP_Error( 'rozholy_companion_invalid_phone', esc_html__( 'تعداد درخواست‌ها بیش از حد مجاز است. ۱۵ دقیقه صبر کنید.', 'rozholy-companion' ) );
	}

	$code = wp_rand( 100000, 999999 );
	set_transient( 'rozholy_otp_' . $phone, $code, 5 * MINUTE_IN_SECONDS );
	set_transient( $rate_key, $attempts + 1, 15 * MINUTE_IN_SECONDS );

	$message = sprintf( esc_html__( 'کد ورود شما به %1$s: %2$s', 'rozholy-companion' ), get_bloginfo( 'name' ), $code );

	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		return new WP_REST_Response(
			array(
				'success' => true,
				'message' => esc_html__( 'کد تأیید ارسال شد.', 'rozholy-companion' ),
				'code'    => (string) $code,
			),
			200
		);
	}

	$sent = rozholy_companion_send_sms( $phone, $message );
	if ( is_wp_error( $sent ) ) {
		return $sent;
	}

	return new WP_REST_Response(
		array(
			'success' => true,
			'message' => esc_html__( 'کد تأیید ارسال شد.', 'rozholy-companion' ),
		),
		200
	);
}

function rozholy_companion_otp_verify( $request ) {
	$phone = $request->get_param( 'phone' );
	$code  = $request->get_param( 'code' );

	$stored = get_transient( 'rozholy_otp_' . $phone );

	if ( false === $stored ) {
		return new WP_Error( 'rozholy_companion_invalid_phone', esc_html__( 'کد منقضی شده یا نامعتبر است.', 'rozholy-companion' ) );
	}

	if ( ! hash_equals( (string) $stored, $code ) ) {
		return new WP_Error( 'rozholy_companion_invalid_phone', esc_html__( 'کد وارد شده اشتباه است.', 'rozholy-companion' ) );
	}

	$user = get_user_by( 'login', $phone );
	if ( ! $user ) {
		$user_id = wp_insert_user(
			array(
				'user_login'   => $phone,
				'user_pass'    => wp_generate_password(),
				'display_name' => $phone,
				'role'         => 'subscriber',
			)
		);
		if ( is_wp_error( $user_id ) ) {
			return new WP_Error( 'rozholy_companion_not_initialized', esc_html__( 'خطا در ایجاد حساب کاربری.', 'rozholy-companion' ) );
		}
		$user = get_user_by( 'ID', $user_id );
	}

	wp_set_auth_cookie( $user->ID );
	delete_transient( 'rozholy_otp_' . $phone );

	return new WP_REST_Response(
		array(
			'success' => true,
			'message' => esc_html__( 'ورود موفقیت‌آمیز بود.', 'rozholy-companion' ),
			'user_id' => $user->ID,
		),
		200
	);
}
