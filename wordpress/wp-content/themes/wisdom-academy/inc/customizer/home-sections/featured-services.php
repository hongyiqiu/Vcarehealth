<?php
/**
 * Services Section options.
 *
 * @package Wisdom Academy
 */

$default = wisdom_academy_get_default_theme_options();

// Services Section
$wp_customize->add_section( 'section_featured_services',
	array(
	'title'      => __( 'Services Section', 'wisdom-academy' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'home_page_panel',
	)
);

// Enable Section
$wp_customize->add_setting('theme_options[enable_featured_services_section]', 
	array(
	'default' 			=> $default['enable_featured_services_section'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'wisdom_academy_sanitize_checkbox'
	)
);

$wp_customize->add_control('theme_options[enable_featured_services_section]', 
	array(		
	'label' 	=> __('Enable Section', 'wisdom-academy'),
	'section' 	=> 'section_featured_services',
	'settings'  => 'theme_options[enable_featured_services_section]',
	'type' 		=> 'checkbox',	
	)
);

// Items
$wp_customize->add_setting('theme_options[number_of_featured_services_items]', 
	array(
	'default' 			=> $default['number_of_featured_services_items'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range'
	)
);

$wp_customize->add_control('theme_options[number_of_featured_services_items]', 
	array(
	'label'       => __('Items (Max: 6)', 'wisdom-academy'),
	'section'     => 'section_featured_services',   
	'settings'    => 'theme_options[number_of_featured_services_items]',		
	'type'        => 'number',
	'active_callback' => 'wisdom_academy_featured_services_active',
	'input_attrs' => array(
			'min'	=> 1,
			'max'	=> 6,
			'step'	=> 1,
		),
	)
);

// Column
$wp_customize->add_setting('theme_options[featured_services_column]', 
	array(
	'default' 			=> $default['featured_services_column'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'wisdom_academy_sanitize_select'
	)
);

$wp_customize->add_control(new wisdom_academy_Image_Radio_Control($wp_customize, 'theme_options[featured_services_column]', 
	array(		
	'label' 	=> __('Column', 'wisdom-academy'),
	'section' 	=> 'section_featured_services',
	'settings'  => 'theme_options[featured_services_column]',
	'type' 		=> 'radio-image',
	'active_callback' => 'wisdom_academy_featured_services_active',
	'choices' 	=> array(		
		'col-1' 	=> esc_url(get_template_directory_uri()) . '/assets/images/column-1.jpg',						
		'col-2' 	=> esc_url(get_template_directory_uri()) . '/assets/images/column-2.jpg',
		'col-3' 	=> esc_url(get_template_directory_uri()) . '/assets/images/column-3.jpg',
		'col-4' 	=> esc_url(get_template_directory_uri()) . '/assets/images/column-4.jpg',
		'col-5' 	=> esc_url(get_template_directory_uri()) . '/assets/images/column-5.jpg',
		'col-6' 	=> esc_url(get_template_directory_uri()) . '/assets/images/column-6.jpg',
		),	
	))
);

// Content Type
$wp_customize->add_setting('theme_options[featured_services_content_type]', 
	array(
	'default' 			=> $default['featured_services_content_type'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'wisdom_academy_sanitize_select'
	)
);

$wp_customize->add_control('theme_options[featured_services_content_type]', 
	array(
	'label'       => __('Content Type', 'wisdom-academy'),
	'section'     => 'section_featured_services',   
	'settings'    => 'theme_options[featured_services_content_type]',		
	'type'        => 'select',
	'active_callback' => 'wisdom_academy_featured_services_active',
	'choices'	  => array(
			'featured_services_page'	  => __('Page','wisdom-academy'),
			'featured_services_post'	  => __('Post','wisdom-academy'),
		),
	)
);

$number_of_featured_services_items = wisdom_academy_get_option( 'number_of_featured_services_items' );

for( $i=1; $i<=$number_of_featured_services_items; $i++ ) {

	// Icon
	$wp_customize->add_setting('theme_options[featured_services_icon_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'sanitize_text_field'
		)
	);

	$wp_customize->add_control('theme_options[featured_services_icon_'.$i.']', 
		array(
		'label'       		=> sprintf( __('Icon #%1$s', 'wisdom-academy'), $i),
		'section'     		=> 'section_featured_services',   
		'settings'    		=> 'theme_options[featured_services_icon_'.$i.']',		
		'active_callback' 	=> 'wisdom_academy_featured_services_active',			
		'type'        		=> 'text',
		)
	);

	// Page
	$wp_customize->add_setting('theme_options[featured_services_page_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'wisdom_academy_dropdown_pages'
		)
	);
	
	$wp_customize->add_control('theme_options[featured_services_page_'.$i.']', 
		array(
		'label'       => sprintf( __('Page #%1$s', 'wisdom-academy'), $i),
		'section'     => 'section_featured_services',   
		'settings'    => 'theme_options[featured_services_page_'.$i.']',		
		'type'        => 'dropdown-pages',
		'active_callback' => 'wisdom_academy_featured_services_page',
		)
	);

	// Post
	$wp_customize->add_setting('theme_options[featured_services_post_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'wisdom_academy_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[featured_services_post_'.$i.']', 
		array(
		'label'       => sprintf( __('Post #%1$s', 'wisdom-academy'), $i),
		'section'     => 'section_featured_services',   
		'settings'    => 'theme_options[featured_services_post_'.$i.']',		
		'type'        => 'select',
		'choices'	  => wisdom_academy_dropdown_posts(),
		'active_callback' => 'wisdom_academy_featured_services_post',
		)
	);
}

// Title Font Size
$wp_customize->add_setting( 'theme_options[featured_services_title_font_size]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[featured_services_title_font_size]', array(
	'label'       => esc_html__( 'Title Font Size', 'wisdom-academy' ),
	'section'     => 'section_featured_services',
	'type'        => 'number',
	'active_callback' 	=> 'wisdom_academy_featured_services_active',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// Title Line Height
$wp_customize->add_setting( 'theme_options[featured_services_title_line_height]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[featured_services_title_line_height]', array(
	'label'       => esc_html__( 'Title Line Height', 'wisdom-academy' ),
	'section'     => 'section_featured_services',
	'type'        => 'number',
	'active_callback' 	=> 'wisdom_academy_featured_services_active',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// Title Letter Spacing
$wp_customize->add_setting( 'theme_options[featured_services_title_letter_spacing]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[featured_services_title_letter_spacing]', array(
	'label'       => esc_html__( 'Title Letter Spacing', 'wisdom-academy' ),
	'section'     => 'section_featured_services',
	'type'        => 'number',
	'active_callback' 	=> 'wisdom_academy_featured_services_active',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// Title Font Weight
$wp_customize->add_setting( 'theme_options[featured_services_title_font_weight]', array(
	'default' 			=> $default['featured_services_title_font_weight'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[featured_services_title_font_weight]', array(
	'label'       => esc_html__( 'Title Font Weight', 'wisdom-academy' ),
	'section'     => 'section_featured_services',
	'type'        => 'select',
	'active_callback' 	=> 'wisdom_academy_featured_services_active',
	'choices' 	  => array(		
		'title-font-weight-regular' 	=> 'Regular',		
		'title-font-weight-semi-bold'   => 'Semi-Bold',										
		'title-font-weight-bold'        => 'Bold',
	),	
) );

// Title Text Transform
$wp_customize->add_setting( 'theme_options[featured_services_title_text_transform]', array(
	'default' 			=> $default['featured_services_title_text_transform'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[featured_services_title_text_transform]', array(
	'label'       		=> esc_html__( 'Title Text Transform', 'wisdom-academy' ),
	'section'     		=> 'section_featured_services',
	'type'        		=> 'select',
	'active_callback' 	=> 'wisdom_academy_featured_services_active',
	'active_callback' 	=> 'wisdom_academy_featured_services_active',
	'choices' 	  	  	=> array(		
		'title-default' 		=> 'Default',
		'title-uppercase'   	=> 'Uppercase',		
		'title-lowercase'   	=> 'Lowercase',										
		'title-capitalize'  	=> 'Capitalize',
	),	
) );

// Title Bottom Gap
$wp_customize->add_setting( 'theme_options[featured_services_title_bottom_gap]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[featured_services_title_bottom_gap]', array(
	'label'       => esc_html__( 'Title Bottom Gap', 'wisdom-academy' ),
	'section'     => 'section_featured_services',
	'type'        => 'number',
	'active_callback' 	=> 'wisdom_academy_featured_services_active',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// Content Font Size
$wp_customize->add_setting( 'theme_options[featured_services_content_font_size]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[featured_services_content_font_size]', array(
	'label'       => esc_html__( 'Content Font Size', 'wisdom-academy' ),
	'section'     => 'section_featured_services',
	'type'        => 'number',
	'active_callback' 	=> 'wisdom_academy_featured_services_active',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// Content Line Height
$wp_customize->add_setting( 'theme_options[featured_services_content_line_height]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[featured_services_content_line_height]', array(
	'label'       => esc_html__( 'Content Line Height', 'wisdom-academy' ),
	'section'     => 'section_featured_services',
	'type'        => 'number',
	'active_callback' 	=> 'wisdom_academy_featured_services_active',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// Content Letter Spacing
$wp_customize->add_setting( 'theme_options[featured_services_content_letter_spacing]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[featured_services_content_letter_spacing]', array(
	'label'       => esc_html__( 'Content Letter Spacing', 'wisdom-academy' ),
	'section'     => 'section_featured_services',
	'type'        => 'number',
	'active_callback' 	=> 'wisdom_academy_featured_services_active',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// Content Font Weight
$wp_customize->add_setting( 'theme_options[featured_services_content_font_weight]', array(
	'default' 			=> $default['featured_services_content_font_weight'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[featured_services_content_font_weight]', array(
	'label'       => esc_html__( 'Content Font Weight', 'wisdom-academy' ),
	'section'     => 'section_featured_services',
	'type'        => 'select',
	'active_callback' 	=> 'wisdom_academy_featured_services_active',
	'choices' 	  => array(		
		'content-font-weight-regular' 	=> 'Regular',		
		'content-font-weight-semi-bold' => 'Semi-Bold',										
		'content-font-weight-bold'      => 'Bold',
	),	
) );

// Content Text Transform
$wp_customize->add_setting( 'theme_options[featured_services_content_text_transform]', array(
	'default' 			=> $default['featured_services_content_text_transform'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[featured_services_content_text_transform]', array(
	'label'       		=> esc_html__( 'Content Text Transform', 'wisdom-academy' ),
	'section'     		=> 'section_featured_services',
	'type'        		=> 'select',
	'active_callback' 	=> 'wisdom_academy_featured_services_active',
	'choices' 	  	  	=> array(		
		'content-default' 		=> 'Default',
		'content-uppercase'   	=> 'Uppercase',		
		'content-lowercase'   	=> 'Lowercase',										
		'content-capitalize'  	=> 'Capitalize',
	),	
) );

// Show / Hide Icon
$wp_customize->add_setting( 'theme_options[show_featured_services_icon]', array(
	'default'           => $default['show_featured_services_icon'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[show_featured_services_icon]', array(
	'label'              => esc_html__( 'Display Icon', 'wisdom-academy' ),
	'section'            => 'section_featured_services',
	'type'               => 'select',
	'active_callback'    => 'wisdom_academy_featured_services_active',
	'choices' 	         => array(		
		'icon-enable' 	 => 'Yes',						
		'icon-disable'   => 'No',
	),	
) );

// Show / Hide Title
$wp_customize->add_setting( 'theme_options[show_featured_services_title]', array(
	'default'           => $default['show_featured_services_title'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[show_featured_services_title]', array(
	'label'              => esc_html__( 'Display Title', 'wisdom-academy' ),
	'section'            => 'section_featured_services',
	'type'               => 'select',
	'active_callback'    => 'wisdom_academy_featured_services_active',
	'choices' 	         => array(		
		'title-enable' 	 => 'Yes',						
		'title-disable'  => 'No',
	),	
) );

// Show / Hide Content
$wp_customize->add_setting( 'theme_options[show_featured_services_content]', array(
	'default'           => $default['show_featured_services_content'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[show_featured_services_content]', array(
	'label'       => esc_html__( 'Display Content', 'wisdom-academy' ),
	'section'     => 'section_featured_services',
	'type'        => 'select',
	'active_callback' => 'wisdom_academy_featured_services_active',
	'choices' 	  => array(		
		'content-enable' 	=> 'Yes',						
		'content-disable'  => 'No',
	),	
) );