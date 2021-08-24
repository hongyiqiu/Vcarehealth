<?php
/**
 * Services options.
 *
 * @package Kiddie Care
 */

$default = kiddie_care_get_default_theme_options();

// Services Section
$wp_customize->add_section( 'section_home_service',
	array(
		'title'      => __( 'Services Section', 'kiddie-care' ),
		'priority'   => 15,
		'capability' => 'edit_theme_options',
		'panel'      => 'home_page_panel',
		)
);

$wp_customize->add_setting( 'theme_options[disable_services_section]',
	array(
		'default'           => $default['disable_services_section'],
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'kiddie_care_sanitize_switch_control',
	)
);
$wp_customize->add_control( new Kiddie_Care_Switch_Control( $wp_customize, 'theme_options[disable_services_section]',
    array(
		'label' 			=> __('Enable/Disable Service Section', 'kiddie-care'),
		'section'    		=> 'section_home_service',
		 'settings'  		=> 'theme_options[disable_services_section]',
		'on_off_label' 		=> kiddie_care_switch_options(),
    )
) );

//Services Section title
$wp_customize->add_setting('theme_options[service_title]', 
	array(
	'default'           => $default['service_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[service_title]', 
	array(
	'label'       => __('Section Title', 'kiddie-care'),
	'section'     => 'section_home_service',   
	'settings'    => 'theme_options[service_title]',
	'active_callback' => 'kiddie_care_services_active',		
	'type'        => 'text'
	)
);

for( $i=1; $i<=3; $i++ ){

		//Services Section icon
	$wp_customize->add_setting('theme_options[service_icon_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'sanitize_text_field'
		)
	);

	$wp_customize->add_control('theme_options[service_icon_'.$i.']', 
		array(
		'label'       => sprintf( __('Icon #%1$s', 'kiddie-care'), $i),
		'description' => sprintf( __('Please input icon as eg: fa-archive. Find Font-awesome icons %1$shere%2$s', 'kiddie-care'), '<a href="' . esc_url( 'https://fontawesome.com/v4.7.0/cheatsheet/' ) . '" target="_blank">', '</a>' ),
		'section'     => 'section_home_service',   
		'settings'    => 'theme_options[service_icon_'.$i.']',
		'active_callback' => 'kiddie_care_services_active',		
		'type'        => 'text'
		)
	);

	// Additional Information First Page
	$wp_customize->add_setting('theme_options[services_page_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'kiddie_care_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[services_page_'.$i.']', 
		array(
		'label'       => sprintf( __('Select Page #%1$s', 'kiddie-care'), $i),
		'section'     => 'section_home_service',   
		'settings'    => 'theme_options[services_page_'.$i.']',		
		'type'        => 'dropdown-pages',
		'active_callback' => 'kiddie_care_services_active',
		)
	);
}