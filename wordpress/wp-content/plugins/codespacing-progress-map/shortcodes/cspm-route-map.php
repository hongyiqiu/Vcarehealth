<?php

/**
 * Credits to "Jean-Michel Carrel" (https://github.com/neyxo)
 * @since "Progress Map v3.6" */
 
if(!class_exists('CspmRouteMap')){
	
	class CspmRouteMap{
		
		private static $_this;	
		
		public $plugin_settings = array();

		function __construct(){
			
			if (!class_exists('CspmMainMap'))
				return; 
		
			self::$_this = $this;       

			$CspmMainMap = CspmMainMap::this();
			 
			$this->plugin_settings = $CspmMainMap->plugin_settings;

		}
		
	
		static function this(){
			
			return self::$_this;
			
		}
		
		
		function cspm_hooks(){
			
			if(!is_admin()){
				
				/**
				 * Add map's shortcode */
					
				add_shortcode('cspm_route_map', array($this, 'cspm_route_map_shortcode'));
				
			}

		}
		
		
		/**
		 * Check if array_key_exists and if empty() doesn't return false
		 * Replace the empty value with the default value if available 
		 * @empty() return false when the value is (null, 0, "0", "", 0.0, false, array())
		 *
		 * @since 5.4
		 */
		function cspm_setting_exists($key, $array, $default = ''){
			
			$array_value = isset($array[$key]) ? $array[$key] : $default;
			
			$setting_value = empty($array_value) ? $default : $array_value;
			
			return $setting_value;
			
		}
		
		
		/**
		 * This will load the styles needed by our shortcodes based on its settings
		 *
		 * @since 3.0
		 * @updated 3.5
		 */
		function cspm_enqueue_styles($hide_modal = 'no'){
			
			do_action('cspm_before_enqueue_route_map_style');
			
			/**
			 * Media Element 
			 * @since 3.5 */
			 
			if($hide_modal == 'no')
				wp_enqueue_style('wp-mediaelement');				 			

			/**
			 * Font Style */
			
			if($this->plugin_settings['remove_google_fonts'] == 'enable')  	
				wp_enqueue_style('cspm-font');
			
			$script_handle = 'cspm-style';
	
			/**
			 * iziModal
			 * @since 3.5 */

			if($hide_modal == 'no')				 
				wp_enqueue_style('jquery-izimodal');
						
			/**
			 * iziToast
			 * @since 3.5 */
			 
			if($hide_modal == 'no')
				wp_enqueue_style('jquery-izitoast');
				
			/**
			 * Progress Bar loader */
			 
			wp_enqueue_style('nprogress');											
			
			/**
			 * Snazzy Infobox
			 * @since 3.9 */
			
			wp_enqueue_style('snazzy-info-window');
			
			/** 
			 * Progress Map styles */
			
			wp_enqueue_style($script_handle);
			
			do_action('cspm_after_enqueue_route_map_style');
		
			/**
			 * Add custom header script */
			
			wp_add_inline_style($script_handle, $this->cspm_custom_map_style());
			
		}

		
		/** 
		 * This will build the custom CSS needed for this map
		 *
		 * @since 3.0
		 */
		function cspm_custom_map_style(){
				
			$custom_map_style = '';
			
			/**
			 * Nprogress CSS
			 * @since 3.8 */
			
			$custom_map_style .= '#nprogress .bar{background: '.$this->plugin_settings['main_hex_color'].' !important;}';
			$custom_map_style .= '#nprogress .spinner-icon{border-top-color: '.$this->plugin_settings['main_hex_color'].' !important;}';
			
			$custom_map_style .= (isset($this->plugin_settings['custom_css'])) ? $this->plugin_settings['custom_css'] : '';
			
			return $custom_map_style;
				
		}
		
		
		/**
		 * This will load the scripts needed by our shortcodes based on its settings
		 *
		 * @since 3.0
		 * @updated 3.5
		 */
		function cspm_enqueue_scripts($hide_modal = 'no'){
			
			/**
			 * jQuery */
			 
			wp_enqueue_script('jquery');				 			
			
			/**
			 * Media Element 
			 * @since 3.5 */
			 
			if($hide_modal == 'no')
				wp_enqueue_script('wp-mediaelement');
			
			/**
			 * Images Loaded 
			 * @since 3.5 */
			 			
			if($hide_modal == 'no')
				wp_enqueue_script('imagesloaded');			 			

			do_action('cspm_before_enqueue_route_map_script');
			
			/**
			 * GMaps API */
			
			if(!in_array('disable_frontend', $this->plugin_settings['remove_gmaps_api']))				 
				wp_enqueue_script('cs-gmaps-api-v3');
			
			$localize_script_handle = 'cspm-script';
		
			/**
			 * GMap3 jQuery Plugin */
			 
			wp_enqueue_script('cspm-gmap3');
						
			/**
			 * iziModal */
			 
			if($hide_modal == 'no')
				wp_enqueue_script('jquery-izimodal');
						
			/**
			 * iziToast */
			 
			if($hide_modal == 'no')
				wp_enqueue_script('jquery-izitoast');
						
			/**
			 * Siema */
			
			if($hide_modal == 'no')
				wp_enqueue_script('siema');
				
			/**
			 * Progress Bar loader */
			 
			wp_enqueue_script('nprogress');
			
			/**
			 * Snazzy Infobox
			 * @since 3.9 */
			
			wp_enqueue_script('snazzy-info-window');
			
			/**
			 * Progress Map Script */
			 
			wp_enqueue_script($localize_script_handle);

			do_action('cspm_after_enqueue_route_map_script');
			
		}
		
							
		/**
		 * Build the infoboxes content
		 *
		 * @since 3.9 
		 * @updated 4.0
		 */		
		function cspm_infoboxes_data($atts = array()){

			extract( wp_parse_args( $atts, array(
				'map_id' => '', 
				'post_ids' => '',
				'infobox_type' => $this->plugin_settings['infobox_type'],
				'infobox_link_target' => $this->plugin_settings['infobox_external_link'],
				'infobox_width' => $this->plugin_settings['infobox_width'], //@since 4.0
				'infobox_height' => $this->plugin_settings['infobox_height'], //@since 4.0		
				'infobox_title' => $this->cspm_setting_exists('infobox_title', $this->plugin_settings), //@edited 5.4	
				'infobox_external_link' => $this->plugin_settings['infobox_external_link'], //@since 5.0		
				'infobox_details' => $this->cspm_setting_exists('infobox_content', $this->plugin_settings), //@edited 5.4
			))); 

			$infoboxes = $infoboxes_data = array();
			
			if(!class_exists('CspmMainMap'))
				return $infoboxes_data; 
				
			$CspmMainMap = CspmMainMap::this();
			
			foreach($post_ids as $post_id){
				$infoboxes[$post_id] = $CspmMainMap->cspm_infobox(array(
					'post_id' => $post_id,
					'map_id' => $map_id,
					'carousel' => 'false',
					'infobox_type' => $infobox_type,
					'infobox_link_target' => $infobox_link_target,
					'infobox_width' => $infobox_width, //@since 4.0
					'infobox_height' => $infobox_height, //@since 4.0
					'infobox_title' => $infobox_title, //@since 5.0		
					'infobox_external_link' => $infobox_external_link, //@since 5.0		
					'infobox_details' => $infobox_details, //@since 5.0
				));
			}
			
			$infoboxes_data['infoboxes_'.$map_id] = $infoboxes;
			
			return $infoboxes_data;
			
		}
		
		
		/**
		 * Add new data to the JS scripts
		 *
		 * @since 3.9
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
		 * This will check if the code is a hexa decimal color
		 *
		 * @since 5.6
		 */
		function cspm_is_hex_color($hexStr){
			
			$hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
			
			if(ctype_xdigit($hexStr) && (strlen($hexStr) == 6 || strlen($hexStr) == 3)){
				return true;			
			}else return false; // Invalid hex color code
		
		}
		
 
	    /**
		 * Display a route between 2 or more posts
		 * Note: No carousel used
		 */
		function cspm_route_map_shortcode($atts){
			
			/**
			 * Prevent the shortcode from been executed in the WP admin.
			 * This will prevent errors like the error "headers already sent"!
			 * @since 3.4 */
			 
			if(is_admin())
				return;
				
			if (!class_exists('CspmMainMap'))
				return; 
				
			$CspmMainMap = CspmMainMap::this();

			extract( shortcode_atts( array(
			
				'post_ids' => '',
				'center_at' => '',
				'height' => '300px',
				'width' => '100%',
				'zoom' => $this->plugin_settings['map_zoom'],
				'show_overlay' => str_replace(array('true', 'false'), array('yes', 'no'), $this->plugin_settings['show_infobox']),
				'show_secondary' => 'yes',
				'map_style' => '',
				'initial_map_style' => esc_attr($this->plugin_settings['initial_map_style']),
				'infobox_type' => $this->plugin_settings['infobox_type'],
				'hide_empty' => 'yes', //@since 2.7.1
				
				/**
				 * [@window_resize] Whether to resize the map on window resize or not.
				 * @since 2.8.5 */
				
				'window_resize' => 'yes', // Possible values, "yes" & "no"
				
				 /**
				  * [@link_target] Possible value, "same_window", "new_window", "popup" & "disable"
				  * @since 2.8.6 */
				  
				'infobox_link_target' => esc_attr($this->plugin_settings['infobox_external_link']), 
				
				/**
				 * Prevent displaying modal on marker click
				 * @since 3.5 */
				  
				'hide_modal' => 'no', 
				
				/** 
				 * Route options */
				 
				'travel_mode' => 'DRIVING', // Possible values, "DRIVING", "BICYCLING", "TRANSIT" & "WALKING"
				'unit' => 'METRIC', // Possible values, "METRIC" & "IMPERIAL"
				
				'route_color' => '#73b9ff', // The polyline stroke color | @since 5.6
				'route_weight' => 6, // The polyline stroke weight | @since 5.6
				'route_opacity' => 0.6, // The polyline stroke opacity | @since 5.6
				
			), $atts, 'cspm_route_map' ) ); 
			
			$post_ids = esc_attr($post_ids);
			
			$post_ids_array = array();
			
			global $post;

			/**
			 * Get the given post id */
			 
			if(!empty($post_ids)){
				
				$post_ids_array = explode(',', $post_ids);			
			
			/**
			 * Get the current post id */
			 
			}else{
				
				$post_ids_array[] = $post->ID;
				
			}
			
			$map_id = implode('', $post_ids_array);
			
			/**
			 * Get the center point */
				 
			$default_map_center = explode(',', $this->plugin_settings['map_center']);
 
			if(!empty($center_at)){
				
				$center_point = esc_attr($center_at);
				
				/**
				 * If the center point is Lat&Lng coordinates */
				 
				if(strpos($center_point, ',') !== false){
						
					$center_latlng = explode(',', str_replace(' ', '', $center_point));
					
					/**
					 * Get lat and lng data */
					 
					$centerLat = isset($center_latlng[0]) ? $center_latlng[0] : '';
					$centerLng = isset($center_latlng[1]) ? $center_latlng[1] : '';
				
				/**
				 * If the center point is a post id */
				 
				}else{
						
					/**
					 * Get lat and lng data */
					 
					$post_lat = get_post_meta($center_point, CSPM_LATITUDE_FIELD, true);
					$post_lng = get_post_meta($center_point, CSPM_LONGITUDE_FIELD, true);
					
					$centerLat = (!empty($post_lat)) ? $post_lat : $default_map_center[0];
					$centerLng = (!empty($post_lng)) ? $post_lng : $default_map_center[1];
			
				}
				
			}else{
					
				/**
				 * Get lat and lng data */
				
				$post_lat = get_post_meta($post_ids_array[0], CSPM_LATITUDE_FIELD, true);
				$post_lng = get_post_meta($post_ids_array[0], CSPM_LONGITUDE_FIELD, true);
				
				$centerLat = (!empty($post_lat)) ? $post_lat : $default_map_center[0];
				$centerLng = (!empty($post_lng)) ? $post_lng : $default_map_center[1];
			
			}
			
			$latLng = '"'.$centerLat.','.$centerLng.'"';										
									
			/**
			 * Map Styling */
			 
			$this_map_style = empty($map_style) ? $this->plugin_settings['map_style'] : esc_attr($map_style);
							
			$map_styles = array();

			if($this->plugin_settings['style_option'] == 'progress-map'){
					
				/**
				 * Include the map styles array	*/
		
				if(file_exists($CspmMainMap->map_styles_file))
					$map_styles = include($CspmMainMap->map_styles_file);
						
			}elseif($this->plugin_settings['style_option'] == 'custom-style' && !empty($this->plugin_settings['js_style_array'])){
				
				$this_map_style = 'custom-style';
				$map_styles = array('custom-style' => array('style' => $this->plugin_settings['js_style_array']));
				
			}
				
			/**
			 * Infoboxes JS options
			 * @since 3.9
			 * @updated 5.3 */

			$infobox_options = array(
				'type' => $infobox_type,
				'display_event' => $this->plugin_settings['infobox_display_event'],
				'link_target' => $infobox_link_target,
				'remove_on_mouseout' => $this->plugin_settings['remove_infobox_on_mouseout'],
				'display_zoom_level' => isset($this->plugin_settings['infobox_display_zoom_level']) ? $this->plugin_settings['infobox_display_zoom_level'] : 12, //@since 5.3
				'show_close_btn' => isset($this->plugin_settings['infobox_show_close_btn']) ? $this->plugin_settings['infobox_show_close_btn'] : 'false', //@since 5.3
				'map_type' => 'light_map', //@since 5.3
			);
			
			/**
			 * Route/Polyline style
			 * @since 5.6 */
			 
			$stroke_color = $this->cspm_is_hex_color(esc_attr($route_color)) ? esc_attr($route_color) : '#73b9ff'; //@since 5.6
			$stroke_weight = is_numeric(esc_attr($route_weight)) ? esc_attr($route_weight) : 6; //@since 5.6
			$stroke_opacity = is_numeric(esc_attr($route_opacity)) ? esc_attr($route_opacity) : 0.6; //@since 5.6
			
			ob_start(); //@since 4.9.1
			
			?>
			
			<script>
			
			jQuery(document).ready(function($){ 
				
				"use strict"; 
									
				/**
				 * init plugin map */
				 
				var plugin_map_placeholder = 'div#cspm_route_map_<?php echo $map_id; ?>';
				var plugin_map = $(plugin_map_placeholder);
				
				/**
				 * Start displaying the Progress Bar loader */
				 
				if(typeof NProgress !== 'undefined'){
					
					NProgress.configure({
					  parent: plugin_map_placeholder,
					  showSpinner: true
					});				
					
					NProgress.start();
					
				}
				
				/**
				 * Load Map options */
				 
				var map_options = cspm_load_map_options('initial', true, <?php echo $latLng; ?>, <?php echo esc_attr($zoom); ?>);
				
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
							style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
							position: google.maps.ControlPosition.TOP_RIGHT,
							mapTypeIds: [
								google.maps.MapTypeId.ROADMAP,
								google.maps.MapTypeId.SATELLITE,
								google.maps.MapTypeId.TERRAIN,
								google.maps.MapTypeId.HYBRID,
								"custom_style"
							]				
						}
					};
												
					var map_options = $.extend({}, map_options, map_type_id, mapTypeControlOptions);
					
				<?php }else{ ?>
										
					/**
					 * The initial style */
					 
					var map_type_id = cspm_initial_map_style(initial_map_style, false);
												
					var map_options = $.extend({}, map_options, map_type_id);
					
				<?php } ?>
				
				<?php $show_infobox = (esc_attr($show_overlay) == 'yes') ? 'true' : 'false'; ?>
				
				var map_id = 'route_<?php echo $map_id ?>';
				
				var json_markers_data = [];
				
				var show_infobox = '<?php echo $show_infobox; ?>';
				var infobox_type = '<?php echo esc_attr($infobox_type); ?>';
				var infobox_display_event = '<?php echo $this->plugin_settings['infobox_display_event']; ?>';
				
				_CSPM_MAP_RESIZED[map_id] = 0;
				
				post_ids_and_categories[map_id] = {};
				post_lat_lng_coords[map_id] = {};
				post_ids_and_child_status[map_id] = {};
				 
				cspm_infoboxes[map_id] = []; //@since 3.9

				<?php 
				
				/**
				 * [is_latlng_empty] Whether the post has a LatLng coordinates. Usefull to use with [hide_empty] to hide the map when the user wants to.
				 * @since 2.7.1 */
				 
				$is_latlng_empty = true;
									
				/**
				 * Count items */
				 
				$count_post = count($post_ids_array);
				
				if($count_post > 0){
					
					$markers_array = get_option('cspm_markers_array'); //@since 3.5
					
					/**
					 * Loop throught items */
					 
					foreach($post_ids_array as $post_id){

						/**
						 * Get lat & lng data */
						 
						$lat = get_post_meta($post_id, CSPM_LATITUDE_FIELD, true);
						$lng = get_post_meta($post_id, CSPM_LONGITUDE_FIELD, true);
						
						/**
						 * Get the post type name & the post media 
						 * @since 3.5
                         * @edited 5.6.3 */
						 
						$post_type = get_post($post_id); //@edited 5.6.3
                        
                        if(isset($post_type->post_type)){ //@since 5.6.3
                            
                            $post_type = $post_type->post_type; //@since 5.6.3
                            
                            $media = isset($markers_array[$post_type]['post_id_'.$post_id]['media']) ? $markers_array[$post_type]['post_id_'.$post_id]['media'] : array();
					
                            /**
                             * Show items only if lat and lng are not empty */

                            if(!empty($lat) && !empty($lng)){

                                /**
                                 * Set [is_latlng_empty] to "false" to make sure that the map cannot be empty 
                                 * @since 2.7.1 */

                                $is_latlng_empty = false;

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
                                        'marker_width' => $this->plugin_settings['marker_icon_width'], //@since 4.0
                                        'marker_height' => $this->plugin_settings['marker_icon_height'], //@since 4.0																				
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
                                 * [@pin_options] Contains all infos about the marker/post ...
                                 * ... that will send to the JS function "cspm_new_pin_object()" ...
                                 * ... to add markers/pins to the map.
                                 * @since 3.5 */

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

                                /**
                                 * Secondary Lats & longs */						 

                                $secondary_latlng = get_post_meta($post_id, CSPM_SECONDARY_LAT_LNG_FIELD, true);

                                if(!empty($secondary_latlng) && esc_attr($show_secondary) == "yes"){

                                    $secondary_latlng_array = explode('][', $secondary_latlng);

                                    $secondary_marker_index = 0;

                                    foreach($secondary_latlng_array as $single_latlng){

                                        $strip_coordinates = str_replace(array('[', ']', ' '), '', $single_latlng);
                                        $coordinates = explode(',', $strip_coordinates);

                                        if(isset($coordinates[0]) && isset($coordinates[1]) && !empty($coordinates[0]) && !empty($coordinates[1])){

                                            $lat = $coordinates[0];
                                            $lng = $coordinates[1]; 

                                            /**
                                             * Update the main marker [@pin_options].
                                             * Secondary markers will share everything with the main marker ...
                                             * ... except for the coordinates & post ID.
                                             * @since 3.5 */

                                            $pin_options['post_id'] = $post_id.'-'.$secondary_marker_index;
                                            $pin_options['coordinates']['lat'] = $lat;
                                            $pin_options['coordinates']['lng'] = $lng;
                                            $pin_options['is_child'] = 'yes_'.$secondary_marker_index;

                                            ?>

                                            /**
                                             * Create the child pin object */

                                            var marker_object = cspm_new_pin_object(map_id, <?php echo wp_json_encode($pin_options); ?>);
                                            json_markers_data.push(marker_object); <?php 

                                            $lat = $lng = '';

                                            $secondary_marker_index++;

                                        } 

                                    }

                                } 

                            }
                            
                        }
								
					} 
					
				}
							
				/**
				 * Execute the map when there's or when there's no LatLng coordinates to display 
				 * & when the user chooses to display the map even when it's empty
				 * @since 2.7.1 */					 
				 
				if(!$is_latlng_empty || $is_latlng_empty && $hide_empty == 'no'){ ?>
					
					var hide_modal = <?php if($hide_modal == 'no'){ ?> false; <?php }else{ ?> true; <?php } ?> // @since 3.5
					
					/**
					 * Create the map */
	
					plugin_map.gmap3({	
						map:{
							options: map_options,
							onces: {
								tilesloaded: function(){

									plugin_map.gmap3({ 
										marker:{
											values: json_markers_data,
											callback: function(markers){
												
												var nbr_markers = cspm_object_size(markers);
												
												var travel_mode = '<?php echo esc_attr(strtoupper($travel_mode)); ?>';
												var distance_unit = '<?php echo esc_attr(strtoupper($unit)); ?>';
												
												var waypoints = [];
												var waypoint_obj = {};
												
												if(nbr_markers <= 23){
													
													for(i = 1; i <= markers.length-1; i++){
													   var waypoint = [];
													   waypoint["location"] = markers[i].position;
													   waypoint["stopover"] = true;
													   waypoints[waypoints.length] = waypoint;
													}
													
													waypoint_obj = {
														optimizeWaypoints: true,
														waypoints: waypoints,
													}
				
												}
												
												for(var i = 0; i < markers.length; i++){	
													
													if(i == markers.length-1)
														break;
														
													var origin = markers[i].position;
													var next_index = (nbr_markers <= 23) ? markers.length-1 : (i+1);
													var destination = markers[next_index].position;
													
													var route_options = $.extend({}, 
														{
															origin: origin,
															destination: destination,
															travelMode: google.maps.DirectionsTravelMode[travel_mode],
															unitSystem: google.maps.UnitSystem[distance_unit],
														}, 
														waypoint_obj
													);
													
													plugin_map.gmap3({ 
														getroute:{
															options: route_options,
															callback: function(response, status){

																if(!response) 
																	return;

																if(status === 'OK'){
																	plugin_map.gmap3({
																		directionsrenderer:{
																			options:{
																				directions: response,
																				suppressMarkers: true,
																				draggable: false, //@since 5.6
																				polylineOptions: {
																					strokeColor: '<?php echo esc_attr($stroke_color); ?>', //@since 5.6																					
																					strokeWeight: Number('<?php echo esc_attr($stroke_weight); ?>'), //@since 5.6
																					strokeOpacity: Number('<?php echo esc_attr($stroke_opacity); ?>'), //@since 5.6
																					visible: true, //@since 5.6
																					draggable: false, //@since 5.6
																					editable: false, //@since 5.6
																				}
																			} 
																		}
																	});
																}else{
																	var api_status_codes = progress_map_vars.directions_api_status_codes; //@since 3.9
																	cspm_api_status_info(map_id, api_status_codes, status, 'Directions API'); //@since 3.9
																}
													
															}
															
														}
														
													});
													
													if(nbr_markers <= 23)
														break;
													
												}
								
												/**
												 * End the Progress Bar Loader */
													
												if(typeof NProgress !== 'undefined')
													NProgress.done();
								
											},
											events:{
												mouseover: function(marker, event, elements){

													/**
													 * Display the single infobox
													 * @since 3.9 */

													if(json_markers_data.length > 0 && show_infobox == 'true' && infobox_display_event == 'onhover')
														cspm_draw_single_infobox(plugin_map, map_id, marker, <?php echo wp_json_encode($infobox_options); ?>);
													
													/**
													 * Show a message to the user to inform them that ...
													 * ... they can open the the post medial modal if they ...
													 * ... click on the marker.
													 *
													 * @since 3.5 */

													if(!hide_modal && typeof marker.media !== 'undefined' && marker.media.format != 'standard' && marker.media.format != '')
														cspm_open_media_message(marker.media, map_id);
												
												},
												mouseout: function(marker, event, elements){
													
													/**
													 * Hide the post media message
													 * @since 3.5 */

													if(!hide_modal && typeof marker.media !== 'undefined' && marker.media.format != 'standard' && marker.media.format != '')
														cspm_close_media_message(map_id);
													
												},
												click: function(marker, event, elements){

													var post_id = marker.post_id; //@since 4.6
													
													marker.media['post_id'] = marker.post_id; // Add post ID to media array | @since 4.6													
												
													/**
													 * Display the single infobox
													 * @since 3.9 */

													if(json_markers_data.length > 0 && show_infobox == 'true' && infobox_display_event == 'onclick')
														cspm_draw_single_infobox(plugin_map, map_id, marker, <?php echo wp_json_encode($infobox_options); ?>);
													
													/**
													 * Open the post/location media modal
													 * @since 3.5 */

													if(!hide_modal && typeof marker.media !== 'undefined' && marker.media.format != 'standard' && marker.media.format != '')
														cspm_open_media_modal(marker.media, map_id);
													
												}
											}
										},
									});
									
									<?php

									/**
									 * Show the Zoom control after the map load */
									 
									if($this->plugin_settings['zoomControl'] == 'true' && $this->plugin_settings['zoomControlType'] == 'customize'){ ?>
									
										$('div.cspm_route_map_zoom_in_<?php echo $map_id ?>, div.cspm_route_map_zoom_out_<?php echo $map_id ?>').show(); <?php 
									
									}
									
									?>

									/**
									 * Show the bubbles after the map load
									 * @updated 5.3 */
									 
									if(json_markers_data.length > 0 && show_infobox == 'true' && (infobox_display_event == 'onload' || infobox_display_event == 'onzoom')){ //@edited 5.3
										cspm_draw_multiple_infoboxes(plugin_map, map_id, <?php echo wp_json_encode($infobox_options); ?>); //@updated 3.9
									}

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
							}
						<?php } ?>
						
					});								
						
					/**
					 * Call zoom-in function */
					 
					cspm_zoom_in('<?php echo $map_id; ?>', $('div.cspm_route_map_zoom_in_<?php echo $map_id; ?>'), plugin_map);
				
					/**
					 * Call zoom-out function */
					 
					cspm_zoom_out('<?php echo $map_id; ?>', $('div.cspm_route_map_zoom_out_<?php echo $map_id; ?>'), plugin_map);
					
					/**
					 * Hide/Show UI Controls depending on the streetview visibility */
					
					var mapObject = plugin_map.gmap3('get');
					
					if(typeof mapObject.getStreetView === 'function'){
						
						var streetView = mapObject.getStreetView();
					
						google.maps.event.addListener(streetView, "visible_changed", function(){
							
							if(this.getVisible()){
								
								/**
								 * Hide the Zoom control before the map load */
								 
								<?php if($this->plugin_settings['zoomControl'] == 'true' && $this->plugin_settings['zoomControlType'] == 'customize'){ ?>
									$('div.cspm_route_map_zoom_in_<?php echo $map_id; ?>, div.cspm_route_map_zoom_out_<?php echo $map_id; ?>').hide();
								<?php } ?>
								
							}else{
								
								/**
								 * Show the Zoom cotrol after the map load */
								 
								<?php if($this->plugin_settings['zoomControl'] == 'true' && $this->plugin_settings['zoomControlType'] == 'customize'){ ?>
									$('div.cspm_route_map_zoom_in_<?php echo $map_id; ?>, div.cspm_route_map_zoom_out_<?php echo $map_id; ?>').show();
								<?php } ?>

							}
								
						});
						
					}
					
					<?php
					
					/**
					 * Center the Map on screen resize */
					 
					 if(esc_attr($window_resize) == 'yes' && !empty($centerLat) && !empty($centerLng)){ ?>
					
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
                        }); //@edited 5.6.3
					
					<?php } ?>
				
				<?php } /* End if($is_latlng_empty ...) */ ?>
				
			});
			
			</script> 
			
			<?php
			
			$map_js_script = str_replace(array('<script>', '</script>'), '', ob_get_contents()); //@since 4.9.1
			ob_end_clean(); //@since 4.9.1
										
			/**
			 * Build the infoboxes content and add it to the JS script
			 * @since 3.9 */
			
			$this->cspm_add_js_script_data(
				$this->cspm_infoboxes_data(array(
					'map_id' => 'route_'.$map_id, 
					'post_ids' => $post_ids_array,
					'infobox_type' => $infobox_type,
					'infobox_link_target' => $infobox_link_target,
				)
			));
			
			/**
			 * Enqueue styles & scripts */
			 
			$this->cspm_enqueue_styles($hide_modal);
			$this->cspm_enqueue_scripts($hide_modal);			
			
			wp_add_inline_script('cspm-script', $map_js_script); //@since 4.9.1	
			
			/**
			 * Override infobox width & height
			 * @since 4.0 */
						
			if(!empty($this->plugin_settings['infobox_width']) && !empty($this->plugin_settings['infobox_height'])){
				
				wp_add_inline_style('cspm-style', $CspmMainMap->cspm_infobox_size(
					array(
						'map_id' => 'route_'.$map_id,
						'width' => $this->plugin_settings['infobox_width'],
						'height' => $this->plugin_settings['infobox_height'],
						'type' => $infobox_type,
					)
				));
				
			}
			
			/**
			 * Execute the map when there's or when there's no LatLng coordinates to display 
			 * & when the user chooses to display the map even when it's empty
			 * @since 2.7.1 */		
			 			 
			if(!$is_latlng_empty || $is_latlng_empty && $hide_empty == 'no'){										

				$output = '<div style="width:'.esc_attr($width).'; height:'.esc_attr($height).'; position:relative; overflow: hidden;" class="cspm_linear_gradient_bg">';
				
					/**
					 * Zoom Control */					 
								
					if($this->plugin_settings['zoomControl'] == 'true' && $this->plugin_settings['zoomControlType'] == 'customize'){
					
						$output .= '<div class="cspm_zoom_container">';
							$output .= '<div class="cspm_route_map_zoom_in_'.$map_id.' cspm_map_btn cspm_zoom_in_control cspm_bg_rgb_hover cspm_border_shadow cspm_border_top_radius" title="'.esc_attr__('Zoom in', 'cspm').'">';
								$output .= '<img class="cspm_svg cspm_svg_white" src="'.$this->plugin_settings['zoom_in_icon'].'" />';
							$output .= '</div>';
							$output .= '<div class="cspm_route_map_zoom_out_'.$map_id.' cspm_map_btn cspm_zoom_out_control cspm_bg_rgb_hover cspm_border_shadow cspm_border_bottom_radius" title="'.esc_attr__('Zoom out', 'cspm').'">';
								$output .= '<img class="cspm_svg cspm_svg_white" src="'.$this->plugin_settings['zoom_out_icon'].'" />';
							$output .= '</div>';
						$output .= '</div>';
			
					}
					
					/**
					 * Map */
								
					$output .= '<div id="cspm_route_map_'.$map_id.'" style="width:100%; height:100%;"></div>';
				
				$output .= '</div>';
				
				return $output;
			
			}else return '';
			
		}
		
	}
	
}


if(class_exists('CspmRouteMap')){
	$CspmRouteMap = new CspmRouteMap();
	$CspmRouteMap->cspm_hooks();
}

