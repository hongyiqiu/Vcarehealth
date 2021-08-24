<?php
/**
 * Slider options.
 *
 * @package Wisdom Academy
 */

$default = wisdom_academy_get_default_theme_options();

//  Slider Section
$wp_customize->add_section( 'section_featured_slider',
	array(
	'title'      => __( 'Slider Section', 'wisdom-academy' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'home_page_panel',
	)
);

// Enable Section
$wp_customize->add_setting('theme_options[enable_featured_slider_section]', 
	array(
	'default' 			=> $default['enable_featured_slider_section'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'wisdom_academy_sanitize_checkbox'
	)
);

$wp_customize->add_control('theme_options[enable_featured_slider_section]', 
	array(		
	'label' 	=> __('Enable Section', 'wisdom-academy'),
	'section' 	=> 'section_featured_slider',
	'settings'  => 'theme_options[enable_featured_slider_section]',
	'type' 		=> 'checkbox',	
	)
);

// Items
$wp_customize->add_setting('theme_options[number_of_featured_slider_items]', 
	array(
	'default' 			=> $default['number_of_featured_slider_items'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range'
	)
);

$wp_customize->add_control('theme_options[number_of_featured_slider_items]', 
	array(
	'label'       => __('Items (Max: 6)', 'wisdom-academy'),
	'section'     => 'section_featured_slider',   
	'settings'    => 'theme_options[number_of_featured_slider_items]',		
	'type'        => 'number',
	'active_callback' => 'wisdom_academy_featured_slider_active',
	'input_attrs' => array(
			'min'	=> 1,
			'max'	=> 6,
			'step'	=> 1,
		),
	)
);

// Content Type
$wp_customize->add_setting('theme_options[featured_slider_content_type]', 
	array(
	'default' 			=> $default['featured_slider_content_type'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'wisdom_academy_sanitize_select'
	)
);

$wp_customize->add_control('theme_options[featured_slider_content_type]', 
	array(
	'label'       => __('Content Type', 'wisdom-academy'),
	'section'     => 'section_featured_slider',   
	'settings'    => 'theme_options[featured_slider_content_type]',		
	'type'        => 'select',
	'active_callback' => 'wisdom_academy_featured_slider_active',
	'choices'	  => array(
			'featured_slider_page'	   => __('Page','wisdom-academy'),
			'featured_slider_post'	   => __('Post','wisdom-academy'),
		),
	)
);

$number_of_featured_slider_items = wisdom_academy_get_option( 'number_of_featured_slider_items' );

for( $i=1; $i<=$number_of_featured_slider_items; $i++ ) {

	// Page
	$wp_customize->add_setting('theme_options[featured_slider_page_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'wisdom_academy_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[featured_slider_page_'.$i.']', 
		array(
		'label'       	  => sprintf( __('Select Page #%1$s', 'wisdom-academy'), $i),
		'section'     	  => 'section_featured_slider',   
		'settings'    	  => 'theme_options[featured_slider_page_'.$i.']',		
		'type'        	  => 'dropdown-pages',
		'active_callback' => 'wisdom_academy_featured_slider_page',
		)
	);

	// Posts
	$wp_customize->add_setting('theme_options[featured_slider_post_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'wisdom_academy_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[featured_slider_post_'.$i.']', 
		array(
		'label'       	  => sprintf( __('Select Post #%1$s', 'wisdom-academy'), $i),
		'section'     	  => 'section_featured_slider',   
		'settings'    	  => 'theme_options[featured_slider_post_'.$i.']',		
		'type'        	  => 'select',
		'choices'	  	  => wisdom_academy_dropdown_posts(),
		'active_callback' => 'wisdom_academy_featured_slider_post',
		)
	);
}

// Slider Speed
$wp_customize->add_setting('theme_options[data_slick_speed]', 
	array(
	'default' 			=> $default['data_slick_speed'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range'
	)
);

$wp_customize->add_control('theme_options[data_slick_speed]', 
	array(
	'label'       		=> __('Delay Speed (Max: 5000)', 'wisdom-academy'),
	'section'     		=> 'section_featured_slider',   
	'settings'    		=> 'theme_options[data_slick_speed]',		
	'type'        		=> 'number',
	'active_callback' 	=> 'wisdom_academy_featured_slider_active',
	'input_attrs' => array(
			'min'	=> 0,
			'max'	=> 5000,
			'step'	=> 100,
		),
	)
);

// Slider Infinite
$wp_customize->add_setting('theme_options[data_slick_infinite]', 
	array(
	'default' 			=> $default['data_slick_infinite'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'wisdom_academy_sanitize_checkbox'
	)
);

$wp_customize->add_control('theme_options[data_slick_infinite]', 
	array(		
	'label' 	        => __('Infinite', 'wisdom-academy'),
	'section' 	        => 'section_featured_slider',
	'settings'          => 'theme_options[data_slick_infinite]',
	'type' 		        => 'checkbox',	
	'active_callback' 	=> 'wisdom_academy_featured_slider_active',
	)
);

// Slider Dots
$wp_customize->add_setting('theme_options[data_slick_dots]', 
	array(
	'default' 			=> $default['data_slick_dots'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'wisdom_academy_sanitize_checkbox'
	)
);

$wp_customize->add_control('theme_options[data_slick_dots]', 
	array(		
	'label' 	        => __('Dots', 'wisdom-academy'),
	'section' 	        => 'section_featured_slider',
	'settings'          => 'theme_options[data_slick_dots]',
	'type' 		        => 'checkbox',	
	'active_callback' 	=> 'wisdom_academy_featured_slider_active',
	)
);

// Slider Arrows
$wp_customize->add_setting('theme_options[data_slick_arrows]', 
	array(
	'default' 			=> $default['data_slick_arrows'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'wisdom_academy_sanitize_checkbox'
	)
);

$wp_customize->add_control('theme_options[data_slick_arrows]', 
	array(		
	'label' 	        => __('Arrows', 'wisdom-academy'),
	'section' 	        => 'section_featured_slider',
	'settings'          => 'theme_options[data_slick_arrows]',
	'type' 		        => 'checkbox',	
	'active_callback' 	=> 'wisdom_academy_featured_slider_active',
	)
);

// Slider Autoplay
$wp_customize->add_setting('theme_options[data_slick_autoplay]', 
	array(
	'default' 			=> $default['data_slick_autoplay'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'wisdom_academy_sanitize_checkbox'
	)
);

$wp_customize->add_control('theme_options[data_slick_autoplay]', 
	array(		
	'label' 	        => __('Autoplay', 'wisdom-academy'),
	'section' 	        => 'section_featured_slider',
	'settings'          => 'theme_options[data_slick_autoplay]',
	'type' 		        => 'checkbox',	
	'active_callback' 	=> 'wisdom_academy_featured_slider_active',
	)
);

// Slider Draggable
$wp_customize->add_setting('theme_options[data_slick_draggable]', 
	array(
	'default' 			=> $default['data_slick_draggable'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'wisdom_academy_sanitize_checkbox'
	)
);

$wp_customize->add_control('theme_options[data_slick_draggable]', 
	array(		
	'label' 	        => __('Draggable', 'wisdom-academy'),
	'section' 	        => 'section_featured_slider',
	'settings'          => 'theme_options[data_slick_draggable]',
	'type' 		        => 'checkbox',	
	'active_callback' 	=> 'wisdom_academy_featured_slider_active',
	)
);

// Slider Fade
$wp_customize->add_setting('theme_options[data_slick_fade]', 
	array(
	'default' 			=> $default['data_slick_fade'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'wisdom_academy_sanitize_checkbox'
	)
);

$wp_customize->add_control('theme_options[data_slick_fade]', 
	array(		
	'label' 	        => __('Fade', 'wisdom-academy'),
	'section' 	        => 'section_featured_slider',
	'settings'          => 'theme_options[data_slick_fade]',
	'type' 		        => 'checkbox',	
	'active_callback' 	=> 'wisdom_academy_featured_slider_active',
	)
);

// Title Font Size
$wp_customize->add_setting( 'theme_options[featured_slider_title_font_size]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[featured_slider_title_font_size]', array(
	'label'       => esc_html__( 'Title Font Size', 'wisdom-academy' ),
	'section'     => 'section_featured_slider',
	'type'        => 'number',
	'active_callback' 	=> 'wisdom_academy_featured_slider_active',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// Title Letter Spacing
$wp_customize->add_setting( 'theme_options[featured_slider_title_letter_spacing]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[featured_slider_title_letter_spacing]', array(
	'label'       => esc_html__( 'Title Letter Spacing', 'wisdom-academy' ),
	'section'     => 'section_featured_slider',
	'type'        => 'number',
	'active_callback' 	=> 'wisdom_academy_featured_slider_active',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// Title Font Weight
$wp_customize->add_setting( 'theme_options[featured_slider_title_font_weight]', array(
	'default' 			=> $default['featured_slider_title_font_weight'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[featured_slider_title_font_weight]', array(
	'label'       => esc_html__( 'Title Font Weight', 'wisdom-academy' ),
	'section'     => 'section_featured_slider',
	'type'        => 'select',
	'active_callback' 	=> 'wisdom_academy_featured_slider_active',
	'choices' 	  => array(		
		'title-font-weight-regular' 	=> 'Regular',		
		'title-font-weight-semi-bold'   => 'Semi-Bold',										
		'title-font-weight-bold'        => 'Bold',
	),	
) );

// Title Text Transform
$wp_customize->add_setting( 'theme_options[featured_slider_title_text_transform]', array(
	'default' 			=> $default['featured_slider_title_text_transform'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[featured_slider_title_text_transform]', array(
	'label'       		=> esc_html__( 'Title Text Transform', 'wisdom-academy' ),
	'section'     		=> 'section_featured_slider',
	'type'        		=> 'select',
	'active_callback' 	=> 'wisdom_academy_featured_slider_active',
	'active_callback' 	=> 'wisdom_academy_featured_slider_active',
	'choices' 	  	  	=> array(		
		'title-default' 		=> 'Default',
		'title-uppercase'   	=> 'Uppercase',		
		'title-lowercase'   	=> 'Lowercase',										
		'title-capitalize'  	=> 'Capitalize',
	),	
) );

// Title Bottom Gap
$wp_customize->add_setting( 'theme_options[featured_slider_title_bottom_gap]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[featured_slider_title_bottom_gap]', array(
	'label'       => esc_html__( 'Title Bottom Gap', 'wisdom-academy' ),
	'section'     => 'section_featured_slider',
	'type'        => 'number',
	'active_callback' 	=> 'wisdom_academy_featured_slider_active',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// Content Font Size
$wp_customize->add_setting( 'theme_options[featured_slider_content_font_size]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[featured_slider_content_font_size]', array(
	'label'       => esc_html__( 'Content Font Size', 'wisdom-academy' ),
	'section'     => 'section_featured_slider',
	'type'        => 'number',
	'active_callback' 	=> 'wisdom_academy_featured_slider_active',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// Content Letter Spacing
$wp_customize->add_setting( 'theme_options[featured_slider_content_letter_spacing]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[featured_slider_content_letter_spacing]', array(
	'label'       => esc_html__( 'Content Letter Spacing', 'wisdom-academy' ),
	'section'     => 'section_featured_slider',
	'type'        => 'number',
	'active_callback' 	=> 'wisdom_academy_featured_slider_active',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// Content Font Weight
$wp_customize->add_setting( 'theme_options[featured_slider_content_font_weight]', array(
	'default' 			=> $default['featured_slider_content_font_weight'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[featured_slider_content_font_weight]', array(
	'label'       => esc_html__( 'Content Font Weight', 'wisdom-academy' ),
	'section'     => 'section_featured_slider',
	'type'        => 'select',
	'active_callback' 	=> 'wisdom_academy_featured_slider_active',
	'choices' 	  => array(		
		'content-font-weight-regular' 	=> 'Regular',		
		'content-font-weight-semi-bold' => 'Semi-Bold',										
		'content-font-weight-bold'      => 'Bold',
	),	
) );

// Content Text Transform
$wp_customize->add_setting( 'theme_options[featured_slider_content_text_transform]', array(
	'default' 			=> $default['featured_slider_content_text_transform'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[featured_slider_content_text_transform]', array(
	'label'       		=> esc_html__( 'Content Text Transform', 'wisdom-academy' ),
	'section'     		=> 'section_featured_slider',
	'type'        		=> 'select',
	'active_callback' 	=> 'wisdom_academy_featured_slider_active',
	'choices' 	  	  	=> array(		
		'content-default' 		=> 'Default',
		'content-uppercase'   	=> 'Uppercase',		
		'content-lowercase'   	=> 'Lowercase',										
		'content-capitalize'  	=> 'Capitalize',
	),	
) );

// Content Bottom Gap
$wp_customize->add_setting( 'theme_options[featured_slider_content_bottom_gap]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[featured_slider_content_bottom_gap]', array(
	'label'       => esc_html__( 'Content Bottom Gap', 'wisdom-academy' ),
	'section'     => 'section_featured_slider',
	'type'        => 'number',
	'active_callback' 	=> 'wisdom_academy_featured_slider_active',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// Button Font Size
$wp_customize->add_setting( 'theme_options[featured_slider_button_font_size]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[featured_slider_button_font_size]', array(
	'label'       => esc_html__( 'Button Font Size', 'wisdom-academy' ),
	'section'     => 'section_featured_slider',
	'type'        => 'number',
	'active_callback' 	=> 'wisdom_academy_featured_slider_active',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// Button Line Height
$wp_customize->add_setting( 'theme_options[featured_slider_button_line_height]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[featured_slider_button_line_height]', array(
	'label'       => esc_html__( 'Button Line Height', 'wisdom-academy' ),
	'section'     => 'section_featured_slider',
	'type'        => 'number',
	'active_callback' 	=> 'wisdom_academy_featured_slider_active',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// Button Letter Spacing
$wp_customize->add_setting( 'theme_options[featured_slider_button_letter_spacing]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[featured_slider_button_letter_spacing]', array(
	'label'       => esc_html__( 'Button Letter Spacing', 'wisdom-academy' ),
	'section'     => 'section_featured_slider',
	'type'        => 'number',
	'active_callback' 	=> 'wisdom_academy_featured_slider_active',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// Button Padding (Vertical)
$wp_customize->add_setting( 'theme_options[featured_slider_button_vertical_padding]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[featured_slider_button_vertical_padding]', array(
	'label'       => esc_html__( 'Button Padding (Vertical)', 'wisdom-academy' ),
	'section'     => 'section_featured_slider',
	'type'        => 'number',
	'active_callback' 	=> 'wisdom_academy_featured_slider_active',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// Button Padding (Horizontal)
$wp_customize->add_setting( 'theme_options[featured_slider_button_horizontal_padding]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[featured_slider_button_horizontal_padding]', array(
	'label'       => esc_html__( 'Button Padding (Horizontal)', 'wisdom-academy' ),
	'section'     => 'section_featured_slider',
	'type'        => 'number',
	'active_callback' 	=> 'wisdom_academy_featured_slider_active',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// Button Border Radius
$wp_customize->add_setting( 'theme_options[featured_slider_button_border_radius]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[featured_slider_button_border_radius]', array(
	'label'       => esc_html__( 'Button Border Radius', 'wisdom-academy' ),
	'section'     => 'section_featured_slider',
	'type'        => 'number',
	'active_callback' 	=> 'wisdom_academy_featured_slider_active',
	'input_attrs' => array( 'min' => 1, 'max' => 100, 'style' => 'width: 80px;' ),
) );

// Button Font Weight
$wp_customize->add_setting( 'theme_options[featured_slider_button_font_weight]', array(
	'default' 			=> $default['featured_slider_button_font_weight'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[featured_slider_button_font_weight]', array(
	'label'       => esc_html__( 'Button Font Weight', 'wisdom-academy' ),
	'section'     => 'section_featured_slider',
	'type'        => 'select',
	'active_callback' 	=> 'wisdom_academy_featured_slider_active',
	'choices' 	  => array(		
		'button-font-weight-regular' 	=> 'Regular',		
		'button-font-weight-semi-bold'  => 'Semi-Bold',										
		'button-font-weight-bold'       => 'Bold',
	),	
) );

// Button Text Transform
$wp_customize->add_setting( 'theme_options[featured_slider_button_text_transform]', array(
	'default' 			=> $default['featured_slider_button_text_transform'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[featured_slider_button_text_transform]', array(
	'label'       		=> esc_html__( 'Button Text Transform', 'wisdom-academy' ),
	'section'     		=> 'section_featured_slider',
	'type'        		=> 'select',
	'active_callback' 	=> 'wisdom_academy_featured_slider_active',
	'choices' 	  	  	=> array(		
		'button-default'     => 'Default',
		'button-uppercase'   => 'Uppercase',		
		'button-lowercase'   => 'Lowercase',										
		'button-capitalize'  => 'Capitalize',
	),	
) );

// Show / Hide Title
$wp_customize->add_setting( 'theme_options[show_featured_slider_title]', array(
	'default'           => $default['show_featured_slider_title'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[show_featured_slider_title]', array(
	'label'              => esc_html__( 'Display Title', 'wisdom-academy' ),
	'section'            => 'section_featured_slider',
	'type'               => 'select',
	'active_callback'    => 'wisdom_academy_featured_slider_active',
	'choices' 	         => array(		
		'title-enable' 	 => 'Yes',						
		'title-disable'  => 'No',
	),	
) );

// Show / Hide Content
$wp_customize->add_setting( 'theme_options[show_featured_slider_content]', array(
	'default'           => $default['show_featured_slider_content'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[show_featured_slider_content]', array(
	'label'       => esc_html__( 'Display Content', 'wisdom-academy' ),
	'section'     => 'section_featured_slider',
	'type'        => 'select',
	'active_callback' => 'wisdom_academy_featured_slider_active',
	'choices' 	  => array(		
		'content-enable' 	=> 'Yes',						
		'content-disable'  => 'No',
	),	
) );

// Show / Hide Button
$wp_customize->add_setting( 'theme_options[show_featured_slider_button]', array(
	'default'           => $default['show_featured_slider_button'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[show_featured_slider_button]', array(
	'label'       => esc_html__( 'Display Button', 'wisdom-academy' ),
	'section'     => 'section_featured_slider',
	'type'        => 'select',
	'active_callback' => 'wisdom_academy_featured_slider_active',
	'choices' 	  => array(		
		'button-enable' 	=> 'Yes',						
		'button-disable'    => 'No',
	),	
) );