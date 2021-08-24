<?php
/**
 * Featured Team options.
 *
 * @package Wisdom Academy
 */

$default = wisdom_academy_get_default_theme_options();

// Featured Featured Team Section
$wp_customize->add_section( 'section_featured_team',
	array(
	'title'      => __( 'Team Section', 'wisdom-academy' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'home_page_panel',
	)
);

// Enable Featured Team Section
$wp_customize->add_setting('theme_options[enable_featured_team_section]', 
	array(
	'default' 			=> $default['enable_featured_team_section'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'wisdom_academy_sanitize_checkbox'
	)
);

$wp_customize->add_control('theme_options[enable_featured_team_section]', 
	array(		
	'label' 	=> __('Enable Section', 'wisdom-academy'),
	'section' 	=> 'section_featured_team',
	'settings'  => 'theme_options[enable_featured_team_section]',
	'type' 		=> 'checkbox',	
	)
);

// Background Color
$wp_customize->add_setting( 'theme_options[featured_team_background_color]', array(
	'default'           => $default['featured_team_background_color'],
	'sanitize_callback' => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'theme_options[featured_team_background_color]', array(
	'label'             => esc_html__( 'Background Color', 'wisdom-academy' ),
	'section'           => 'section_featured_team',
	'active_callback' => 'wisdom_academy_featured_team_active',
) ) );

// Section Title
$wp_customize->add_setting('theme_options[featured_team_section_title]', 
	array(
	'default'           => $default['featured_team_section_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[featured_team_section_title]', 
	array(
	'label'       => __('Section Title', 'wisdom-academy'),
	'section'     => 'section_featured_team',   
	'settings'    => 'theme_options[featured_team_section_title]',	
	'active_callback' => 'wisdom_academy_featured_team_active',		
	'type'        => 'text'
	)
);

// Number of items
$wp_customize->add_setting('theme_options[number_of_featured_team_items]', 
	array(
	'default' 			=> $default['number_of_featured_team_items'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range'
	)
);

$wp_customize->add_control('theme_options[number_of_featured_team_items]', 
	array(
	'label'       => __('Items (Max: 6)', 'wisdom-academy'),
	'section'     => 'section_featured_team',   
	'settings'    => 'theme_options[number_of_featured_team_items]',		
	'type'        => 'number',
	'active_callback' => 'wisdom_academy_featured_team_active',
	'input_attrs' => array(
			'min'	=> 1,
			'max'	=> 6,
			'step'	=> 1,
		),
	)
);

// Content Type
$wp_customize->add_setting('theme_options[featured_team_content_type]', 
	array(
	'default' 			=> $default['featured_team_content_type'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'wisdom_academy_sanitize_select'
	)
);

$wp_customize->add_control('theme_options[featured_team_content_type]', 
	array(
	'label'       => __('Content Type', 'wisdom-academy'),
	'section'     => 'section_featured_team',   
	'settings'    => 'theme_options[featured_team_content_type]',		
	'type'        => 'select',
	'active_callback' => 'wisdom_academy_featured_team_active',
	'choices'	  => array(
			'featured_team_page'	  => __('Page','wisdom-academy'),
			'featured_team_post'	  => __('Post','wisdom-academy'),
		),
	)
);

$number_of_featured_team_items = wisdom_academy_get_option( 'number_of_featured_team_items' );

for( $i=1; $i<=$number_of_featured_team_items; $i++ ) {

	// Page
	$wp_customize->add_setting('theme_options[featured_team_page_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'wisdom_academy_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[featured_team_page_'.$i.']', 
		array(
		'label'       => sprintf( __('Select Page #%1$s', 'wisdom-academy'), $i),
		'section'     => 'section_featured_team',   
		'settings'    => 'theme_options[featured_team_page_'.$i.']',		
		'type'        => 'dropdown-pages',
		'active_callback' => 'wisdom_academy_featured_team_page',
		)
	);

	// Posts
	$wp_customize->add_setting('theme_options[featured_team_post_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'wisdom_academy_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[featured_team_post_'.$i.']', 
		array(
		'label'       => sprintf( __('Select Post #%1$s', 'wisdom-academy'), $i),
		'section'     => 'section_featured_team',   
		'settings'    => 'theme_options[featured_team_post_'.$i.']',		
		'type'        => 'select',
		'choices'	  => wisdom_academy_dropdown_posts(),
		'active_callback' => 'wisdom_academy_featured_team_post',
		)
	);

	// Position
	$wp_customize->add_setting('theme_options[featured_team_position_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'sanitize_text_field'
		)
	);

	$wp_customize->add_control('theme_options[featured_team_position_'.$i.']', 
		array(
		'label'       => sprintf( __('Position #%1$s', 'wisdom-academy'), $i),
		'section'     => 'section_featured_team',   
		'settings'    => 'theme_options[featured_team_position_'.$i.']',		
		'active_callback' => 'wisdom_academy_featured_team_active',		
		'type'        => 'text'
		)
	);
}

// Column
$wp_customize->add_setting('theme_options[featured_team_column]', 
	array(
	'default' 			=> $default['featured_team_column'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'wisdom_academy_sanitize_select'
	)
);

$wp_customize->add_control(new wisdom_academy_Image_Radio_Control($wp_customize, 'theme_options[featured_team_column]', 
	array(		
	'label' 	=> __('Select Column', 'wisdom-academy'),
	'section' 	=> 'section_featured_team',
	'settings'  => 'theme_options[featured_team_column]',
	'type' 		=> 'radio-image',
	'active_callback' => 'wisdom_academy_featured_team_active',
	'choices' 	=> array(		
		'1' 	=> esc_url(get_template_directory_uri()) . '/assets/images/column-1.jpg',						
		'2' 	=> esc_url(get_template_directory_uri()) . '/assets/images/column-2.jpg',
		'3' 	=> esc_url(get_template_directory_uri()) . '/assets/images/column-3.jpg',
		'4' 	=> esc_url(get_template_directory_uri()) . '/assets/images/column-4.jpg',
		'5' 	=> esc_url(get_template_directory_uri()) . '/assets/images/column-5.jpg',
		'6' 	=> esc_url(get_template_directory_uri()) . '/assets/images/column-6.jpg',
		),	
	))
);

// Title Font Size
$wp_customize->add_setting( 'theme_options[featured_team_title_font_size]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[featured_team_title_font_size]', array(
	'label'       => esc_html__( 'Title Font Size', 'wisdom-academy' ),
	'section'     => 'section_featured_team',
	'type'        => 'number',
	'active_callback' 	=> 'wisdom_academy_featured_team_active',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// Title Line Height
$wp_customize->add_setting( 'theme_options[featured_team_title_line_height]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[featured_team_title_line_height]', array(
	'label'       => esc_html__( 'Title Line Height', 'wisdom-academy' ),
	'section'     => 'section_featured_team',
	'type'        => 'number',
	'active_callback' 	=> 'wisdom_academy_featured_team_active',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// Title Letter Spacing
$wp_customize->add_setting( 'theme_options[featured_team_title_letter_spacing]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[featured_team_title_letter_spacing]', array(
	'label'       => esc_html__( 'Title Letter Spacing', 'wisdom-academy' ),
	'section'     => 'section_featured_team',
	'type'        => 'number',
	'active_callback' 	=> 'wisdom_academy_featured_team_active',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// Title Font Weight
$wp_customize->add_setting( 'theme_options[featured_team_title_font_weight]', array(
	'default' 			=> $default['featured_team_title_font_weight'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[featured_team_title_font_weight]', array(
	'label'       => esc_html__( 'Title Font Weight', 'wisdom-academy' ),
	'section'     => 'section_featured_team',
	'type'        => 'select',
	'active_callback' 	=> 'wisdom_academy_featured_team_active',
	'choices' 	  => array(		
		'title-font-weight-regular' 	=> 'Regular',		
		'title-font-weight-semi-bold'   => 'Semi-Bold',										
		'title-font-weight-bold'        => 'Bold',
	),	
) );

// Title Text Transform
$wp_customize->add_setting( 'theme_options[featured_team_title_text_transform]', array(
	'default' 			=> $default['featured_team_title_text_transform'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[featured_team_title_text_transform]', array(
	'label'       		=> esc_html__( 'Title Text Transform', 'wisdom-academy' ),
	'section'     		=> 'section_featured_team',
	'type'        		=> 'select',
	'active_callback' 	=> 'wisdom_academy_featured_team_active',
	'active_callback' 	=> 'wisdom_academy_featured_team_active',
	'choices' 	  	  	=> array(		
		'title-default' 		=> 'Default',
		'title-uppercase'   	=> 'Uppercase',		
		'title-lowercase'   	=> 'Lowercase',										
		'title-capitalize'  	=> 'Capitalize',
	),	
) );

// Title Bottom Gap
$wp_customize->add_setting( 'theme_options[featured_team_title_bottom_gap]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[featured_team_title_bottom_gap]', array(
	'label'       => esc_html__( 'Title Bottom Gap', 'wisdom-academy' ),
	'section'     => 'section_featured_team',
	'type'        => 'number',
	'active_callback' 	=> 'wisdom_academy_featured_team_active',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// Content Font Size
$wp_customize->add_setting( 'theme_options[featured_team_content_font_size]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[featured_team_content_font_size]', array(
	'label'       => esc_html__( 'Content Font Size', 'wisdom-academy' ),
	'section'     => 'section_featured_team',
	'type'        => 'number',
	'active_callback' 	=> 'wisdom_academy_featured_team_active',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// Content Line Height
$wp_customize->add_setting( 'theme_options[featured_team_content_line_height]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[featured_team_content_line_height]', array(
	'label'       => esc_html__( 'Content Line Height', 'wisdom-academy' ),
	'section'     => 'section_featured_team',
	'type'        => 'number',
	'active_callback' 	=> 'wisdom_academy_featured_team_active',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// Content Letter Spacing
$wp_customize->add_setting( 'theme_options[featured_team_content_letter_spacing]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[featured_team_content_letter_spacing]', array(
	'label'       => esc_html__( 'Content Letter Spacing', 'wisdom-academy' ),
	'section'     => 'section_featured_team',
	'type'        => 'number',
	'active_callback' 	=> 'wisdom_academy_featured_team_active',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// Content Font Weight
$wp_customize->add_setting( 'theme_options[featured_team_content_font_weight]', array(
	'default' 			=> $default['featured_team_content_font_weight'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[featured_team_content_font_weight]', array(
	'label'       => esc_html__( 'Content Font Weight', 'wisdom-academy' ),
	'section'     => 'section_featured_team',
	'type'        => 'select',
	'active_callback' 	=> 'wisdom_academy_featured_team_active',
	'choices' 	  => array(		
		'content-font-weight-regular' 	=> 'Regular',		
		'content-font-weight-semi-bold' => 'Semi-Bold',										
		'content-font-weight-bold'      => 'Bold',
	),	
) );

// Content Text Transform
$wp_customize->add_setting( 'theme_options[featured_team_content_text_transform]', array(
	'default' 			=> $default['featured_team_content_text_transform'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[featured_team_content_text_transform]', array(
	'label'       		=> esc_html__( 'Content Text Transform', 'wisdom-academy' ),
	'section'     		=> 'section_featured_team',
	'type'        		=> 'select',
	'active_callback' 	=> 'wisdom_academy_featured_team_active',
	'choices' 	  	  	=> array(		
		'content-default' 		=> 'Default',
		'content-uppercase'   	=> 'Uppercase',		
		'content-lowercase'   	=> 'Lowercase',										
		'content-capitalize'  	=> 'Capitalize',
	),	
) );

// Show / Hide Image
$wp_customize->add_setting( 'theme_options[show_featured_team_image]', array(
	'default'           => $default['show_featured_team_image'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[show_featured_team_image]', array(
	'label'              => esc_html__( 'Display Image', 'wisdom-academy' ),
	'section'            => 'section_featured_team',
	'type'               => 'select',
	'active_callback'    => 'wisdom_academy_featured_team_active',
	'choices' 	         => array(		
		'image-enable' 	 => 'Yes',						
		'image-disable'   => 'No',
	),	
) );

// Show / Hide Position
$wp_customize->add_setting( 'theme_options[show_featured_team_position]', array(
	'default'           => $default['show_featured_team_position'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[show_featured_team_position]', array(
	'label'              => esc_html__( 'Display Position', 'wisdom-academy' ),
	'section'            => 'section_featured_team',
	'type'               => 'select',
	'active_callback'    => 'wisdom_academy_featured_team_active',
	'choices' 	         => array(		
		'position-enable' 	 => 'Yes',						
		'position-disable'  => 'No',
	),	
) );

// Show / Hide Title
$wp_customize->add_setting( 'theme_options[show_featured_team_title]', array(
	'default'           => $default['show_featured_team_title'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[show_featured_team_title]', array(
	'label'              => esc_html__( 'Display Title', 'wisdom-academy' ),
	'section'            => 'section_featured_team',
	'type'               => 'select',
	'active_callback'    => 'wisdom_academy_featured_team_active',
	'choices' 	         => array(		
		'title-enable' 	 => 'Yes',						
		'title-disable'  => 'No',
	),	
) );

// Show / Hide Content
$wp_customize->add_setting( 'theme_options[show_featured_team_content]', array(
	'default'           => $default['show_featured_team_content'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[show_featured_team_content]', array(
	'label'       => esc_html__( 'Display Content', 'wisdom-academy' ),
	'section'     => 'section_featured_team',
	'type'        => 'select',
	'active_callback' => 'wisdom_academy_featured_team_active',
	'choices' 	  => array(		
		'content-enable' 	=> 'Yes',						
		'content-disable'  => 'No',
	),	
) );