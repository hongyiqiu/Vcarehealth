<?php
/**
 * Integration loader. Determines if the integration should execute and if yes, execute it properly.
 *
 * When this file is loaded, we already know Layouts are active, theme integration support is loaded and it has
 * correct API version.
 *
 * See WPDDL_Theme_Integration_Abstract for details.
 *
 */
final class WPDDL_2017_Integration extends WPDDL_Theme_Integration_Abstract {


	/**
	 * Theme-specific initialization.
	 *
	 * @return bool|WP_Error True when the integration was successful or a WP_Error with a sensible message
	 *     (which can be displayed to the user directly).
	 */
	protected function initialize() {

		// Setup the autoloader
		$autoloader = WPDDL_Theme_Integration_Autoloader::getInstance();
		$autoloader->addPaths( array(
			dirname( __FILE__ ) . '/application',
			dirname( __FILE__ ) . '/library/layouts/integration',
		) );

		// Initialize Toolset Site Installer
		try {
			$this->initializeToolsetSiteInstaller();
		} catch( Exception $e ) {
			// no demo import / plugin installation possible
			error_log( 'Toolset Site Installer could not be loaded: ' . $e->getMessage() );
		}

		// Run the integration setup
		$integration = WPDDL_Integration_Setup::get_instance();
		$result = $integration->run();

		return $result;
	}

	/**
	 * Initialize Toolset Site Installer
	 */
	private function initializeToolsetSiteInstaller() {
		// toolset installer init file
		$file = dirname( __FILE__ ) . '/library/toolset-site-installer/toolset-site-installer.php';
		if( ! file_exists( $file ) ) {
			throw new Exception( 'Required file not found. ' . $file );
		}

		require_once( $file );
		unset( $file );

		// init toolset site installer
		$toolset_site_installer = new Toolset_Site_Installer();

		if( ! function_exists( 'get_plugins' ) ) {
			// WP_Installer (our plugin) depends on get_plugins
			require_once(ABSPATH . 'wp-admin/includes/plugin.php');
		}

		// assign setting and export dir
		$toolset_site_installer
			->setSettingsFile( dirname( __FILE__ ) . '/public/toolset-site-installer/settings.json' )
			->setExportsDir( dirname( __FILE__ ) . '/public/toolset-site-installer' );

		// if init() works run the installer
		if( $toolset_site_installer->init( 'TT_Controller_Site_Installer' ) ) {
			$toolset_site_installer
				->getSettings()
				->setRepository( new TT_Repository_OTGS() )
				->setContext( new TT_Context_Plugin() );

			$toolset_site_installer
				->run();
		}
	}


	/**
	 * Determine whether the expected theme is active and the integration can begin.
	 *
	 * @return bool
	 */
	protected function is_theme_active() {
		return function_exists( 'twentyseventeen_setup' );
	}


	protected function get_theme_name() {
		return "Twenty Seventeen";
	}

}

WPDDL_2017_Integration::get_instance();