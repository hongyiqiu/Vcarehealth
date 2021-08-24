<?php
/**
 * Custom header implementation
 */

function child_care_kindergarten_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'child_care_kindergarten_custom_header_args', array(
		'default-text-color'     => 'fff',
		'header-text' 			 =>	false,
		'width'                  => 1200,
		'height'                 => 220,
		'wp-head-callback'       => 'child_care_kindergarten_header_style',
	) ) );
}

add_action( 'after_setup_theme', 'child_care_kindergarten_custom_header_setup' );

if ( ! function_exists( 'child_care_kindergarten_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see child_care_kindergarten_custom_header_setup().
 */
add_action( 'wp_enqueue_scripts', 'child_care_kindergarten_header_style' );
function child_care_kindergarten_header_style() {
	//Check if user has defined any header image.
	if ( get_header_image() ) :
	$custom_css = "
        .page-template-custom-home-page #header, #header {
			background-image:url('".esc_url(get_header_image())."');
			background-size: 100% 100%;
		}";
	   	wp_add_inline_style( 'child-care-kindergarten-basic-style', $custom_css );
	endif;
}
endif; // child_care_kindergarten_header_style