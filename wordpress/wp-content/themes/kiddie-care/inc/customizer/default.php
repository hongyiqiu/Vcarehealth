<?php
/**
 * Default theme options.
 *
 * @package Kiddie Care
 */

if ( ! function_exists( 'kiddie_care_get_default_theme_options' ) ) :

	/**
	 * Get default theme options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Default theme options.
	 */
function kiddie_care_get_default_theme_options() {

	$theme_data = wp_get_theme();
	$defaults = array();

	// Featured Slider Section
	$defaults['disable_featured-slider_section']	= false;
	$defaults['slider_speed']						= 800;

	//Cta Section	
	$defaults['disable_about_section']	   	= false;
	$defaults['about_btn_text']	   	 		= esc_html__( 'Read More', 'kiddie-care' );

	// Our Service Section
	$defaults['disable_services_section']	= false;
	$defaults['service_title']	   	 		= esc_html__( 'Our Services', 'kiddie-care' );

	// gallery Section
	$defaults['disable_gallery_section']	= false;
	$defaults['gallery_title']	   	 		= esc_html__( 'Our Gallery', 'kiddie-care' );

	// Featured Section
	$defaults['disable_course_section']	= false;
	$defaults['course_title']	   	 		= esc_html__( 'Our Courses', 'kiddie-care' );

	// Team Section
	$defaults['disable_team_section']	= false;
	$defaults['team_title']	   	 		= esc_html__( 'Our Team', 'kiddie-care' );

	//Cta Section	
	$defaults['disable_cta_section']	   	= false;
	$defaults['background_cta_section']		= esc_url(get_template_directory_uri()) .'/assets/images/default-header.jpg';
	$defaults['cta_button_label']	   	 	= esc_html__( 'Purchase Now', 'kiddie-care' );
	$defaults['cta_alt_button_label']	   	= esc_html__( 'Contact Us', 'kiddie-care' );
	$defaults['cta_alt_button_url']	   	 	= '#';

	// Blog Section
	$defaults['disable_blog_section']		= false;
	$defaults['blog_title']	   	 			= esc_html__( 'Latest Post', 'kiddie-care' ); 

	//General Section
	$defaults['excerpt_length']				= 40;
	$defaults['layout_options_blog']			= 'right-sidebar';
	$defaults['layout_options_archive']			= 'right-sidebar';
	$defaults['layout_options_page']			= 'right-sidebar';	
	$defaults['layout_options_single']			= 'right-sidebar';	


	//Footer section 		
	$defaults['copyright_text']				= esc_html__( 'Copyright &copy; All rights reserved.', 'kiddie-care' );
	// Pass through filter.
	$defaults = apply_filters( 'kiddie_care_filter_default_theme_options', $defaults );
	return $defaults;
}

endif;

/**
*  Get theme options
*/
if ( ! function_exists( 'kiddie_care_get_option' ) ) :

	/**
	 * Get theme option
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Option key.
	 * @return mixed Option value.
	 */
	function kiddie_care_get_option( $key ) {

		$default_options = kiddie_care_get_default_theme_options();
		if ( empty( $key ) ) {
			return;
		}

		$theme_options = (array)get_theme_mod( 'theme_options' );
		$theme_options = wp_parse_args( $theme_options, $default_options );

		$value = null;

		if ( isset( $theme_options[ $key ] ) ) {
			$value = $theme_options[ $key ];
		}

		return $value;

	}

endif;