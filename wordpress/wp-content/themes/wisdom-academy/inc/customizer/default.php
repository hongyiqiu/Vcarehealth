<?php
/**
 * Default theme options.
 *
 * @package Wisdom Academy
 */

if ( ! function_exists( 'wisdom_academy_get_default_theme_options' ) ) :

	/**
	 * Get default theme options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Default theme options.
	 */
function wisdom_academy_get_default_theme_options() {

	$defaults = array();

	// Top Bar
	$defaults['show_header_contact_info'] 		= false;
    $defaults['show_header_social_links'] 		= false;
    $defaults['header_social_links']			= array();

    // Front Page Content
	$defaults['enable_frontpage_content'] 		= true;

	// Slider Section	
	$defaults['enable_featured_slider_section']		    	= false;
	$defaults['featured_slider_content_type']		    	= 'featured_slider_page';
	$defaults['featured_slider_category_readmore_text']		= esc_html__('Read More','wisdom-academy');
	$defaults['data_slick_speed']					    	= 1000;
	$defaults['data_slick_infinite']				    	= 1;
	$defaults['data_slick_dots']					    	= 1;
	$defaults['data_slick_arrows']					    	= 1;
	$defaults['data_slick_autoplay']				    	= 0;
	$defaults['data_slick_draggable']				    	= 1;
	$defaults['data_slick_fade']					    	= 1;
	$defaults['number_of_featured_slider_items']	    	= 6;
	$defaults['featured_slider_title_font_weight']	    	= 'title-font-weight-semi-bold';
	$defaults['featured_slider_title_text_transform']		= 'title-default';
	$defaults['featured_slider_content_font_weight']		= 'content-font-weight-regular';
	$defaults['featured_slider_content_text_transform']		= 'content-default';
	$defaults['featured_slider_button_font_weight']	    	= 'button-font-weight-regular';
	$defaults['featured_slider_button_text_transform']		= 'button-default';
	$defaults['show_featured_slider_title']			    	= 'title-enable';
	$defaults['show_featured_slider_content']		    	= 'content-enable';
	$defaults['show_featured_slider_button']		    	= 'button-enable';

	// Services Section	
	$defaults['enable_featured_services_section']			= false;
	$defaults['number_of_featured_services_items']			= 6;
	$defaults['featured_services_column']					= 'col-3';
	$defaults['featured_services_title_font_weight']		= 'title-font-weight-semi-bold';
	$defaults['featured_services_title_text_transform']		= 'title-default';
	$defaults['featured_services_content_font_weight']		= 'content-font-weight-regular';
	$defaults['featured_services_content_text_transform']	= 'content-default';
	$defaults['show_featured_services_icon']				= 'icon-enable';
	$defaults['show_featured_services_title']				= 'title-enable';
	$defaults['show_featured_services_content']				= 'content-enable';
	$defaults['featured_services_content_type']				= 'featured_services_page';

	// Classes Section	
	$defaults['enable_featured_classes_section']			= false;
	$defaults['featured_classes_background_color']			= '#2196f3';
	$defaults['featured_classes_section_title']				= esc_html__( 'Classes', 'wisdom-academy' );
	$defaults['number_of_featured_classes_items']			= 6;
	$defaults['featured_classes_column']					= 'col-3';
	$defaults['featured_classes_title_font_weight']			= 'title-font-weight-semi-bold';
	$defaults['featured_classes_title_text_transform']		= 'title-default';
	$defaults['featured_classes_content_font_weight']		= 'content-font-weight-regular';
	$defaults['featured_classes_content_text_transform']	= 'content-default';
	$defaults['show_featured_classes_image']		    	= 'image-enable';
	$defaults['show_featured_classes_title']		    	= 'title-enable';
	$defaults['show_featured_classes_content']		    	= 'content-enable';
	$defaults['featured_classes_content_type']				= 'featured_classes_page';

	// Gallery Section	
	$defaults['enable_featured_gallery_section']		= false;
	$defaults['featured_gallery_section_title']			= esc_html__( 'Gallery', 'wisdom-academy' );
	$defaults['number_of_featured_gallery_items']		= 6;
	$defaults['featured_gallery_column']				= 'col-3';
	$defaults['featured_gallery_content_type']			= 'featured_gallery_page';

	// Team Section	
	$defaults['enable_featured_team_section']		    = false;
	$defaults['featured_team_background_color']		    = '#2196f3';
	$defaults['featured_team_section_title']		    = esc_html__( 'Teachers', 'wisdom-academy' );
	$defaults['number_of_featured_team_items']		    = 6;
	$defaults['featured_team_column']				    = '3';
	$defaults['featured_team_title_font_weight']		= 'title-font-weight-semi-bold';
	$defaults['featured_team_title_text_transform']		= 'title-default';
	$defaults['featured_team_content_font_weight']		= 'content-font-weight-regular';
	$defaults['featured_team_content_text_transform']	= 'content-default';
	$defaults['show_featured_team_image']		        = 'image-enable';
	$defaults['show_featured_team_position']		    = 'position-enable';
	$defaults['show_featured_team_title']		        = 'title-enable';
	$defaults['show_featured_team_content']		        = 'content-enable';
	$defaults['featured_team_content_type']			    = 'featured_team_page';

	// Featured Posts Section
	$defaults['enable_featured_posts_section']			= false;
	$defaults['featured_posts_background_color']    	= '#2196f3';
	$defaults['featured_posts_section_title']	    	= esc_html__( 'Latest Posts', 'wisdom-academy' );
	$defaults['featured_posts_category']	   	    	= 0; 
	$defaults['featured_posts_number']					= 6;
	$defaults['featured_posts_column']					= 'col-3';
	$defaults['show_featured_posts_image']		    	= 'image-enable';
	$defaults['show_featured_posts_category']			= 'category-enable';
	$defaults['show_featured_posts_title']		    	= 'title-enable';
	$defaults['show_featured_posts_content']			= 'content-enable';
	$defaults['show_featured_posts_button']		    	= 'button-enable';
	$defaults['featured_posts_title_font_weight']	    = 'title-font-weight-semi-bold';
	$defaults['featured_posts_title_text_transform']	= 'title-default';
	$defaults['featured_posts_content_font_weight']		= 'content-font-weight-regular';
	$defaults['featured_posts_content_text_transform']	= 'content-default';
	$defaults['featured_posts_button_font_weight']	    = 'button-font-weight-regular';
	$defaults['featured_posts_button_text_transform']	= 'button-default';

	// Colors
	$defaults['top_bar_color'] 							= '#fcb614';
	$defaults['custom_theme_color'] 					= '#fcb614';

	// Theme Options
	$defaults['show_header_image']		    			= 'header-image-enable';
	$defaults['show_page_title']		    			= 'page-title-enable';
	$defaults['layout_options_blog']					= 'no-sidebar';
	$defaults['layout_options_archive']					= 'no-sidebar';
	$defaults['layout_options_page']					= 'no-sidebar';	
	$defaults['layout_options_single']					= 'right-sidebar';	
	$defaults['excerpt_length']							= 25;
	$defaults['readmore_text']							= esc_html__('Learn More','wisdom-academy');
	$defaults['your_latest_posts_title']				= esc_html__('Blog','wisdom-academy');
	$defaults['show_blog_posts_image']		    		= 'image-enable';
	$defaults['show_blog_posts_category']				= 'category-enable';
	$defaults['show_blog_posts_title']		    		= 'title-enable';
	$defaults['show_blog_posts_content']				= 'content-enable';
	$defaults['show_blog_posts_button']		    		= 'button-enable';

	//Footer section 		
	$defaults['copyright_text']							= esc_html__( 'Copyright &copy; All rights reserved.', 'wisdom-academy' );

	// Pass through filter.
	$defaults = apply_filters( 'wisdom_academy_filter_default_theme_options', $defaults );
	return $defaults;
}

endif;

/**
*  Get theme options
*/
if ( ! function_exists( 'wisdom_academy_get_option' ) ) :

	/**
	 * Get theme option
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Option key.
	 * @return mixed Option value.
	 */
	function wisdom_academy_get_option( $key ) {

		$default_options = wisdom_academy_get_default_theme_options();
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