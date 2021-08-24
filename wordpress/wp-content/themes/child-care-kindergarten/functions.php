<?php
/**
 * Child Care Kindergarten functions and definitions
 *
 * @subpackage Child Care Kindergarten
 * @since 1.0
 */

include get_theme_file_path( 'vendor/wptrt/autoload/src/Child_Care_Kindergarten_Loader.php' );

$child_care_kindergarten_loader = new \WPTRT\Autoload\Child_Care_Kindergarten_Loader();

$child_care_kindergarten_loader->child_care_kindergarten_add( 'WPTRT\\Customize\\Section', get_theme_file_path( 'vendor/wptrt/customize-section-button/src' ) );

$child_care_kindergarten_loader->child_care_kindergarten_register();

function child_care_kindergarten_setup() {
	
	load_theme_textdomain( 'child-care-kindergarten', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( "responsive-embeds" );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-background', $defaults = array(
	    'default-color'          => '',
	    'default-image'          => '',
	    'default-repeat'         => '',
	    'default-position-x'     => '',
	    'default-attachment'     => '',
	    'wp-head-callback'       => '_custom_background_cb',
	    'admin-head-callback'    => '',
	    'admin-preview-callback' => ''
	));

	$GLOBALS['content_width'] = 525;
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'child-care-kindergarten' ),
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style( array( 'assets/css/editor-style.css', child_care_kindergarten_fonts_url() ) );
}
add_action( 'after_setup_theme', 'child_care_kindergarten_setup' );

function child_care_kindergarten_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'child-care-kindergarten' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'child-care-kindergarten' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget_container"><h2 class="widget-title">',
		'after_title'   => '</h2></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Sidebar 2', 'child-care-kindergarten' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your pages and posts', 'child-care-kindergarten' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget_container"><h2 class="widget-title">',
		'after_title'   => '</h2></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Sidebar 3', 'child-care-kindergarten' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Add widgets here to appear in your pages and posts', 'child-care-kindergarten' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget_container"><h2 class="widget-title">',
		'after_title'   => '</h2></div>',
	) );
}
add_action( 'widgets_init', 'child_care_kindergarten_widgets_init' );

function child_care_kindergarten_fonts_url(){
	$font_url = '';
	$font_family = array();
	$font_family[] = 'Balsamiq Sans:400,400i,700,700i';

	$query_args = array(
		'family' => rawurlencode(implode('|',$font_family)),
	);
	$font_url = add_query_arg($query_args,'//fonts.googleapis.com/css');
	return $font_url;
}

//Enqueue scripts and styles.
function child_care_kindergarten_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'child-care-kindergarten-fonts', child_care_kindergarten_fonts_url(), array(), null );
	
	//Bootstarp 
	wp_enqueue_style( 'bootstrap-css', esc_url( get_template_directory_uri() ).'/assets/css/bootstrap.css' );
	
	// Theme stylesheet.
	wp_enqueue_style( 'child-care-kindergarten-basic-style', get_stylesheet_uri() );

	// Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
	if ( is_customize_preview() ) {
		wp_enqueue_style( 'child-care-kindergarten-ie9', get_theme_file_uri( '/assets/css/ie9.css' ), array( 'child-care-kindergarten-style' ), '1.0' );
		wp_style_add_data( 'child-care-kindergarten-ie9', 'conditional', 'IE 9' );
	}
	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'child-care-kindergarten-ie8', get_theme_file_uri( '/assets/css/ie8.css' ), array( 'child-care-kindergarten-style' ), '1.0' );
	wp_style_add_data( 'child-care-kindergarten-ie8', 'conditional', 'lt IE 9' );

	//font-awesome
	wp_enqueue_style( 'font-awesome-css', esc_url( get_template_directory_uri() ).'/assets/css/fontawesome-all.css' );

	$custom_css = '';

	$child_care_kindergarten_logo_top_padding = get_theme_mod('child_care_kindergarten_logo_top_padding');
	$child_care_kindergarten_logo_bottom_padding = get_theme_mod('child_care_kindergarten_logo_bottom_padding');
	$child_care_kindergarten_logo_left_padding = get_theme_mod('child_care_kindergarten_logo_left_padding');
	$child_care_kindergarten_logo_right_padding = get_theme_mod('child_care_kindergarten_logo_right_padding');

	$child_care_kindergarten_service_section_padding = get_theme_mod('child_care_kindergarten_service_section_padding');

	$custom_css = '
		.inner-logo {
			padding-top: '.esc_attr($child_care_kindergarten_logo_top_padding).'px;
			padding-bottom: '.esc_attr($child_care_kindergarten_logo_bottom_padding).'px;
			padding-left: '.esc_attr($child_care_kindergarten_logo_left_padding).'px;
			padding-right: '.esc_attr($child_care_kindergarten_logo_right_padding).'px;
		}
		#services-section {
			padding-top: '.esc_attr($child_care_kindergarten_service_section_padding).'px;
			padding-bottom: '.esc_attr($child_care_kindergarten_service_section_padding).'px;
		}
	';
	wp_add_inline_style( 'child-care-kindergarten-basic-style',$custom_css );

	wp_enqueue_script( 'child-care-kindergarten-navigation-jquery', get_theme_file_uri( '/assets/js/navigation.js' ), array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'bootstrap-js', esc_url( get_template_directory_uri() ). '/assets/js/bootstrap.js', array('jquery') );
	wp_enqueue_script( 'jquery-superfish', esc_url( get_template_directory_uri() ). '/assets/js/jquery.superfish.js', array('jquery') ,'',true);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'child_care_kindergarten_scripts' );

function child_care_kindergarten_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template',  'child_care_kindergarten_front_page_template' );

function child_care_kindergarten_sanitize_dropdown_pages( $page_id, $setting ) {
	// Ensure $input is an absolute integer.
	$page_id = absint( $page_id );
	// If $page_id is an ID of a published page, return it; otherwise, return the default.
	return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}

function child_care_kindergarten_sanitize_choices( $input, $setting ) {
    global $wp_customize; 
    $control = $wp_customize->get_control( $setting->id ); 
    if ( array_key_exists( $input, $control->choices ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}

function child_care_kindergarten_sanitize_checkbox( $input ) {
	return ( ( isset( $input ) && true == $input ) ? true : false );
}

function child_care_kindergarten_sanitize_phone_number( $phone ) {
	return preg_replace( '/[^\d+]/', '', $phone );
}

function child_care_kindergarten_sanitize_float( $input ) {
    return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}

/* Excerpt Limit Begin */
function child_care_kindergarten_string_limit_words($string, $word_limit) {
	$words = explode(' ', $string, ($word_limit + 1));
	if(count($words) > $word_limit)
	array_pop($words);
	return implode(' ', $words);
}

// Change number or products per row to 3
add_filter('loop_shop_columns', 'child_care_kindergarten_loop_columns');
	if (!function_exists('child_care_kindergarten_loop_columns')) {
		function child_care_kindergarten_loop_columns() {
	return 3; // 3 products per row
	}
}

require get_parent_theme_file_path( '/inc/custom-header.php' );

require get_parent_theme_file_path( '/inc/template-tags.php' );

require get_parent_theme_file_path( '/inc/template-functions.php' );

require get_parent_theme_file_path( '/inc/customizer.php' );

require get_parent_theme_file_path( '/inc/font-awesome-icons.php' );