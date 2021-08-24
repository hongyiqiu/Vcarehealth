<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Kiddie Care
 */

/**
 *
 * @hooked kiddie_care_footer_start
 */
do_action( 'kiddie_care_action_before_footer' );

/**
 * Hooked - kiddie_care_footer_top_section -10
 * Hooked - kiddie_care_footer_section -20
 */
do_action( 'kiddie_care_action_footer' );

/**
 * Hooked - kiddie_care_footer_end. 
 */
do_action( 'kiddie_care_action_after_footer' );

wp_footer(); ?>

</body>  
</html>