<?php
/**
 * Theme Options.
 *
 * @package Wisdom Academy
 */

$default = wisdom_academy_get_default_theme_options();

// Add Panel.
$wp_customize->add_panel( 'theme_option_panel',
	array(
	'title'      => __( 'Wisdom Academy Options', 'wisdom-academy' ),
	'priority'   => 150,
	'capability' => 'edit_theme_options',
	)
);

// Page Title
$wp_customize->add_section('section_page_title', 
	array(    
	'title'       => __('Page Title', 'wisdom-academy'),
	'panel'       => 'theme_option_panel'    
	)
);

// Show / Hide Page Title
$wp_customize->add_setting( 'theme_options[show_page_title]', array(
	'default'           => $default['show_page_title'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[show_page_title]', array(
	'label'              => esc_html__( 'Display Page Title', 'wisdom-academy' ),
	'section'            => 'section_page_title',
	'type'               => 'select',
	'choices' 	         => array(		
		'page-title-enable' 	 => 'Yes',						
		'page-title-disable'     => 'No',
	),	
) );

// Sidebar Layout
$wp_customize->add_section('section_sidebar_layout', array(    
	'title'       => __('Sidebar Layout', 'wisdom-academy'),
	'panel'       => 'theme_option_panel'    
));

// Blog Layout
$wp_customize->add_setting('theme_options[layout_options_blog]', 
	array(
	'default' 			=> $default['layout_options_blog'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'wisdom_academy_sanitize_select'
	)
);

$wp_customize->add_control(new wisdom_academy_Image_Radio_Control($wp_customize, 'theme_options[layout_options_blog]', 
	array(		
	'label' 	=> __('Blog Layout', 'wisdom-academy'),
	'section' 	=> 'section_sidebar_layout',
	'settings'  => 'theme_options[layout_options_blog]',
	'type' 		=> 'radio-image',
	'choices' 	=> array(		
		'left-sidebar' 	=> get_template_directory_uri() . '/assets/images/left-sidebar.png',						
		'right-sidebar' => get_template_directory_uri() . '/assets/images/right-sidebar.png',
		'no-sidebar' 	=> get_template_directory_uri() . '/assets/images/no-sidebar.png',
		),	
	))
);

// Archive Layout
$wp_customize->add_setting('theme_options[layout_options_archive]', 
	array(
	'default' 			=> $default['layout_options_archive'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'wisdom_academy_sanitize_select'
	)
);

$wp_customize->add_control(new wisdom_academy_Image_Radio_Control($wp_customize, 'theme_options[layout_options_archive]', 
	array(		
	'label' 	=> __('Archive Layout', 'wisdom-academy'),
	'section' 	=> 'section_sidebar_layout',
	'settings'  => 'theme_options[layout_options_archive]',
	'type' 		=> 'radio-image',
	'choices' 	=> array(		
		'left-sidebar' 	=> get_template_directory_uri() . '/assets/images/left-sidebar.png',						
		'right-sidebar' => get_template_directory_uri() . '/assets/images/right-sidebar.png',
		'no-sidebar' 	=> get_template_directory_uri() . '/assets/images/no-sidebar.png',
		),	
	))
);


// Page Layout
$wp_customize->add_setting('theme_options[layout_options_page]', 
	array(
	'default' 			=> $default['layout_options_page'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'wisdom_academy_sanitize_select'
	)
);

$wp_customize->add_control(new wisdom_academy_Image_Radio_Control($wp_customize, 'theme_options[layout_options_page]', 
	array(		
	'label' 	=> __('Page Layout', 'wisdom-academy'),
	'section' 	=> 'section_sidebar_layout',
	'settings'  => 'theme_options[layout_options_page]',
	'type' 		=> 'radio-image',
	'choices' 	=> array(		
		'left-sidebar' 	=> get_template_directory_uri() . '/assets/images/left-sidebar.png',						
		'right-sidebar' => get_template_directory_uri() . '/assets/images/right-sidebar.png',
		'no-sidebar' 	=> get_template_directory_uri() . '/assets/images/no-sidebar.png',
		),	
	))
);

// Single Post Layout
$wp_customize->add_setting('theme_options[layout_options_single]', 
	array(
	'default' 			=> $default['layout_options_single'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'wisdom_academy_sanitize_select'
	)
);

$wp_customize->add_control(new wisdom_academy_Image_Radio_Control($wp_customize, 'theme_options[layout_options_single]', 
	array(		
	'label' 	=> __('Single Post Layout', 'wisdom-academy'),
	'section' 	=> 'section_sidebar_layout',
	'settings'  => 'theme_options[layout_options_single]',
	'type' 		=> 'radio-image',
	'choices' 	=> array(		
		'left-sidebar' 	=> get_template_directory_uri() . '/assets/images/left-sidebar.png',						
		'right-sidebar' => get_template_directory_uri() . '/assets/images/right-sidebar.png',
		'no-sidebar' 	=> get_template_directory_uri() . '/assets/images/no-sidebar.png',
		),	
	))
);

// Excerpt Length
$wp_customize->add_section('section_excerpt_length', 
	array(    
	'title'       => __('Excerpt Length', 'wisdom-academy'),
	'panel'       => 'theme_option_panel'    
	)
);

$wp_customize->add_setting( 'theme_options[excerpt_length]', array(
	'default'           => $default['excerpt_length'],
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );
$wp_customize->add_control( 'theme_options[excerpt_length]', array(
	'label'       => esc_html__( 'Excerpt Length', 'wisdom-academy' ),
	'section'     => 'section_excerpt_length',
	'type'        => 'number',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// Blog Settings
$wp_customize->add_section('section_blog_setting', 
	array(    
	'title'       => __('Blog / Archive Settings', 'wisdom-academy'),
	'panel'       => 'theme_option_panel'    
	)
);

// Blog Title
$wp_customize->add_setting( 'theme_options[your_latest_posts_title]',
	array(
	'default'           => $default['your_latest_posts_title'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'wisdom_academy_sanitize_textarea_content',
	'transport'         => 'refresh',
	)
);
$wp_customize->add_control( 'theme_options[your_latest_posts_title]',
	array(
	'label'    => __( 'Blog Title', 'wisdom-academy' ),
	'section'  => 'section_blog_setting',
	'type'     => 'text',
	)
);

// Blog Button Label
$wp_customize->add_setting( 'theme_options[readmore_text]',
	array(
	'default'           => $default['readmore_text'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'wisdom_academy_sanitize_textarea_content',
	'transport'         => 'refresh',
	)
);

$wp_customize->add_control( 'theme_options[readmore_text]',
	array(
	'label'    => __( 'Button Label', 'wisdom-academy' ),
	'section'  => 'section_blog_setting',
	'type'     => 'text',
	)
);

// Footer Setting Section starts
$wp_customize->add_section('section_footer', 
	array(    
	'title'       => __('Footer Setting', 'wisdom-academy'),
	'panel'       => 'theme_option_panel'    
	)
);

// Setting copyright_text.
$wp_customize->add_setting( 'theme_options[copyright_text]',
	array(
	'default'           => $default['copyright_text'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	'transport'         => 'refresh',
	)
);
$wp_customize->add_control( 'theme_options[copyright_text]',
	array(
	'label'    => __( 'Copyright Text', 'wisdom-academy' ),
	'section'  => 'section_footer',
	'type'     => 'text',
	'priority' => 100,
	)
);

// Homepage Static setting and control.
$wp_customize->add_setting( 'theme_options[enable_frontpage_content]', array(
	'default'             => $default['enable_frontpage_content'],
	'sanitize_callback'   => 'wisdom_academy_sanitize_checkbox',
) );

$wp_customize->add_control( 'theme_options[enable_frontpage_content]', array(
	'label'       	=> __( 'Enable Content', 'wisdom-academy' ),
	'description' 	=> __( 'Click to enable content on static front page only.', 'wisdom-academy' ),
	'section'     	=> 'static_front_page',
	'type'        	=> 'checkbox',
) );

// Show / Hide Blog Image
$wp_customize->add_setting( 'theme_options[show_blog_posts_image]', array(
	'default'           => $default['show_blog_posts_image'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[show_blog_posts_image]', array(
	'label'              => esc_html__( 'Display Image', 'wisdom-academy' ),
	'section'            => 'section_blog_setting',
	'type'               => 'select',
	'choices' 	         => array(		
		'image-enable' 	 => 'Yes',						
		'image-disable'   => 'No',
	),	
) );

// Show / Hide Blog Category
$wp_customize->add_setting( 'theme_options[show_blog_posts_category]', array(
	'default'           => $default['show_blog_posts_category'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[show_blog_posts_category]', array(
	'label'              => esc_html__( 'Display Category', 'wisdom-academy' ),
	'section'            => 'section_blog_setting',
	'type'               => 'select',
	'choices' 	         => array(		
		'category-enable' 	 => 'Yes',						
		'category-disable'  => 'No',
	),	
) );

// Show / Hide Blog Title
$wp_customize->add_setting( 'theme_options[show_blog_posts_title]', array(
	'default'           => $default['show_blog_posts_title'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[show_blog_posts_title]', array(
	'label'              => esc_html__( 'Display Title', 'wisdom-academy' ),
	'section'            => 'section_blog_setting',
	'type'               => 'select',
	'choices' 	         => array(		
		'title-enable' 	 => 'Yes',						
		'title-disable'  => 'No',
	),	
) );

// Show / Hide Blog Content
$wp_customize->add_setting( 'theme_options[show_blog_posts_content]', array(
	'default'           => $default['show_blog_posts_content'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[show_blog_posts_content]', array(
	'label'       => esc_html__( 'Display Content', 'wisdom-academy' ),
	'section'     => 'section_blog_setting',
	'type'        => 'select',
	'choices' 	  => array(		
		'content-enable' 	=> 'Yes',						
		'content-disable'  => 'No',
	),	
) );

// Show / Hide Blog Button
$wp_customize->add_setting( 'theme_options[show_blog_posts_button]', array(
	'default'           => $default['show_blog_posts_button'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[show_blog_posts_button]', array(
	'label'       => esc_html__( 'Display Button', 'wisdom-academy' ),
	'section'     => 'section_blog_setting',
	'type'        => 'select',
	'choices' 	  => array(		
		'button-enable' 	=> 'Yes',						
		'button-disable'    => 'No',
	),	
) );

// Typography
$wp_customize->add_section('section_typography', 
	array(  
    'capability'  => 'edit_theme_options',  
	'title'       => __('Global Typography', 'wisdom-academy'),
	'panel'       => 'theme_option_panel'    
	)
);

// H1 Font Size
$wp_customize->add_setting( 'theme_options[h1_font_size]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[h1_font_size]', array(
	'label'       => esc_html__( 'H1 Font Size (Default: 52)', 'wisdom-academy' ),
	'section'     => 'section_typography',
	'type'        => 'number',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// H2 Font Size
$wp_customize->add_setting( 'theme_options[h2_font_size]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[h2_font_size]', array(
	'label'       => esc_html__( 'H2 Font Size (Default: 42)', 'wisdom-academy' ),
	'section'     => 'section_typography',
	'type'        => 'number',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// H3 Font Size
$wp_customize->add_setting( 'theme_options[h3_font_size]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[h3_font_size]', array(
	'label'       => esc_html__( 'H3 Font Size (Default: 32)', 'wisdom-academy' ),
	'section'     => 'section_typography',
	'type'        => 'number',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// H4 Font Size
$wp_customize->add_setting( 'theme_options[h4_font_size]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[h4_font_size]', array(
	'label'       => esc_html__( 'H4 Font Size (Default: 22)', 'wisdom-academy' ),
	'section'     => 'section_typography',
	'type'        => 'number',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// H5 Font Size
$wp_customize->add_setting( 'theme_options[h5_font_size]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[h5_font_size]', array(
	'label'       => esc_html__( 'H5 Font Size (Default: 18)', 'wisdom-academy' ),
	'section'     => 'section_typography',
	'type'        => 'number',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// H6 Font Size
$wp_customize->add_setting( 'theme_options[h6_font_size]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[h6_font_size]', array(
	'label'       => esc_html__( 'H6 Font Size (Default: 16)', 'wisdom-academy' ),
	'section'     => 'section_typography',
	'type'        => 'number',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// Body Font Size
$wp_customize->add_setting( 'theme_options[body_font_size]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[body_font_size]', array(
	'label'       => esc_html__( 'Body Font Size (Default: 16)', 'wisdom-academy' ),
	'section'     => 'section_typography',
	'type'        => 'number',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// Body Line Height
$wp_customize->add_setting( 'theme_options[body_line_height]', array(
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range',
) );

$wp_customize->add_control( 'theme_options[body_line_height]', array(
	'label'       => esc_html__( 'Body Line Height (Default: 28)', 'wisdom-academy' ),
	'section'     => 'section_typography',
	'type'        => 'number',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 80px;' ),
) );

// Custom Theme Color
$wp_customize->add_setting( 'theme_options[custom_theme_color]', array(
	'default'           => $default['custom_theme_color'],
	'sanitize_callback' => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'theme_options[custom_theme_color]', array(
	'label'             => esc_html__( 'Main Theme Color', 'wisdom-academy' ),
	'section'           => 'colors',
) ) );


// Top Bar Background Color
$wp_customize->add_setting( 'theme_options[top_bar_color]', array(
	'default'           => $default['top_bar_color'],
	'sanitize_callback' => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'theme_options[top_bar_color]', array(
	'label'             => esc_html__( 'Top Bar Color', 'wisdom-academy' ),
	'section'           => 'colors',
) ) );

// Show / Hide Frontpage Content
$wp_customize->add_setting( 'theme_options[enable_frontpage_content]', array(
	'default'             => $default['enable_frontpage_content'],
	'sanitize_callback'   => 'wisdom_academy_sanitize_checkbox',
) );

$wp_customize->add_control( 'theme_options[enable_frontpage_content]', array(
	'label'       	=> esc_html__( 'Enable Homepage Content', 'wisdom-academy' ),
	'description' 	=> esc_html__( 'Enable content on A static page.', 'wisdom-academy' ),
	'section'     	=> 'static_front_page',
	'type'        	=> 'checkbox',
) );

// Show / Hide Header Image
$wp_customize->add_setting( 'theme_options[show_header_image]', array(
	'default'           => $default['show_header_image'],
	'sanitize_callback' => 'wisdom_academy_sanitize_select',
) );

$wp_customize->add_control( 'theme_options[show_header_image]', array(
	'label'              => esc_html__( 'Display Header Image', 'wisdom-academy' ),
	'section'            => 'header_image',
	'type'               => 'select',
	'choices' 	         => array(		
		'header-image-enable' 	   => 'Yes',						
		'header-image-disable'     => 'No',
	),	
) );