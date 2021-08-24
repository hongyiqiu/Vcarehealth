<?php
/**
 * Theme functions related to structure.
 *
 * This file contains structural hook functions.
 *
 * @package Wisdom Academy
 */

if ( ! function_exists( 'wisdom_academy_doctype' ) ) :
	/**
	 * Doctype Declaration.
	 *
	 * @since 1.0.0
	 */
function wisdom_academy_doctype() {
	?><!DOCTYPE html> <html <?php language_attributes(); ?>><?php
}
endif;

add_action( 'wisdom_academy_action_doctype', 'wisdom_academy_doctype', 10 );


if ( ! function_exists( 'wisdom_academy_head' ) ) :
	/**
	 * Header Codes.
	 *
	 * @since 1.0.0
	 */
function wisdom_academy_head() {
	?>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
	<?php endif;
}
endif;
add_action( 'wisdom_academy_action_head', 'wisdom_academy_head', 10 );

if ( ! function_exists( 'wisdom_academy_page_start' ) ) :
	/**
	 * Add Skip to content.
	 *
	 * @since 1.0.0
	 */
	function wisdom_academy_page_start() {
	?><div id="page" class="site"><a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'wisdom-academy' ); ?></a><?php
	}
endif;

add_action( 'wisdom_academy_action_before', 'wisdom_academy_page_start', 10 );

if ( ! function_exists( 'wisdom_academy_header_start' ) ) :
	/**
	 * Header Start.
	 *
	 * @since 1.0.0
	 */
	function wisdom_academy_header_start() {

		$show_contact = wisdom_academy_get_option( 'show_header_contact_info' );
        $location     = wisdom_academy_get_option( 'header_location' );
        $email        = wisdom_academy_get_option( 'header_email' );
        $phone        = wisdom_academy_get_option( 'header_phone' ); 
        $show_social  = wisdom_academy_get_option( 'show_header_social_links' );
        $class 		  = 'col-1';

        if( ( ( ! empty( $email ) || ! empty( $phone ) || ! empty( $location ) ) && $show_contact ) && ( $show_social ) ) {
            $class = 'col-2';
        }

        if( $show_contact || $show_social ){ ?>
    
            <div id="top-bar" class="top-bar-widgets <?php echo esc_attr( $class ); ?>">
                <div class="wrapper">
                    <?php if( ( ! empty( $email ) || ! empty( $phone ) || ! empty( $location ) ) && $show_contact ) : ?>
                        
                        <div class="widget widget_address_block">
                            <ul>
                                <?php 

                                    if( ! empty( $location ) ){
                                        echo '<li><i class="fas fa-map-marker-alt"></i>'. esc_html( $location ) .'</li>';
                                    }
                                    if( ! empty( $phone ) ){
                                        echo '<li><a href="' . esc_url('tel: '. esc_attr( $phone )) .'"><i class="fas fa-phone-alt"></i>'. esc_html( $phone ) .'</a></li>';
                                    }
                                    if( ! empty( $email ) ){
									    echo '<li><a href="' . esc_url('mailto:' . sanitize_email($email)) . '"><i class="far fa-envelope"></i>'. esc_html( $email ) .'</a></li>';
									}
                                ?>
                            </ul>
                        </div><!-- .widget_address_block -->
                    <?php endif; 

                    if ( $show_social ){ ?>
                        <div class="widget widget_social_icons">
                           <?php wisdom_academy_render_social_links(); ?>
                        </div><!-- .widget_social_icons -->
                    <?php } ?>
                </div><!-- .wrapper -->
            </div><!-- #top-bar -->
        <?php
        } ?>
		<header id="masthead" class="site-header" role="banner"><?php
	}
endif;
add_action( 'wisdom_academy_action_before_header', 'wisdom_academy_header_start' );

if ( ! function_exists( 'wisdom_academy_header_end' ) ) :
	/**
	 * Header Start.
	 *
	 * @since 1.0.0
	 */
	function wisdom_academy_header_end() {

		?>
		</header> <!-- header ends here --><?php
	}
endif;
add_action( 'wisdom_academy_action_header', 'wisdom_academy_header_end', 15 );

if ( ! function_exists( 'wisdom_academy_content_start' ) ) :
	/**
	 * Header End.
	 *
	 * @since 1.0.0
	 */
	function wisdom_academy_content_start() { 
	?>
	<div id="content" class="site-content">
	<?php 

	}
endif;

add_action( 'wisdom_academy_action_before_content', 'wisdom_academy_content_start', 10 );

if ( ! function_exists( 'wisdom_academy_footer_start' ) ) :
	/**
	 * Footer Start.
	 *
	 * @since 1.0.0
	 */
	function wisdom_academy_footer_start() {
		if( !(is_home() || is_front_page()) ){
			echo '</div>';
		} ?>
		</div>
		<footer id="colophon" class="site-footer" role="contentinfo">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/cloud.png' ) ?>" class="cloud-top">
			<?php
	}
endif;
add_action( 'wisdom_academy_action_before_footer', 'wisdom_academy_footer_start' );

if ( ! function_exists( 'wisdom_academy_footer_end' ) ) :
	/**
	 * Footer End.
	 *
	 * @since 1.0.0
	 */
	function wisdom_academy_footer_end() {?>
		</footer><?php
	}
endif;
add_action( 'wisdom_academy_action_after_footer', 'wisdom_academy_footer_end' );
