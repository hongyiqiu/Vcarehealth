<?php
/**
 * Featured Gallery options.
 *
 * @package Wisdom Academy
 */

$default = wisdom_academy_get_default_theme_options();

// Featured Gallery Section
$wp_customize->add_section( 'section_featured_gallery',
	array(
	'title'      => __( 'Gallery Section', 'wisdom-academy' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'home_page_panel',
	)
);

// Enable Featured Gallery Section
$wp_customize->add_setting('theme_options[enable_featured_gallery_section]', 
	array(
	'default' 			=> $default['enable_featured_gallery_section'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'wisdom_academy_sanitize_checkbox'
	)
);

$wp_customize->add_control('theme_options[enable_featured_gallery_section]', 
	array(		
	'label' 	=> __('Enable Section', 'wisdom-academy'),
	'section' 	=> 'section_featured_gallery',
	'settings'  => 'theme_options[enable_featured_gallery_section]',
	'type' 		=> 'checkbox',	
	)
);

// Section Title
$wp_customize->add_setting('theme_options[featured_gallery_section_title]', 
	array(
	'default'           => $default['featured_gallery_section_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[featured_gallery_section_title]', 
	array(
	'label'       => __('Section Title', 'wisdom-academy'),
	'section'     => 'section_featured_gallery',   
	'settings'    => 'theme_options[featured_gallery_section_title]',	
	'active_callback' => 'wisdom_academy_featured_gallery_active',		
	'type'        => 'text'
	)
);

// Number of items
$wp_customize->add_setting('theme_options[number_of_featured_gallery_items]', 
	array(
	'default' 			=> $default['number_of_featured_gallery_items'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'wisdom_academy_sanitize_number_range'
	)
);

$wp_customize->add_control('theme_options[number_of_featured_gallery_items]', 
	array(
	'label'       => __('Items (Max: 6)', 'wisdom-academy'),
	'section'     => 'section_featured_gallery',   
	'settings'    => 'theme_options[number_of_featured_gallery_items]',		
	'type'        => 'number',
	'active_callback' => 'wisdom_academy_featured_gallery_active',
	'input_attrs' => array(
			'min'	=> 1,
			'max'	=> 6,
			'step'	=> 1,
		),
	)
);

// Column
$wp_customize->add_setting('theme_options[featured_gallery_column]', 
	array(
	'default' 			=> $default['featured_gallery_column'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'wisdom_academy_sanitize_select'
	)
);

$wp_customize->add_control(new wisdom_academy_Image_Radio_Control($wp_customize, 'theme_options[featured_gallery_column]', 
	array(		
	'label' 	=> __('Select Column', 'wisdom-academy'),
	'section' 	=> 'section_featured_gallery',
	'settings'  => 'theme_options[featured_gallery_column]',
	'type' 		=> 'radio-image',
	'active_callback' => 'wisdom_academy_featured_gallery_active',
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
$wp_customize->add_setting('theme_options[featured_gallery_content_type]', 
	array(
	'default' 			=> $default['featured_gallery_content_type'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'wisdom_academy_sanitize_select'
	)
);

$wp_customize->add_control('theme_options[featured_gallery_content_type]', 
	array(
	'label'       => __('Content Type', 'wisdom-academy'),
	'section'     => 'section_featured_gallery',   
	'settings'    => 'theme_options[featured_gallery_content_type]',		
	'type'        => 'select',
	'active_callback' => 'wisdom_academy_featured_gallery_active',
	'choices'	  => array(
			'featured_gallery_page'	     => __('Page','wisdom-academy'),
			'featured_gallery_post'	     => __('Post','wisdom-academy'),
		),
	)
);

$number_of_featured_gallery_items = wisdom_academy_get_option( 'number_of_featured_gallery_items' );

for( $i=1; $i<=$number_of_featured_gallery_items; $i++ ) {

	// Page
	$wp_customize->add_setting('theme_options[featured_gallery_page_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'wisdom_academy_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[featured_gallery_page_'.$i.']', 
		array(
		'label'       => sprintf( __('Select Page #%1$s', 'wisdom-academy'), $i),
		'section'     => 'section_featured_gallery',   
		'settings'    => 'theme_options[featured_gallery_page_'.$i.']',		
		'type'        => 'dropdown-pages',
		'active_callback' => 'wisdom_academy_featured_gallery_page',
		)
	);

	// Posts
	$wp_customize->add_setting('theme_options[featured_gallery_post_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'wisdom_academy_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[featured_gallery_post_'.$i.']', 
		array(
		'label'       => sprintf( __('Select Post #%1$s', 'wisdom-academy'), $i),
		'section'     => 'section_featured_gallery',   
		'settings'    => 'theme_options[featured_gallery_post_'.$i.']',		
		'type'        => 'select',
		'choices'	  => wisdom_academy_dropdown_posts(),
		'active_callback' => 'wisdom_academy_featured_gallery_post',
		)
	);
}