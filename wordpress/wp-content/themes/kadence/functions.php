<?php
/**
 * Kadence functions and definitions
 *
 * This file must be parseable by PHP 5.2.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package kadence
 */

define( 'KADENCE_VERSION', '1.0.30' );
define( 'KADENCE_MINIMUM_WP_VERSION', '5.2' );
define( 'KADENCE_MINIMUM_PHP_VERSION', '7.0' );

// Bail if requirements are not met.
if ( version_compare( $GLOBALS['wp_version'], KADENCE_MINIMUM_WP_VERSION, '<' ) || version_compare( phpversion(), KADENCE_MINIMUM_PHP_VERSION, '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

// Include WordPress shims.
require get_template_directory() . '/inc/wordpress-shims.php';

// Load the `kadence()` entry point function.
require get_template_directory() . '/inc/class-theme.php';

// Load the `kadence()` entry point function.
require get_template_directory() . '/inc/functions.php';

// Initialize the theme.
call_user_func( 'Kadence\kadence' );

function myshortcode_function($atts, $content = null){ // $atts 代表了 shortcode 的各个参数，$content 为标签内的内容
 
 extract(shortcode_atts(array( // 使用 extract 函数解析标签内的参数
 "title" => '标题' // 给参数赋默认值，下面直接调用 $ 加上参数名输出参数值
 ), $atts));
 // 返回内容
 return "<style>
#map{
height:400px;
}
</style>

<iframe id='map'src='https://api.mapbox.com/styles/v1/hongyiqiu/ckssrx0dt0npw17mq7m2t2cyu.html?fresh=true&title=false&access_token=pk.eyJ1IjoiaG9uZ3lpcWl1IiwiYSI6ImNrc3E0dWdlaTAzcHoyb3BibGw5b3FmZmkifQ.L2Xt1QFiizrd5F-H_O8BkA' />";
}
 
add_shortcode("msc", "myshortcode_function");