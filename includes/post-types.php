<?php

add_action( 'init', 'rozholy_companion_register_post_types' );
function rozholy_companion_register_post_types() {
	register_post_type(
		'rz_booking',
		array(
			'labels'        => array(
				'name'               => esc_html__( 'رزروها', 'rozholy-companion' ),
				'singular_name'      => esc_html__( 'رزرو', 'rozholy-companion' ),
				'add_new'            => esc_html__( 'افزودن رزرو', 'rozholy-companion' ),
				'add_new_item'       => esc_html__( 'افزودن رزرو جدید', 'rozholy-companion' ),
				'edit_item'          => esc_html__( 'ویرایش رزرو', 'rozholy-companion' ),
				'view_item'          => esc_html__( 'مشاهده رزرو', 'rozholy-companion' ),
				'search_items'       => esc_html__( 'جستجوی رزروها', 'rozholy-companion' ),
				'not_found'          => esc_html__( 'رزروی یافت نشد', 'rozholy-companion' ),
				'not_found_in_trash' => esc_html__( 'رزروی در زباله‌دان یافت نشد', 'rozholy-companion' ),
				'all_items'          => esc_html__( 'همه رزروها', 'rozholy-companion' ),
				'menu_name'          => esc_html__( 'رزروهای Rozholy', 'rozholy-companion' ),
			),
			'public'        => false,
			'show_ui'       => true,
			'show_in_menu'  => true,
			'menu_icon'     => 'dashicons-calendar-alt',
			'menu_position' => 25,
			'capabilities'  => array(
				'edit_post'          => 'manage_options',
				'read_post'          => 'manage_options',
				'delete_post'        => 'manage_options',
				'edit_posts'         => 'manage_options',
				'edit_others_posts'  => 'manage_options',
				'publish_posts'      => 'manage_options',
				'read_private_posts' => 'manage_options',
			),
			'supports'      => array( 'title', 'editor' ),
			'show_in_rest'  => true,
			'rest_base'     => 'rz-bookings',
		)
	);
}

add_filter( 'manage_rz_booking_posts_columns', 'rz_booking_columns' );
function rz_booking_columns( $columns ) {
	return array(
		'cb'           => '<input type="checkbox" />',
		'title'        => esc_html__( 'نام مشتری', 'rozholy-companion' ),
		'phone'        => esc_html__( 'شماره تماس', 'rozholy-companion' ),
		'service'      => esc_html__( 'خدمت', 'rozholy-companion' ),
		'booking_date' => esc_html__( 'تاریخ رزرو', 'rozholy-companion' ),
		'status'       => esc_html__( 'وضعیت', 'rozholy-companion' ),
		'date'         => esc_html__( 'تاریخ ثبت', 'rozholy-companion' ),
	);
}

add_action( 'manage_rz_booking_posts_custom_column', 'rz_booking_column_data', 10, 2 );
function rz_booking_column_data( $column, $post_id ) {
	switch ( $column ) {
		case 'phone':
			echo esc_html( get_post_meta( $post_id, '_booking_phone', true ) );
			break;
		case 'service':
			echo esc_html( get_post_meta( $post_id, '_booking_service', true ) );
			break;
		case 'booking_date':
			echo esc_html( get_post_meta( $post_id, '_booking_date', true ) );
			break;
		case 'status':
			$status = get_post_meta( $post_id, '_booking_status', true ) ?: 'pending';
			$labels = array(
				'pending'   => esc_html__( 'در انتظار', 'rozholy-companion' ),
				'confirmed' => esc_html__( 'تایید شده', 'rozholy-companion' ),
				'completed' => esc_html__( 'انجام شده', 'rozholy-companion' ),
				'cancelled' => esc_html__( 'لغو شده', 'rozholy-companion' ),
			);
			$colors = array(
				'pending'   => '#f59e0b',
				'confirmed' => '#10b981',
				'completed' => '#6366f1',
				'cancelled' => '#ef4444',
			);
			printf(
				'<span style="display:inline-block;padding:2px 10px;border-radius:999px;font-size:12px;font-weight:600;background:%s;color:#fff">%s</span>',
				esc_attr( $colors[ $status ] ?? '#6b7280' ),
				esc_html( $labels[ $status ] ?? $status )
			);
			break;
	}
}
