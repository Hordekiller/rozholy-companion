<?php
defined( 'ABSPATH' ) || exit;

add_action( 'rest_api_init', 'rozholy_companion_frontend_booking' );
function rozholy_companion_frontend_booking() {
	register_rest_route(
		'rozholy-companion/v1',
		'/submit-booking',
		array(
			'methods'             => 'POST',
			'callback'            => 'rozholy_companion_handle_submit_booking',
			'permission_callback' => '__return_true',
			'args'                => array(
				'_wpnonce' => array(
					'required'          => true,
					'sanitize_callback' => 'sanitize_text_field',
				),
				'name'     => array(
					'required'          => true,
					'sanitize_callback' => 'sanitize_text_field',
					'validate_callback' => function ( $v ) {
						return mb_strlen( trim( $v ) ) >= 2 && mb_strlen( trim( $v ) ) <= 100;
					},
				),
				'phone'    => array(
					'required'          => true,
					'sanitize_callback' => 'sanitize_text_field',
					'validate_callback' => function ( $v ) {
						return (bool) preg_match( '/^09\d{9}$/', trim( $v ) );
					},
				),
				'service'  => array(
					'sanitize_callback' => 'sanitize_text_field',
				),
				'date'     => array(
					'sanitize_callback' => 'sanitize_text_field',
				),
				'message'  => array(
					'sanitize_callback' => 'sanitize_textarea_field',
				),
			),
		)
	);
}

function rozholy_companion_handle_submit_booking( $request ) {
	if ( ! wp_verify_nonce(
		sanitize_key( wp_unslash( $request->get_param( '_wpnonce' ) ) ),
		'rozholy_booking_submit'
	) ) {
		return new WP_Error(
			'rozholy_companion_invalid_nonce',
			esc_html__( 'درخواست نامعتبر. لطفاً صفحه را مجدداً بارگذاری کنید.', 'rozholy-companion' ),
			array( 'status' => 403 )
		);
	}

	$rate_key = 'rozholy_booking_rate_' . sanitize_key( $request->get_param( 'phone' ) );
	$attempts = (int) get_transient( $rate_key );
	if ( $attempts >= 3 ) {
		return new WP_Error(
			'rozholy_companion_rate_limit',
			esc_html__( 'تعداد درخواست‌ها بیش از حد مجاز است. ۱۵ دقیقه صبر کنید.', 'rozholy-companion' ),
			array( 'status' => 429 )
		);
	}
	set_transient( $rate_key, $attempts + 1, 15 * MINUTE_IN_SECONDS );

	$data = array(
		'name'    => $request->get_param( 'name' ),
		'phone'   => $request->get_param( 'phone' ),
		'service' => $request->get_param( 'service' ) ?: '',
		'date'    => $request->get_param( 'date' ) ?: '',
		'message' => $request->get_param( 'message' ) ?: '',
	);

	$post_id = wp_insert_post(
		array(
			'post_title'  => sprintf(
				/* translators: 1: customer name, 2: phone number */
				esc_html__( 'رزرو - %1$s - %2$s', 'rozholy-companion' ),
				$data['name'],
				$data['phone']
			),
			'post_type'   => 'rz_booking',
			'post_status' => 'publish',
			'meta_input'  => array(
				'_booking_name'    => $data['name'],
				'_booking_phone'   => $data['phone'],
				'_booking_service' => $data['service'],
				'_booking_date'    => $data['date'],
				'_booking_message' => $data['message'],
				'_booking_status'  => 'pending',
			),
		)
	);

	if ( ! $post_id || is_wp_error( $post_id ) ) {
		return new WP_Error(
			'rozholy_companion_insert_failed',
			esc_html__( 'خطا در ثبت رزرو. لطفاً دوباره تلاش کنید.', 'rozholy-companion' ),
			array( 'status' => 500 )
		);
	}

	$admin_email = get_option( 'admin_email' );
	if ( $admin_email ) {
		wp_mail(
			$admin_email,
			sprintf(
				/* translators: %s: customer name */
				esc_html__( 'رزرو جدید از %s', 'rozholy-companion' ),
				$data['name']
			),
			sprintf(
				/* translators: 1: name, 2: phone, 3: service, 4: date, 5: message */
				esc_html__( "نام: %1\$s\nشماره: %2\$s\nخدمت: %3\$s\nتاریخ: %4\$s\nپیام: %5\$s", 'rozholy-companion' ),
				$data['name'],
				$data['phone'],
				$data['service'],
				$data['date'],
				$data['message']
			),
			array( 'Content-Type: text/plain; charset=UTF-8' )
		);
	}

	return new WP_REST_Response(
		array(
			'success' => true,
			'message' => esc_html__( 'درخواست شما با موفقیت ثبت شد.', 'rozholy-companion' ),
		),
		201
	);
}
