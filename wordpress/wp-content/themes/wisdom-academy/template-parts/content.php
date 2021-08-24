<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Wisdom Academy
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-item">
		<?php if ( has_post_thumbnail() ) : ?>
            <div class="featured-image">
                <a href="<?php the_permalink();?>"><?php the_post_thumbnail(); ?></a>
            </div><!-- .featured-image -->
        <?php endif; ?>

		<div class="entry-container">
			<div class="entry-meta">
                <?php wisdom_academy_entry_meta(); ?>
            </div><!-- .entry-meta -->
                            
			<header class="entry-header">
				<?php
				if ( is_single() ) :
					the_title( '<h1 class="entry-title">', '</h1>' );
				else :
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				endif; ?>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<?php the_excerpt(); ?>
			</div><!-- .entry-content -->

			<?php $readmore_text = wisdom_academy_get_option( 'readmore_text' );?>
            <?php if (!empty($readmore_text) ) :?>
                <div class="read-more">
                    <a href="<?php the_permalink();?>" class="btn"><?php echo esc_html($readmore_text);?></a>
                </div><!-- .read-more -->
            <?php endif; ?>
		</div><!-- .entry-container -->
	</div><!-- .post-item -->
</article><!-- #post-## -->
