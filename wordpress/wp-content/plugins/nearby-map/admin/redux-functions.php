<?php

/**
 * Load the custome style for Redux Panel
 *
 * @since 1.0
 */
function cspm_nearby_map_customize_redux_panel_css(){

	if (!class_exists('CspmNearbyMap'))
		return; 
	
	$CspmNearbyMapClass = CspmNearbyMap::this();

	/**
	 * Our custom style */
	 
    wp_register_style(
        'cspm_nearby_map-redux-custom-css',
        $CspmNearbyMapClass->csnm_plugin_url.'admin/style.css',
        array('redux-admin-css'), // Be sure to include redux-admin-css so it's appended after the core css is applied
        time(),
        'all'
    );  
	
    wp_enqueue_style('cspm_nearby_map-redux-custom-css');
	
}
add_action('redux/page/cspm_nearby_map/enqueue', 'cspm_nearby_map_customize_redux_panel_css');

