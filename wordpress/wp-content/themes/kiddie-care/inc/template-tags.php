<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Kiddie Care
 */

if ( ! function_exists( 'kiddie_care_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function kiddie_care_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$posted_on = sprintf(
		'%s',
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);
	$post_author_enable = kiddie_care_get_option( 'post_author_enable');

		if( is_single() ){
			$byline = sprintf(
		        esc_html_x( 'By %s', 'post author', 'kiddie-care' ),
		        '<span class="author vcard"><a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" class="url" itemprop="url">' . esc_html( get_the_author_meta( 'display_name' ) ) . '</a></span>'
		    );
		    echo '<span class="byline">' . $byline . '</span>';
		}
	
	echo '<span class="date">' . $posted_on . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'kiddie_care_entry_meta' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function kiddie_care_entry_meta() {

	$post_category_enable = kiddie_care_get_option( 'post_category_enable');

		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( );
			if ( $categories_list && kiddie_care_categorized_blog() ) {
				printf( '<span class="cat-links">%1$s</span>', $categories_list ); // WPCS: XSS OK.
			}
		
	}

	$post_comment_enable = kiddie_care_get_option( 'post_comment_enable');
	if (true == $post_comment_enable ) { 
		if ( is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			/* translators: %s: post title */
			comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'kiddie-care' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
			echo '</span>';
		}
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function kiddie_care_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'kiddie_care_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'kiddie_care_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so kiddie_care_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so kiddie_care_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in kiddie_care_categorized_blog.
 */
function kiddie_care_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'kiddie_care_categories' );
}
add_action( 'edit_category', 'kiddie_care_category_transient_flusher' );
add_action( 'save_post',     'kiddie_care_category_transient_flusher' );


if ( ! function_exists( 'kiddie_care_svg_curve' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function kiddie_care_svg_curve() {
	$curve_svg = ' <svg class="svg-curve" viewBox="0 0 1428.75 65.53"><path  d="M-114,158s138-33,369-17c0,0,70.5,2.5,310,21.5,0,0,157,14.17,314.33,8.83,0,0,105.17-2.33,435.42-49.33V107H-114Z" transform="translate(114 -107)"></path></svg>';
	echo $curve_svg; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'kiddie_care_svg_cloud' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function kiddie_care_svg_cloud() {
	$cloud_svg = '<svg class="svg-cloud-2" viewBox="0 0 1428 130.87"><path class="cls-1" d="M-83,345V288s158-27,262-22l104,5,138,8,300,21s245,4,281-5c0,0-9-39,33-45,0,0,8-51,58-25,0,0,48-36,61,23,0,0,27,2,28,24,0,0,163-22,163-17v90Z" transform="translate(83 -214.13)"></path></svg>';
	echo $cloud_svg; // WPCS: XSS OK.

}
endif;