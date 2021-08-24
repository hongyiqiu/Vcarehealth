<?php 

/**
 * Theme Options.
 *
 * @package Kiddie Care
 */

$default = kiddie_care_get_default_theme_options();
//For General Option
$wp_customize->add_section('section_general', array(    
'title'       => __('General Setting', 'kiddie-care'),
'panel'       => 'theme_option_panel'    
));

$wp_customize->add_setting( 'theme_options[disable_homepage_content_section]',
	array(
		'default'           => true,
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'kiddie_care_sanitize_switch_control',
	)
);
$wp_customize->add_control( new Kiddie_Care_Switch_Control( $wp_customize, 'theme_options[disable_homepage_content_section]',
    array(
		'label' 			=> __('Enable/Disable Static Homepage Content Section', 'kiddie-care'),
		'description' => __('This option is only work on Static HomePage ', 'kiddie-care'),
		'section'    		=> 'section_general',
		 'settings'  		=> 'theme_options[disable_homepage_content_section]',
		'on_off_label' 		=> kiddie_care_switch_options(),
    )
) );

// Setting excerpt_length.
$wp_customize->add_setting( 'theme_options[excerpt_length]', array(
	'default'           => $default['excerpt_length'],
	'sanitize_callback' => 'kiddie_care_sanitize_positive_integer',
) );
$wp_customize->add_control( 'theme_options[excerpt_length]', array(
	'label'       => esc_html__( 'Excerpt Length', 'kiddie-care' ),
	'description' => esc_html__( 'in words', 'kiddie-care' ),
	'section'     => 'section_general',
	'type'        => 'number',
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 55px;' ),
) );

 ?>