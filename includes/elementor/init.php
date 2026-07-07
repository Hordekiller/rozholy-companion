<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! did_action( 'elementor/loaded' ) ) {
	return;
}

add_action( 'elementor/elements/categories_registered', 'rozholy_companion_add_elementor_category' );
function rozholy_companion_add_elementor_category( $elements_manager ) {
	$elements_manager->add_category(
		'rozholy-salon',
		array(
			'title' => esc_html__( 'Rozholy Salon', 'rozholy-companion' ),
			'icon'  => 'fa fa-spa',
		)
	);
}

add_action( 'elementor/widgets/register', 'rozholy_companion_register_elementor_widgets' );
function rozholy_companion_register_elementor_widgets( $widgets_manager ) {
	$widget_files = glob( ROZHOLY_COMPANION_DIR . 'includes/elementor/widgets/widget-*.php' );
	foreach ( $widget_files as $file ) {
		require_once $file;
	}

	$widgets = array(
		'Rozholy_Widget_Hero_Banner',
		'Rozholy_Widget_Promo_Banner',
		'Rozholy_Widget_Banner_Slider',
		'Rozholy_Widget_Section_Heading',
		'Rozholy_Widget_Service_Card',
		'Rozholy_Widget_Services_Grid',
		'Rozholy_Widget_Pricing_Table',
		'Rozholy_Widget_Products_Grid',
		'Rozholy_Widget_Testimonial_Card',
		'Rozholy_Widget_Testimonials_Slider',
		'Rozholy_Widget_Team_Member',
		'Rozholy_Widget_Team_Grid',
		'Rozholy_Widget_Stats_Counter',
		'Rozholy_Widget_Gallery_Grid',
		'Rozholy_Widget_Before_After',
		'Rozholy_Widget_Video_Popup',
		'Rozholy_Widget_Instagram_Feed',
		'Rozholy_Widget_Brands_Carousel',
		'Rozholy_Widget_Booking_Form',
		'Rozholy_Widget_Opening_Hours',
		'Rozholy_Widget_Contact_Info',
		'Rozholy_Widget_Newsletter_Form',
		'Rozholy_Widget_FAQ_Accordion',
		'Rozholy_Widget_Social_Links',
		'Rozholy_Widget_Highlight_Box',
		'Rozholy_Widget_Step_By_Step',
		'Rozholy_Widget_Empty_State',
		'Rozholy_Widget_Floating_Contact',
		'Rozholy_Widget_Gift_Card',
		'Rozholy_Widget_Loyalty_Card',
		'Rozholy_Widget_Special_Offer',
		'Rozholy_Widget_Progress_Bar',
		'Rozholy_Widget_About_Section',
		'Rozholy_Widget_Cta_Banner',
	);

	foreach ( $widgets as $class ) {
		if ( class_exists( $class ) ) {
			$widgets_manager->register( new $class() );
		}
	}
}
