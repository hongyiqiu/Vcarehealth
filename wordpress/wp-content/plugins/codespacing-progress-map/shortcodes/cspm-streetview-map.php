<?php

if(!class_exists('CspmStreetviewMap')){
	
	class CspmStreetviewMap{
		
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
					
				add_shortcode('cspm_streetview_map', array($this, 'cspm_streetview_map_shortcode'));
				
			}

		}
		
		
		/**
		 * This will load the scripts needed by our shortcodes based on its settings
		 *
		 * @since 3.0
		 */
		function cspm_enqueue_scripts(){
			
			/**
			 * jQuery */
			 
			wp_enqueue_script('jquery');				 			

			do_action('cspm_before_enqueue_streetview_map_script');
			
			/**
			 * GMaps API */
			
			if(!in_array('disable_frontend', $this->plugin_settings['remove_gmaps_api']))				 
				wp_enqueue_script('cs-gmaps-api-v3');
			
			$localize_script_handle = 'cspm-script';

			/**
			 * GMap3 jQuery Plugin */
			 
			wp_enqueue_script('cspm-gmap3');
				
			/**
			 * Progress Map Script */
			 
			wp_enqueue_script($localize_script_handle);

			do_action('cspm_after_enqueue_streetview_map_script');
			
		}
		
			
		/**
		 * Display the StreetView map of a location
		 * Note: No carousel used
		 *
		 * @since 2.7 
		 */		
		function cspm_streetview_map_shortcode($atts){
			
			/**
			 * Prevent the shortcode from been executed in the WP admin.
			 * This will prevent errors like the error "headers already sent"!
			 * @since 3.4 */
			 
			if(is_admin())
				return;
				
			extract( shortcode_atts( array(
			
				'post_id' => '',
				'center_at' => '',
				'height' => '300px',
				'width' => '100%',
				'zoom' => 1,			  
				'hide_empty' => 'yes', //@since 2.7.1
			  
			), $atts, 'cspm_streetview_map' ) ); 
			
			$post_id = esc_attr($post_id);
					
			/**
			 * Get the current post ID */
			 
			if(empty($post_id)){
			
				global $post;
				
				$post_id = $post->ID;
				
			}
			
			$map_id = 'streetview_'.$post_id;
			
			/**
			 * Get the center point */
			 
			if(!empty($center_at)){
				
				$center_point = esc_attr($center_at);
			
				if(strpos($center_point, ',') !== false){
						
					$center_latlng = explode(',', str_replace(' ', '', $center_point));
					
					/**
					 * Get lat and lng data */
					 
					$centerLat = isset($center_latlng[0]) ? $center_latlng[0] : '';
					$centerLng = isset($center_latlng[1]) ? $center_latlng[1] : '';
					
				}else{
						
					/**
					 * Get lat and lng data */
					 
					$centerLat = get_post_meta($center_point, CSPM_LATITUDE_FIELD, true);
					$centerLng = get_post_meta($center_point, CSPM_LONGITUDE_FIELD, true);
			
				}
				
			}else{
					
				/**
				 * Get lat and lng data */
				 
				$centerLat = get_post_meta($post_id, CSPM_LATITUDE_FIELD, true);
				$centerLng = get_post_meta($post_id, CSPM_LONGITUDE_FIELD, true);
			
			}
			
			$latLng = '"'.$centerLat.','.$centerLng.'"';	
					
			/**
			 * Execute the map when there's or when there's no LatLng coordinates to display 
			 * & when the user chooses to display the map even when it's empty
			 * @since 2.7.1 */
			 					 
			if((!empty($centerLat) && !empty($centerLng)) || (empty($centerLat) && empty($centerLng)) && $hide_empty == 'no'){						
				
				ob_start(); //@since 4.9.1
						
				?>
				
				<script>
				
				jQuery(document).ready(function($){ 
					
					"use strict"; 
					
					/**
					 * init plugin map */
					 
					var plugin_map_placeholder = 'div#codespacing_progress_map_streetview_<?php echo $map_id; ?>';
					var plugin_map = $(plugin_map_placeholder);
					
					/**
					 * Activate the new google map visual */
					 
					google.maps.visualRefresh = true;
					
					var map_options = { center:[<?php echo $centerLat; ?>, <?php echo $centerLng; ?>],
										zoom: 14,
										streetViewControl: true,
									  };
					
					var map_id = 'streetview_<?php echo $map_id ?>';
					
					_CSPM_MAP_RESIZED[map_id] = 0;
					
					/**
					 * Create the map */
					 
					plugin_map.gmap3({	
						map:{
							options: map_options,
						},						
						streetviewpanorama:{
							options:{
								container: plugin_map,
								opts:{
									position: [<?php echo $centerLat; ?>, <?php echo $centerLng; ?>],
									visible: true,
									pov: {
										heading: 34,
										pitch: 10,
										zoom: <?php echo esc_attr($zoom); ?>
									}
								}
							}
						}
					});	

					<?php 
					
					/**
					 * Resolve a problem of Google Maps & jQuery Tabs */
					 
					if(!empty($centerLat) && !empty($centerLng)){ ?>					
                    
                        $('body').ready(function(){
                            if($(plugin_map_placeholder).is(':visible')){                            
                                if(_CSPM_MAP_RESIZED[map_id] <= 1){ /** 0 is for the first loading, 1 is when the user clicks the map tab */
                                    cspm_center_map_at_point(plugin_map, '<?php echo $map_id ?>', <?php echo $centerLat; ?>, <?php echo $centerLng; ?>, 'resize');
                                    _CSPM_MAP_RESIZED[map_id]++;
                                }	
                            }
                        }); //@edited 5.6.3
					
					<?php } ?>
					
				});
				
				</script> 
				
				<?php
			
				$map_js_script = str_replace(array('<script>', '</script>'), '', ob_get_contents()); //@since 4.9.1
				ob_end_clean(); //@since 4.9.1
										
				$this->cspm_enqueue_scripts();			
			
				wp_add_inline_script('cspm-script', $map_js_script); //@since 4.9.1	
			
				/**
				 * Map */
				
				$output = '<div style="width:'.esc_attr($width).'; height:'.esc_attr($height).';" class="cspm_linear_gradient_bg">';
					$output .= '<div id="codespacing_progress_map_streetview_'.$map_id.'" style="width:100%; height:100%"></div>';
				$output .= '</div>';		
				
				return $output;

			}else return '';
			
		}
		
	}
	
}


if(class_exists('CspmStreetviewMap')){
	$CspmStreetviewMap = new CspmStreetviewMap();
	$CspmStreetviewMap->cspm_hooks();
}

