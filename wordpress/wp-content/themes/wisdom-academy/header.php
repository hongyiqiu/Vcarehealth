<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Wisdom Academy
 */
/**
* Hook - wisdom_academy_action_doctype.
*
* @hooked wisdom_academy_doctype -  10
*/
do_action( 'wisdom_academy_action_doctype' );
?>
<head>
<?php
/**
* Hook - wisdom_academy_action_head.
*
* @hooked wisdom_academy_head -  10
*/
do_action( 'wisdom_academy_action_head' );
?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>

<?php

/**
* Hook - wisdom_academy_action_before.
*
* @hooked wisdom_academy_page_start - 10
*/
do_action( 'wisdom_academy_action_before' );

/**
*
* @hooked wisdom_academy_header_start - 10
*/
do_action( 'wisdom_academy_action_before_header' );

/**
*
*@hooked wisdom_academy_site_branding - 10
*@hooked wisdom_academy_header_end - 15 
*/
do_action('wisdom_academy_action_header');

/**
*
* @hooked wisdom_academy_content_start - 10
*/
do_action( 'wisdom_academy_action_before_content' );

/**
 * Banner start
 * 
 * @hooked wisdom_academy_banner_header - 10
*/
do_action( 'wisdom_academy_banner_header' );  
