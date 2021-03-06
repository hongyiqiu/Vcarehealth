<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Kiddie Care
 */

?>

</article><!-- #post-## -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
	<div class="blog-item-wrapper">
      	<?php if(has_post_thumbnail()):?>
	        <div class="featured-image" style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');">
	        	<a href="<?php the_permalink();?>"></a>  
	        </div>
    	<?php endif;?>

    	<div class="entry-container">
			
			<header class="entry-header">
				<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

				<?php if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta">
					<?php kiddie_care_posted_on(); ?>
				</div><!-- .entry-meta -->
				<?php endif; ?>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<?php the_excerpt(); ?>
			</div><!-- .entry-content -->
		</div><!-- .entry-container -->
    </div><!-- .post-item -->
</article>
