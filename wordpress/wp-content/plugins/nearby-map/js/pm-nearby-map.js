
var origin = {};
var nearby_map = {};
var nearby_map_object = {};
var nearbyDirectionsDisplay = {};
var current_map_id;
var current_distance_unit;
var selected_proximity_id = {};
var existing_places = {};

/**
 * This will create & initialize the map and display nearby places
 * 
 * @since 1.0
 * @updated 2.4
 */
function cspm_nearby_locations(map_id, type, unit_system, radius, rankby){		

	var type = type;

	var request = {
	  location: origin[map_id],
	  types: [type], /* https://developers.google.com/places/documentation/supported_types?hl=fr */
	};
	
	if(rankby != 'distance')
		request = jQuery.extend({}, request, {radius: radius});
	else request = jQuery.extend({}, request, {rankBy: google.maps.places.RankBy.DISTANCE}); //@since 2.4

	cspm_clear_nearby_markers(map_id);
	
	nearby_map_object[map_id].setZoom(9);
	
	jQuery('div#travel_mode_container_'+map_id).hide(); 
	jQuery('div#cspm_directions_btn_container_'+map_id).hide(); 
	jQuery('div#cspm_place_name_container_'+map_id).hide(); 
	jQuery('div.cspm_nearby_map_directions_'+map_id).hide();
	
	current_map_id = map_id;

	current_distance_unit = unit_system;

	selected_proximity_id[map_id] = type;
		
	existing_places[map_id] = new Array();
	
	places_service_callback_limit = 0;
	
	var service = new google.maps.places.PlacesService(nearby_map_object[map_id]);
		service.nearbySearch(request, cspm_places_service_callback);

}	


/**
 * This will create and add nearby places on the map as markers when the user selects a category of places.
 * It'll also display the places in the list next to map.
 *
 * @since 1.0
 */
function cspm_places_service_callback(results, status, pagination){

	var item_output = '';
	var stars_width = '';	
	
	jQuery('div.cspm_nearby_location_list_items_container_'+current_map_id).html();
	
	if (status === google.maps.places.PlacesServiceStatus.OK){

		if(results.length > 0){

			var proximity_id = selected_proximity_id[current_map_id];

			var proximity_name = jQuery('div#'+proximity_id+'[data-map-id='+current_map_id+']').attr('data-proximity-name');

			/** 
			 * Hide nearby cats */
			 
			jQuery('div#cspm_nearby_cats_container_'+current_map_id).hide();
			
			/**
			 * Display locations list */

			jQuery('div#cspm_nearby_places_list_'+current_map_id+' img.cspm_nearby_cat_list_img').attr('src', cspm_nearby_map.img_file_url+'nearby_white/'+proximity_id+'.png');

			jQuery('div#cspm_nearby_places_list_'+current_map_id+' span.cspm_nearby_cat_list_name').html(proximity_name);
				
			jQuery('div#cspm_nearby_places_list_'+current_map_id).show();
			
			/**
			 * Check if the user want's to use a custom marker icon for the places */
								
			var custom_marker_exists = cspm_file_exists(cspm_nearby_map.place_markers_file_url + proximity_id + '.png');

			/**
			 * List all places */
			
			for (var i = 0; i < results.length; i++){
					
				var this_place_id = results[i].place_id;
				
				if(jQuery.inArray( this_place_id, existing_places[current_map_id] ) == -1 && jQuery.inArray( proximity_id, results[i].types ) != -1){
					
					existing_places[current_map_id].push(this_place_id);
					
					/**
					 * Create Location markers */
					 
					cspm_add_place_marker(current_map_id, proximity_id, results[i], current_distance_unit, custom_marker_exists);
						  
					/**
					 * Create Locations list */			 			
								
					item_output += '<div class="cspm_nearby_location_list_item cspm-row cspm_animated fadeInRight" data-place-type="'+proximity_id+'" data-place-id="'+this_place_id+'">';

						if(typeof results[i].photos !== 'undefined')								
							var photo_url = results[i].photos[0].getUrl({'maxWidth': 0, 'maxHeight': 120});
						else var photo_url = cspm_nearby_map.img_file_url + 'default-img-sm.jpg';

						item_output += '<div class="cspm_show_place_details_'+current_map_id+' cspm_location_list_item_photo pull-left" data-place-id="'+this_place_id+'" data-place-name="'+proximity_name+'" data-map-id="'+current_map_id+'" style="background:url('+photo_url+') center center"></div>';
	
						item_output += '<div class="cspm_location_list_item_details pull-left">';					

							if(typeof results[i].name !== 'undefined')
								item_output += '<div class="cspm_place_name_list"><a class="cspm_show_place_details_'+current_map_id+' cspm_nearby_map_main_color hover" data-place-id="'+this_place_id+'" data-place-name="'+proximity_name+'" data-map-id="'+current_map_id+'">' + results[i].name + '</a></div>';
						
							if(typeof results[i].vicinity !== 'undefined')
								item_output += '<div class="cspm_place_vicinity_list"><img src="'+cspm_nearby_map.img_file_url + 'vicinity.png" />' + results[i].vicinity + '</div>';
			
							/**
							 * Get Distance & Duration */
							
							if(typeof results[i].geometry.location !== 'undefined'){
								
								cspm_distance_matrix(current_map_id, this_place_id, origin[current_map_id], results[i].geometry.location, current_distance_unit, 'div.cspm_place_distance_list_'+this_place_id+' .cspm_place_distance_text');
								
								item_output += '<div class="cspm_place_distance_list_'+this_place_id+'"><img src="'+cspm_nearby_map.img_file_url + 'distance.png" /><span class="cspm_place_distance_text"><span class="wrapper"><span class="cssload-loader"></span></span></span></div>';
							
							}
							
							item_output += '<div>';
							
								if(typeof results[i].rating !== 'undefined'){
									
									stars_width = cspm_stars(results[i].rating);
									
									item_output += '<div class="cspm_place_rating_list pull-left"><span class="cspm_stars_rating"><span style="width:'+stars_width+'px;"></span></span></div>';
								
								}	
														
								item_output += '<div class="cspm_nearby_route_list cspm_nearby_map_main_background hover cspm_border_radius cspm_border_shadow pull-right" data-map-id="'+current_map_id+'" data-place-id="'+this_place_id+'">'+cspm_nearby_map.the_word_route+' <img src="' + cspm_nearby_map.img_file_url + 'directions.png" /></div>';
							
								item_output += '<div class="clearfix"></div>';
						
							item_output += '</div>';
							
						item_output += '</div>';
						
						item_output += '<div class="clearfix"></div>';
						
					item_output += '</div>';
								
					jQuery('div.cspm_nearby_location_list_items_container_'+current_map_id).append(item_output).scrollTop();
					
					item_output = '';
				
				}
				
			}
			
			/**
			 * Extend the map bounds to contain each marker added */
			 
			nearby_map[current_map_id].gmap3({
				get: {
					name: 'marker',
					tag: current_map_id,
					all:  true,	
					callback: function(markers){
						
						/**
						 * Change all markers opacity to distinguish the current marker
						 * @since 2.0 */
						  
						if(jQuery('div#cspm_place_name_container_'+current_map_id).is(':visible')){
						
							var current_route_displayed = jQuery('div#cspm_nearby_map_'+current_map_id).attr('data-selected-place-id');
													
							jQuery.each(markers, function(i, marker){				
								if(marker.placeID != current_route_displayed){										
									marker.setOpacity(0.6);
								}else marker.setOpacity(1);
							});
							
						}
						
					}
				},
				autofit:{}
			});			
			
			/** 
			 * Display the number of places */

			setTimeout(function(){
				jQuery('div#cspm_nearby_places_list_'+current_map_id+' span.cspm_nbr_places_found').html('<span class="wrapper"><span class="cssload-loader white"></span></span>');			
				setTimeout(function(){ 
					jQuery('div#cspm_nearby_places_list_'+current_map_id+' span.cspm_nbr_places_found').html('('+existing_places[current_map_id].length+')');
				}, 500);
			}, 500);
			
			/**
			 * Load more places when the scroll hits the end of the list */
						
			if(pagination.hasNextPage){

				if(typeof NProgress !== 'undefined'){
					NProgress.configure({
					  parent: 'div#codespacing_progress_map_'+current_map_id,
					  showSpinner: true
					});				
					NProgress.start();
				}
		
				jQuery('div.cspm_nearby_location_list_items_container_'+current_map_id).on('scroll', function() {
					if(jQuery(this).scrollTop() + jQuery(this).innerHeight() >= jQuery(this)[0].scrollHeight) {
						setTimeout(function(){ 
							pagination.nextPage();
						}, 500);
					}
				})

				/**
				 * End the Progress Bar Loader */
					
				if(typeof NProgress !== 'undefined')
					NProgress.done();

			}else{
				jQuery('div.cspm_nearby_location_list_items_container_'+current_map_id).off('scroll'); //@since 2.6
				return;
			}

		}else return;
		
	}else{
		var api_status_codes = progress_map_vars.places_api_status_codes; //@since 2.4
		cspm_api_status_info(current_map_id, api_status_codes, status, 'Places API'); //@since 2.4
		return;
	}
	
}


/**
 * This will add the place marker on the map.
 * Note: This function is used in the callaback of the Google Map Places Service!
 *
 * @since 1.0
 */
function cspm_add_place_marker(map_id, place_type, place_object, unit_system, use_custom_marker_icon){

	var placeLoc = place_object.geometry.location;
	var placeName = place_object.name;
	var placeID = place_object.place_id;
	var distance_unit = unit_system; // METRIC/IMPERIAL					
	var post_latlng = origin[map_id];
	var travel_modes_output = '';
	var directions_btn_output = '';

	var placeMarkerIcon = use_custom_marker_icon ? cspm_nearby_map.place_markers_file_url + place_type + '.png' : cspm_nearby_map.img_file_url + 'destination.png';

	nearby_map[map_id].gmap3({ 
		marker:{
			latLng: placeLoc,
			title: placeName,
			tag: map_id,
			options:{
				icon: new google.maps.MarkerImage(placeMarkerIcon),
				opacity: 1,
				placeID: placeID, 
			},
			callback: function(marker){			
				
				/**
				 * Display the different travel modes and the directions button */
				 
				travel_modes_output += '<div class="travel_modes_container cspm_box_shadow">';
					travel_modes_output += '<div id="driving" class="nearby_map_mode_'+map_id+' active cspm_nearby_map_main_background cspm_border_top_radius" data-map-id="'+map_id+'" data-travel-mode="DRIVING" data-units="'+distance_unit+'" data-origin="'+post_latlng+'" data-destination="'+placeLoc+'" data-place-name="'+placeName+'" data-place-id="'+placeID+'"><i class="travel-mode icon-driving"></i></div>';			
					travel_modes_output += '<div id="transit" class="nearby_map_mode_'+map_id+' cspm_nearby_map_main_background" data-travel-mode="TRANSIT" data-map-id="'+map_id+'" data-units="'+distance_unit+'" data-origin="'+post_latlng+'" data-destination="'+placeLoc+'" data-place-name="'+placeName+'" data-place-id="'+placeID+'"><i class="travel-mode icon-transit"></i></div>';				
					travel_modes_output += '<div id="walking" class="nearby_map_mode_'+map_id+' cspm_nearby_map_main_background" data-travel-mode="WALKING" data-map-id="'+map_id+'" data-units="'+distance_unit+'" data-origin="'+post_latlng+'" data-destination="'+placeLoc+'" data-place-name="'+placeName+'" data-place-id="'+placeID+'"><i class="travel-mode icon-walking"></i></div>';
					travel_modes_output += '<div id="bicycle" class="nearby_map_mode_'+map_id+' cspm_nearby_map_main_background cspm_border_bottom_radius" data-map-id="'+map_id+'" data-travel-mode="BICYCLING" data-units="'+distance_unit+'" data-origin="'+post_latlng+'" data-destination="'+placeLoc+'" data-place-name="'+placeName+'"><i class="travel-mode icon-bicycle"></i></div>';		
				travel_modes_output += '</div>';
				
				directions_btn_output += '<div id="directions" class="nearby_directions_btn_'+map_id+' cspm_nearby_map_main_background cspm_border_radius cspm_box_shadow" data-status="open" data-map-id="'+map_id+'"><i class="icon-directions"></i></div>';
				directions_btn_output += '<div id="'+placeID+'" class="clear-both"></div>';
				
				/**
				 * Render the route on the map and display the place info when the user selects a place from the ...
				 * ... list of nearby places */
				 
                jQuery(document).on('click', '.cspm_nearby_route_list[data-place-id='+placeID+']', function(){ //@edited 5.6.6
					
					/**
					 * Prevent loading the same route and save our quotas limit when button is deactivated.
					 * Note: The btn can be deactivated when the user clicks on the this place marker on the map!
					 * @since 2.4 */
					
					if(jQuery(this).hasClass('disabled'))
						return;
						
					cspm_get_place_route(map_id, post_latlng, placeLoc, 'DRIVING', distance_unit, placeName, placeID);	
					
					jQuery('div#travel_mode_container_'+map_id).html(travel_modes_output);
					
					jQuery('div#cspm_directions_btn_container_'+map_id).html(directions_btn_output);
										
					jQuery('div#cspm_nearby_places_list_'+map_id+' div.cspm_nearby_location_list_item').removeClass('active');
					
					jQuery('div.cspm_nearby_location_list_item[data-place-id='+placeID+']').addClass('active');
						
					jQuery('.cspm_nearby_route_list[data-map-id='+map_id+']').removeClass('disabled'); //@since 2.4
					jQuery(this).addClass('disabled'); //@since 2.4

				});
				
			},
			events:{
				click: function(marker){
					
					/** 
					 * Make sure to hide the directions container if already displayed */
						
					jQuery('div.nearby_directions_btn_'+map_id).removeClass('active').attr('data-status', 'open');
					jQuery('div.cspm_nearby_map_directions_'+map_id).hide();
					jQuery('div#cspm_nearby_places_list_'+map_id).show();
					
					/**
					 * Get route and place infos */
					 	
					cspm_get_place_route(map_id, post_latlng, placeLoc, 'DRIVING', distance_unit, placeName, placeID);	
					
					jQuery('div#travel_mode_container_'+map_id).html(travel_modes_output);
					
					jQuery('div#cspm_directions_btn_container_'+map_id).html(directions_btn_output);	
					
					setTimeout(function(){
						
						jQuery('div#cspm_nearby_places_list_'+map_id+' div.cspm_nearby_location_list_item').removeClass('active');
						
						jQuery('div.cspm_nearby_location_list_item[data-place-id='+placeID+']').addClass('active');
	
						var selected_place = jQuery('div.cspm_nearby_location_list_item[data-place-id='+placeID+']');
		
						if(selected_place.length)
							jQuery('div.cspm_nearby_location_list_items_container_'+map_id).scrollTo(selected_place, 1000);
													
					}, 500);
					
					/**
					 * Prevent loading the same route and save our quotas limit by deactivating ...
					 * ... the "Route" button in the list.
					 * @since 2.4 */
					
					jQuery('.cspm_nearby_route_list[data-map-id='+map_id+']').removeClass('disabled'); //@since 2.4
					jQuery('.cspm_nearby_route_list[data-map-id='+map_id+'][data-place-id='+placeID+']').addClass('disabled');

				}
			}
	  	}
		
	});
	
}

/**
 * This will display the place details
 *
 * @since 1.0
 * @updated 2.6 [Added support for "fields" attribute]
 */
function cspm_get_place_details(map_id, place_id, place_name){
	
	var item_output = '';

	var proximity_id = selected_proximity_id[map_id];
	var proximity_name = place_name;
			
	jQuery('div.cspm_nearby_map_place_details_content_'+map_id).html('');
	
	var service = new google.maps.places.PlacesService(nearby_map_object[map_id]);
			
	service.getDetails({
		
		placeId: place_id,
		fields: [
			'name', 
			'photo', 
			'rating', 
			'user_ratings_total', 
			'place_id', 
			'formatted_address',
			'plus_code',
			'geometry',
			'website',
			'international_phone_number',
			'url',
			'type',
			'review'
		] //@since 2.6
		
	}, function(place, status){
		
		if(status === google.maps.places.PlacesServiceStatus.OK){
	
			item_output += '<div class="cspm_close_place_details" data-map-id="'+map_id+'">';
				item_output += '<img src="'+cspm_nearby_map.img_file_url + 'close.png" />';
			item_output += '</div>';
							
			if(typeof place.photos !== 'undefined')								
				var photo_url = place.photos[0].getUrl({'maxWidth': 0, 'maxHeight': 600});
			else var photo_url = cspm_nearby_map.img_file_url + 'default-img.jpg';
			
			item_output += '<div class="cspm_place_details_header text-center" style="background:url('+photo_url+') center center no-repeat;">';
				
				item_output += '<div class="cspm_place_details_header_overlay"></div>';
				
				if(typeof place.name !== 'undefined')	
					item_output += '<div class="cspm_place_title text-center">'+place.name+'<div class="cspm_place_type text-center">'+cspm_ucfirst(proximity_name)+'</div></div>';
				
				if(typeof place.rating !== 'undefined' && typeof place.user_ratings_total !== 'undefined')									
					item_output += '<div class="cspm_place_rating text-center"><img src="'+cspm_nearby_map.img_file_url + 'one_star.png" class="cspm_one_star" />'+place.rating+' ('+place.user_ratings_total+' '+cspm_nearby_map.the_word_ratings+')</div>';
				
			item_output += '</div>';
				
			item_output += '<div class="cspm_place_details_info_container">';	
				
				item_output += '<div class="cspm_place_details_targets_container cspm_nearby_map_main_background text-center">';
					
					if(typeof place.reviews !== 'undefined')
						item_output += '<a data-target="#cspm_place_reviews_container_'+map_id+'" class="cspm_place_details_target cspm_target_'+map_id+'" data-map-id="'+map_id+'"><img src="'+cspm_nearby_map.img_file_url + 'reviews_target.png" />'+cspm_nearby_map.the_word_reviews+'</a>';
					
					if(typeof place.photos !== 'undefined')
						item_output += '<a data-target="#cspm_place_photos_container_'+map_id+'" class="cspm_place_details_target cspm_target_'+map_id+'" data-map-id="'+map_id+'"><img src="'+cspm_nearby_map.img_file_url + 'photos_target.png" />'+cspm_nearby_map.the_word_photos+'</a>';
					
					item_output += '<a class="cspm_place_details_target cspm_nearby_route_list" data-map-id="'+map_id+'" data-place-id="'+place.place_id+'"><img src="'+cspm_nearby_map.img_file_url + 'route_target.png" />'+cspm_nearby_map.the_word_route+'</a>';
					
					item_output += '<div class="clearfix"></div>';
					
				item_output += '</div>';

				/**
				 * Details */
				 
				item_output += '<div class="cspm_place_details_content">';
					
					/**
					 * Place address */
					 
					if(typeof place.formatted_address !== 'undefined')
						item_output += '<div class="cspm_place_details_item"><img src="'+cspm_nearby_map.img_file_url + 'address.png" />'+place.formatted_address+'</div>';											
					
					/**
					 * Place "Plus code"
					 * @since 2.6 */
															
					if(typeof place.plus_code !== 'undefined' && typeof place.plus_code.compound_code !== 'undefined')
						item_output += '<div class="cspm_place_details_item"><img src="'+cspm_nearby_map.img_file_url + 'plus-code.png" />'+place.plus_code.compound_code+'</div>';											
			
					/**
					 * Get Distance & Duration */
					
					if(typeof place.geometry !== 'undefined' && typeof place.geometry.location !== 'undefined'){
						
						cspm_distance_matrix(map_id, place_id, origin[map_id], place.geometry.location, current_distance_unit, 'div.cspm_place_distance_'+place_id+' .cspm_place_distance_text');
						
						item_output += '<div class="cspm_place_details_item cspm_place_distance_'+place_id+'"><img src="'+cspm_nearby_map.img_file_url + 'distance.png" /><span class="cspm_place_distance_text"><span class="wrapper"><span class="cssload-loader"></span></span></span></div>';
					
					}
							
					if(typeof place.website !== 'undefined')
						item_output += '<div class="cspm_place_details_item website"><img src="'+cspm_nearby_map.img_file_url + 'website.png" /><a href="'+place.website+'" target="_blank" class="cspm_nearby_map_main_color hover">'+place.website+'</a></div>';
					
					if(typeof place.international_phone_number !== 'undefined')
						item_output += '<div class="cspm_place_details_item"><img src="'+cspm_nearby_map.img_file_url + 'tel.png" />'+place.international_phone_number+'</div>';
					
					if(typeof place.url !== 'undefined')
						item_output += '<div class="cspm_place_details_item"><img src="'+cspm_nearby_map.img_file_url + 'link.png" /><a href="'+place.url+'" target="_blank" class="cspm_nearby_map_main_color hover">'+cspm_nearby_map.google_map_link_text+'</a></div>';
					
					if(typeof place.types !== 'undefined' && place.types.length > 0){

						item_output += '<div class="cspm_place_details_item"><img src="'+cspm_nearby_map.img_file_url + 'tag.png" /> '+cspm_nearby_map.appears_also_text+' ';
							
							for (i = 0; i < place.types.length; i++){
								if(typeof cspm_nearby_map[place.types[i]] !== 'undefined'){
									item_output += cspm_nearby_map[place.types[i]];
									if(i < (place.types.length-1)) item_output += ', ';
								}
							}
							
						item_output += '</div>';
						
					}
										
				item_output += '</div>';
				
				/**
				 * Photos */
							
				if(typeof place.photos !== 'undefined'){						
					
					item_output += '<div id="cspm_place_photos_container_'+map_id+'">';
				
						item_output += '<div class="cspm_place_photos_toggle cspm_nearby_map_main_background">';
						
							item_output += '<img src="'+cspm_nearby_map.img_file_url + 'photos_target.png" />'+cspm_nearby_map.the_word_photos;
							
						item_output += '</div>';
						
						item_output += '<div class="cspm_place_photos_container">';
						
							var nbr_photos_by_clmn = Math.round(place.photos.length / 3);
							
							item_output += '<div id="place_img_container" class="cspm-col-lg-4 cspm-col-md-4 cspm-col-sm-4 cspm-col-xs-4 place_img_container">';
							
								for (p = 0; p < place.photos.length; p++){ 
									
									var thumb_url = place.photos[p].getUrl({'maxWidth': 0, 'maxHeight': 600});
									var photo_url = place.photos[p].getUrl({'maxWidth': 0, 'maxHeight': 1000});
									
									item_output += '<a href="' + photo_url + '"><img src="' + thumb_url + '" class="img-responsive" /></a>';
									
									if(p == nbr_photos_by_clmn || p == (nbr_photos_by_clmn*2)){
										
										item_output += '</div>';
										
										item_output += '<div class="cspm-col-lg-4 cspm-col-md-4 cspm-col-sm-4 cspm-col-xs-4 place_img_container">';
									
									}
									
								}
							
							item_output += '</div>';
						
							item_output += '<div class="clearfix"></div>';
						
						item_output += '</div>';
						
					item_output += '</div>';

					setTimeout(function(){
						
						var gallery = jQuery('.place_img_container a').simpleLightbox({
							fileExt: false,
							captions: false,
							disableScroll: true,
							alertError: true,
							spinner: true,	
						});	
					
                        jQuery(document).on('click', '.cspm_target_'+map_id, function(){ //@edited 5.6.6
	
							var target = jQuery(this).attr('data-target');
			
							if(target.length)
								jQuery('.cspm_nearby_map_place_details_container_'+map_id).scrollTo(target, 1000);
							
						});
			
					}, 500);
					
				}
					
				/**
				 * Reviews */
				 
				if(typeof place.reviews !== 'undefined'){
					
					item_output += '<div id="cspm_place_reviews_container_'+map_id+'" class="cspm_place_reviews_container">';
					
						item_output += '<div class="cspm_place_reviews_toggle cspm_nearby_map_main_background">';
						
							item_output += '<img src="'+cspm_nearby_map.img_file_url + 'reviews_target.png" />'+cspm_nearby_map.the_word_reviews;
							
						item_output += '</div>';
						
						item_output += '<div class="cspm_place_reviews_content">';
							
							for (i = 0; i < place.reviews.length; i++){ 
								
								item_output += '<div class="cspm_nearby_place_author_review">';
									
									item_output += '<div class="cspm_review_header">';
									
										if(typeof place.reviews[i].author_name !== 'undefined'){
										
											if(typeof place.reviews[i].author_url !== 'undefined')
												var author_url = place.reviews[i].author_url;
											else var author_url = '#';
											
											item_output += '<span class="cspm_review_author_name pull-left"><a href="'+author_url+'" target="_blank" class="author_name cspm_nearby_map_main_color hover">'+place.reviews[i].author_name+'</a></span>';
										
										}
										
										if(typeof place.reviews[i].time !== 'undefined'){
	
											var review_date = cspm_time_converter(place.reviews[i].time);
											
											item_output += '<span class="cspm_review_date pull-left">'+review_date+'</span>';
										
										}																	
																		
										if(typeof place.reviews[i].rating !== 'undefined'){
											
											stars_width = cspm_stars(place.reviews[i].rating);
											
											item_output += '<span class="cspm_review_rating pull-right cspm_stars_rating"><span style="width:'+stars_width+'px;"></span></span>';
										
										}
									
										item_output += '<div class="clearfix"></div>';
										
									item_output += '</div>';
									
									item_output += '<div class="cspm_review_text">';
										
										if(typeof place.reviews[i].text !== 'undefined')
											item_output += place.reviews[i].text;
									
									item_output += '</div>';
										
								item_output += '</div>';
								
							}
					 
							if(typeof place.url !== 'undefined' && place.reviews.length >= 4)
								item_output += '<div class="cspm_load_more_reviews text-center"><a href="'+place.url+'" target="_blank" class="cspm_nearby_map_main_color hover">'+cspm_nearby_map.more_reviews_text+'</a></div>';
					
						item_output += '</div>';
						
					item_output += '</div>';
					
					setTimeout(function(){
						
						jQuery('.cspm_review_text').readmore({
							speed: 500,
							collapsedHeight: 100,
							moreLink: '<a href="#" class="text-right cspm_nearby_map_main_color hover" style="margin-top:10px">'+cspm_nearby_map.show_more_text+'</a>',
							lessLink: '<a href="#" class="text-right cspm_nearby_map_main_color hover" style="margin-top:10px">'+cspm_nearby_map.show_less_text+'</a>',
						});
						
					}, 500);
					
				}
				
			item_output += '</div>';
						
			jQuery('div.cspm_nearby_map_place_details_container_'+map_id).show();

			jQuery('div.cspm_nearby_map_place_details_content_'+map_id).append(item_output);
			
			item_output = '';
		  
		}else{
			var api_status_codes = progress_map_vars.places_api_status_codes; //@since 2.4
			cspm_api_status_info(map_id, api_status_codes, status, 'Places API'); //@since 2.4
			return;
		}
		
	});
					
}


/**
 * This will display the route & the directions to the selected place on the map or the list
 *
 * @since 1.0
 * @updated 2.4
 */
function cspm_get_place_route(map_id, start, end, travel_mode, units, place_name, place_id) {
	
	var start = start;
	var end = end;
	var mode = travel_mode;
	var units = units;
	
	var start_address_output = '';
	var end_address_output = '';
	var directions_output = '';
	
	var place_info_map_widget = ''; //@since 2.4

	jQuery('div#travel_mode_container_'+map_id+', div#cspm_directions_btn_container_'+map_id).show();		

	if(typeof NProgress !== 'undefined'){
		
		NProgress.configure({
		  parent: 'div#codespacing_progress_map_'+map_id,
		  showSpinner: true
		});				
		
		NProgress.start();
		
	}
	
	if(start == '' || end == ''){
		
		var message = cspm_nearby_map.no_results_msg;		
		cspm_popup_msg(map_id, 'warning', '', message);	
		
		console.warn('PROGRESS MAP, "Directions API": (NOT_FOUND) At least one of the locations specified in the request\'s origin, destination, or waypoints could not be geocoded.');
		
		/**
		 * End the Progress Bar Loader */
			
		if(typeof NProgress !== 'undefined')
			NProgress.done();
						
		return;
			
	} //@since 2.4
	
	nearby_map[map_id].gmap3({ 
		getroute:{
			options:{
				origin: start,
				destination: end,
				travelMode: google.maps.DirectionsTravelMode[mode.toUpperCase()],
				unitSystem: google.maps.UnitSystem[units.toUpperCase()],
			},
			callback: function(response, status){
					
				if(typeof response !== 'undefined' && status === 'OK'){
						 
					var route = response.routes[0];

					var distance = route.legs[0].distance.text;
					var duration = route.legs[0].duration.text;		
				
					/**
					 * Display the places info widget on the map
					 * @since 2.4 */
	
					place_info_map_widget += '<div class="cspm_place_name text-center">' + place_name + '</div><hr />';
					place_info_map_widget += '<div class="text-center">';
						place_info_map_widget += '<span class="cspm_place_distance"><i class="cspm_place_distance_icon"></i>' + distance + '</span>';
						place_info_map_widget += '<span class="cspm_place_travel_time"><i class="cspm_place_travel_time_icon"></i>' + duration + '</span>';
					place_info_map_widget += '</div>';
	
					jQuery('div#cspm_place_name_container_'+map_id).show().html(place_info_map_widget);
					
					/**
					 * Render the route on the map */
					 
					nearbyDirectionsDisplay[map_id].setDirections(response);						
					
					/**
					 * Render the directions on the directions area */

					if(typeof NProgress !== 'undefined')
						NProgress.set(0.5);
			
					start_address_output += '<div class="cspm_start_address cspm_nearby_map_main_background"><i class="cspm_nearby_start_icon"></i><span>'+route.legs[0].start_address+'</span></div>';
					
					directions_output += '<div class="cspm_direction_steps cspm_box_shadow cspm_animated fadeIn">';
						for (var i = 0; i < route.legs[0].steps.length; i++){
							var routeSegment = i+1;
							directions_output += '<div class="cspm_nearby_step">';
								if(route.legs[0].steps[i].maneuver != '')
									directions_output += '<div class="text-left pull-left cspm_maneuver_icon"><i class="maneuver_sprite '+route.legs[0].steps[i].maneuver+'"></i></div>';							
								directions_output += '<div class="text-left pull-left cspm_route_distance cspm_nearby_map_main_color"><small>' + route.legs[0].steps[i].distance.text + ', ' + route.legs[0].steps[i].duration.text + '</small></div>';
								directions_output += '<div class="clearfix"></div>';
								directions_output += '<div class="text-left cspm_route_step">'+ route.legs[0].steps[i].instructions + '</div>';
							directions_output += '</div>';
						}	
					directions_output += '</div>';	
						
					end_address_output += '<div class="cspm_destination_address cspm_nearby_map_main_background"><i class="cspm_nearby_end_icon"></i><span>'+route.legs[0].end_address+'</span></div>';
					
					jQuery('div.nearby_directions_btn_'+map_id).show();
					
					jQuery('div.cspm_nearby_map_directions_'+map_id+' div.cspm_start_address_container').html(start_address_output);
					
					jQuery('div.cspm_nearby_map_directions_'+map_id+' div.cspm_direction_steps_container').html(directions_output);
						
					jQuery('div.cspm_nearby_map_directions_'+map_id+' div.cspm_destination_address_container').html(end_address_output);

					/**
					 * Change all markers opacity to distinguish the current marker
					 * @since 2.0 */
					  
					nearby_map[map_id].gmap3({
						get: {
							name: 'marker',
							tag: map_id,
							all:  true,	
							callback: function(markers){
								jQuery.each(markers, function(i, marker){
									if(marker.placeID != place_id){										
										marker.setOpacity(0.6);
									}else{
										marker.setOpacity(1);
										jQuery('div#cspm_nearby_map_'+map_id).attr('data-selected-place-id', place_id);
									}
								});									
							}
						},
					});			
				
				}else{
					
					/**
					 * Display the places info widget on the map
					 * @since 2.4 */
	
					place_info_map_widget += '<div class="cspm_place_name text-center">' + place_name + '</div>';
					jQuery('div#cspm_place_name_container_'+map_id).show().html(place_info_map_widget);
					
					/**
					 * Hide the directions area */
					 
					jQuery('div.nearby_directions_btn_'+map_id).hide().removeClass('active').attr('data-status', 'open');
					jQuery('div.cspm_nearby_map_directions_'+map_id).hide();
					jQuery('div#cspm_nearby_places_list_'+map_id).show();
					
					/**
					 * Display the error message
					 * @since 2.4 */
					 	
					var api_status_codes = progress_map_vars.directions_api_status_codes; //@since 2.4
					cspm_api_status_info(map_id, api_status_codes, status, 'Directions API'); //@since 2.4
					
				}
	
				/**
				 * End the Progress Bar Loader */
					
				if(typeof NProgress !== 'undefined')
					NProgress.done();
				
			}
			
		}
		
	});
	
}


/**
 * This will get the distance & durations between two location
 *
 * @since 1.0
 */
function cspm_distance_matrix(map_id, place_id, origin, destination, unit_system, output){
	
	setTimeout(function(){
		nearby_map[map_id].gmap3({
			getdistance:{
				options:{ 
					origins: [origin],
					destinations: [destination],
					travelMode: google.maps.TravelMode.DRIVING,
					unitSystem: google.maps.UnitSystem[unit_system.toUpperCase()],
				},
				callback: function(results, status){
					
					var distance_service_output = "";
					
					if(typeof results !== 'undefined' && status === 'OK'){
						if(typeof results.rows[0].elements[0] !== 'undefined' && status === results.rows[0].elements[0].status){
							var distance_service_results = results.rows[0].elements[0];
							distance_service_output = distance_service_results.distance.text + ' ' + cspm_nearby_map.the_word_away + ' (' + distance_service_results.duration.text + ')';
							jQuery(output).html(distance_service_output);
						}
					}else{
						var api_status_codes = progress_map_vars.distance_matrix_api_status_codes; //@since 2.4
						cspm_api_status_info(map_id, api_status_codes, status, 'Distance Matrix API'); //@since 2.4
					}
							
				}
			
			}
		  
		});
	}, 1000);
			
}


/**
 * This will prepare the map to display new markers and routes.
 * 
 * @since 1.0
 */
function cspm_init_nearby_directions_display(map_id){

	var DirectionsRendererOptions = {
		suppressMarkers: true,
		suppressInfoWindows: true,
		draggable: false,
		preserveViewport: false,
		suppressBicyclingLayer: true,
	};
	
	if(nearbyDirectionsDisplay[map_id] != null) {
		nearbyDirectionsDisplay[map_id].setMap(null);
		nearbyDirectionsDisplay[map_id] = null;
	}

	nearbyDirectionsDisplay[map_id] = new google.maps.DirectionsRenderer(DirectionsRendererOptions);
	nearbyDirectionsDisplay[map_id].setMap(nearby_map_object[map_id]);
	
}


/**
 * This will remove all markers & routes displayed on the map
 *
 * @since 1.0
 */
function cspm_clear_nearby_markers(map_id){
	
	nearby_map[map_id].gmap3({
		clear: {
			tag: map_id
		}
	});	
			
	jQuery('div#cspm_nearby_map_'+map_id).attr('data-selected-place-id', 'false');
	
	cspm_init_nearby_directions_display(map_id);
	
}


/**
 * This will reset the plugin layout
 *
 * @since 1.0
 */
function cspm_reset_nearby_layout(map_id, show_geoloc_form){
	
	jQuery('div#cspm_nearby_places_list_'+map_id).hide();
	jQuery('div.cspm_nearby_map_place_details_container_'+map_id).hide();
	jQuery('div.cspm_nearby_map_directions_'+map_id).hide();
	jQuery('div#travel_mode_container_'+map_id).hide(); 	
	jQuery('div#cspm_directions_btn_container_'+map_id).hide(); 
	jQuery('div#cspm_place_name_container_'+map_id).hide();
	
	jQuery('div.cspm_nearby_location_list_items_container_'+map_id).html('');
		
	jQuery('div#cspm_nearby_cats_container_'+map_id).show();
	
	if(show_geoloc_form){
		jQuery('div#cspm_nearby_address_locator_'+map_id).show();
		jQuery('input[name=cspm_nearby_address_'+map_id+']').select().trigger('focus'); //@edited 2.6.6
	}
	
}


/**
 * This will convert the rating number to stars.
 *
 * @since 1.0
 */
function cspm_stars(value){
    return (Math.max(0, (Math.min(5, parseFloat(value)))) * 16);
}


function cspm_ucfirst(str){
	str += '';
	var f = str.charAt(0).toUpperCase();
	return f + str.substr(1);
}	


function cspm_time_converter(UNIX_timestamp){
	
	var a = new Date(UNIX_timestamp * 1000);
	
	var months = [cspm_nearby_map.jan, cspm_nearby_map.feb, cspm_nearby_map.mar, cspm_nearby_map.apr, cspm_nearby_map.may, cspm_nearby_map.jun, cspm_nearby_map.jul, cspm_nearby_map.aug, cspm_nearby_map.sep, cspm_nearby_map.oct, cspm_nearby_map.nov, cspm_nearby_map.dec];
	var year = a.getFullYear();
	var month = months[a.getMonth()];
	var date = a.getDate();
	
	/*var hour = a.getHours();
	var min = a.getMinutes();
	var sec = a.getSeconds();*/
	
	var time = date + ' ' + month + ' ' + year ;
	
	return time;
	
}

/**
 * A JavaScript equivalent of PHP’s file_exists
 *
 * @since 1.0
 */
function cspm_file_exists(url){
  
	// http://kevin.vanzonneveld.net
	// +   original by: Enrique Gonzalez
	// +      input by: Jani Hartikainen
	// +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	// %        note 1: This function uses XmlHttpRequest and cannot retrieve resource from different domain.
	// %        note 1: Synchronous so may lock up browser, mainly here for study purposes.
	// *     example 1: file_exists('http://kevin.vanzonneveld.net/pj_test_supportfile_1.htm');
	// *     returns 1: '123'
	
	var req = this.window.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
	if (!req) {
	throw new Error('XMLHttpRequest not supported');
	}
	
	// HEAD Results are usually shorter (faster) than GET
	req.open('HEAD', url, true);
	req.send(null);
	if (req.status == 200) {
	return true;
	}
	
	return false;	
  
}	

//jQuery(document).ready(function($){		
(function($){		
    
	/**
	 * Display Nearby places */
 
 	var proximity_id = null;
	
    $(document).on('click', 'div[class^=proximity_place_]', function(){ //@edited 5.6.6
		
		var map_id = $(this).attr('data-map-id');

		if(typeof NProgress !== 'undefined'){
			
			NProgress.configure({
			  parent: 'div#codespacing_progress_map_'+map_id,
			  showSpinner: true
			});				
			
			NProgress.start();
			
		}
		
		var selected_system_unit = $('div#cspm_nearby_map_'+map_id).attr('data-selected-system-unit');
		
		var radius = $('div#cspm_nearby_map_'+map_id).attr('data-radius');
		var rankby = $('div#cspm_nearby_map_'+map_id).attr('data-rankby'); //@since 2.4
		
		proximity_id = $(this).attr('id');
		
		/**
		 * Create Nearby Markers */
		 
		cspm_nearby_locations(map_id, proximity_id, selected_system_unit, radius, rankby);
		
		$('div#cspm_nearby_map_'+map_id).attr('data-current-screen', 'places_list');

		/**
		 * End the Progress Bar Loader */
			
		if(typeof NProgress !== 'undefined')
			NProgress.done();
				
	});
										
	/**
	 * Go back to the categories list */
	
    $(document).on('click', 'img.cspm_back_to_nearby_cats', function(){ //@edited 5.6.6
		
		var map_id = $(this).attr('data-map-id');

		if(typeof NProgress !== 'undefined'){
			
			NProgress.configure({
			  parent: 'div#codespacing_progress_map_'+map_id,
			  showSpinner: true
			});				
			
			NProgress.start();
			
		}
		
		/** 
		 * Hide nearby places list */
			
		$('div#cspm_nearby_places_list_'+map_id).hide();
		
		/**
		 * Show nearby cats */
		 
		$('div#cspm_nearby_cats_container_'+map_id).show();
		
		$('div#cspm_nearby_map_'+map_id).attr('data-current-screen', 'nearby_cats');
		
		/**
		 * Reset the Map */
		 
		cspm_clear_nearby_markers(map_id);
		
		nearby_map_object[map_id].panTo(origin[map_id]);
		nearby_map_object[map_id].setCenter(origin[map_id]);
		
		$('div#travel_mode_container_'+map_id).hide(); 
		$('div#cspm_directions_btn_container_'+map_id).hide(); 
		$('div#cspm_place_name_container_'+map_id).hide();
		$('div.cspm_nearby_location_list_items_container_'+map_id).html('');

		/**
		 * End the Progress Bar Loader */
			
		if(typeof NProgress !== 'undefined')
			NProgress.done();
				
	});
					
	/**
	 * Display the place details */
	
    $(document).on('click', '[class^=cspm_show_place_details_]', function(){ //@edited 5.6.6
		
		var map_id = $(this).attr('data-map-id');

		if(typeof NProgress !== 'undefined'){
			
			NProgress.configure({
			  parent: 'div#codespacing_progress_map_'+map_id,
			  showSpinner: true
			});				
			
			NProgress.start();
			
		}
		
		var place_id = $(this).attr('data-place-id');
		
		var place_name = $(this).attr('data-place-name');
		
		$('div#cspm_nearby_places_list_'+map_id+' div.cspm_nearby_location_list_item').removeClass('active');
		
		$('div#cspm_nearby_places_list_'+map_id+' div.cspm_nearby_location_list_item[data-place-id='+place_id+']').addClass('active');

		cspm_get_place_details(map_id, place_id, place_name);
		
		$('div#cspm_nearby_map_'+map_id).attr('data-current-screen', 'place_details');
			
		/** 
		 * Hide nearby places list */
			
		$('div#cspm_nearby_places_list_'+map_id).hide();						

		/**
		 * End the Progress Bar Loader */
			
		if(typeof NProgress !== 'undefined')
			NProgress.done();
				
	});
	
	/**
	 * Close the place details */
	
    $(document).on('click', 'div.cspm_close_place_details', function(){ //@edited 5.6.6
		
		var map_id = $(this).attr('data-map-id');

		if(typeof NProgress !== 'undefined'){
			
			NProgress.configure({
			  parent: 'div#codespacing_progress_map_'+map_id,
			  showSpinner: true
			});				
			
			NProgress.start();
			
		}
		
		$('div.cspm_nearby_map_place_details_container_'+map_id).hide();
		
		$('div#cspm_nearby_map_'+map_id).attr('data-current-screen', 'places_list');
		
		/** 
		 * Show nearby places list */
			
		$('div#cspm_nearby_places_list_'+map_id).show();						

		/**
		 * End the Progress Bar Loader */
			
		if(typeof NProgress !== 'undefined')
			NProgress.done();
				
	});
					
	/**
	 * Display the place route according to the selected travel mode */
	 
    $(document).on('click', 'div[class^=nearby_map_mode_]', function(){ //@edited 5.6.6
					
		/**
		 * Prevent loading the same route and save our quotas limit when button is already activated.
		 * @since 2.4 */
		
		if($(this).hasClass('active'))
			return; //@since 2.4
		
		var map_id = $(this).attr('data-map-id');

		$('div.nearby_map_mode_'+map_id).removeClass('active');
		
		$(this).addClass('active');
		
		var origin = $(this).attr('data-origin').slice(1, -1).split(',');
		var destination = $(this).attr('data-destination').slice(1, -1).split(',');
		
		/**
		 * Create the Route for the selected location/marker */
		 
		cspm_get_place_route(map_id, new google.maps.LatLng(origin[0],origin[1]), new google.maps.LatLng(destination[0],destination[1]), $(this).attr('data-travel-mode'), $(this).attr('data-units'), $(this).attr('data-place-name'), $(this).attr('data-place-id'));
				
	});	
	
	/**
	 * Hide/Show the place directions */
	 
    $(document).on('click', 'div[class^=nearby_directions_btn_]', function(){ //@edited 5.6.6
		
		var map_id = $(this).attr('data-map-id');

		if(typeof NProgress !== 'undefined'){
			
			NProgress.configure({
			  parent: 'div#codespacing_progress_map_'+map_id,
			  showSpinner: true
			});				
			
			NProgress.start();
			
		}
		
		var btn_status = $(this).attr('data-status');
		
		if(btn_status == 'open'){
			
			$(this).addClass('active').attr('data-status', 'hide');
		
			$('div#cspm_nearby_map_'+map_id).attr('data-current-screen', 'place_directions');
		
			/** 
			 * Hide nearby places list */
			
			$('div#cspm_nearby_places_list_'+map_id).hide();
			
			/** 
			 * Hide places details */
			
			$('div.cspm_nearby_map_place_details_container_'+map_id).hide();
		
		}else{
		
			$('div#cspm_nearby_map_'+map_id).attr('data-current-screen', 'places_list');
		
			$(this).removeClass('active').attr('data-status', 'open');
			
			/** 
			 * Hide nearby places list */
			
			$('div#cspm_nearby_places_list_'+map_id).show();
		
		}
		
		$('div.cspm_nearby_map_directions_'+map_id).toggle();	  

		/**
		 * End the Progress Bar Loader */
			
		if(typeof NProgress !== 'undefined')
			NProgress.done();
				
	});
					
	/**
	 * Geolocalization */
	
    $(document).on('click', '.cspm_get_geoloc', function(){ //@edited 5.6.6
		
		var map_id = $(this).attr('data-map-id');

		if(typeof NProgress !== 'undefined'){
			
			NProgress.configure({
			  parent: 'div#codespacing_progress_map_'+map_id,
			  showSpinner: true
			});				
			
			NProgress.start();
			
		}
		
		var selected_system_unit = $('div#cspm_nearby_map_'+map_id).attr('data-selected-system-unit');
		
		var radius = $('div#cspm_nearby_map_'+map_id).attr('data-radius');
		var rankby = $('div#cspm_nearby_map_'+map_id).attr('data-rankby'); //@since 2.4
		
		var proximity_id = $('div#cspm_nearby_map_'+map_id).attr('data-single-proximity-id');
						
		var count_place_types = $('div#cspm_nearby_map_'+map_id).attr('data-count-place-types');
																					
		nearby_map[map_id].gmap3({
			getgeoloc:{
				callback : function(latLng){

					if(latLng){
				
						if(typeof NProgress !== 'undefined')
							NProgress.set(0.5);
				
						/**
						 * Save the position in a variable */
						
						origin[map_id] = latLng;
						
						/**
						 * Display the marker position */
						
						nearby_map[map_id].gmap3({
							marker:{ 
								latLng:latLng,
								tag: 'csnm_user_marker_'+map_id,												
								options:{
									icon: new google.maps.MarkerImage(cspm_nearby_map.img_file_url+'marker.png'),									
									draggable: true,
								},
								events:{
									dragend: function(){
									
										nearby_map[map_id].gmap3({
										  get: {
											name: 'marker',
											tag: 'csnm_user_marker_'+map_id,
											callback: function(obj){
												
												if(typeof obj.position !== 'undefined'){

													/**
													 * Save the position in a variable */
																						
													origin[map_id] = obj.position;	
			
													/**
													 * Reset the Map */
													
													cspm_reset_nearby_layout(map_id, false);
													 
													cspm_clear_nearby_markers(map_id);

													setTimeout(function(){
														nearby_map_object[map_id].panTo(origin[map_id]);
														nearby_map_object[map_id].setCenter(origin[map_id]);
													}, 500);
					 	
													/**
													 * Display Places when user choosed to use one single place type in their website
													 * @since 1.3 */
													
													if(count_place_types == 1){

														/**
														 * Create Nearby Markers */
														 
														cspm_nearby_locations(map_id, proximity_id, selected_system_unit, radius, rankby);
														
														$('div#cspm_nearby_map_'+map_id).attr('data-current-screen', 'places_list');
																								
													}else $('div#cspm_nearby_map_'+map_id).attr('data-current-screen', 'nearby_cats');
			
												}
												
											}
										  }
										});	
										
									}
								}
							},
							map:{
								options:{
									center:latLng,
								}
							}
						});
																						
						$('#cspm_nearby_address_locator_'+map_id).hide();
						
						$('div.cspm_btn_reset_nearby_map_'+map_id).show();
					 	
						/**
						 * Display Places when user choosed to use one single place type in their website
						 * @since 1.3 */
						
						if(count_place_types == 1){
																		
							/**
							 * Create Nearby Markers */
							 
							cspm_nearby_locations(map_id, proximity_id, selected_system_unit, radius, rankby);
							
							$('div#cspm_nearby_map_'+map_id).attr('data-current-screen', 'places_list');
																	
						}else $('div#cspm_nearby_map_'+map_id).attr('data-current-screen', 'nearby_cats');
			
					}else{
					
						/**
						 * More info at https://support.google.com/maps/answer/152197
						 * Deprecate Geolocation API: https://developers.google.com/web/updates/2016/04/geolocation-on-secure-contexts-only */
						
						var title = progress_map_vars.geoErrorTitle;
						var message = progress_map_vars.geoErrorMsg;
					
						cspm_popup_msg(map_id, 'error', title, '<br />'+message);
						console.log('PROGRESS MAP: ' + progress_map_vars.geoDeprecateMsg);
					  
					}
			
					/**
					 * End the Progress Bar Loader */
						
					if(typeof NProgress !== 'undefined')
						NProgress.done();
				
				}
				
			}
			
		});								
		
	});
	
	/**
	 * Address Localization */
	
    $(document).on('click', '.cspm_get_address', function(){ //@edited 5.6.6
		
		var map_id = $(this).attr('data-map-id');

		if(typeof NProgress !== 'undefined'){
			
			NProgress.configure({
			  parent: 'div#codespacing_progress_map_'+map_id,
			  showSpinner: true
			});				
			
			NProgress.start();
			
		}
		
		var address = $('input[name=cspm_nearby_address_'+map_id+']').val();

		var selected_system_unit = $('div#cspm_nearby_map_'+map_id).attr('data-selected-system-unit');
		
		var radius = $('div#cspm_nearby_map_'+map_id).attr('data-radius');
		var rankby = $('div#cspm_nearby_map_'+map_id).attr('data-rankby'); //@since 2.4
		
		var proximity_id = $('div#cspm_nearby_map_'+map_id).attr('data-single-proximity-id');
		
		var count_place_types = $('div#cspm_nearby_map_'+map_id).attr('data-count-place-types');
						
		if(address){
				
			if(typeof NProgress !== 'undefined')
				NProgress.set(0.5);
				
			var geocoder = new google.maps.Geocoder();
	
			/** Convert our address to Lat & Lng */
			
			geocoder.geocode({'address': address }, function (results, status) {
				
				/** If the address was found */
				
				if(status === google.maps.GeocoderStatus.OK){
	
					var latitude = results[0].geometry.location.lat();
					var longitude = results[0].geometry.location.lng();
						
					/**
					 * Save the position in a variable */
					
					origin[map_id] = results[0].geometry.location;
					
					/**
					 * Display the marker position */
						
					setTimeout(function(){
						
						/** Center the map in our address position */
						
						cspm_center_map_at_point(nearby_map[map_id], map_id, latitude, longitude, 'zoom');
						
						nearby_map[map_id].gmap3({							
							marker:{
							  latLng:results[0].geometry.location,
							  tag: 'csnm_user_marker_'+map_id,
							  options:{
								icon: new google.maps.MarkerImage(cspm_nearby_map.img_file_url+'marker.png'),
								draggable: true,
							  },
							  events:{
								dragend: function(){
									
									nearby_map[map_id].gmap3({
									  get: {
										name: 'marker',
										tag: 'csnm_user_marker_'+map_id,
										callback: function(obj){
											
											if(typeof obj.position !== 'undefined'){

												/**
												 * Save the position in a variable */
																					
												origin[map_id] = obj.position;	
		
												/**
												 * Reset the Map */
												
												cspm_reset_nearby_layout(map_id, false);
												 
												cspm_clear_nearby_markers(map_id);
												
												setTimeout(function(){
													nearby_map_object[map_id].panTo(origin[map_id]);
													nearby_map_object[map_id].setCenter(origin[map_id]);
												}, 500);
					 	
												/**
												 * Display Places when user choosed to use one single place type in their website
												 * @since 1.3 */
												
												if(count_place_types == 1){
																								
													/**
													 * Create Nearby Markers */
													 
													cspm_nearby_locations(map_id, proximity_id, selected_system_unit, radius, rankby);
													
													$('div#cspm_nearby_map_'+map_id).attr('data-current-screen', 'places_list');
																							
												}else $('div#cspm_nearby_map_'+map_id).attr('data-current-screen', 'nearby_cats');
			
											}
											
										}
									  }
									});	
									
								},
							  }
							}
						});
						
						$('#cspm_nearby_address_locator_'+map_id).hide();
						
						$('div.cspm_btn_reset_nearby_map_'+map_id).show();
					 	
						/**
						 * Display Places when user choosed to use one single place type in their website
						 * @since 1.3 */
		
						if(count_place_types == 1){
																		
							/**
							 * Create Nearby Markers */
							 
							cspm_nearby_locations(map_id, proximity_id, selected_system_unit, radius, rankby);
							
							$('div#cspm_nearby_map_'+map_id).attr('data-current-screen', 'places_list');
																	
						}else $('div#cspm_nearby_map_'+map_id).attr('data-current-screen', 'nearby_cats');
			
					}, 500);
					
				}else{
					var api_status_codes = progress_map_vars.geocoding_api_status_codes; //@since 2.4
					cspm_api_status_info(map_id, api_status_codes, status, 'Geocoding API'); //@since 2.4
				}
				
			});	
			
		}else{

			var message = cspm_nearby_map.no_address;
			cspm_popup_msg(map_id, 'warning', '', message);

			$('input[name=cspm_nearby_address_'+map_id+']').trigger('focus'); //@edited 2.6.6
			
		}
			
		/**
		 * End the Progress Bar Loader */
			
		if(typeof NProgress !== 'undefined')
			NProgress.done();
				
	});
	
	/**
	 * Reset the map & layout for new gelocalization */
	
    $(document).on('click', 'div[class^=cspm_btn_reset_nearby_map_]', function(){ //@edited 5.6.6
		
		var map_id = $(this).attr('data-map-id');

		if(typeof NProgress !== 'undefined'){
			
			NProgress.configure({
			  parent: 'div#codespacing_progress_map_'+map_id,
			  showSpinner: true
			});				
			
			NProgress.start();
			
		}
		
		$(this).hide();
						
		/**
		 * Reset the Map */
				
		if(typeof NProgress !== 'undefined')
			NProgress.set(0.5);
				
		cspm_reset_nearby_layout(map_id, true);
		 
		cspm_clear_nearby_markers(map_id);

		nearby_map[map_id].gmap3({
			clear: {
				tag: 'csnm_user_marker_'+map_id,
			}
		});	
		
		setTimeout(function(){
			nearby_map_object[map_id].panTo(origin[map_id]);
			nearby_map_object[map_id].setCenter(origin[map_id]);
		}, 500);

		$('div#cspm_nearby_map_'+map_id).attr('data-current-screen', 'nearby_cats');
			
		/**
		 * End the Progress Bar Loader */
			
		if(typeof NProgress !== 'undefined')
			NProgress.done();
				
	});

})(jQuery);
		
