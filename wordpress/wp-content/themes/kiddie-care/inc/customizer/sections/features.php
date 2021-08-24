<?php
/**
 * Course options.
 *
 * @package Kiddie Care
 */

$default = kiddie_care_get_default_theme_options();

// Course Section
$wp_customize->add_section( 'section_home_course',
	array(
		'title'      => __( ' Course Section', 'kiddie-care' ),
		'priority'   => 30,
		'capability' => 'edit_theme_options',
		'panel'      => 'home_page_panel',
		)
);

$wp_customize->add_setting( 'theme_options[disable_course_section]',
	array(
		'default'           => $default['disable_course_section'],
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'kiddie_care_sanitize_switch_control',
	)
);
$wp_customize->add_control( new Kiddie_Care_Switch_Control( $wp_customize, 'theme_options[disable_course_section]',
    array(
		'label' 			=> __('Enable/Disable Course Section', 'kiddie-care'),
		'section'    		=> 'section_home_course',
		'settings'  		=> 'theme_options[disable_course_section]',
		'on_off_label' 		=> kiddie_care_switch_options(),
    )
) );

//Course Section title
$wp_customize->add_setting('theme_options[course_title]', 
	array(
	'default'           => $default['course_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[course_title]', 
	array(
	'label'       => __('Section Title', 'kiddie-care'),
	'section'     => 'section_home_course',   
	'settings'    => 'theme_options[course_title]',
	'active_callback' => 'kiddie_care_course_active',		
	'type'        => 'text'
	)
);



// Setting  Course Category.
$wp_customize->add_setting( 'theme_options[course_category]',
	array(

	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	new Kiddie_Care_Dropdown_Taxonomies_Control( $wp_customize, 'theme_options[course_category]',
		array(
		'label'    => __( 'Select Category', 'kiddie-care' ),
		'section'  => 'section_home_course',
		'settings' => 'theme_options[course_category]',	
		'active_callback' => 'kiddie_care_course_active',		
		)
	)
);
