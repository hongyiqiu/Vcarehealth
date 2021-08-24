<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Kiddie Care
 */
/**
* Hook - kiddie_care_action_doctype.
*
* @hooked kiddie_care_doctype -  10
*/
do_action( 'kiddie_care_action_doctype' );
?>
<head>
<?php
/**
* Hook - kiddie_care_action_head.
*
* @hooked kiddie_care_head -  10
*/
do_action( 'kiddie_care_action_head' );
?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>
<?php

/**
* Hook - kiddie_care_action_before.
*
* @hooked kiddie_care_page_start - 10
*/
do_action( 'kiddie_care_action_before' );

/**
*
* @hooked kiddie_care_header_start - 10
*/
do_action( 'kiddie_care_action_before_header' );

/**
*
*@hooked kiddie_care_site_branding - 10
*@hooked kiddie_care_header_end - 15 
*/
do_action('kiddie_care_action_header');

/**
*
* @hooked kiddie_care_content_start - 10
*/
do_action( 'kiddie_care_action_before_content' );

/**
 * Banner start
 * 
 * @hooked kiddie_care_banner_header - 10
*/
do_action( 'kiddie_care_banner_header' );  
