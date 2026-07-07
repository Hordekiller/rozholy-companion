<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

$delete_data = get_option( 'rozholy_companion_remove_data_on_uninstall', '0' );

if ( '1' === $delete_data ) {
	$bookings = get_posts(
		array(
			'post_type'      => 'rz_booking',
			'posts_per_page' => -1,
			'fields'         => 'ids',
			'post_status'    => 'any',
		)
	);

	foreach ( $bookings as $booking_id ) {
		wp_delete_post( $booking_id, true );
	}

	delete_option( 'rozholy_companion_db_version' );
	delete_option( 'rozholy_companion_remove_data_on_uninstall' );

	wp_clear_scheduled_hook( 'rozholy_companion_daily_cleanup' );
}
