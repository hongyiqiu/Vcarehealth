<?php
/**
 * Child Care Kindergarten: Customizer
 *
 * @subpackage Child Care Kindergarten
 * @since 1.0
 */

use WPTRT\Customize\Section\Child_Care_Kindergarten_Button;

add_action( 'customize_register', function( $manager ) {

	$manager->register_section_type( Child_Care_Kindergarten_Button::class );

	$manager->add_section(
		new Child_Care_Kindergarten_Button( $manager, 'child_care_kindergarten_pro', [
			'title'      => __( 'Kindergarten Pro', 'child-care-kindergarten' ),
			'priority'    => 0,
			'button_text' => __( 'Go Pro', 'child-care-kindergarten' ),
			'button_url'  => esc_url( 'https://www.luzuk.com/product/child-care-wordpress-theme/', 'child-care-kindergarten')
		] )
	);

} );

// Load the JS and CSS.
add_action( 'customize_controls_enqueue_scripts', function() {

	$version = wp_get_theme()->get( 'Version' );

	wp_enqueue_script(
		'child-care-kindergarten-customize-section-button',
		get_theme_file_uri( 'vendor/wptrt/customize-section-button/public/js/customize-controls.js' ),
		[ 'customize-controls' ],
		$version,
		true
	);

	wp_enqueue_style(
		'child-care-kindergarten-customize-section-button',
		get_theme_file_uri( 'vendor/wptrt/customize-section-button/public/css/customize-controls.css' ),
		[ 'customize-controls' ],
 		$version
	);

} );

function child_care_kindergarten_customize_register( $wp_customize ) {

	$wp_customize->add_setting('child_care_kindergarten_logo_padding',array(
       'sanitize_callback'	=> 'esc_html'
    ));
    $wp_customize->add_control('child_care_kindergarten_logo_padding',array(
       'label' => __('Logo Padding','child-care-kindergarten'),
       'section' => 'title_tagline'
    ));

	$wp_customize->add_setting('child_care_kindergarten_logo_top_padding',array(
       'default' => '',
       'sanitize_callback'	=> 'child_care_kindergarten_sanitize_float'
    ));
    $wp_customize->add_control('child_care_kindergarten_logo_top_padding',array(
       'type' => 'number',
       'description' => __('Top','child-care-kindergarten'),
       'section' => 'title_tagline',
    ));

	$wp_customize->add_setting('child_care_kindergarten_logo_bottom_padding',array(
       'default' => '',
       'sanitize_callback'	=> 'child_care_kindergarten_sanitize_float'
    ));
    $wp_customize->add_control('child_care_kindergarten_logo_bottom_padding',array(
       'type' => 'number',
       'description' => __('Bottom','child-care-kindergarten'),
       'section' => 'title_tagline',
    ));

	$wp_customize->add_setting('child_care_kindergarten_logo_left_padding',array(
       'default' => '',
       'sanitize_callback'	=> 'child_care_kindergarten_sanitize_float'
    ));
    $wp_customize->add_control('child_care_kindergarten_logo_left_padding',array(
       'type' => 'number',
       'description' => __('Left','child-care-kindergarten'),
       'section' => 'title_tagline',
    ));

	$wp_customize->add_setting('child_care_kindergarten_logo_right_padding',array(
       'default' => '',
       'sanitize_callback'	=> 'child_care_kindergarten_sanitize_float'
    ));
    $wp_customize->add_control('child_care_kindergarten_logo_right_padding',array(
       'type' => 'number',
       'description' => __('Right','child-care-kindergarten'),
       'section' => 'title_tagline',
    ));

	$wp_customize->add_setting('child_care_kindergarten_show_site_title',array(
       'default' => true,
       'sanitize_callback'	=> 'child_care_kindergarten_sanitize_checkbox'
    ));
    $wp_customize->add_control('child_care_kindergarten_show_site_title',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Site Title','child-care-kindergarten'),
       'section' => 'title_tagline'
    ));

    $wp_customize->add_setting('child_care_kindergarten_show_tagline',array(
       'default' => true,
       'sanitize_callback'	=> 'child_care_kindergarten_sanitize_checkbox'
    ));
    $wp_customize->add_control('child_care_kindergarten_show_tagline',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Site Tagline','child-care-kindergarten'),
       'section' => 'title_tagline'
    ));

	$wp_customize->add_panel( 'child_care_kindergarten_panel_id', array(
	    'priority' => 10,
	    'capability' => 'edit_theme_options',
	    'theme_supports' => '',
	    'title' => __( 'Theme Settings', 'child-care-kindergarten' ),
	    'description' => __( 'Description of what this panel does.', 'child-care-kindergarten' ),
	) );

	$wp_customize->add_section( 'child_care_kindergarten_theme_options_section', array(
    	'title'      => __( 'General Settings', 'child-care-kindergarten' ),
		'priority'   => 30,
		'panel' => 'child_care_kindergarten_panel_id'
	) );

	$wp_customize->add_setting('child_care_kindergarten_theme_options',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'child_care_kindergarten_sanitize_choices'
	));
	$wp_customize->add_control('child_care_kindergarten_theme_options',array(
        'type' => 'select',
        'label' => __('Blog Page Sidebar Layout','child-care-kindergarten'),
        'section' => 'child_care_kindergarten_theme_options_section',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','child-care-kindergarten'),
            'Right Sidebar' => __('Right Sidebar','child-care-kindergarten'),
            'One Column' => __('One Column','child-care-kindergarten'),
            'Grid Layout' => __('Grid Layout','child-care-kindergarten')
        ),
	));

	$wp_customize->add_setting('child_care_kindergarten_single_post_sidebar',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'child_care_kindergarten_sanitize_choices'
	));
	$wp_customize->add_control('child_care_kindergarten_single_post_sidebar',array(
        'type' => 'select',
        'label' => __('Single Post Sidebar Layout','child-care-kindergarten'),
        'section' => 'child_care_kindergarten_theme_options_section',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','child-care-kindergarten'),
            'Right Sidebar' => __('Right Sidebar','child-care-kindergarten'),
            'One Column' => __('One Column','child-care-kindergarten')
        ),
	));

	$wp_customize->add_setting('child_care_kindergarten_page_sidebar',array(
        'default' => 'One Column',
        'sanitize_callback' => 'child_care_kindergarten_sanitize_choices'
	));
	$wp_customize->add_control('child_care_kindergarten_page_sidebar',array(
        'type' => 'select',
        'label' => __('Page Sidebar Layout','child-care-kindergarten'),
        'section' => 'child_care_kindergarten_theme_options_section',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','child-care-kindergarten'),
            'Right Sidebar' => __('Right Sidebar','child-care-kindergarten'),
            'One Column' => __('One Column','child-care-kindergarten')
        ),
	));

	$wp_customize->add_setting('child_care_kindergarten_archive_page_sidebar',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'child_care_kindergarten_sanitize_choices'
	));
	$wp_customize->add_control('child_care_kindergarten_archive_page_sidebar',array(
        'type' => 'select',
        'label' => __('Archive & Search Page Sidebar Layout','child-care-kindergarten'),
        'section' => 'child_care_kindergarten_theme_options_section',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','child-care-kindergarten'),
            'Right Sidebar' => __('Right Sidebar','child-care-kindergarten'),
            'One Column' => __('One Column','child-care-kindergarten'),
            'Grid Layout' => __('Grid Layout','child-care-kindergarten')
        ),
	));

	//Bottom Header
	$wp_customize->add_section( 'child_care_kindergarten_header_section' , array(
    	'title'    => __( 'Header', 'child-care-kindergarten' ),
		'priority' => null,
		'panel' => 'child_care_kindergarten_panel_id'
	) );

	$wp_customize->add_setting('child_care_kindergarten_topheader_phone_no',array(
       	'default' => '',
       	'sanitize_callback'	=> 'child_care_kindergarten_sanitize_phone_number'
	));
	$wp_customize->add_control('child_care_kindergarten_topheader_phone_no',array(
	   	'type' => 'text',
	   	'label' => __('Add Phone Number','child-care-kindergarten'),
	   	'section' => 'child_care_kindergarten_header_section',
	));

	$wp_customize->add_setting('child_care_kindergarten_topheader_mail',array(
       	'default' => '',
       	'sanitize_callback'	=> 'sanitize_email'
	));
	$wp_customize->add_control('child_care_kindergarten_topheader_mail',array(
	   	'type' => 'text',
	   	'label' => __('Add Email Address','child-care-kindergarten'),
	   	'section' => 'child_care_kindergarten_header_section',
	));

	$wp_customize->add_setting('child_care_kindergarten_topheader_twitter_url',array(
       	'default' => '',
       	'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('child_care_kindergarten_topheader_twitter_url',array(
	   	'type' => 'url',
	   	'label' => __('Add Twitter URL','child-care-kindergarten'),
	   	'section' => 'child_care_kindergarten_header_section',
	));

	$wp_customize->add_setting('child_care_kindergarten_topheader_facebook_url',array(
       	'default' => '',
       	'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('child_care_kindergarten_topheader_facebook_url',array(
	   	'type' => 'url',
	   	'label' => __('Add Facebook URL','child-care-kindergarten'),
	   	'section' => 'child_care_kindergarten_header_section',
	));

	$wp_customize->add_setting('child_care_kindergarten_topheader_instagram_url',array(
       	'default' => '',
       	'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('child_care_kindergarten_topheader_instagram_url',array(
	   	'type' => 'url',
	   	'label' => __('Add Instagram URL','child-care-kindergarten'),
	   	'section' => 'child_care_kindergarten_header_section',
	));

	//home page slider
	$wp_customize->add_section( 'child_care_kindergarten_slider_section' , array(
    	'title'    => __( 'Slider Settings', 'child-care-kindergarten' ),
		'priority' => null,
		'panel' => 'child_care_kindergarten_panel_id'
	) );

	$wp_customize->add_setting('child_care_kindergarten_slider_hide_show',array(
       	'default' => false,
       	'sanitize_callback'	=> 'child_care_kindergarten_sanitize_checkbox'
	));
	$wp_customize->add_control('child_care_kindergarten_slider_hide_show',array(
	   	'type' => 'checkbox',
	   	'label' => __('Show / Hide Slider','child-care-kindergarten'),
	   	'section' => 'child_care_kindergarten_slider_section',
	));

	for ( $count = 1; $count <= 4; $count++ ) {
		$wp_customize->add_setting( 'child_care_kindergarten_slider' . $count, array(
			'default'           => '',
			'sanitize_callback' => 'child_care_kindergarten_sanitize_dropdown_pages'
		));
		$wp_customize->add_control( 'child_care_kindergarten_slider' . $count, array(
			'label' => __('Select Slider Image Page', 'child-care-kindergarten' ),
			'description' => __('Image Size (625px x 550px)', 'child-care-kindergarten' ),
			'section' => 'child_care_kindergarten_slider_section',
			'type' => 'dropdown-pages'
		));
	}

	//Features Section
	$wp_customize->add_section('child_care_kindergarten_feature_section',array(
		'title'	=> __('Features Section','child-care-kindergarten'),
		'description'=> __('This section will appear below the slider.','child-care-kindergarten'),
		'panel' => 'child_care_kindergarten_panel_id',
	));

	$wp_customize->add_setting('child_care_kindergarten_feature_section_title',array(
       	'default' => '',
       	'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('child_care_kindergarten_feature_section_title',array(
	   	'type' => 'text',
	   	'label' => __('Add Section Title','child-care-kindergarten'),
	   	'section' => 'child_care_kindergarten_feature_section',
	));

	$categories = get_categories();
	$cats = array();
	$i = 0;
	$cat_pst[]= 'select';
	foreach($categories as $category){
		if($i==0){
			$default = $category->slug;
			$i++;
		}
		$cat_pst[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('child_care_kindergarten_feature_category',array(
		'default' => 'select',
		'sanitize_callback' => 'child_care_kindergarten_sanitize_choices',
	));
	$wp_customize->add_control('child_care_kindergarten_feature_category',array(
		'type' => 'select',
		'choices' => $cat_pst,
		'label' => __('Select Category to display Post','child-care-kindergarten'),
		'section' => 'child_care_kindergarten_feature_section',
	));

	$wp_customize->add_setting('child_care_kindergarten_feature_number',array(
		'default'	=> '4',
		'sanitize_callback'	=> 'sanitize_text_field',
	));
	$wp_customize->add_control('child_care_kindergarten_feature_number',array(
		'label'	=> __('Number of posts to show in a category','child-care-kindergarten'),
		'section' => 'child_care_kindergarten_feature_section',
		'type'	  => 'number'
	));

	$child_care_kindergarten_feature_number = get_theme_mod('child_care_kindergarten_feature_number', 4);
	for ($i=1; $i <= $child_care_kindergarten_feature_number; $i++) { 
	    $wp_customize->add_setting('child_care_kindergarten_feature_icon' . $i, array(
	        'default' => 'fas fa-heart',
	        'sanitize_callback' => 'sanitize_text_field'
	    ));
	    $wp_customize->add_control(new Child_Care_Kindergarten_Fontawesome_Icon_Chooser($wp_customize, 'child_care_kindergarten_feature_icon' . $i, array(
	        'section' => 'child_care_kindergarten_feature_section',
	        'type' => 'icon',
	        'label' => esc_html__('Features Icon ', 'child-care-kindergarten') . $i
	    )));
	}

	$wp_customize->add_setting('child_care_kindergarten_feature_section_padding',array(
       'default' => '',
       'sanitize_callback'	=> 'child_care_kindergarten_sanitize_float'
    ));
    $wp_customize->add_control('child_care_kindergarten_feature_section_padding',array(
       'type' => 'number',
       'label' => __('Section Top Bottom Padding','child-care-kindergarten'),
       'section' => 'child_care_kindergarten_feature_section',
    ));

	//Footer
    $wp_customize->add_section( 'child_care_kindergarten_footer', array(
    	'title'  => __( 'Footer Text', 'child-care-kindergarten' ),
		'priority' => null,
		'panel' => 'child_care_kindergarten_panel_id'
	) );

	$wp_customize->add_setting('child_care_kindergarten_show_back_totop',array(
       'default' => true,
       'sanitize_callback'	=> 'child_care_kindergarten_sanitize_checkbox'
    ));
    $wp_customize->add_control('child_care_kindergarten_show_back_totop',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Back to Top','child-care-kindergarten'),
       'section' => 'child_care_kindergarten_footer'
    ));

    $wp_customize->add_setting('child_care_kindergarten_footer_copy',array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('child_care_kindergarten_footer_copy',array(
		'label'	=> __('Footer Text','child-care-kindergarten'),
		'section' => 'child_care_kindergarten_footer',
		'setting' => 'child_care_kindergarten_footer_copy',
		'type' => 'text'
	));

	$wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport  = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.site-title a',
		'render_callback' => 'child_care_kindergarten_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.site-description',
		'render_callback' => 'child_care_kindergarten_customize_partial_blogdescription',
	) );

	//front page
	$num_sections = apply_filters( 'child_care_kindergarten_front_page_sections', 4 );

	// Create a setting and control for each of the sections available in the theme.
	for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
		$wp_customize->add_setting( 'panel_' . $i, array(
			'default'           => false,
			'sanitize_callback' => 'child_care_kindergarten_sanitize_dropdown_pages',
			'transport'         => 'postMessage',
		) );

		$wp_customize->add_control( 'panel_' . $i, array(
			/* translators: %d is the front page section number */
			'label'          => sprintf( __( 'Front Page Section %d Content', 'child-care-kindergarten' ), $i ),
			'description'    => ( 1 !== $i ? '' : __( 'Select pages to feature in each area from the dropdowns. Add an image to a section by setting a featured image in the page editor. Empty sections will not be displayed.', 'child-care-kindergarten' ) ),
			'section'        => 'theme_options',
			'type'           => 'dropdown-pages',
			'allow_addition' => true,
			'active_callback' => 'child_care_kindergarten_is_static_front_page',
		) );

		$wp_customize->selective_refresh->add_partial( 'panel_' . $i, array(
			'selector'            => '#panel' . $i,
			'render_callback'     => 'child_care_kindergarten_front_page_section',
			'container_inclusive' => true,
		) );
	}
}
add_action( 'customize_register', 'child_care_kindergarten_customize_register' );

function child_care_kindergarten_customize_partial_blogname() {
	bloginfo( 'name' );
}

function child_care_kindergarten_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

function child_care_kindergarten_is_static_front_page() {
	return ( is_front_page() && ! is_home() );
}

function child_care_kindergarten_is_view_with_layout_option() {
	// This option is available on all pages. It's also available on archives when there isn't a sidebar.
	return ( is_page() || ( is_archive() && ! is_active_sidebar( 'sidebar-1' ) ) );
}

if (class_exists('WP_Customize_Control')) {

    class Child_Care_Kindergarten_Fontawesome_Icon_Chooser extends WP_Customize_Control {

        public $type = 'icon';

        public function render_content() {
            ?>
            <label>
                <span class="customize-control-title">
                    <?php echo esc_html($this->label); ?>
                </span>

                <?php if ($this->description) { ?>
                    <span class="description customize-control-description">
                        <?php echo wp_kses_post($this->description); ?>
                    </span>
                <?php } ?>

                <div class="child-care-kindergarten-selected-icon">
                    <i class="fa <?php echo esc_attr($this->value()); ?>"></i>
                    <span><i class="fa fa-angle-down"></i></span>
                </div>

                <ul class="child-care-kindergarten-icon-list clearfix">
                    <?php
                    $child_care_kindergarten_font_awesome_icon_array = child_care_kindergarten_font_awesome_icon_array();
                    foreach ($child_care_kindergarten_font_awesome_icon_array as $child_care_kindergarten_font_awesome_icon) {
                        $icon_class = $this->value() == $child_care_kindergarten_font_awesome_icon ? 'icon-active' : '';
                        echo '<li class=' . esc_attr($icon_class) . '><i class="' . esc_attr($child_care_kindergarten_font_awesome_icon) . '"></i></li>';
                    }
                    ?>
                </ul>
                <input type="hidden" value="<?php $this->value(); ?>" <?php $this->link(); ?> />
            </label>
            <?php
        }
    }
}
function child_care_kindergarten_customizer_script() {
    wp_enqueue_style( 'font-awesome-1', esc_url(get_template_directory_uri()).'/assets/css/fontawesome-all.css');
}
add_action( 'customize_controls_enqueue_scripts', 'child_care_kindergarten_customizer_script' );