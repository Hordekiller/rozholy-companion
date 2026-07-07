<?php

add_action('rest_api_init', 'rozholy_companion_register_routes');
function rozholy_companion_register_routes() {
    register_rest_route('rozholy-companion/v1', '/bookings', [
        'methods'             => 'GET',
        'callback'            => 'rozholy_companion_get_bookings',
        'permission_callback' => function () { return current_user_can('manage_options'); },
    ]);

    register_rest_route('rozholy-companion/v1', '/bookings/(?P<id>\d+)', [
        'methods'             => 'GET',
        'callback'            => 'rozholy_companion_get_booking',
        'permission_callback' => function () { return current_user_can('manage_options'); },
    ]);

    register_rest_route('rozholy-companion/v1', '/bookings/(?P<id>\d+)/status', [
        'methods'             => 'PUT',
        'callback'            => 'rozholy_companion_update_booking_status',
        'permission_callback' => function () { return current_user_can('manage_options'); },
        'args'                => [
            'status' => [
                'required'          => true,
                'type'              => 'string',
                'enum'              => ['pending', 'confirmed', 'completed', 'cancelled'],
                'sanitize_callback' => 'sanitize_text_field',
            ],
        ],
    ]);

    register_rest_route('rozholy-companion/v1', '/bookings/(?P<id>\d+)', [
        'methods'             => 'DELETE',
        'callback'            => 'rozholy_companion_delete_booking',
        'permission_callback' => function () { return current_user_can('manage_options'); },
    ]);

    register_rest_route('rozholy-companion/v1', '/stats', [
        'methods'             => 'GET',
        'callback'            => 'rozholy_companion_get_stats',
        'permission_callback' => function () { return current_user_can('manage_options'); },
    ]);
}

function rozholy_companion_get_bookings($request) {
    $args = [
        'post_type'      => 'rz_booking',
        'posts_per_page' => $request->get_param('per_page') ?: 20,
        'paged'          => $request->get_param('page') ?: 1,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];

    if ($status = $request->get_param('status')) {
        $args['meta_query'] = [
            ['key' => '_booking_status', 'value' => $status],
        ];
    }

    $query = new WP_Query($args);
    $items = [];

    foreach ($query->posts as $post) {
        $items[] = [
            'id'          => $post->ID,
            'name'        => get_the_title($post),
            'phone'       => get_post_meta($post->ID, '_booking_phone', true),
            'service'     => get_post_meta($post->ID, '_booking_service', true),
            'bookingDate' => get_post_meta($post->ID, '_booking_date', true),
            'message'     => get_post_meta($post->ID, '_booking_message', true),
            'status'      => get_post_meta($post->ID, '_booking_status', true) ?: 'pending',
            'createdAt'   => get_the_date('c', $post),
        ];
    }

    return new WP_REST_Response([
        'items'      => $items,
        'total'      => $query->found_posts,
        'totalPages' => $query->max_num_pages,
    ], 200);
}

function rozholy_companion_get_booking($request) {
    $post = get_post($request['id']);
    if (!$post || $post->post_type !== 'rz_booking') {
        return new WP_Error('not_found', esc_html__('رزرو یافت نشد', 'rozholy-companion'), ['status' => 404]);
    }

    return new WP_REST_Response([
        'id'          => $post->ID,
        'name'        => get_the_title($post),
        'phone'       => get_post_meta($post->ID, '_booking_phone', true),
        'service'     => get_post_meta($post->ID, '_booking_service', true),
        'bookingDate' => get_post_meta($post->ID, '_booking_date', true),
        'message'     => get_post_meta($post->ID, '_booking_message', true),
        'status'      => get_post_meta($post->ID, '_booking_status', true) ?: 'pending',
        'createdAt'   => get_the_date('c', $post),
    ], 200);
}

function rozholy_companion_update_booking_status($request) {
    $post_id = $request['id'];
    $status  = $request->get_param('status');

    update_post_meta($post_id, '_booking_status', $status);

    return new WP_REST_Response([
        'success' => true,
        'message' => esc_html__('وضعیت به‌روزرسانی شد', 'rozholy-companion'),
        'status'  => $status,
    ], 200);
}

function rozholy_companion_delete_booking($request) {
    wp_delete_post($request['id'], true);
    return new WP_REST_Response(['success' => true], 200);
}

function rozholy_companion_get_stats() {
    $counts = wp_count_posts('rz_booking');
    return new WP_REST_Response([
        'total'     => $counts->publish ?? 0,
        'pending'   => number_format_i18n(wp_count_posts('rz_booking')->publish ?? 0),
        'confirmed' => number_format_i18n(0),
    ], 200);
}
