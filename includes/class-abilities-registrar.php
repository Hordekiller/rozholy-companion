<?php
defined( 'ABSPATH' ) || exit;

class Rozholy_Companion_Abilities_Registrar {

	public static function register_category() {
		wp_register_ability_category(
			'rozholy-companion',
			array(
				'label' => esc_html__( 'Rozholy Companion', 'rozholy-companion' ),
			)
		);
	}

	public static function register_abilities() {
		$abilities = array(
			'rozholy-companion/list-bookings'         => array(
				'label'               => esc_html__( 'List Bookings', 'rozholy-companion' ),
				'description'         => esc_html__( 'List salon bookings with optional status, page, and per_page filters.', 'rozholy-companion' ),
				'category'            => 'rozholy-companion',
				'input_schema'        => array(
					'type'                 => 'object',
					'additionalProperties' => false,
					'default'              => (object) array(),
					'properties'           => array(
						'status'   => array(
							'type'        => 'string',
							'enum'        => array( 'pending', 'confirmed', 'completed', 'cancelled' ),
							'description' => esc_html__( 'Filter by booking status.', 'rozholy-companion' ),
						),
						'page'     => array(
							'type'        => 'integer',
							'default'     => 1,
							'description' => esc_html__( 'Page number for pagination.', 'rozholy-companion' ),
						),
						'per_page' => array(
							'type'        => 'integer',
							'default'     => 20,
							'description' => esc_html__( 'Results per page.', 'rozholy-companion' ),
						),
					),
				),
				'execute_callback'    => array( self::class, 'execute_list_bookings' ),
				'permission_callback' => array( self::class, 'check_admin' ),
				'meta'                => array(
					'show_in_rest' => true,
					'annotations'  => array(
						'readonly'    => true,
						'destructive' => false,
						'idempotent'  => true,
					),
				),
			),

			'rozholy-companion/get-booking'           => array(
				'label'               => esc_html__( 'Get Booking', 'rozholy-companion' ),
				'description'         => esc_html__( 'Get a single booking by ID.', 'rozholy-companion' ),
				'category'            => 'rozholy-companion',
				'input_schema'        => array(
					'type'                 => 'object',
					'additionalProperties' => false,
					'default'              => (object) array(),
					'properties'           => array(
						'id' => array(
							'type'        => 'integer',
							'required'    => true,
							'description' => esc_html__( 'The booking ID.', 'rozholy-companion' ),
						),
					),
				),
				'execute_callback'    => array( self::class, 'execute_get_booking' ),
				'permission_callback' => array( self::class, 'check_admin' ),
				'meta'                => array(
					'show_in_rest' => true,
					'annotations'  => array(
						'readonly'    => true,
						'destructive' => false,
						'idempotent'  => true,
					),
				),
			),

			'rozholy-companion/get-stats'             => array(
				'label'               => esc_html__( 'Get Booking Stats', 'rozholy-companion' ),
				'description'         => esc_html__( 'Get booking statistics — total count.', 'rozholy-companion' ),
				'category'            => 'rozholy-companion',
				'input_schema'        => array(
					'type'                 => 'object',
					'additionalProperties' => false,
					'default'              => (object) array(),
					'properties'           => array(),
				),
				'execute_callback'    => array( self::class, 'execute_get_stats' ),
				'permission_callback' => array( self::class, 'check_admin' ),
				'meta'                => array(
					'show_in_rest' => true,
					'annotations'  => array(
						'readonly'    => true,
						'destructive' => false,
						'idempotent'  => true,
					),
				),
			),

			'rozholy-companion/update-booking-status' => array(
				'label'               => esc_html__( 'Update Booking Status', 'rozholy-companion' ),
				'description'         => esc_html__( 'Update a booking\'s status (pending, confirmed, completed, cancelled).', 'rozholy-companion' ),
				'category'            => 'rozholy-companion',
				'input_schema'        => array(
					'type'                 => 'object',
					'additionalProperties' => false,
					'default'              => (object) array(),
					'properties'           => array(
						'id'     => array(
							'type'        => 'integer',
							'required'    => true,
							'description' => esc_html__( 'The booking ID.', 'rozholy-companion' ),
						),
						'status' => array(
							'type'        => 'string',
							'required'    => true,
							'enum'        => array( 'pending', 'confirmed', 'completed', 'cancelled' ),
							'description' => esc_html__( 'New status value.', 'rozholy-companion' ),
						),
					),
				),
				'execute_callback'    => array( self::class, 'execute_update_booking_status' ),
				'permission_callback' => array( self::class, 'check_admin' ),
				'meta'                => array(
					'show_in_rest' => true,
					'annotations'  => array(
						'readonly'    => false,
						'destructive' => false,
						'idempotent'  => false,
					),
				),
			),

			'rozholy-companion/delete-booking'        => array(
				'label'               => esc_html__( 'Delete Booking', 'rozholy-companion' ),
				'description'         => esc_html__( 'Permanently delete a booking by ID.', 'rozholy-companion' ),
				'category'            => 'rozholy-companion',
				'input_schema'        => array(
					'type'                 => 'object',
					'additionalProperties' => false,
					'default'              => (object) array(),
					'properties'           => array(
						'id' => array(
							'type'        => 'integer',
							'required'    => true,
							'description' => esc_html__( 'The booking ID to delete.', 'rozholy-companion' ),
						),
					),
				),
				'execute_callback'    => array( self::class, 'execute_delete_booking' ),
				'permission_callback' => array( self::class, 'check_admin' ),
				'meta'                => array(
					'show_in_rest' => true,
					'annotations'  => array(
						'readonly'    => false,
						'destructive' => true,
						'idempotent'  => false,
					),
				),
			),

			'rozholy-companion/submit-booking'        => array(
				'label'               => esc_html__( 'Submit Booking', 'rozholy-companion' ),
				'description'         => esc_html__( 'Submit a new booking request from the public-facing form.', 'rozholy-companion' ),
				'category'            => 'rozholy-companion',
				'input_schema'        => array(
					'type'                 => 'object',
					'additionalProperties' => false,
					'default'              => (object) array(),
					'properties'           => array(
						'name'    => array(
							'type'        => 'string',
							'required'    => true,
							'description' => esc_html__( 'Customer name.', 'rozholy-companion' ),
						),
						'phone'   => array(
							'type'        => 'string',
							'required'    => true,
							'description' => esc_html__( 'Customer phone number.', 'rozholy-companion' ),
						),
						'service' => array(
							'type'        => 'string',
							'description' => esc_html__( 'Requested service name.', 'rozholy-companion' ),
						),
						'date'    => array(
							'type'        => 'string',
							'description' => esc_html__( 'Requested appointment date and time.', 'rozholy-companion' ),
						),
						'message' => array(
							'type'        => 'string',
							'description' => esc_html__( 'Additional customer message.', 'rozholy-companion' ),
						),
					),
				),
				'execute_callback'    => array( self::class, 'execute_submit_booking' ),
				'permission_callback' => '__return_true',
				'meta'                => array(
					'show_in_rest' => true,
					'annotations'  => array(
						'readonly'    => false,
						'destructive' => false,
						'idempotent'  => false,
					),
				),
			),

			'rozholy-companion/request-otp'           => array(
				'label'               => esc_html__( 'Request OTP Code', 'rozholy-companion' ),
				'description'         => esc_html__( 'Request a one-time password sent via SMS for login.', 'rozholy-companion' ),
				'category'            => 'rozholy-companion',
				'input_schema'        => array(
					'type'                 => 'object',
					'additionalProperties' => false,
					'default'              => (object) array(),
					'properties'           => array(
						'phone' => array(
							'type'        => 'string',
							'required'    => true,
							'description' => esc_html__( 'Phone number in Iranian format (09xxxxxxxxx).', 'rozholy-companion' ),
						),
					),
				),
				'execute_callback'    => array( self::class, 'execute_request_otp' ),
				'permission_callback' => '__return_true',
				'meta'                => array(
					'show_in_rest' => true,
					'annotations'  => array(
						'readonly'    => false,
						'destructive' => false,
						'idempotent'  => false,
					),
				),
			),

			'rozholy-companion/verify-otp'            => array(
				'label'               => esc_html__( 'Verify OTP Code', 'rozholy-companion' ),
				'description'         => esc_html__( 'Verify a one-time password and log the user in.', 'rozholy-companion' ),
				'category'            => 'rozholy-companion',
				'input_schema'        => array(
					'type'                 => 'object',
					'additionalProperties' => false,
					'default'              => (object) array(),
					'properties'           => array(
						'phone' => array(
							'type'        => 'string',
							'required'    => true,
							'description' => esc_html__( 'Phone number used in the OTP request.', 'rozholy-companion' ),
						),
						'code'  => array(
							'type'        => 'string',
							'required'    => true,
							'description' => esc_html__( 'The 6-digit OTP code received via SMS.', 'rozholy-companion' ),
						),
					),
				),
				'execute_callback'    => array( self::class, 'execute_verify_otp' ),
				'permission_callback' => '__return_true',
				'meta'                => array(
					'show_in_rest' => true,
					'annotations'  => array(
						'readonly'    => false,
						'destructive' => false,
						'idempotent'  => false,
					),
				),
			),
		);

		foreach ( $abilities as $name => $args ) {
			wp_register_ability( $name, $args );
		}
	}

	/* ── Permission callbacks ── */

	public static function check_admin() {
		return current_user_can( 'manage_options' );
	}

	/* ── Execute callbacks ── */

	public static function execute_list_bookings( $input = null ) {
		$input = is_array( $input ) ? $input : array();

		$request = new WP_REST_Request( 'GET', '/rozholy-companion/v1/bookings' );
		foreach ( $input as $key => $value ) {
			$request->set_param( $key, $value );
		}

		$response = rozholy_companion_get_bookings( $request );
		if ( is_wp_error( $response ) ) {
			return $response;
		}
		$data = $response->get_data();
		return is_array( $data ) ? $data : array();
	}

	public static function execute_get_booking( $input = null ) {
		$input = is_array( $input ) ? $input : array();

		if ( ! isset( $input['id'] ) || ! is_numeric( $input['id'] ) || (int) $input['id'] <= 0 ) {
			return new WP_Error(
				'rozholy_companion_missing_id',
				esc_html__( 'A booking id is required.', 'rozholy-companion' )
			);
		}

		$request = new WP_REST_Request( 'GET', '/rozholy-companion/v1/bookings/' . (int) $input['id'] );
		$request->set_param( 'id', (int) $input['id'] );

		$response = rozholy_companion_get_booking( $request );
		if ( is_wp_error( $response ) ) {
			return $response;
		}
		$data = $response->get_data();
		return is_array( $data ) ? $data : array();
	}

	public static function execute_get_stats( $input = null ) {
		$request = new WP_REST_Request( 'GET', '/rozholy-companion/v1/stats' );

		$response = rozholy_companion_get_stats( $request );
		if ( is_wp_error( $response ) ) {
			return $response;
		}
		$data = $response->get_data();
		return is_array( $data ) ? $data : array();
	}

	public static function execute_update_booking_status( $input = null ) {
		$input = is_array( $input ) ? $input : array();

		if ( ! isset( $input['id'] ) || ! is_numeric( $input['id'] ) || (int) $input['id'] <= 0 ) {
			return new WP_Error(
				'rozholy_companion_missing_id',
				esc_html__( 'A booking id is required.', 'rozholy-companion' )
			);
		}
		if ( ! isset( $input['status'] ) || ! is_string( $input['status'] ) || '' === $input['status'] ) {
			return new WP_Error(
				'rozholy_companion_missing_status',
				esc_html__( 'A status value is required.', 'rozholy-companion' )
			);
		}

		$valid_statuses = array( 'pending', 'confirmed', 'completed', 'cancelled' );
		if ( ! in_array( $input['status'], $valid_statuses, true ) ) {
			return new WP_Error(
				'rozholy_companion_invalid_status',
				esc_html__( 'Invalid status value.', 'rozholy-companion' )
			);
		}

		$request = new WP_REST_Request( 'PUT', '/rozholy-companion/v1/bookings/' . (int) $input['id'] . '/status' );
		$request->set_param( 'id', (int) $input['id'] );
		$request->set_param( 'status', $input['status'] );

		$response = rozholy_companion_update_booking_status( $request );
		if ( is_wp_error( $response ) ) {
			return $response;
		}
		$data = $response->get_data();
		return is_array( $data ) ? $data : array();
	}

	public static function execute_delete_booking( $input = null ) {
		$input = is_array( $input ) ? $input : array();

		if ( ! isset( $input['id'] ) || ! is_numeric( $input['id'] ) || (int) $input['id'] <= 0 ) {
			return new WP_Error(
				'rozholy_companion_missing_id',
				esc_html__( 'A booking id is required.', 'rozholy-companion' )
			);
		}

		$request = new WP_REST_Request( 'DELETE', '/rozholy-companion/v1/bookings/' . (int) $input['id'] );
		$request->set_param( 'id', (int) $input['id'] );

		$response = rozholy_companion_delete_booking( $request );
		if ( is_wp_error( $response ) ) {
			return $response;
		}
		$data = $response->get_data();
		return is_array( $data ) ? $data : array();
	}

	public static function execute_submit_booking( $input = null ) {
		$input = is_array( $input ) ? $input : array();

		if ( ! isset( $input['name'] ) || ! is_string( $input['name'] ) || '' === $input['name'] ) {
			return new WP_Error(
				'rozholy_companion_missing_name',
				esc_html__( 'Customer name is required.', 'rozholy-companion' )
			);
		}
		if ( ! isset( $input['phone'] ) || ! is_string( $input['phone'] ) || '' === $input['phone'] ) {
			return new WP_Error(
				'rozholy_companion_missing_phone',
				esc_html__( 'Phone number is required.', 'rozholy-companion' )
			);
		}

		$post_id = wp_insert_post(
			array(
				'post_title'  => sprintf( esc_html__( 'رزرو - %1$s - %2$s', 'rozholy-companion' ), $input['name'], $input['phone'] ),
				'post_type'   => 'rz_booking',
				'post_status' => 'publish',
				'meta_input'  => array(
					'_booking_name'    => sanitize_text_field( $input['name'] ),
					'_booking_phone'   => sanitize_text_field( $input['phone'] ),
					'_booking_service' => isset( $input['service'] ) ? sanitize_text_field( $input['service'] ) : '',
					'_booking_date'    => isset( $input['date'] ) ? sanitize_text_field( $input['date'] ) : '',
					'_booking_message' => isset( $input['message'] ) ? sanitize_textarea_field( $input['message'] ) : '',
					'_booking_status'  => 'pending',
				),
			)
		);

		if ( ! $post_id ) {
			return new WP_Error(
				'rozholy_companion_data_unavailable',
				esc_html__( 'خطا در ثبت رزرو.', 'rozholy-companion' )
			);
		}

		$admin_email = get_option( 'admin_email' );
		wp_mail(
			$admin_email,
			sprintf( esc_html__( 'رزرو جدید از %s', 'rozholy-companion' ), $input['name'] ),
			sprintf(
				"نام: %s\nشماره: %s\nخدمت: %s\nتاریخ: %s\nپیام: %s",
				$input['name'],
				$input['phone'],
				$input['service'] ?? '',
				$input['date'] ?? '',
				$input['message'] ?? ''
			),
			array( 'Content-Type: text/plain; charset=UTF-8' )
		);

		return array(
			'success' => true,
			'message' => esc_html__( 'درخواست شما با موفقیت ثبت شد.', 'rozholy-companion' ),
			'id'      => $post_id,
		);
	}

	public static function execute_request_otp( $input = null ) {
		if ( ! is_array( $input ) || ! isset( $input['phone'] ) || ! is_string( $input['phone'] ) || '' === $input['phone'] ) {
			return new WP_Error(
				'rozholy_companion_missing_phone',
				esc_html__( 'Phone number is required.', 'rozholy-companion' )
			);
		}

		if ( ! preg_match( '/^09\d{9}$/', $input['phone'] ) ) {
			return new WP_Error(
				'rozholy_companion_invalid_phone',
				esc_html__( 'Invalid phone number format.', 'rozholy-companion' )
			);
		}

		$phone    = $input['phone'];
		$rate_key = 'rozholy_otp_rate_' . sanitize_key( $phone );
		$attempts = (int) get_transient( $rate_key );

		if ( $attempts >= 5 ) {
			return new WP_Error(
				'rozholy_companion_invalid_phone',
				esc_html__( 'تعداد درخواست‌ها بیش از حد مجاز است. ۱۵ دقیقه صبر کنید.', 'rozholy-companion' )
			);
		}

		$code = wp_rand( 100000, 999999 );
		set_transient( 'rozholy_otp_' . $phone, $code, 5 * MINUTE_IN_SECONDS );
		set_transient( $rate_key, $attempts + 1, 15 * MINUTE_IN_SECONDS );

		$message = sprintf( esc_html__( 'کد ورود شما به %1$s: %2$s', 'rozholy-companion' ), get_bloginfo( 'name' ), $code );

		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			return array(
				'success' => true,
				'message' => esc_html__( 'کد تأیید ارسال شد.', 'rozholy-companion' ),
				'code'    => (string) $code,
			);
		}

		$sent = rozholy_companion_send_sms( $phone, $message );
		if ( is_wp_error( $sent ) ) {
			return $sent;
		}

		return array(
			'success' => true,
			'message' => esc_html__( 'کد تأیید ارسال شد.', 'rozholy-companion' ),
		);
	}

	public static function execute_verify_otp( $input = null ) {
		if ( ! is_array( $input ) ) {
			return new WP_Error(
				'rozholy_companion_missing_phone',
				esc_html__( 'Phone and code are required.', 'rozholy-companion' )
			);
		}

		if ( ! isset( $input['phone'] ) || ! is_string( $input['phone'] ) || '' === $input['phone'] ) {
			return new WP_Error(
				'rozholy_companion_missing_phone',
				esc_html__( 'Phone number is required.', 'rozholy-companion' )
			);
		}
		if ( ! isset( $input['code'] ) || ! is_string( $input['code'] ) || '' === $input['code'] ) {
			return new WP_Error(
				'rozholy_companion_missing_code',
				esc_html__( 'OTP code is required.', 'rozholy-companion' )
			);
		}

		$phone = $input['phone'];
		$code  = $input['code'];

		$stored = get_transient( 'rozholy_otp_' . $phone );
		if ( false === $stored ) {
			return new WP_Error(
				'rozholy_companion_invalid_phone',
				esc_html__( 'کد منقضی شده یا نامعتبر است.', 'rozholy-companion' )
			);
		}

		if ( ! hash_equals( (string) $stored, $code ) ) {
			return new WP_Error(
				'rozholy_companion_invalid_phone',
				esc_html__( 'کد وارد شده اشتباه است.', 'rozholy-companion' )
			);
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
				return new WP_Error(
					'rozholy_companion_not_initialized',
					esc_html__( 'خطا در ایجاد حساب کاربری.', 'rozholy-companion' )
				);
			}
			$user = get_user_by( 'ID', $user_id );
		}

		wp_set_auth_cookie( $user->ID );
		delete_transient( 'rozholy_otp_' . $phone );

		return array(
			'success' => true,
			'message' => esc_html__( 'ورود موفقیت‌آمیز بود.', 'rozholy-companion' ),
			'user_id' => $user->ID,
		);
	}
}
