<?php

/**
 * TGM Init Class
 */
include_once ('class-tgm-plugin-activation.php');

function cspm_nearby_map_register_required_plugins() {

	$plugins = array(
		array(
			'name' 	   => 'Redux Framework',
			'slug' 	   => 'redux-framework',
			'required' => true,
			'force_activation' => true,
		),		
	);

	$config = array(
		'domain'       		=> 'cs_nearby_map',         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		//'parent_menu_slug' 	=> 'plugins.php', 				// Default parent menu slug
		//'parent_url_slug' 	=> 'plugins.php', 				// Default parent URL slug
                'parent_slug'           => 'plugins.php',
                'capability'            => 'manage_options',
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
		'dismissable'  		=> false,                    // If false, a user cannot dismiss the nag message.

		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'cs_nearby_map' ),
			'menu_title'                      => __( 'Install Plugins', 'cs_nearby_map' ),
			'installing'                      => __( 'Installing Plugin: %s', 'cs_nearby_map' ), // %s = plugin name.
			'oops'                            => __( 'Something went wrong with the plugin API.', 'cs_nearby_map' ),
			'notice_can_install_required'     => _n_noop(
				'The plugin "Nearby Places" requires the following plugin: %1$s.',
				'The plugin "Nearby Places" requires the following plugins: %1$s.',
				'cs_nearby_map'
			), // %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop(
				'The plugin "Nearby Places" recommends the following plugin: %1$s.',
				'The plugin "Nearby Places" recommends the following plugins: %1$s.',
				'cs_nearby_map'
			), // %1$s = plugin name(s).
			'notice_cannot_install'           => _n_noop(
				'Sorry, but you do not have the correct permissions to install the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to install the %1$s plugins.',
				'cs_nearby_map'
			), // %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop(
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'cs_nearby_map'
			), // %1$s = plugin name(s).
			'notice_ask_to_update_maybe'      => _n_noop(
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'cs_nearby_map'
			), // %1$s = plugin name(s).
			'notice_cannot_update'            => _n_noop(
				'Sorry, but you do not have the correct permissions to update the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to update the %1$s plugins.',
				'cs_nearby_map'
			), // %1$s = plugin name(s).
			'notice_can_activate_required'    => _n_noop(
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'cs_nearby_map'
			), // %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop(
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'cs_nearby_map'
			), // %1$s = plugin name(s).
			'notice_cannot_activate'          => _n_noop(
				'Sorry, but you do not have the correct permissions to activate the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to activate the %1$s plugins.',
				'cs_nearby_map'
			), // %1$s = plugin name(s).
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'cs_nearby_map'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'cs_nearby_map'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'cs_nearby_map'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'cs_nearby_map' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'cs_nearby_map' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'cs_nearby_map' ),
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'cs_nearby_map' ),  // %1$s = plugin name(s).
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'cs_nearby_map' ),  // %1$s = plugin name(s).
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'cs_nearby_map' ), // %s = dashboard link.
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'cs_nearby_map' ),

			'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		),
	
	);

	tgmpa( $plugins, $config );

}
add_action( 'tgmpa_register', 'cspm_nearby_map_register_required_plugins' );