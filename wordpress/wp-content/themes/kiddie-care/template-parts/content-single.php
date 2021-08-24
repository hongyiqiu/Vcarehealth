<?php 
 /*
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Kiddie Care
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-meta">
		<?php kiddie_care_posted_on();
		kiddie_care_entry_meta(); ?>
	</div><!-- .entry-meta -->	
	<div class="entry-content">
		<?php $post_featured_image_enable = kiddie_care_get_option( 'post_featured_image_enable');
		if (true == $post_featured_image_enable ) { ?>

			<div class="featured-image">
		        <?php the_post_thumbnail( 'full', array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
			</div><!-- .featured-post-image -->
		<?php } the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'kiddie-care' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php kiddie_care_posts_tags(); ?>
	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
				edit_post_link(
					sprintf(
						/* translators: %s: Name of current post */
						esc_html__( 'Edit %s', 'kiddie-care' ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					),
					'<span class="edit-link">',
					'</span>'
				);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>	
</article><!-- #post-## -->