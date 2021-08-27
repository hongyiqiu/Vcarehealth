<?php
/**
 * Singleton for setting up the integration.
 *
 * Note that it doesn't have to have unique name. Because of autoloading, it will be loaded only once (when this
 * integration plugin is operational).
 *
 */
/** @noinspection PhpUndefinedClassInspection */
class WPDDL_Integration_Setup extends WPDDL_Theme_Integration_Setup_Abstract {
	/**
	 * @var $custom_frontend_js_path
	 */
	protected $custom_frontend_js_path;

	/**
	 * @var Toolset_Admin_Notice_Layouts_Help
	 */
	private $help_notice;

	/**
	 * @var $help_anchor
	 */
	private static $help_anchor = '';

	/**
	 * Run Integration.
	 *
	 * @return bool|WP_Error True when the integration was successful or a WP_Error with a sensible message
	 *     (which can be displayed to the user directly).
	 */
	public function run() {
		$this->custom_frontend_js_path = 'public/js/custom-frontend.js';

		// Load default layouts
		$this->set_layouts_path( dirname( dirname( __FILE__) ) . DIRECTORY_SEPARATOR . 'public/layouts' );

		parent::run();
		return true;
	}

	public function frontend_enqueue() {
		parent::frontend_enqueue();

		if( is_ddlayout_assigned() ) {
			wp_register_script(
					'layouts-theme-integration-frontend-js',
					$this->get_plugins_url( $this->custom_frontend_js_path ),
					array(),
					$this->get_supported_theme_version()
			);

			wp_enqueue_script( 'layouts-theme-integration-frontend-js' );
		}
	}

	public function admin_enqueue() {
		parent::admin_enqueue();
        wp_enqueue_script( 'layouts-theme-integration-backend' );
	}

    function get_custom_backend_js_path(){
        return 'public/js/theme-integration-admin.js';
    }

	/**
	 * @return string
	 */
	protected function get_supported_theme_version() {
		return '1.0';
	}


	/**
	 * Build URL of a resource from path relative to plugin's root directory.
	 *
	 * @param string $relative_path Some path relative to the plugin's root directory.
	 * @return string URL of the given path.
	 */
	protected function get_plugins_url( $relative_path ) {
		return plugins_url( '/../' . $relative_path , __FILE__ );
	}


	/**
	 * Get list of templates supported by Layouts with this theme.
	 *
	 * @return array Associative array with template file names as keys and theme names as values.
	 */
	protected function get_supported_templates() {
		return array(
			$this->getPageDefaultTemplate() => __( 'Template page', 'ddl-layouts' )
		);
	}

	/**
	 * Layouts Support
	 *
	 * Implement theme-specific logic here. For example, you may want to:
	 *     - if theme has it's own loop, replace it by the_ddlayout()
	 *     - remove headers, footer, sidebars, menus and such, if achievable by filters
	 *     - otherwise you will have to resort to something like redirecting templates (see the template router below)
	 *     - add $this->clear_content() to some filters to remove unwanted site structure elements
	 */
	protected function add_layouts_support() {
	    parent::add_layouts_support();

	    /** @noinspection PhpUndefinedClassInspection */
	    WPDDL_Integration_Theme_Template_Router::get_instance();

		// Remove row-fluid support
		add_filter('ddl-get_fluid_type_class_suffix', array( &$this, 'remove_row_fluid_support' ), 10, 2);

		// Return list of forbidden cells for Content Layouts
		add_filter( 'ddl-disabled_cells_on_content_layout', array( &$this, 'disabled_cells_on_content_layout_function' ), 10, 1 );

		if( version_compare( WPDDL_VERSION, '1.9-b3' ) !== -1 ) {
			// Add custom help link on edit layout screen
			$this->init_specific_help_link();
		}
	}

	/**
	 * Get template for notice text.
	 *
	 * @param string $tag Unique id for template file.
	 *
	 * @return string Absolute path to notice template file.
	 */
	private function get_notice_template( $tag ) {
		$notice_templates = array(
			'help-generic' => 'help-generic.phtml'
		);
		$notices_dir = dirname( dirname( __FILE__) )  . '/public/notices/';

		return $notices_dir . $notice_templates[ $tag ];
	}

	public static function get_help_anchor() {
		return self::$help_anchor;
	}

	/**
	 * @param $layout_slug
	 *
	 * @return bool
	 */
	private function is_default_layout( $layout_slug ) {
		$default_layouts = array(
			'header-and-footer',
			'pages',
			'posts',
			'layout-for-archives',
			'layout-for-blog',
			'error-404-page',
			'layout-for-search-results',
			'homepage'
		);

		if( in_array( $layout_slug, $default_layouts ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Initialise the registration of help notice placed under the title of the layout
	 */
	private function init_specific_help_link() {
		// init Toolset_Admin_Notice_Layouts_Help (the id is just a "dummy" id and will be overwritten later)
		$this->help_notice = new Toolset_Admin_Notice_Layouts_Help( 'layouts-no-help-link' );
		// make notice permanent dismissible by the user
		$this->help_notice->set_is_dismissible_permanent( true );
		// add the notice to our Toolset_Admin_Notices_Manager
		Toolset_Admin_Notices_Manager::add_notice( $this->help_notice );

		// apply content to notice related to the current layout on 'ddl-print-editor-additional-help-link'
		add_action( 'ddl-print-editor-additional-help-link', array( &$this, 'set_content_for_specific_help_link'), 10, 3 );
	}

	/**
	 * Set content for help link
	 *
	 * @param $layouts_array
	 * @param $current_id
	 * @param $current_slug
	 */
	public function set_content_for_specific_help_link( $layouts_array, $current_id, $current_slug ){
		//$current = $layouts_array[$current_id];

		if( $this->is_default_layout( $current_slug ) ){
			$this->help_notice->set_id( 'layouts-help-generic' );
			$this->help_notice->set_content( $this->get_notice_template( 'help-generic' ) );
			self::$help_anchor = $current_slug;

			// we don't want to show more than one message
			return;
		}

		// place for more help links
		// ...
		// ...
	}

	public function disabled_cells_on_content_layout_function() {
		return array(
			'2017-header-image',
			'2017-front-page-sections',
			'2017-social-menu',
			'2017-top-menu'
		);
	}

	/**
	 * Add custom theme elements to Layouts.
	 *
	 */
	protected function add_layouts_cells() {
		// header image
		$header_image = new WPDDL_Integration_Layouts_Cell_Header_Image();
		$header_image->setup();

		// top menu
		$top_menu = new WPDDL_Integration_Layouts_Cell_Top_Menu();
		$top_menu->setup();

		// post navigation
		$post_navigation = new WPDDL_Integration_Layouts_Cell_Post_Navigation();
		$post_navigation->setup();

		// social menu
		$social_menu = new WPDDL_Integration_Layouts_Cell_Social_Menu();
		$social_menu->setup();

		// search form
		$search_form = new WPDDL_Integration_Layouts_Cell_Search_Form();
		$search_form->setup();

		// page panels
		$front_page_sections = new WPDDL_Integration_Layouts_Cell_Front_Page_Sections();
		$front_page_sections->setup();
	}

	/**
	 * Add custom row modes elements to Layouts.
	 *
	 */
	protected function add_layout_row_types() {
	    // Header
	    $header = new WPDDL_Integration_Layouts_Row_Type_Header();
	    $header->setup();

		// Content
		$content = new WPDDL_Integration_Layouts_Row_Type_Content();
		$content->setup();

		// Footer
		$footer = new WPDDL_Integration_Layouts_Row_Type_Footer();
		$footer->setup();

		return $this;
	}

	/**
	 * This method can be used to remove all theme settings which are obsolete with the use of Layouts
	 * i.e. "Default Layout" in "Theme Settings"
	 *
	 */
	protected function modify_theme_settings() {
		// ...
	}

	public function remove_row_fluid_support( $suffix, $mode ){
		return '';
	}
}