<?php

/**
 * Class CS_CMB2_Tabs
 * @since 1.0.1
 */

if( !class_exists( 'CS_CMB2_Tabs' ) ) {
 
	class CS_CMB2_Tabs {
	
		/**
		 * CS_CMB2_Tabs constructor.
		 */
		public function __construct() {
			add_action( 'cmb2_render_tabs', array( $this, 'render' ), 10, 3 );
			add_filter( 'cmb2_sanitize_tabs', array( $this, 'save' ), 10, 4 );
		}
	
	
		/**
		 * Hook: Render field
		 *
		 * @param $field_object
		 * @param $escaped_value
		 * @param $object_id
		 */
		public function render( $field_object, $escaped_value, $object_id ) {
						
			$settings = $field_object->args['tabs']; 
			
			$this->enqueue_scripts(array(
				'options_page' => isset($field_object->args['options_page']) ? $field_object->args['options_page'] : false,
			));
						
			$metabox_id = $settings['args']['id'];
	
			?>
			
			<div id="<?php echo $metabox_id; ?>" class="dtheme-cmb2-tabs">
				
				<ul id="<?php echo $metabox_id; ?>" class="tabs-menu">
					
					<?php 
					
					$i = 0;
					
					$current_class = '';
					
					foreach ( $settings['tabs'] as $key => $tab ): 
						
						$current_class = ($i==0) ? ' class="current"' : ''; ?>
						
						<li<?php echo $current_class; ?>>
                        	<a href="#<?php echo $tab['id']; ?>" data-metabox-id="<?php echo $metabox_id; ?>"><?php echo $tab['title']; ?></a>
                       	</li> <?php 
						
						$i++;
						
					endforeach; ?>
					
					<div style="clear:both"></div>
					
				</ul>
	
				<div id="<?php echo $metabox_id; ?>" class="tabs_content_container">
				
					<?php foreach ( $settings['tabs'] as $key => $tab ): ?>
					
						<div id="<?php echo $tab['id']; ?>" class="tab-content">
		
							<?php
							
							// set options to cmb2
							$setting_fields = array_merge( $settings['args'], array( 'fields' => $tab['fields'] ) );
							$CMB2           = new CMB2( $setting_fields, $object_id );
		
							foreach ( $tab['fields'] as $key_field => $field ) {
							   /* if ( $CMB2->is_options_page_mb() ) {
									$CMB2->object_type( $settings['args']['object_type'] );
								}*/
		
								// cmb2 render field
								$CMB2->render_field( $field );
							}
							
							?>
		
						</div>
					
					<?php endforeach; ?>
					
				</div>
				
			</div><?php
			
		}
	
	
		/**
		 * Hook: Save field values
		 *
		 * @param $override_value
		 * @param $value
		 * @param $post_id
		 * @param $data
		 */
		public function save( $override_value, $value, $post_id, $data ) {
			foreach ( $data['tabs']['tabs'] as $tab ) {
				$setting_fields = array_merge( $data['tabs']['args'], array( 'fields' => $tab['fields'] ) );
				$CMB2 = new CMB2( $setting_fields, $post_id );
	
				/*if ( $CMB2->is_options_page_mb() ) {
					$cmb2_options = cmb2_options( $post_id );
					$values       = $CMB2->get_sanitized_values( $_POST );
					foreach ( $values as $key => $value ) {
						$cmb2_options->update( $key, $value );
					}
				} else {*/
					$CMB2->save_fields();
				//}
			}
		}
	
		/**
		 * Enqueue scripts and styles
		 *
		 * @since 1.0
		 */
		public function enqueue_scripts($atts = array()){
			
			extract( wp_parse_args( $atts, array(
				'options_page' => false,
			)));
			
			/**
			 * Tabs JS */
			 
			wp_register_script('cspm-cmb2-tabs-js', plugins_url( 'js/cmb2-tabs.js', __FILE__ ), array(), false, true);
			wp_enqueue_script('cspm-cmb2-tabs-js');
			
			if(is_admin()){
				
				/**
				 * Tabs CSS */
				
				$css_file = ($options_page == true) ? 'css/cmb2-options-page-tabs.css' : 'css/cmb2-tabs.css';
				
				wp_register_style('cs-cmb2-tabs-css', plugins_url( $css_file, __FILE__ ), array(), false);
				wp_enqueue_style('cs-cmb2-tabs-css');
			
				/**
				 * JS Cookie */
								
				wp_register_script('js-cookie', plugins_url( 'js/js.cookie.js', __FILE__ ), array(), false, true);
				wp_enqueue_script('js-cookie');
			
				/**
				 * Read More JS */
			 				
				wp_register_script('readmore-js', plugins_url( 'js/readMoreJS.js', __FILE__ ), array(), false, true);
				wp_enqueue_script('readmore-js');
			
			}
			
		}
		
	}
	
	new CS_CMB2_Tabs();
	
}
