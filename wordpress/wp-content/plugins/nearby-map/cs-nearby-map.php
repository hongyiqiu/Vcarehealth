<?php
/**
 * Plugin Name: Nearby Places
 * Plugin URI: http://codecanyon.net/item/nearby-places-wordpress-plugin/15067875?ref=codespacing 
 * Description: <strong>"Nearby Places" is an extension of "Progress Map WordPress plugin"</strong>. This plugin allows you to display various nearby places - also known as "Points of Interest" - of a location/post on the map.
 * Version: 2.6.7
 * Author: Hicham Radi (CodeSpacing)
 * Author URI: https://www.codespacing.com/
 * Text Domain: cs_nearby_map
 * Domain Path: /languages
 */

if(!class_exists('CspmNearbyMap')){
	
	class CspmNearbyMap{
		
		private static $_this;	
		
		private $plugin_path;
		private $plugin_url;
		
		public $plugin_version = '2.6.7';
		
		public $csnm_plugin_path;
		public $csnm_plugin_url;
		
		public $plugin_settings = array();
		
		/**
		 * General Settings */
		 
		public $distance_unit = 'METRIC'; // Possible values are, METRIC & IMPERIAL
		public $radius = 50000;
		public $rankBy = 'prominence'; //@since 2.4
		public $proximity = array(
			'accounting', 'airport', 'amusement_park', 'aquarium', 'art_gallery', 'atm',
			'bakery', 'bank', 'bar', 'beauty_salon', 'bicycle_store', 'book_store', 'bowling_alley',
			'bus_station', 'cafe', 'campground', 'car_dealer', 'car_rental', 'car_repair', 'car_wash',
			'casino', 'cemetery', 'church', 'city_hall', 'clothing_store', 'convenience_store',
			'courthouse', 'dentist', 'department_store', 'doctor', 'electrician', 'electronics_store',
			'embassy', /*'establishment',*/ /*'finance',*/ 'fire_station', 'florist', /*'food',*/ 'funeral_home',
			'furniture_store', 'gas_station', /*'general_contractor',*/ /*'grocery_or_supermarket',*/ 'gym',
			'hair_care', 'hardware_store', /*'health',*/ 'hindu_temple', 'home_goods_store', 'hospital',
			'insurance_agency', 'jewelry_store', 'laundry', 'lawyer', 'library', 'liquor_store',
			'local_government_office', 'locksmith', 'lodging', 'meal_delivery', 'meal_takeaway',
			'mosque', 'movie_rental', 'movie_theater', 'moving_company', 'museum', 'night_club',
			'painter', 'park', 'parking', 'pet_store', 'pharmacy', 'physiotherapist', /*'place_of_worship',*/
			'plumber', 'police', 'post_office', 'real_estate_agency', 'restaurant', 'roofing_contractor',
			'rv_park', 'school', 'shoe_store', 'shopping_mall', 'spa', 'stadium', 'storage', 'store',
			'subway_station', 'synagogue', 'taxi_stand', 'train_station', 'travel_agency', 'university',
			'veterinary_care', 'zoo');
		public $proximity_names = array(); //@since 1.1
		
		/**
		 * Customize */
		
		public $width = '100%';
		public $height = '420px';
		public $main_layout = 'pl-mr';
		public $places_grid = '3cols';
					
		/**
		 * Autocomplete settings
		 * @since 2.6.5 */
		
		public $autocomplete_option = 'yes';
		public $autocomplete_strict_bounds = 'no';
		public $autocomplete_country_restrict = 'no';
		public $autocomplete_countries = array();
		
		function __construct(){	

			if (!class_exists('CspmMainMap'))
				return; 

			self::$_this = $this;       
			
			$this->plugin_path = $this->csnm_plugin_path = plugin_dir_path( __FILE__ );
			$this->plugin_url = $this->csnm_plugin_url = plugin_dir_url( __FILE__ );

			$CspmMainMap = CspmMainMap::this();
			 
			$this->plugin_settings = $CspmMainMap->plugin_settings;

			/**
			 * Override default settings by the ones selected in the plugin settings page */
			
			/**
			 * General Settings */
			 
			$this->distance_unit = $this->cspm_get_nearby_map_option('distance_unit', $this->distance_unit);
			$this->radius = $this->cspm_get_nearby_map_option('radius', $this->radius);
			$this->rankBy = $this->cspm_get_nearby_map_option('rankBy', $this->rankBy); //@since 2.4
			
			/**
			 * Build the list of all place types enabled in the plugin settings page */
			 
			$all_places_in_settings = $this->cspm_get_nearby_map_option('proximity', $this->proximity);
			
			$enabled_places_array = array();
			
			if(isset($all_places_in_settings['enabled'])){
				
				foreach($all_places_in_settings['enabled'] as $key => $value){
					
					if(in_array($key, $this->proximity))
						$enabled_places_array[] = $key;
				
				}
				
			}else $enabled_places_array = $this->proximity;
			
			$this->proximity = $enabled_places_array;
			
			$this->proximity_names = $this->cspm_nearby_map_places_list();
			
			/**
			 * Customize */
			
			$dimensions = $this->cspm_get_nearby_map_option('dimensions', array($this->width, $this->height, 'px'));
		
			$this->width = !empty($dimensions['width']) ? $dimensions['width'] : $this->width;
			$this->height = !empty($dimensions['height']) ? $dimensions['height'] : $this->height;
			$this->main_layout = $this->cspm_get_nearby_map_option('main_layout', $this->main_layout);
			$this->places_grid = $this->cspm_get_nearby_map_option('places_grid', $this->places_grid);
			
			$this->main_color = $this->cspm_get_nearby_map_option('main_color', '#008fed');
			$this->hover_color = $this->cspm_get_nearby_map_option('hover_color', '#009bfd');
					
			/**
			 * Autocomplete settings
			 * @since 2.6.5 */
			
			$this->autocomplete_option = $this->cspm_setting_exists('autocomplete_option', $this->plugin_settings, 'yes');
			$this->autocomplete_strict_bounds = $this->cspm_setting_exists('autocomplete_strict_bounds', $this->plugin_settings, 'yes');
			$this->autocomplete_country_restrict = $this->cspm_setting_exists('autocomplete_country_restrict', $this->plugin_settings, 'yes');
			$this->autocomplete_countries = $this->cspm_setting_exists('autocomplete_countries', $this->plugin_settings, array());
		
		}
		
		
		static function this(){
			
			return self::$_this;
		
		}
		
		
		function cspm_hooks(){

			/**
			 * Load plugin textdomain.
			 * @since 2.8 */
			 
			add_action('init', array($this, 'cspm_load_nearby_map_textdomain')); 
			
			if(is_admin()){
		
				/**
				 * Load the TGM Plugin Activation functions	file
				 *
				 * @since 1.0
				 */
				 
				if(file_exists($this->plugin_path . '/admin/admin-init.php'))
					require_once($this->plugin_path . '/admin/admin-init.php');
			
				add_action( 'admin_notices', array($this, 'cspm_nearby_map_required_plugin_notice') );	
				
			}else{
			
				/**
				 * Call .js and .css files */
				 
				add_action('wp_enqueue_scripts', array($this, 'cspm_register_styles'));
				add_action('wp_enqueue_scripts', array($this, 'cspm_register_scripts'));
				
			}
			
			add_shortcode('cs_nearby_map', array($this, 'cspm_nearby_map_shortcode'));
			
		}
		
		
		/**
		 * Load plugin text domain
		 *
		 * @since 1.1
		 */
		function cspm_load_nearby_map_textdomain(){
			
			/**
			 * To translate the plugin, create a new folder in "wp-content/languages" ...
			 * ... and name it "cs-progress-map". Inside "cs-progress-map", paste your .mo & . po files.
			 * The plugin will detect the language of your website and display the appropriate language. */
			 
			$domain = 'cs_nearby_map';
			
			$locale = apply_filters('plugin_locale', get_locale(), $domain);
		
			load_textdomain($domain, WP_LANG_DIR.'/cs-progress-map/'.$domain.'-'.$locale.'.mo');
	
			load_plugin_textdomain($domain, FALSE, $this->plugin_path.'/languages/');
			
		}
		
		
		/**
		 * Check if array_key_exists and if empty() doesn't return false
		 * Replace the empty value with the default value if available 
		 * @empty() return false when the value is (null, 0, "0", "", 0.0, false, array())
		 *
		 * @since 2.6.4
		 */
		function cspm_setting_exists($key, $array, $default = ''){
			
			$array_value = isset($array[$key]) ? $array[$key] : $default;
			
			$setting_value = empty($array_value) ? $default : $array_value;
			
			return $setting_value;
			
		}
		
		
		/**
		 * This will display an admin notice if the main plugin "Progress Map" is not installed 
		 *
		 * @since 1.0
         * @edited 2.6.6
		 */		 
		function cspm_nearby_map_required_plugin_notice() {
			
			$required_version = '5.6.5';
			
			if(!class_exists('CSProgressMap')){
				
				echo '<div class="notice notice-warning"><p>';
					echo 'The add-on <strong>"Nearby Places"</strong> requires the plugin <strong>"Progress Map" (version '.$required_version.' or upper)</strong>! Please navigate to your downloads page on Codecanyon, download the plugin <strong>"Progress Map Wordpress Plugin"</strong>, then, install and activate it. If you did not yet purchased this plugin, you can <a href="http://codecanyon.net/item/progress-map-wordpress-plugin/5581719?ref=codespacing" target="_blank">buy it from here</a>.';
				echo '</p></div>';
			
			}elseif(class_exists('CSProgressMap')){
											
				$CSProgressMap = CSProgressMap::this();
				
				$reflect = new ReflectionClass($CSProgressMap);
				
				$plugin_version = $reflect->getProperty('plugin_version');
				
				if(($plugin_version->isPublic() && version_compare($CSProgressMap->plugin_version, $required_version, '<')) || !$plugin_version->isPublic()){
				
					echo '<div class="notice notice-warning"><p>';
						echo 'The version <strong>'.$this->plugin_version.'</strong> of <strong>"Nearby Places"</strong> requires <strong>"Progress Map"</strong> version <strong>'.$required_version.' or upper</strong>. Please navigate to your downloads page on <strong>Codecanyon</strong> and download the latest version of <strong>"Progress Map"</strong>!';
					echo '</p></div>';
			
				}
				
			}
            
		}
		

		/**
		 * This will get a plugin option and assign it a default value when the option is empty
		 *
		 * @since 1.0
		 */
		function cspm_get_nearby_map_option($option_name, $default = ''){
				
			/**
			 * Get the plugin Options */
			
			$cspm_nearby_map_options = get_option('cspm_nearby_map');
			
			/**
			 * Display the Option */
			 
			return (!empty($option_name) && isset($cspm_nearby_map_options[$option_name]) && !empty($cspm_nearby_map_options[$option_name])) ? $cspm_nearby_map_options[$option_name] : $default;
					
		}
		
	
		/**
		 * Register CSS files
		 * 
		 * @since 1.0
		 * @updated 1.1 (Moving bootstrap files to Progress Map)
		 */
		function cspm_register_styles(){
								
			$min_path = '';
			$min_prefix = $this->plugin_settings['combine_files'] == 'seperate' ? '' : '.min' ;

			wp_register_style('jquery-simple-lightbox', $this->plugin_url .'css/'.$min_path.'simplelightbox'.$min_prefix.'.css', array(), $this->plugin_version);			
			
			wp_register_style('cspm-nearby-map-style', $this->plugin_url .'css/'.$min_path.'style'.$min_prefix.'.css', array(), $this->plugin_version);
			
		}
		
	
		/**
		 * Enqueue CSS files
		 * 
		 * @since 1.0
		 * @updated 1.1 (Moving bootstrap files to Progress Map) | 2.3 (custom css)
		 */
		function cspm_enqueue_styles(){
				
			wp_enqueue_style('jquery-simple-lightbox');								
			wp_enqueue_style('cspm-nearby-map-style');
			
			/**
			 * Custom CSS
			 * @since 2.3 */
			
			$custom_colors_css  = '.cspm_nearby_map_main_color, a.cspm_nearby_map_main_color{color:'.$this->main_color.' !important;}'; 
			$custom_colors_css .= '.cspm_nearby_map_main_background, .cspm_nearby_map_main_background.active{background-color:'.$this->main_color.' !important;}';
			$custom_colors_css .= '.cspm_nearby_map_main_color.hover:hover, a.cspm_nearby_map_main_color.hover:hover{color:'.$this->hover_color.' !important;}';
			$custom_colors_css .= '.cspm_nearby_map_main_background.hover:hover{background-color:'.$this->hover_color.' !important;}';

			wp_add_inline_style('cspm-nearby-map-style', $custom_colors_css);
			
		}
		
			
		/**
		 * Register JS files
		 * 
		 * @since 1.0
		 */		 
		function cspm_register_scripts(){
								
			$min_path = $this->plugin_settings['combine_files'] == 'seperate' ? '' : 'min/';
			$min_prefix = $this->plugin_settings['combine_files'] == 'seperate' ? '' : '.min' ;
			
			wp_register_script('cspm_simplelightbox_js', $this->plugin_url .'js/'.$min_path.'simple-lightbox.jquery'.$min_prefix.'.js', array( 'jquery' ), $this->plugin_version, true);
			wp_register_script('jquery-readmore', $this->plugin_url .'js/'.$min_path.'readmore'.$min_prefix.'.js', array( 'jquery' ), $this->plugin_version, true);				
			wp_register_script('cspm-nearby-map-script', $this->plugin_url .'js/'.$min_path.'pm-nearby-map'.$min_prefix.'.js', array( 'jquery' ), $this->plugin_version, true);
				
		}
		
			
		/**
		 * Register & Enqueue JS files
		 * 
		 * @since 1.0
		 */		 
		function cspm_enqueue_scripts(){
			
			$img_file_url = apply_filters('csnm_img_file', $this->plugin_url.'img/');
			$place_markers_file_url = apply_filters('csnm_place_markers_file', $img_file_url.'place_types_markers/');
			
			$wp_localize_script_args = array(
				'ajax_url' => esc_url(home_url()) . '/wp-admin/admin-ajax.php',
				'plugin_url'  => $this->plugin_url,
				'img_file_url'  => $img_file_url,
				'place_markers_file_url'  => $place_markers_file_url,
				'get_directions' => esc_html__('Directions', 'cs_nearby_map'),
				'no_results_msg' => esc_html__('We couldn\'t find any result!', 'cs_nearby_map'),
				'the_word_ratings' => esc_html__('ratings', 'cs_nearby_map'),
				'the_word_reviews' => esc_html__('Reviews', 'cs_nearby_map'),
				'the_word_photos' => esc_html__('Photos', 'cs_nearby_map'),
				'the_word_route' => esc_html__('Route', 'cs_nearby_map'),
				'google_map_link_text' => esc_html__('Open On Google Map', 'cs_nearby_map'),
				'appears_also_text' => esc_html__('Appears also in: ', 'cs_nearby_map'),
				'more_reviews_text' => esc_html__('Read more reviews', 'cs_nearby_map'),
				'show_more_text' => esc_html__('Show more', 'cs_nearby_map'),
				'show_less_text' => esc_html__('Show less', 'cs_nearby_map'),
				'the_word_away' => esc_html__('away', 'cs_nearby_map'),
				'jan' => esc_html__('Jan', 'cs_nearby_map'),
				'feb' => esc_html__('Feb', 'cs_nearby_map'),
				'mar' => esc_html__('Mar', 'cs_nearby_map'),
				'apr' => esc_html__('Apr', 'cs_nearby_map'),
				'may' => esc_html__('May', 'cs_nearby_map'),
				'jun' => esc_html__('Jun', 'cs_nearby_map'),
				'jul' => esc_html__('Jul', 'cs_nearby_map'),
				'aug' => esc_html__('Aug', 'cs_nearby_map'),
				'sep' => esc_html__('Sep', 'cs_nearby_map'),
				'oct' => esc_html__('Oct', 'cs_nearby_map'),
				'nov' => esc_html__('Nov', 'cs_nearby_map'),
				'dec' => esc_html__('Dec', 'cs_nearby_map'),				
				'point_of_interest' => esc_html__('Point of interest', 'cs_nearby_map'),
				'site_direction' => is_rtl() ? 'left' : 'right',
				'no_address' => esc_html('Type your address or geolocate your position', 'cs_nearby_map'), //@since 2.4								
			);
			
			$wp_localize_script_args = $wp_localize_script_args + $this->cspm_nearby_map_places_list();
			
			wp_enqueue_script('jquery');				 			
			
			/**
			 * ScrollTo jQuery Plugin
			 * Registered in the plugin "Progress Map */
			
			wp_enqueue_script('jquery-scrollto');
				
			wp_enqueue_script('cspm_simplelightbox_js');
			wp_enqueue_script('jquery-readmore');
			wp_enqueue_script('cspm-nearby-map-script');
	
			/**
			 * Localize the script with new data */

			wp_localize_script('cspm-nearby-map-script', 'cspm_nearby_map', $wp_localize_script_args);
			
		}
		
		
		/**
		 * Build the list of all places
		 *
		 * @since 1.1
		 */
		function cspm_nearby_map_places_list(){
			
			$places_array = array(
				'accounting' => esc_html__('Accounting', 'cs_nearby_map'),
				'airport' => esc_html__('Airport', 'cs_nearby_map'),
				'amusement_park' => esc_html__('Amusement park', 'cs_nearby_map'),
				'aquarium' => esc_html__('Aquarium', 'cs_nearby_map'),
				'art_gallery' => esc_html__('Art gallery', 'cs_nearby_map'),
				'atm' => esc_html__('Atm', 'cs_nearby_map'),
				'bakery' => esc_html__('Bakery', 'cs_nearby_map'),
				'bank' => esc_html__('Bank', 'cs_nearby_map'),
				'bar' => esc_html__('Bar', 'cs_nearby_map'),
				'beauty_salon' => esc_html__('Beauty salon', 'cs_nearby_map'),
				'bicycle_store' => esc_html__('Bicycle store', 'cs_nearby_map'),
				'book_store' => esc_html__('Book store', 'cs_nearby_map'),
				'bowling_alley' => esc_html__('Bowling alley', 'cs_nearby_map'),
				'bus_station' => esc_html__('Bus station', 'cs_nearby_map'),
				'cafe' => esc_html__('Cafe', 'cs_nearby_map'),
				'campground' => esc_html__('Campground', 'cs_nearby_map'),
				'car_dealer' => esc_html__('Car dealer', 'cs_nearby_map'),
				'car_rental' => esc_html__('Car rental', 'cs_nearby_map'),
				'car_repair' => esc_html__('Car repair', 'cs_nearby_map'),
				'car_wash' => esc_html__('Car wash', 'cs_nearby_map'),
				'casino' => esc_html__('Casino', 'cs_nearby_map'),
				'cemetery' => esc_html__('Cemetery', 'cs_nearby_map'),
				'church' => esc_html__('Church', 'cs_nearby_map'),
				'city_hall' => esc_html__('City hall', 'cs_nearby_map'),
				'clothing_store' => esc_html__('Clothing store', 'cs_nearby_map'),
				'convenience_store' => esc_html__('Convenience store', 'cs_nearby_map'),
				'courthouse' => esc_html__('Courthouse', 'cs_nearby_map'),
				'dentist' => esc_html__('Dentist', 'cs_nearby_map'),
				'department_store' => esc_html__('Department store', 'cs_nearby_map'),
				'doctor' => esc_html__('Doctor', 'cs_nearby_map'),
				'electrician' => esc_html__('Electrician', 'cs_nearby_map'),
				'electronics_store' => esc_html__('Electronics store', 'cs_nearby_map'),
				'embassy' => esc_html__('Embassy', 'cs_nearby_map'),
				//'establishment' => esc_html__('Establishment', 'cs_nearby_map'),
				//'finance' => esc_html__('Finance', 'cs_nearby_map'),
				'fire_station' => esc_html__('Fire station', 'cs_nearby_map'),
				'florist' => esc_html__('Florist', 'cs_nearby_map'),
				//'food' => esc_html__('Food', 'cs_nearby_map'),
				'funeral_home' => esc_html__('Funeral home', 'cs_nearby_map'),
				'furniture_store' => esc_html__('Furniture store', 'cs_nearby_map'),
				'gas_station' => esc_html__('Gas station', 'cs_nearby_map'),
				//'general_contractor' => esc_html__('General contractor', 'cs_nearby_map'),
				//'grocery_or_supermarket' => esc_html__('Grocery or supermarket', 'cs_nearby_map'),
				'gym' => esc_html__('Gym', 'cs_nearby_map'),
				'hair_care' => esc_html__('Hair care', 'cs_nearby_map'),
				'hardware_store' => esc_html__('Hardware store', 'cs_nearby_map'),
				//'health' => esc_html__('Health', 'cs_nearby_map'),
				'hindu_temple' => esc_html__('Hindu temple', 'cs_nearby_map'),
				'home_goods_store' => esc_html__('Home goods store', 'cs_nearby_map'),
				'hospital' => esc_html__('Hospital', 'cs_nearby_map'),
				'insurance_agency' => esc_html__('Insurance agency', 'cs_nearby_map'),
				'jewelry_store' => esc_html__('Jewelry store', 'cs_nearby_map'),
				'laundry' => esc_html__('Laundry', 'cs_nearby_map'),
				'lawyer' => esc_html__('Lawyer', 'cs_nearby_map'),
				'library' => esc_html__('Library', 'cs_nearby_map'),
				'liquor_store' => esc_html__('Liquor store', 'cs_nearby_map'),
				'local_government_office' => esc_html__('Local government office', 'cs_nearby_map'),
				'locksmith' => esc_html__('Locksmith', 'cs_nearby_map'),
				'lodging' => esc_html__('Lodging', 'cs_nearby_map'),
				'meal_delivery' => esc_html__('Meal delivery', 'cs_nearby_map'),
				'meal_takeaway' => esc_html__('Meal takeaway', 'cs_nearby_map'),
				'mosque' => esc_html__('Mosque', 'cs_nearby_map'),
				'movie_rental' => esc_html__('Movie rental', 'cs_nearby_map'),
				'movie_theater' => esc_html__('Movie theater', 'cs_nearby_map'),
				'moving_company' => esc_html__('Moving company', 'cs_nearby_map'),
				'museum' => esc_html__('Museum', 'cs_nearby_map'),
				'night_club' => esc_html__('Night club', 'cs_nearby_map'),
				'painter' => esc_html__('Painter', 'cs_nearby_map'),
				'park' => esc_html__('Park', 'cs_nearby_map'),
				'parking' => esc_html__('Parking', 'cs_nearby_map'),
				'pet_store' => esc_html__('Pet store', 'cs_nearby_map'),
				'pharmacy' => esc_html__('Pharmacy', 'cs_nearby_map'),
				'physiotherapist' => esc_html__('Physiotherapist', 'cs_nearby_map'),
				//'place_of_worship' => esc_html__('Place of worship', 'cs_nearby_map'),
				'plumber' => esc_html__('Plumber', 'cs_nearby_map'),
				'police' => esc_html__('Police', 'cs_nearby_map'),
				'post_office' => esc_html__('Post office', 'cs_nearby_map'),
				'real_estate_agency' => esc_html__('Real estate agency', 'cs_nearby_map'),
				'restaurant' => esc_html__('Restaurant', 'cs_nearby_map'),
				'roofing_contractor' => esc_html__('Roofing contractor', 'cs_nearby_map'),
				'rv_park' => esc_html__('Rv park', 'cs_nearby_map'),
				'school' => esc_html__('School', 'cs_nearby_map'),
				'shoe_store' => esc_html__('Shoe store', 'cs_nearby_map'),
				'shopping_mall' => esc_html__('Shopping mall', 'cs_nearby_map'),
				'spa' => esc_html__('Spa', 'cs_nearby_map'),
				'stadium' => esc_html__('Stadium', 'cs_nearby_map'),
				'storage' => esc_html__('Storage', 'cs_nearby_map'),
				'store' => esc_html__('Store', 'cs_nearby_map'),
				'subway_station' => esc_html__('Subway station', 'cs_nearby_map'),
				'synagogue' => esc_html__('Synagogue', 'cs_nearby_map'),
				'taxi_stand' => esc_html__('Taxi stand', 'cs_nearby_map'),
				'train_station' => esc_html__('Train station', 'cs_nearby_map'),
				'travel_agency' => esc_html__('Travel agency', 'cs_nearby_map'),
				'university' => esc_html__('University', 'cs_nearby_map'),
				'veterinary_care' => esc_html__('Veterinary care', 'cs_nearby_map'),
				'zoo' => esc_html__('Zoo', 'cs_nearby_map'),
			);
			
			return $places_array;
				
		}
		
							
		/**
		 * Build the infoboxes content
		 *
		 * @since 2.4 
		 * @updated 2.5 | 2.6.2
		 */		
		function cspm_infoboxes_data($atts = array()){
			
			if (!class_exists('CspmMainMap'))
				return array(); 
				
			$CspmMainMap = CspmMainMap::this();

			extract( wp_parse_args( $atts, array(
				'map_id' => '', 
				'post_ids' => '',
				'infobox_type' => $this->plugin_settings['infobox_type'],
				'infobox_link_target' => $this->plugin_settings['infobox_external_link'],
				'infobox_width' => $this->plugin_settings['infobox_width'], //@since 2.5
				'infobox_height' => $this->plugin_settings['infobox_height'], //@since 2.5		
				'infobox_title' => $this->cspm_setting_exists('infobox_title', $this->plugin_settings), //@since 2.6.2		
				'infobox_external_link' => $this->plugin_settings['infobox_external_link'], //@since 2.6.2		
				'infobox_details' => $this->cspm_setting_exists('infobox_content', $this->plugin_settings), //@since 2.6.2																		
			))); 

			$infoboxes = $infoboxes_data = array();
			
			foreach($post_ids as $post_id){
				$infoboxes[$post_id] = $CspmMainMap->cspm_infobox(array(
					'post_id' => $post_id,
					'map_id' => $map_id,
					'carousel' => 'false',
					'infobox_type' => $infobox_type,
					'infobox_link_target' => $infobox_link_target,
					'infobox_width' => $infobox_width, //@since 2.5
					'infobox_height' => $infobox_height, //@since 2.5
					'infobox_title' => $infobox_title, //@since 2.6.2		
					'infobox_external_link' => $infobox_external_link, //@since 2.6.2		
					'infobox_details' => $infobox_details, //@since 2.6.2													
				));
			}
			
			$infoboxes_data['infoboxes_'.$map_id] = $infoboxes;
			
			return $infoboxes_data;
			
		}
		
		
		/**
		 * Add new data to the JS scripts
		 *
		 * @since 2.4
		 */
		function cspm_add_js_script_data($new_data){
								
			/**
			 * Localize the script with new data
			 * 1) We'll get the old data already localized.
			 * 2) Add this map's new data to the old data array.
			 * 3) We'll clear the old wp_localize_script(), then, send a new one that contains old & new data. */
			
			global $wp_scripts;
			
			$localize_script_handle = 'cspm-script';
			
			$progress_map_vars = $wp_scripts->get_data($localize_script_handle, 'data');
			
			$current_progress_map_vars = json_decode(str_replace('var progress_map_vars = ', '', substr($progress_map_vars, 0, -1)), true);
			
			$old_map_script_args = (array) $current_progress_map_vars;
			
			$new_map_scripts_args = array_merge($old_map_script_args, $new_data);
			
			$wp_scripts->add_data($localize_script_handle, 'data', '');
		
			wp_localize_script($localize_script_handle, 'progress_map_vars', $new_map_scripts_args);
				
		}
		

		/**
		 * This will display the nearby map
		 *
		 * @since 1.0
		 * @updated 2.1
		 */
		function cspm_nearby_map_shortcode($atts){
			
			/**
			 * Prevent the shortcode from been executed in the WP admin.
			 * This will prevent errors like the error "headers already sent"!
			 * @since 2.1 */
			 
			if(is_admin())
				return;
				
			if(!class_exists('CspmMainMap'))
				return; 
				
			$CspmMainMap = CspmMainMap::this();
			
			extract( shortcode_atts( array(
				
				'map_id' => '', /** Used only to display multiple maps for Geolocalization */
				'post_ids' => '',
				'center_at' => '',
				'height' => $this->height,
				'width' => $this->width,
				'zoom' => $this->plugin_settings['map_zoom'],				
				'show_overlay' => str_replace(array('true', 'false'), array('yes', 'no'), $this->plugin_settings['show_infobox']),
				'show_secondary' => 'no',
				'map_style' => '',
				'initial_map_style' => $this->plugin_settings['initial_map_style'],
				'infobox_type' => $this->plugin_settings['infobox_type'],
				'distance_unit' => $this->distance_unit,
				'radius' => $this->radius,
				'rankby' => $this->rankBy, //@since 2.4
				'geoloc' => 'no',
				'places' => implode(',', $this->proximity),
				'layout' => $this->main_layout, /** Possible values: pl-mr, pr-ml, pt-mb */
				'list_cols' => '5',
				'map_cols' => '7',
				'list_grid' => $this->places_grid, /** Possible values: 2cols, 3cols, 4cols, 6cols */
				
				 /**
				  * [@link_target] Possible value, "same_window", "new_window" & "disable"
				  * @since 2.0 */
				  
				'infobox_link_target' => esc_attr($this->plugin_settings['infobox_external_link']), 
				
				/**
				 * Prevent displaying modal on marker click
				 * @since 2.1 */
				  
				'hide_modal' => 'no', 
				
			), $atts, 'cs_nearby_map' ) ); 
			
			$post_ids = esc_attr($post_ids);
			
			$post_ids_array = array();
			
			/**
			 * Check whether to use the map with the user's locations or a post location */
			 
			if($geoloc == 'no'){
				
				// Get the given post id
				if(!empty($post_ids)){
					
					$post_ids_array = explode(',', $post_ids);			
				
				// Get the current post id	
				}else{
				
					global $post;
					
					$post_ids_array[] = $post->ID;
					
				}
								
			}else{
				
				$post_ids_array = explode(',', esc_attr($map_id));
				
				if(empty($center_at))
					$center_at = $this->plugin_settings['map_center'];	
					
				$show_overlay = 'no';
				
			}
			
			$map_id = 'nearby_map_'.implode('', $post_ids_array);
			
			// Get the center point
			if(!empty($center_at)){
				
				$center_point = esc_attr($center_at);
				
				// If the center point is Lat&Lng coordinates
				if(strpos($center_point, ',') !== false){
						
					$center_latlng = explode(',', str_replace(' ', '', $center_point));
					
					// Get lat and lng data
					$centerLat = isset($center_latlng[0]) ? $center_latlng[0] : '';
					$centerLng = isset($center_latlng[1]) ? $center_latlng[1] : '';
				
				// If the center point is a post id
				}else{
						
					// Get lat and lng data
					$centerLat = get_post_meta($center_point, CSPM_LATITUDE_FIELD, true);
					$centerLng = get_post_meta($center_point, CSPM_LONGITUDE_FIELD, true);
			
				}
				
			}else{
					
				/**
				 * Get lat and lng data */
				 
				$centerLat = get_post_meta($post_ids_array[0], CSPM_LATITUDE_FIELD, true);
				$centerLng = get_post_meta($post_ids_array[0], CSPM_LONGITUDE_FIELD, true);
				
				/**
				 * In case the Lat and Lng still empty */
				
				if(empty($centerLat) && empty($centerLng)){
					
					$center_latlng = explode(',', str_replace(' ', '', $this->plugin_settings['map_center']));
					
					/**
					 * Get lat and lng data */
					 
					$centerLat = isset($center_latlng[0]) ? $center_latlng[0] : '';
					$centerLng = isset($center_latlng[1]) ? $center_latlng[1] : '';				
				}
				
			}
			
			$latLng = '"'.$centerLat.','.$centerLng.'"';										
									
			/**
			 * Map Styling */
			 
			$this_map_style = empty($map_style) ? $this->plugin_settings['map_style'] : esc_attr($map_style);
							
			$map_styles = array();
			
			if($this->plugin_settings['style_option'] == 'progress-map'){
					
				// Include the map styles array	
		
				if(file_exists($CspmMainMap->map_styles_file))
					$map_styles = include($CspmMainMap->map_styles_file);
						
			}elseif($this->plugin_settings['style_option'] == 'custom-style' && !empty($this->plugin_settings['js_style_array'])){
				
				$this_map_style = 'custom-style';
				$map_styles = array('custom-style' => array('style' => $this->plugin_settings['js_style_array']));
				
			}
			
			/**
			 * Set the height of the map.
			 * The height must be in pixels and at least 420px to properly display all the elements */
			
			$map_height = esc_attr($height);
			
			if(strpos($map_height, 'px') !== false){
				
				$strip_map_height = str_replace('px', '', $map_height);
				
				$map_height = ($strip_map_height >= 420) ? $map_height : '420px';
				
			}else $map_height = '420px';
			
			/**
			 * The list of all places selected by the user
			 * https://developers.google.com/places/documentation/supported_types?hl=fr */
			
			$proximity_array = explode(',', esc_attr(str_replace(' ', '', $places)));
				
			/**
			 * Infoboxes JS options
			 * @since 2.4
			 * @updated 2.6.3 */

			$infobox_options = array(
				'type' => $infobox_type,
				'display_event' => $this->plugin_settings['infobox_display_event'],
				'link_target' => $infobox_link_target,
				'remove_on_mouseout' => $this->plugin_settings['remove_infobox_on_mouseout'],
				'display_zoom_level' => isset($this->plugin_settings['infobox_display_zoom_level']) ? $this->plugin_settings['infobox_display_zoom_level'] : 12, //@since 2.6.3
				'show_close_btn' => isset($this->plugin_settings['infobox_show_close_btn']) ? $this->plugin_settings['infobox_show_close_btn'] : 'false', //@since 2.6.3
				'map_type' => 'light_map', //@since 2.6.3				
			);
			
			ob_start(); //@since 2.6.1
			
			?>
			
			<script>
			
			jQuery(document).ready(function($) { 
				
				/**
				 * init plugin map */
				 
				var plugin_map_placeholder = 'div#codespacing_progress_map_<?php echo $map_id; ?>';
				var plugin_map = $(plugin_map_placeholder);
				
				/**
				 * Load Map options */
				 
				var map_options = cspm_load_map_options('initial', true, <?php echo $latLng; ?>, <?php echo esc_attr($zoom); ?>);
					
				var mapzoomControlOptions = {
					zoomControl: true,
					zoomControlOptions: {
						position: google.maps.ControlPosition.RIGHT_BOTTOM
					}
				};	
															
				/**
				 * Activate the new google map visual */
				 
				google.maps.visualRefresh = true;
				
				/**
				 * The initial map style */
				 
				var initial_map_style = "<?php echo $initial_map_style; ?>";
				
				/**
				 * Enhance the map option with the map types id of the style */
				 
				<?php if(count($map_styles) > 0 && $this_map_style != 'google-map' && isset($map_styles[$this_map_style])){ ?> 
										
					/**
					 * The initial style */
					 
					var map_type_id = cspm_initial_map_style(initial_map_style, true);
					
					/**
					 * Map type control option */
					 
					var mapTypeControlOptions = {
						mapTypeControlOptions: {
							position: google.maps.ControlPosition.TOP_RIGHT,
							mapTypeIds: [
								google.maps.MapTypeId.ROADMAP,
								google.maps.MapTypeId.SATELLITE,
								google.maps.MapTypeId.TERRAIN,
								google.maps.MapTypeId.HYBRID,
								"custom_style"
							],				
						}
					};
												
					var map_options = $.extend({}, map_options, map_type_id, mapzoomControlOptions, mapTypeControlOptions);
					
				<?php }else{ ?>
										
					/**
					 * The initial style */
					 
					var map_type_id = cspm_initial_map_style(initial_map_style, false);
					
					var map_options = $.extend({}, map_options, map_type_id, mapzoomControlOptions);
					
				<?php } ?>
				
				<?php $show_infobox = (esc_attr($show_overlay) == 'yes') ? 'true' : 'false'; ?>
				
				var json_markers_data = [];
				
				var map_id = '<?php echo $map_id ?>';
				
				var show_infobox = '<?php echo $show_infobox; ?>';
				var infobox_type = '<?php echo esc_attr($infobox_type); ?>';
				var infobox_display_event = '<?php echo $this->plugin_settings['infobox_display_event']; ?>';
				var infobox_loaded = false;
				
				_CSPM_MAP_RESIZED[map_id] = 0;
				
				post_ids_and_categories[map_id] = {};
				post_lat_lng_coords[map_id] = {};
				post_ids_and_child_status[map_id] = {}
				 
				cspm_infoboxes[map_id] = []; //@since 2.4
				
				<?php 
		
				// Count items
				$count_post = count($post_ids_array);
				
				if($count_post > 0 && $geoloc == 'no'){
					
					$markers_array = get_option('cspm_markers_array'); //@since 2.1
					
					$secondary_latlng_array = array();
					
					/**
					 * Loop throught items */
					 
					foreach($post_ids_array as $post_id){
						
						/**
						 * Get lat and lng data */
						 
						$lat = get_post_meta($post_id, CSPM_LATITUDE_FIELD, true);
						$lng = get_post_meta($post_id, CSPM_LONGITUDE_FIELD, true);
					
						/**
						 * Show items only if lat and lng are not empty */
						 
						if(!empty($lat) && !empty($lng)){
					
							$marker_img_array = apply_filters('cspm_bubble_img', wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'cspm-marker-thumbnail' ), $post_id);
							$marker_img = isset($marker_img_array[0]) ? $marker_img_array[0] : '';

							/**
							 * 1. Get marker category */
							 
							$post_categories = array();
							$implode_post_categories = '';
								
							/**
							 * 2. Get marker image */
							 
							$marker_img_and_size = $CspmMainMap->cspm_get_marker_img(
								array(
									'post_id' => $post_id,
									'default_marker_icon' => $this->plugin_settings['marker_icon'],
									'is_single' => true,
									'marker_width' => $this->plugin_settings['marker_icon_width'], //@since 2.5
									'marker_height' => $this->plugin_settings['marker_icon_height'], //@since 2.5										
								)
							);
							
							$marker_img_by_cat = $marker_img_and_size['image'];

							/**
							 * 3. Get marker image size for Retina display */
							 
							$marker_img_size = $CspmMainMap->cspm_get_image_size(
								array(
									'path' => $CspmMainMap->cspm_get_image_path_from_url($marker_img_by_cat),
									'default_width' => $marker_img_and_size['size']['width'],
									'default_height' => $marker_img_and_size['size']['height'],				
								)
							);
							
							/**
							 * Get the post type name & the post media 
							 * @since 2.1 */
							 
							$post_type = get_post($post_id)->post_type;

							$media = isset($markers_array[$post_type]['post_id_'.$post_id]['media']) ? $markers_array[$post_type]['post_id_'.$post_id]['media'] : array();
							
							/**
							 * [@pin_options] Contains all infos about the marker/post ...
							 * ... that will send to the JS function "cspm_new_pin_object()" ...
							 * ... to add markers/pins to the map.
							 * @since 2.1 */

							$pin_options = array(
								'post_id' => $post_id,
								'post_categories' => $implode_post_categories,
								'coordinates' => array(
									'lat' => $lat,
									'lng' => $lng,
								),									
								'icon' => array(
									'url' => $marker_img_by_cat,
									'size' => $marker_img_size,
								),
								'is_child' => 'no',
								'media' => $media,
							);
							
							?>
															
							/**
							 * Create the pin object */
													 
							var marker_object = cspm_new_pin_object(map_id, <?php echo wp_json_encode($pin_options); ?>);
							json_markers_data.push(marker_object); <?php 
							
						}
								
					} 
											
				}
				
				?>
					
				var hide_modal = <?php if($hide_modal == 'no'){ ?> false; <?php }else{ ?> true; <?php } ?> // @since 2.1
					
				/**
				 * Build the map */
				 
				plugin_map.gmap3({	
						  
					map:{
						options: map_options,
						onces: {
							tilesloaded: function(){

								if(typeof NProgress !== 'undefined'){
									
									NProgress.configure({
									  parent: 'div#codespacing_progress_map_'+map_id,
									  showSpinner: true
									});				
									
									NProgress.start();
									
								}
	
								plugin_map.gmap3({ 
									marker:{
										values: json_markers_data,	
										events:{
											mouseover: function(marker, event, elements){

												/**
												 * Display the single infobox
												 * @since 2.4 */

												if(json_markers_data.length > 0 && show_infobox == 'true' && infobox_display_event == 'onhover')
													cspm_draw_single_infobox(plugin_map, map_id, marker, <?php echo wp_json_encode($infobox_options); ?>);
												
												/**
												 * Show a message to the user to inform them that ...
												 * ... they can open the the post medial modal if they ...
												 * ... click on the marker.
												 *
												 * @since 2.1 */

												if(!hide_modal && typeof marker.media !== 'undefined' && marker.media.format != 'standard' && marker.media.format != '')
													cspm_open_media_message(marker.media, map_id);
											
											},
											mouseout: function(marker, event, elements){
												
												/**
												 * Hide the post media message
												 * @since 2.1 */

												if(!hide_modal && typeof marker.media !== 'undefined' && marker.media.format != 'standard' && marker.media.format != '')
													cspm_close_media_message(map_id);
												
											},
											click: function(marker, event, elements){

												/**
												 * Display the single infobox
												 * @since 3.9 */

												if(json_markers_data.length > 0 && show_infobox == 'true' && infobox_display_event == 'onclick')
													cspm_draw_single_infobox(plugin_map, map_id, marker, <?php echo wp_json_encode($infobox_options); ?>);
													
												/**
												 * Open the post/location media modal
												 * @since 2.1 */

												if(!hide_modal && typeof marker.media !== 'undefined' && marker.media.format != 'standard')
													cspm_open_media_modal(marker.media, map_id);
												
											}
										}																		
									}
								});
													
								/**
								 * Show the bubbles after the map load
								 * @updated 2.6.3 */
								 
								if(json_markers_data.length > 0 && show_infobox == 'true' && (infobox_display_event == 'onload' || infobox_display_event == 'onzoom')){ //@edited 2.6.3
									cspm_draw_multiple_infoboxes(plugin_map, map_id, <?php echo wp_json_encode($infobox_options); ?>); //@updated 2.4
								}
								
								if(typeof NProgress !== 'undefined')
									NProgress.set(0.5);
						
								<?php
					
								/**
								 * Display Places when user choosed to use one single place type in their website
								 * @since 1.3 */
								
								if(count($proximity_array) == 1 && $geoloc == 'no'){ 
									
									foreach($proximity_array as $single_proximity){
										
										$single_proximity_id = ltrim(rtrim(str_replace(' ', '', $single_proximity)));
										
										if(isset($this->proximity_names[$single_proximity])){
											
											?>
	
											var selected_system_unit = $('div#cspm_nearby_map_'+map_id).attr('data-selected-system-unit');
											
											var radius = <?php echo esc_attr($radius); ?>;
											var rankby = '<?php echo esc_attr($rankby); ?>'; //@edited 2.6.4
											
											var proximity_id = '<?php echo $single_proximity_id; ?>';
																						
											/**
											 * Create Nearby Markers */
											 
											cspm_nearby_locations(map_id, proximity_id, selected_system_unit, radius, rankby);
											
											$('div#cspm_nearby_map_'+map_id).attr('data-current-screen', 'places_list');
											
											<?php 
										
										}
										
									}
									
								} 
								
								?>

								/**
								 * End the Progress Bar Loader */
									
								if(typeof NProgress !== 'undefined')
									NProgress.done();
			
							}
							
						},
						events:{
							idle: function(map){
								setTimeout(function(){
									if(	json_markers_data.length > 0 && show_infobox == 'true' && (infobox_display_event == 'onload' || infobox_display_event == 'onzoom')){
										cspm_draw_multiple_infoboxes(plugin_map, map_id, <?php echo wp_json_encode($infobox_options); ?>);																							
									}
								}, 200); //@since 5.3
							}
						},				
					},
					
					<?php if(count($map_styles) > 0 && $this_map_style != 'google-map' && isset($map_styles[$this_map_style])){ ?> 
						<?php $style_title = isset($map_styles[$this_map_style]['title']) ? $map_styles[$this_map_style]['title'] : $this->plugin_settings['custom_style_name']; ?>
						styledmaptype:{
							id: "custom_style",
							options:{
								name: "<?php echo $style_title; ?>",
								alt: "Show <?php echo $style_title; ?>"
							},
							styles: <?php echo $map_styles[$this_map_style]['style']; ?>
						},
					<?php } ?>
					
				});								
					
				/**
				 * Center the Map on screen resize */
					 
				<?php if(!empty($centerLat) && !empty($centerLng)){ ?>
					
					/**
					 * Store the window width */
					 
					var windowWidth = $(window).width();

					$(window).resize(function(){
						
						/**
						 * Check window width has actually changed and it's not just iOS triggering a resize event on scroll */
						 
						if ($(window).width() != windowWidth) {
				
							/**
							 * Update the window width for next time */
							 
							windowWidth = $(window).width();
		
							setTimeout(function(){
								
								var latLng = new google.maps.LatLng (<?php echo $centerLat; ?>, <?php echo $centerLng; ?>);							
							
								var map = plugin_map.gmap3("get");	
								
								if(typeof map.panTo === 'function')
									map.panTo(latLng);
								
								if(typeof map.setCenter === 'function')
									map.setCenter(latLng);
									
							}, 500);
							
						}
						
					});

				<?php } ?> 					
				 
				<?php 
				
				/**
				 * Resolve a problem of Google Maps & jQuery Tabs */
				 
				if(!empty($centerLat) && !empty($centerLng)){ ?>				
                
                    $('body').ready(function(){
                        if($(plugin_map_placeholder).is(':visible')){                           
                            if(_CSPM_MAP_RESIZED[map_id] <= 1){ /* 0 is for the first loading, 1 is when the user clicks the map tab */
                                cspm_center_map_at_point(plugin_map, '<?php echo $map_id ?>', <?php echo $centerLat; ?>, <?php echo $centerLng; ?>, 'resize');
                                _CSPM_MAP_RESIZED[map_id]++;
                            }
                            cspm_zoom_in_and_out(plugin_map);
                        }
                    });
					
				<?php } ?>
			
				/**
				 * This Variables are initialized in "pm-nearby-map.js" */
				
				nearby_map[map_id] = plugin_map;									
				nearby_map_object[map_id] = plugin_map.gmap3("get");					
				origin[map_id] = new google.maps.LatLng(<?php echo $centerLat; ?>, <?php echo $centerLng; ?>);											
				
				cspm_init_nearby_directions_display(map_id);											
				
				<?php 
				
				if($geoloc == 'yes' && $this->autocomplete_option == 'yes'){ ?>
				
					var input = document.getElementById('cspm_nearby_address_'+map_id);
					var autocomplete = new google.maps.places.Autocomplete(input);
	
					<?php 
					
					/** 
					 * Restrict the autocomplete to map bounds
					 * @since 2.6.5 */
					
					if($this->autocomplete_strict_bounds == 'yes'){ ?>
						autocomplete.bindTo('bounds', plugin_map.gmap3("get"));
						autocomplete.setOptions({strictBounds: true}); <?php 
					} 
					
					/** 
					 * Restrict the autocomplete to specific countries
					 * @since 2.6.5 */
					
					if($this->autocomplete_country_restrict == 'yes' && count($this->autocomplete_countries) > 0){ 
						$countries = wp_json_encode($this->autocomplete_countries); ?>
						autocomplete.setComponentRestrictions({'country': <?php echo $countries; ?>}); <?php 
					} 
				
				} 
				
				?>	
				
				<?php if((is_user_logged_in() && current_user_can('administrator')) || $this->plugin_settings['combine_files'] == 'seperate'){ ?> 
					cspm_check_gmaps_failure(map_id); 
				<?php } //@since 2.6.7 ?>
	
			});
			
			</script> 
			
			<?php
			
			$map_js_script = str_replace(array('<script>', '</script>'), '', ob_get_contents()); //@since 2.6.1
			ob_end_clean(); //@since 2.6.1
			
			/**
			 * Build the infoboxes content and add it to the JS script
			 * @since 2.4 */
			
			if($geoloc == 'no'){
				$this->cspm_add_js_script_data(
					$this->cspm_infoboxes_data(array(
						'map_id' => $map_id, 
						'post_ids' => $post_ids_array,
						'infobox_type' => $infobox_type,
						'infobox_link_target' => $infobox_link_target,
					)
				));
			}
			 
			/**
			 * Load styles & scripts from "Progress Map" */
			
			$CspmMainMap->cspm_enqueue_styles($this->plugin_settings['combine_files']);
			$CspmMainMap->cspm_enqueue_scripts($this->plugin_settings['combine_files']);

			/**
			 * Override infobox width & height
			 * @since 2.5 */
						
			if(!empty($this->plugin_settings['infobox_width']) && !empty($this->plugin_settings['infobox_height'])){
				
				wp_add_inline_style('cspm-style', $CspmMainMap->cspm_infobox_size(
					array(
						'map_id' => $map_id,
						'width' => $this->plugin_settings['infobox_width'],
						'height' => $this->plugin_settings['infobox_height'],
						'type' => $infobox_type,
					)
				));
				
			}
			
			/**
			 * Load styles & scripts of this extension */
			 
			$this->cspm_enqueue_styles();
			$this->cspm_enqueue_scripts();

			wp_add_inline_script('cspm-nearby-map-script', $map_js_script); //@since 2.6.1
						
			/**
			 * Set the distance unit */
			
			$selected_system_unit = ($distance_unit == 'all') ? 'METRIC' : esc_attr(strtoupper($distance_unit));
			
			/**
			 * Display the nearby map */
												
			if(count($proximity_array) == 1){
				 
				foreach($proximity_array as $single_proximity)
					$data_single_proximity_id = 'data-single-proximity-id="'.ltrim(rtrim(str_replace(' ', '', $single_proximity))).'"';
					
			}else $data_single_proximity_id = '';
			
			
			/**
			 * [@img_file_url] The images directory */
			
			$img_file_url = apply_filters('csnm_img_file', $this->plugin_url.'img/'); // @since 1.5
			 
			$output = '<div id="cspm_nearby_map_'.$map_id.'" class="cspm-row cspm_nearby_map cspm_linear_gradient_bg" data-map-id="'.$map_id.'" data-current-screen="nearby_cats" data-selected-system-unit="'.$selected_system_unit.'" data-radius="'.esc_attr($radius).'" data-count-place-types="'.count($proximity_array).'" data-selected-place-id="false" data-rankby="'.esc_attr($rankby).'" '.$data_single_proximity_id.' style="width:'.$width.';">';
				
				/**
				 * Set the layout */
				
				$places_position = 'cspm-col-lg-'.$list_cols.' cspm-col-md-'.$list_cols;
				$map_position = 'cspm-col-lg-'.$map_cols.' cspm-col-md-'.$map_cols;
				
				if($layout == 'pr-ml')
					$places_position = 'pull-right cspm-col-lg-'.$list_cols.' cspm-col-md-'.$list_cols;
				elseif($layout == 'pl-mr')
					$places_position = 'cspm-col-lg-'.$list_cols.' cspm-col-md-'.$list_cols;
				elseif($layout == 'pt-mb'){
					$places_position = 'cspm-col-lg-12 cspm-col-md-12';
					$map_position = 'cspm-col-lg-12 cspm-col-md-12';
				}
				
				$output .= '<div class="'.$places_position.' cspm-col-sm-12 cspm-col-xs-12 cspm_nearby_cats_directions_container" style="height:'.$map_height.';">';
					
					/**
					 * Display the address search form */
					 
					if($geoloc == 'yes'){
				
						$output .= '<div id="cspm_nearby_address_locator_'.$map_id.'" class="cspm_nearby_address_locator">';
							
							$output .= '<div class="cspm_locator_form_container text-center cspm_border_shadow cspm_border_radius cspm_animated fadeIn">';
							
								$output .= '<h3 class="cspm_locator_title">'.esc_html__('Type your address or geolocate your position', 'cs_nearby_map').'</h3>';
							
								$output .= '<form action="" onsubmit="return false;">';
									
									$output .= '<input type="text" id="cspm_nearby_address_'.$map_id.'" name="cspm_nearby_address_'.$map_id.'" placeholder="'.esc_html__('Address or Latitude & Longitude', 'cs_nearby_map').'" class="cspm_border_shadow cspm_border_radius" />';
								
									$output .= '<span class="cspm_get_geoloc cspm_border_shadow cspm_border_radius" data-map-id="'.$map_id.'"><img src="'.$img_file_url.'geoloc.png" /></span>';
								
									$output .= '<span class="cspm_get_address cspm_nearby_map_main_background hover cspm_border_shadow cspm_border_radius" data-map-id="'.$map_id.'">'.esc_html__('Localize it', 'cs_nearby_map').'<img src="'.$img_file_url.'search.png" /></span>';
									
								$output .= '</form>';
								
							$output .= '</div>';
								
						$output .= '</div>';
						
					}
					
					/** 
					 * Display proximity Categories */
					 
					if(count($proximity_array) > 1){
															
						$output .= '<div id="cspm_nearby_cats_container_'.$map_id.'" class="cspm-row cspm_nearby_cats_container cspm_animated fadeIn">';
							
							/**
							 * Set the places grid system */
							
							if($list_grid == '2cols')
								$places_columns = 'cspm-col-lg-6 cspm-col-md-6';
							elseif($list_grid == '3cols')
								$places_columns = 'cspm-col-lg-4 cspm-col-md-4';
							elseif($list_grid == '4cols')
								$places_columns = 'cspm-col-lg-3 cspm-col-md-3';
							elseif($list_grid == '6cols')
								$places_columns = 'cspm-col-lg-2 cspm-col-md-2';
								
							foreach($proximity_array as $single_proximity){
								
								$strip_proximity_name = ltrim(rtrim(str_replace(' ', '', $single_proximity)));

								if(!empty($strip_proximity_name) && isset($this->proximity_names[$single_proximity])) {
									
									$proximity_name = esc_html__($this->proximity_names[$single_proximity], 'cs_nearby_map');									

									$output .= '<div id="'.$strip_proximity_name.'" data-proximity-name="'.$proximity_name.'" data-map-id="'.$map_id.'" class="proximity_place_'.$map_id.' '.$places_columns.' cspm-col-sm-2 cspm-col-xs-6 cspm_nearby_cat_holder text-center">';
										
										$output .= '<div class="cspm_nearby_cat cspm_border_shadow cspm_border_radius">';
										
											$output .= '<img class="cspm_nearby_cat_img" src="'.$img_file_url.'nearby/'.$single_proximity.'.png" />';
											
											$output .= '<span class="cspm_nearby_cat_name">'.$proximity_name.'</span>';
										
										$output .= '</div>';
										
									$output .= '</div>'; 
									
								}
							
							}
							
						$output .= '</div>';
						
					}
					
					/**
					 * Display places list */
					 
					$output .= '<div id="cspm_nearby_places_list_'.$map_id.'" class="cspm_nearby_places_list cspm_animated fadeIn">';
						
						$output .= '<div class="cspm_nearby_cat_list cspm_nearby_map_main_background text-center">';
																
							$output .= '<img class="cspm_nearby_cat_list_img img-responsive pull-left" src="" />';
	
							$output .= '<span class="text-center cspm_nearby_cat_list_name pull-left"></span><span class="cspm_nbr_places_found pull-left"><span class="wrapper"><span class="cssload-loader white"></span></span></span>';
							
							if(count($proximity_array) > 1)
								$output .= '<img src="'.$img_file_url.'back.png" class="cspm_back_to_nearby_cats pull-right" data-map-id="'.$map_id.'" />';
							
							$output .= '<div class="clearfix"></div>';
							
						$output .= '</div>';
						
						$output .= '<div class="cspm_nearby_location_list_items_container_'.$map_id.'" style="height:'.(str_replace('px', '', $map_height)-65).'px;"></div>';
						
					$output .= '</div>';
					
					/**
					 * Display place details */
					 
					$output .= '<div class="cspm_nearby_map_place_details_container_'.$map_id.' cspm_animated fadeIn" style="height:'.$map_height.';">';
					
						$output .= '<div class="cspm_nearby_map_place_details_content_'.$map_id.'"></div>';
						
					$output .= '</div>';
					
					/**
					 * Display directions */

					$output .= '<div class="cspm_nearby_map_directions_'.$map_id.' cspm_animated fadeIn">';
							
						$output .= '<div class="cspm_start_address_container"></div>';
						
						$output .= '<div class="cspm_direction_steps_container" style="height:'.(str_replace('px', '', $map_height)-124).'px;"></div>';
							
						$output .= '<div class="cspm_destination_address_container"></div>';
						
					$output .= '</div>';
					
				$output .= '</div>';
				
				$output .= '<div class="'.$map_position.' cspm-col-sm-12 cspm-col-xs-12 cspm_map_container" data-map-id="'.$map_id.'" style="height:'.$map_height.';">';
					
					/**
					 * Display a button to reset the map when the map is used for user localization */
					 
					if($geoloc == 'yes')
						$output .= '<div class="cspm_btn_reset_nearby_map_'.$map_id.' cspm_nearby_map_main_background hover cspm_border_shadow cspm_border_radius" data-map-id="'.$map_id.'">'.esc_html__('New Search', 'cs_nearby_map').' <img src="'.$img_file_url.'search-small.png" /></div>';			
					
					/**
					 * Travel Controls */
				
					$output .= '<div id="travel_mode_container_'.$map_id.'" class="nearby_travel_mode_container geoloc_'.$geoloc.'"></div>';
					
					$output .= '<div id="cspm_directions_btn_container_'.$map_id.'" class="cspm_directions_btn_container geoloc_'.$geoloc.'"></div>';
					
					$output .= '<div id="cspm_place_name_container_'.$map_id.'" class="cspm_place_name_container geoloc_'.$geoloc.' cspm_border_radius cspm_border_shadow text-center"></div>';
										
					/**
					 * Map Container */
								
					$output .= '<div id="codespacing_progress_map_'.$map_id.'"></div>';
					
				$output .= '</div>';
			
			$output .= '</div>';
				
			return $output;
						
		}
		
	}
			
}

if(class_exists('CspmNearbyMap')){
	$CspmNearbyMap = new CspmNearbyMap();
	$CspmNearbyMap->cspm_hooks();
}
