<?php
/**
 * Gallery options.
 *
 * @package Kiddie Care
 */

$default = kiddie_care_get_default_theme_options();

// Gallery Section
$wp_customize->add_section( 'section_home_gallery',
	array(
		'title'      => __( ' Gallery Section', 'kiddie-care' ),
		'priority'   => 50,
		'capability' => 'edit_theme_options',
		'panel'      => 'home_page_panel',
		)
);

$wp_customize->add_setting( 'theme_options[disable_gallery_section]',
	array(
		'default'           => $default['disable_gallery_section'],
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'kiddie_care_sanitize_switch_control',
	)
);
$wp_customize->add_control( new Kiddie_Care_Switch_Control( $wp_customize, 'theme_options[disable_gallery_section]',
    array(
		'label' 			=> __('Enable/Disable Gallery Section', 'kiddie-care'),
		'section'    		=> 'section_home_gallery',
		'settings'  		=> 'theme_options[disable_gallery_section]',
		'on_off_label' 		=> kiddie_care_switch_options(),
    )
) );

//Gallery Section title
$wp_customize->add_setting('theme_options[gallery_title]', 
	array(
	'default'           => $default['gallery_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[gallery_title]', 
	array(
	'label'       => __('Section Title', 'kiddie-care'),
	'section'     => 'section_home_gallery',   
	'settings'    => 'theme_options[gallery_title]',
	'active_callback' => 'kiddie_care_gallery_active',		
	'type'        => 'text'
	)
);

for( $i=1; $i<=6; $i++ ){

	// Additional Information First Page
	$wp_customize->add_setting('theme_options[gallery_page_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'kiddie_care_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[gallery_page_'.$i.']', 
		array(
		'label'       => sprintf( __('Select Page #%1$s', 'kiddie-care'), $i),
		'section'     => 'section_home_gallery',   
		'settings'    => 'theme_options[gallery_page_'.$i.']',		
		'type'        => 'dropdown-pages',
		'active_callback' => 'kiddie_care_gallery_active',
		)
	);

}
