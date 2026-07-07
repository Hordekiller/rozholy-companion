<?php

add_action( 'rest_api_init', 'rozholy_companion_register_routes' );
function rozholy_companion_register_routes() {
	register_rest_route(
		'rozholy-companion/v1',
		'/bookings',
		array(
			'methods'             => 'GET',
			'callback'            => 'rozholy_companion_get_bookings',
			'permission_callback' => function () {
				return current_user_can( 'manage_options' ); },
		)
	);

	register_rest_route(
		'rozholy-companion/v1',
		'/bookings/(?P<id>\d+)',
		array(
			'methods'             => 'GET',
			'callback'            => 'rozholy_companion_get_booking',
			'permission_callback' => function () {
				return current_user_can( 'manage_options' ); },
		)
	);

	register_rest_route(
		'rozholy-companion/v1',
		'/bookings/(?P<id>\d+)/status',
		array(
			'methods'             => 'PUT',
			'callback'            => 'rozholy_companion_update_booking_status',
			'permission_callback' => function () {
				return current_user_can( 'manage_options' ); },
			'args'                => array(
				'status' => array(
					'required'          => true,
					'type'              => 'string',
					'enum'              => array( 'pending', 'confirmed', 'completed', 'cancelled' ),
					'sanitize_callback' => 'sanitize_text_field',
				),
			),
		)
	);

	register_rest_route(
		'rozholy-companion/v1',
		'/bookings/(?P<id>\d+)',
		array(
			'methods'             => 'DELETE',
			'callback'            => 'rozholy_companion_delete_booking',
			'permission_callback' => function () {
				return current_user_can( 'manage_options' ); },
		)
	);

	register_rest_route(
		'rozholy-companion/v1',
		'/stats',
		array(
			'methods'             => 'GET',
			'callback'            => 'rozholy_companion_get_stats',
			'permission_callback' => function () {
				return current_user_can( 'manage_options' ); },
		)
	);
}

function rozholy_companion_get_bookings( $request ) {
	$args = array(
		'post_type'      => 'rz_booking',
		'posts_per_page' => $request->get_param( 'per_page' ) ?: 20,
		'paged'          => $request->get_param( 'page' ) ?: 1,
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	if ( $status = $request->get_param( 'status' ) ) {
		$args['meta_query'] = array(
			array(
				'key'   => '_booking_status',
				'value' => $status,
			),
		);
	}

	$query = new WP_Query( $args );
	$items = array();

	foreach ( $query->posts as $post ) {
		$items[] = array(
			'id'          => $post->ID,
			'name'        => get_the_title( $post ),
			'phone'       => get_post_meta( $post->ID, '_booking_phone', true ),
			'service'     => get_post_meta( $post->ID, '_booking_service', true ),
			'bookingDate' => get_post_meta( $post->ID, '_booking_date', true ),
			'message'     => get_post_meta( $post->ID, '_booking_message', true ),
			'status'      => get_post_meta( $post->ID, '_booking_status', true ) ?: 'pending',
			'createdAt'   => get_the_date( 'c', $post ),
		);
	}

	return new WP_REST_Response(
		array(
			'items'      => $items,
			'total'      => $query->found_posts,
			'totalPages' => $query->max_num_pages,
		),
		200
	);
}

function rozholy_companion_get_booking( $request ) {
	$post = get_post( $request['id'] );
	if ( ! $post || $post->post_type !== 'rz_booking' ) {
		return new WP_Error( 'not_found', esc_html__( 'رزرو یافت نشد', 'rozholy-companion' ), array( 'status' => 404 ) );
	}

	return new WP_REST_Response(
		array(
			'id'          => $post->ID,
			'name'        => get_the_title( $post ),
			'phone'       => get_post_meta( $post->ID, '_booking_phone', true ),
			'service'     => get_post_meta( $post->ID, '_booking_service', true ),
			'bookingDate' => get_post_meta( $post->ID, '_booking_date', true ),
			'message'     => get_post_meta( $post->ID, '_booking_message', true ),
			'status'      => get_post_meta( $post->ID, '_booking_status', true ) ?: 'pending',
			'createdAt'   => get_the_date( 'c', $post ),
		),
		200
	);
}

function rozholy_companion_update_booking_status( $request ) {
	$post_id = $request['id'];
	$status  = $request->get_param( 'status' );

	update_post_meta( $post_id, '_booking_status', $status );

	return new WP_REST_Response(
		array(
			'success' => true,
			'message' => esc_html__( 'وضعیت به‌روزرسانی شد', 'rozholy-companion' ),
			'status'  => $status,
		),
		200
	);
}

function rozholy_companion_delete_booking( $request ) {
	wp_delete_post( $request['id'], true );
	return new WP_REST_Response( array( 'success' => true ), 200 );
}

function rozholy_companion_get_stats() {
	$counts = wp_count_posts( 'rz_booking' );
	return new WP_REST_Response(
		array(
			'total'     => $counts->publish ?? 0,
			'pending'   => number_format_i18n( wp_count_posts( 'rz_booking' )->publish ?? 0 ),
			'confirmed' => number_format_i18n( 0 ),
		),
		200
	);
}

add_action( 'rest_api_init', 'rozholy_companion_cart_route' );
function rozholy_companion_cart_route() {
	register_rest_route(
		'rozholy-companion/v1',
		'/cart-count',
		array(
			'methods'             => 'GET',
			'callback'            => 'rozholy_companion_get_cart_count',
			'permission_callback' => '__return_true',
		)
	);
}

function rozholy_companion_get_cart_count() {
	$count = 0;
	if ( class_exists( 'WooCommerce' ) && isset( WC()->cart ) ) {
		$count = WC()->cart->get_cart_contents_count();
	}
	return new WP_REST_Response( array( 'count' => absint( $count ) ), 200 );
}
