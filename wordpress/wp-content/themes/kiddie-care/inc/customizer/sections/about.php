<?php
/**
 * About options.
 *
 * @package Kiddie Care
 */

$default = kiddie_care_get_default_theme_options();

// About Section
$wp_customize->add_section( 'section_home_about',
	array(
		'title'      => __( 'About Section', 'kiddie-care' ),
		'priority'   => 20,
		'capability' => 'edit_theme_options',
		'panel'      => 'home_page_panel',
		)
);

$wp_customize->add_setting( 'theme_options[disable_about_section]',
	array(
		'default'           => $default['disable_about_section'],
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'kiddie_care_sanitize_switch_control',
	)
);
$wp_customize->add_control( new Kiddie_Care_Switch_Control( $wp_customize, 'theme_options[disable_about_section]',
    array(
		'label' 			=> __('Enable/Disable About Section', 'kiddie-care'),
		'section'    		=> 'section_home_about',
		 'settings'  		=> 'theme_options[disable_about_section]',
		'on_off_label' 		=> kiddie_care_switch_options(),
    )
) );

// Additional Information First Page
	$wp_customize->add_setting('theme_options[about_page]', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'kiddie_care_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[about_page]', 
		array(
		'label'       => __('Select Page kiddie-care', 'kiddie-care'),
		'section'     => 'section_home_about',   
		'settings'    => 'theme_options[about_page]',		
		'type'        => 'dropdown-pages',
		'active_callback' => 'kiddie_care_about_active',
		)
	);

// About Button Text
$wp_customize->add_setting('theme_options[about_btn_text]', 
	array(
	'default'           => $default['about_btn_text'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[about_btn_text]', 
	array(
	'label'       => __('Button Label', 'kiddie-care'),
	'section'     => 'section_home_about',   
	'settings'    => 'theme_options[about_btn_text]',	
	'active_callback' => 'kiddie_care_about_active',	
	'type'        => 'text'
	)
);
