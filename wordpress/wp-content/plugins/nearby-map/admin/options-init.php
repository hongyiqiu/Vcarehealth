<?php

    /**
     * For full documentation, please visit: http://docs.reduxframework.com/
     * For a more extensive sample-config file, you may look at:
     * https://github.com/reduxframework/redux-framework/blob/master/sample/sample-config.php
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    // This is your option name where all the Redux data is stored.
    $opt_name = "cspm_nearby_map";

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

	if (!class_exists('CspmNearbyMap'))
		return; 
	
	$CspmNearbyMapClass = CspmNearbyMap::this();

    $args = array(
        'opt_name' => 'cspm_nearby_map',
        'dev_mode' => FALSE,
        'display_name' => '<img src="'.$CspmNearbyMapClass->csnm_plugin_url.'/img/admin/logo.png" alt="Nearby Places" />',
        'display_version' => FALSE,
        'page_slug' => 'cspm_nearby_map',
        'page_title' => 'Nearby Places',
        'update_notice' => TRUE,
        'admin_bar' => TRUE,
        'menu_type' => 'submenu',
        'menu_title' => 'Nearby Places',
        'allow_sub_menu' => TRUE,
        'page_parent' => 'cspm_default_settings',
        'page_parent_post_type' => '',
        'default_show' => TRUE,
        'default_mark' => '',
        'hints' => array(
            'icon_position' => 'right',
            'icon_color' => 'lightgray',
            'icon_size' => 'normal',
            'tip_style' => array(
                'color' => 'light',
            ),
            'tip_position' => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect' => array(
                'show' => array(
                    'duration' => '500',
                    'event' => 'mouseover',
                ),
                'hide' => array(
                    'duration' => '500',
                    'event' => 'mouseleave unfocus',
                ),
            ),
        ),
        'output' => TRUE,
        'output_tag' => TRUE,
        'settings_api' => TRUE,
        'cdn_check_time' => '1440',
        'compiler' => TRUE,
        'page_permissions' => 'manage_options',
        'save_defaults' => TRUE,
        'show_import_export' => TRUE,
        'database' => 'options',
        'transient_time' => '3600',
        'network_sites' => TRUE,
    );

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */


    /*
     *
     * ---> START SECTIONS
     *
     */

    Redux::setSection( $opt_name, array(
        'title'  => __( 'General Settings', 'cs_nearby_map' ),
        'id'     => 'general_settings',
        'icon'   => 'el el-cogs',
        'fields' => array(
            array(
				'id'       => 'distance_unit',
				'type'     => 'button_set',
				'title'    => __('Unit System', 'cs_nearby_map'),
				'subtitle' => __('Choose the unit system to use when displaying distance', 'cs_nearby_map'),
				'desc'     => __('You can override this option in a shortcode by using the attribute "distance_unit". 
				<br />Possible values are "METRIC" and "IMPERIAL". 
				<br />Default to "METRIC". 
				<br />Usage example: [cs_nearby_map distance_unit="IMPERIAL"]', 'cs_nearby_map'),
				//Must provide key => value pairs for options
				'options' => array(
					'METRIC' => 'Metric (Km)', 
					'IMPERIAL' => 'Imperial (Miles)', 
					//'all' => 'All (Km & Miles)'
				 ), 
				'default' => 'METRIC'
			),
			array(
				'id'       => 'radius',
				'type'     => 'spinner', 
				'title'    => __('Radius', 'cs_nearby_map'),
				'subtitle' => __('Choose the distance from the given location within which to search for Places, in meters. The maximum allowed value is 50000.','cs_nearby_map'),
				'desc'     => __('You can override this option in a shortcode by using the attribute "radius".
				<br />Possible value is a number from 50 to 50000 maximum.
				<br />Default to 50000.
				<br />Usage example: [cs_nearby_map radius="1000"]', 'cs_nearby_map'),
				'default'  => '50000',
				'min'      => '50',
				'step'     => '50',
				'max'      => '50000',
			),
			array(
				'id'       => 'rankBy',
				'type'     => 'button_set', 
				'title'    => __('Display Order', 'cs_nearby_map'),
				'subtitle' => __('Specifies the order in which results are listed.', 'cs_nearby_map'),
				'desc' 	   => 'Possible values are "prominence" and "distance". <br />
				<ol>
					<li>PROMINENCE (default). This option sorts results based on their importance. Ranking will favor prominent places within the set radius over nearby places that match but that are less prominent. Prominence can be affected by a place\'s ranking in Google\'s index, global popularity, and other factors. When used, the radius parameter is required.</li>
					<li>DISTANCE. This option sorts results in ascending order by their distance from the specified location. Note that you cannot specify a custom radius if you use this option. Using this option may also result in displaying less results.</li>					
				</ol>
				Usage example: [cs_nearby_map rankby="distance"]',
				'options' => array(
					'prominence' => 'Prominence (Importance)', 
					'distance' => 'Distance', 
				 ), 
				'default' => 'prominence'
			),
			array(
				'id'      => 'proximity',
				'type'    => 'sorter',
				'title'   => __('Place Types', 'cs_nearby_map'),
				'subtitle' => __('Enable/Disable place types & sort their order.<br /><br />The plugin supports all the types in the Google Places API. 
				<br />If you think that a type is missing, feel free to contact me in the support page. 
				<br /><br />
				<strong>You can override the list of enabled place types in a shortcode by using the attribute "places". 
				<br />Possible values are "THE_PLACE_NAME". 
				<br />By default, it displays all the places. 
				<br /><br />Usage example:<br />[cs_nearby_map places="school,hospital"] 
				<br /><br /><u>Note:</u> below is the formatted names of all places so you can use them in a shortcode.
				<br /><br />A) accounting, airport, amusement_park, aquarium, art_gallery, atm
				<br /><br />B) bakery, bank, bar, beauty_salon, bicycle_store, book_store, bowling_alley,bus_station
				<br /><br />C) cafe, campground, car_dealer, car_rental, car_repair, car_wash,
				casino, cemetery, church, city_hall, clothing_store, convenience_store, courthouse
				<br /><br />D) dentist, department_store, doctor
				<br /><br />E) electrician, electronics_store, embassy, establishment
				<br /><br />F) finance, fire_station, florist, food, funeral_home, furniture_store
				<br /><br />G) gas_station, general_contractor, grocery_or_supermarket, gym
				<br /><br />H) hair_care, hardware_store, health, hindu_temple, home_goods_store, hospital
				<br /><br />I) insurance_agency
				<br /><br />J) jewelry_store
				<br /><br />L) laundry, lawyer, library, liquor_store, local_government_office, locksmith, lodging
				<br /><br />M) meal_delivery, meal_takeaway, mosque, movie_rental, movie_theater, moving_company, museum
				<br /><br />N) night_club
				<br /><br />P) painter, park, parking, pet_store, pharmacy, physiotherapist, place_of_worship,
				plumber, police, post_office
				<br /><br />R) real_estate_agency, restaurant, roofing_contractor, rv_park
				<br /><br />S) school, shoe_store, shopping_mall, spa, stadium, storage, store,
				subway_station, synagogue
				<br /><br />T) taxi_stand, train_station, travel_agency
				<br /><br />U) university
				<br /><br />V) veterinary_care
				<br /><br />Z) zoo</strong>', 'cs_nearby_map'),
				'options' => array(
					'enabled'  => array(
						'accounting' => 'Accounting',
						'airport' => 'Airport',
						'amusement_park' => 'Amusement park',
						'aquarium' => 'Aquarium',
						'art_gallery' => 'Art gallery',
						'atm' => 'ATM',
						'bakery' => 'Bakery',
						'bank' => 'Bank',
						'bar' => 'Bar',
						'beauty_salon' => 'Beauty salon',
						'bicycle_store' => 'Bicycle store',
						'book_store' => 'Book store',
						'bowling_alley' => 'Bowling alley',
						'bus_station' => 'Bus station',
						'cafe' => 'Cafe',
						'campground' => 'Campground',
						'car_dealer' => 'Car dealer',
						'car_rental' => 'Car rental',
						'car_repair' => 'Car repair',
						'car_wash' => 'Car wash',
						'casino' => 'Casino',
						'cemetery' => 'Cemetery',
						'church' => 'Church',
						'city_hall' => 'City hall',
						'clothing_store' => 'Clothing store',
						'convenience_store' => 'Convenience store',
						'courthouse' => 'Courthouse',
						'dentist' => 'Dentist',
						'department_store' => 'Department store',
						'doctor' => 'Doctor',
						'electrician' => 'Electrician',
						'electronics_store' => 'Electronics store',
						'embassy' => 'Embassy',
						'establishment' => 'Establishment',
						'finance' => 'Finance',
						'fire_station' => 'Fire station',
						'florist' => 'Florist',
						'food' => 'Food',
						'funeral_home' => 'Funeral home',
						'furniture_store' => 'Furniture store',
						'gas_station' => 'Gas station',
						'general_contractor' => 'General contractor',
						'grocery_or_supermarket' => 'Grocery or supermarket',
						'gym' => 'GYM',
						'hair_care' => 'Hair care',
						'hardware_store' => 'Hardware store',
						'health' => 'Health',
						'hindu_temple' => 'Hindu temple',
						'home_goods_store' => 'Home goods store',
						'hospital' => 'Hospital',
						'insurance_agency' => 'Insurance agency',
						'jewelry_store' => 'Jewelry store',
						'laundry' => 'Laundry',
						'lawyer' => 'Lawyer',
						'library' => 'Library',
						'liquor_store' => 'Liquor store',
						'local_government_office' => 'Local government office',
						'locksmith' => 'Locksmith',
						'lodging' => 'Lodging',
						'meal_delivery' => 'Meal delivery',
						'meal_takeaway' => 'Meal takeaway',
						'mosque' => 'Mosque',
						'movie_rental' => 'Movie rental',
						'movie_theater' => 'Movie theater',
						'moving_company' => 'Moving company',
						'museum' => 'Museum',
						'night_club' => 'Night club',
						'painter' => 'Painter',
						'park' => 'Park',
						'parking' => 'Parking',
						'pet_store' => 'Pet store',
						'pharmacy' => 'Pharmacy',
						'physiotherapist' => 'Physiotherapist',
						'place_of_worship' => 'Place of worship',
						'plumber' => 'Plumber',
						'police' => 'Police',
						'post_office' => 'Post office',
						'real_estate_agency' => 'Real estate agency',
						'restaurant' => 'Restaurant',
						'roofing_contractor' => 'Roofing contractor',
						'rv_park' => 'RV park',
						'school' => 'School',
						'shoe_store' => 'Shoe store',
						'shopping_mall' => 'Shopping mall',
						'spa' => 'Spa',
						'stadium' => 'Stadium',
						'storage' => 'Storage',
						'store' => 'Store',
						'subway_station' => 'Subway station',
						'synagogue' => 'Synagogue',
						'taxi_stand' => 'Taxi stand',
						'train_station' => 'Train station',
						'travel_agency' => 'Travel agency',
						'university' => 'University',
						'veterinary_care' => 'Veterinary care',
						'zoo' => 'Zoo',
					),
					'disabled' => array(
					)
				),
			)
        )
    ) );
	
	Redux::setSection( $opt_name, array(
        'title'  => __( 'Customize', 'cs_nearby_map' ),
        'id'     => 'customize',
        'icon'   => 'el el-brush',
        'fields' => array(
			array(
				'id'          => 'font_family',
				'type'        => 'typography', 
				'title'       => __('Font Family', 'cs_nearby_map'),
				'google'      => true, 
				'font-backup' => true,
				'output'      => array('.cspm_nearby_map *'),
				'units'       =>'px',
				'subtitle'    => __('Choose the font family to use with the plugin', 'cs_nearby_map'),
				'font-size'	  => false,
				'font-weight' => false,
				'font-style'  => false,
				'text-align'  => false,
				'line-height' => false,
				'subsets'     => false,
				'color'       => false,
				'default'     => array(
					'font-family' => 'Source Sans Pro', 
					'google'      => true,
				),
			),
			array(
				'id'       => 'main_color',
				'type'     => 'color',
				'title'    => __('Main Color', 'cs_nearby_map'), 
				'subtitle' => __('Pick a color for the plugin.<br />Default to "#008fed".', 'cs_nearby_map'),
				'default'  => '#008fed',
				'validate' => 'color',
				'transparent' => false,
				'output'   => array(
					'color' => '.cspm_nearby_map_main_color, a.cspm_nearby_map_main_color', 
					'background-color' => '.cspm_nearby_map_main_background, .cspm_nearby_map_main_background.active'
				),
			),
			array(
				'id'       => 'hover_color',
				'type'     => 'color',
				'title'    => __('Hover Color', 'cs_nearby_map'), 
				'subtitle' => __('Pick the hover color for the plugin.<br />Default to "#00aeff".', 'cs_nearby_map'),
				'default'  => '#00aeff',
				'validate' => 'color',
				'transparent' => false,
				'output'   => array(
					'color' => '.cspm_nearby_map_main_color.hover:hover, a.cspm_nearby_map_main_color.hover:hover', 
					'background-color' => '.cspm_nearby_map_main_background.hover:hover'
				),
			),					
			array(
				'id'       => 'main_layout',
				'type'     => 'image_select',
				'title'    => __('Main Layout', 'cs_nearby_map'), 
				'subtitle' => __('Select map and places alignment.', 'cs_nearby_map'),
				'desc'     => __('You can override the main layout in a shortcode using the attribute "layout".<br />
				Possible values are, "pl-mr", "pr-ml" and "pt-mb". Default to "pr-ml".<br />
				"pl-mr" = Places Left, Map Right<br />
				"pr-ml" = Places Right, Map Left<br />
				"pt-mb" = Places Top, Map Bottom<br />
				Usage example: [cs_nearby_map layout="pr-ml"]', 'cs_nearby_map'),
				'options'  => array(
					'pl-mr'      => array(
						'alt'   => 'Places Left, Map Right', 
						'img'   => $CspmNearbyMapClass->csnm_plugin_url.'/img/admin/2cl.png'
					),
					'pr-ml'      => array(
						'alt'   => 'Map Left, Places Right', 
						'img'  => $CspmNearbyMapClass->csnm_plugin_url.'/img/admin/2cr.png'
					),
					'pt-mb'      => array(
						'alt'   => 'Places Top, Map Bottom', 
						'img'   => $CspmNearbyMapClass->csnm_plugin_url.'/img/admin/1col.png'
					)
				),
				'default' => '1'
			),
			array(
				'id'       => 'dimensions',
				'type'     => 'dimensions',
				'units'    => array('em','px','%'),
				'title'    => __('Dimensions (Width/Height)', 'cs_nearby_map'),
				'subtitle' => __('Choose the width and the height of the map', 'cs_nearby_map'),
				'desc'     => __('By default, the height of the map is "420px". For the sake of displaying all the elements properly, the height cannot be adjusted to something lower than "420px".<br />
				By default, the width of the map is 100%, which means that it will fit to the container\'s width. You can change the width to another value. Leave the width empty to simulate the value "100%".<br /><br />
				You can override the dimensions in a shortcode by using the attributes "width" and "height".<br />
				Usage example: [cs_nearby_map width="100%" height="400px"]<br /><br />
				Note: When "Main Layout" is set to the 3<sup><small>rd</small></sup> option (Places Top, Map Bottom), the height will be executed for both the place types list and the map. In other words, the height of the place types list will be "240px" (or your custom height) and the height of the map will also be "240px" (or your custom height)!', 'cs_nearby_map'),
				'default'  => array(
					'Width'   => '', 
					'Height'  => '420'
				),
			),
			array(
				'id'       => 'places_grid',
				'type'     => 'image_select',
				'title'    => __('Place types Layout', 'cs_nearby_map'), 
				'subtitle' => __('Select the number of columns (place types) to display in each row.', 'cs_nearby_map'),
				'desc'     => __('By default, the grid system is set to display 3 columns on each row. <br /><br />
				You can override this option in a shortcode using the attribute "grid". 
				Possible values are "2cols", "3cols", "4cols" and "6cols". Default to "3cols".<br />
				Usage example: [cs_nearby_map grid="4cols"]', 'cs_nearby_map'),
				'options'  => array(
					'2cols'      => array(
						'alt'   => '2 Columns', 
						'img'   => $CspmNearbyMapClass->csnm_plugin_url.'/img/admin/2-col-portfolio.png'
					),
					'3cols'      => array(
						'alt'   => '3 Columns', 
						'img'  => $CspmNearbyMapClass->csnm_plugin_url.'/img/admin/3-col-portfolio.png'
					),
					'4cols'      => array(
						'alt'   => '4 Columns', 
						'img'   => $CspmNearbyMapClass->csnm_plugin_url.'/img/admin/4-col-portfolio.png'
					),
					'6cols'      => array(
						'alt'   => '6 Columns', 
						'img'   => $CspmNearbyMapClass->csnm_plugin_url.'/img/admin/6-col-portfolio.png'
					)
				),
				'default' => '3cols'
			),
		)
	) );

    /*
     * <--- END SECTIONS
     */
