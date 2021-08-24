<?php
/**
 * Team options.
 *
 * @package Kiddie Care
 */

$default = kiddie_care_get_default_theme_options();

// Team Section
$wp_customize->add_section( 'section_home_team',
	array(
		'title'      => __( 'Team Section', 'kiddie-care' ),
		'priority'   => 35,
		'capability' => 'edit_theme_options',
		'panel'      => 'home_page_panel',
		)
);

$wp_customize->add_setting( 'theme_options[disable_team_section]',
	array(
		'default'           => $default['disable_team_section'],
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'kiddie_care_sanitize_switch_control',
	)
);
$wp_customize->add_control( new Kiddie_Care_Switch_Control( $wp_customize, 'theme_options[disable_team_section]',
    array(
		'label' 			=> __('Enable/Disable Team Section', 'kiddie-care'),
		'section'    		=> 'section_home_team',
		 'settings'  		=> 'theme_options[disable_team_section]',
		'on_off_label' 		=> kiddie_care_switch_options(),
    )
) );

//Team Section title
$wp_customize->add_setting('theme_options[team_title]', 
	array(
	'default'           => $default['team_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[team_title]', 
	array(
	'label'       => __('Section Title', 'kiddie-care'),
	'section'     => 'section_home_team',   
	'settings'    => 'theme_options[team_title]',
	'active_callback' => 'kiddie_care_team_active',		
	'type'        => 'text'
	)
);

for( $i=1; $i<=4; $i++ ){

	// Additional Information First Page
	$wp_customize->add_setting('theme_options[team_page_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'kiddie_care_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[team_page_'.$i.']', 
		array(
		'label'       => sprintf( __('Select Page #%1$s', 'kiddie-care'), $i),
		'section'     => 'section_home_team',   
		'settings'    => 'theme_options[team_page_'.$i.']',		
		'type'        => 'dropdown-pages',
		'active_callback' => 'kiddie_care_team_active',
		)
	);

	// team title setting and control
	$wp_customize->add_setting( 'theme_options[team_custom_position_' . $i . ']', array(
		'type'              => 'theme_mod',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'theme_options[team_custom_position_' . $i . ']', array(
		'label'           	=> sprintf( __( 'Position %d', 'kiddie-care' ), $i ),
		'section'        	=> 'section_home_team',
		'settings'    		=> 'theme_options[team_custom_position_'.$i.']',	
		'active_callback' 	=> 'kiddie_care_team_active',
		'type'				=> 'text',
	) );

	// team hr setting and control
	$wp_customize->add_setting( 'theme_options[team_hr_'. $i .']', array(
		'sanitize_callback' => 'sanitize_text_field'
	) );

	$wp_customize->add_control( new Kiddie_Care_Customize_Horizontal_Line( $wp_customize, 'theme_options[team_hr_'. $i .']',
		array(
			'label'             => __( '<hr style="width: 100%; border: 2px #bcb1b1 solid;"/>', 'kiddie-care' ),
			'section'         => 'section_home_team',
			'active_callback' => 'kiddie_care_team_active',
			'type'			  => 'hr',
	) ) );
}
