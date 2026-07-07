<?php

add_action('rest_api_init', 'rozholy_companion_frontend_booking');
function rozholy_companion_frontend_booking() {
    register_rest_route('rozholy-companion/v1', '/submit-booking', [
        'methods'             => 'POST',
        'callback'            => 'rozholy_companion_handle_submit_booking',
        'permission_callback' => '__return_true',
        'args'                => [
            'name'    => ['required' => true, 'sanitize_callback' => 'sanitize_text_field'],
            'phone'   => ['required' => true, 'sanitize_callback' => 'sanitize_text_field'],
            'service' => ['sanitize_callback' => 'sanitize_text_field'],
            'date'    => ['sanitize_callback' => 'sanitize_text_field'],
            'message' => ['sanitize_callback' => 'sanitize_textarea_field'],
        ],
    ]);
}

function rozholy_companion_handle_submit_booking($request) {
    $data = [
        'name'    => $request->get_param('name'),
        'phone'   => $request->get_param('phone'),
        'service' => $request->get_param('service') ?: '',
        'date'    => $request->get_param('date') ?: '',
        'message' => $request->get_param('message') ?: '',
    ];

    $post_id = wp_insert_post([
        'post_title'  => sprintf(esc_html__('رزرو - %s - %s', 'rozholy-companion'), $data['name'], $data['phone']),
        'post_type'   => 'rz_booking',
        'post_status' => 'publish',
        'meta_input'  => [
            '_booking_name'    => $data['name'],
            '_booking_phone'   => $data['phone'],
            '_booking_service' => $data['service'],
            '_booking_date'    => $data['date'],
            '_booking_message' => $data['message'],
            '_booking_status'  => 'pending',
        ],
    ]);

    if (!$post_id) {
        return new WP_Error('insert_failed', esc_html__('خطا در ثبت رزرو', 'rozholy-companion'), ['status' => 500]);
    }

    $admin_email = get_option('admin_email');
    wp_mail($admin_email, sprintf(esc_html__('رزرو جدید از %s', 'rozholy-companion'), $data['name']),
        sprintf(
            "نام: %s\nشماره: %s\nخدمت: %s\nتاریخ: %s\nپیام: %s",
            $data['name'], $data['phone'], $data['service'], $data['date'], $data['message']
        ),
        ['Content-Type: text/plain; charset=UTF-8']
    );

    return new WP_REST_Response([
        'success' => true,
        'message' => esc_html__('درخواست شما با موفقیت ثبت شد.', 'rozholy-companion'),
    ], 201);
}
