<?php 
/**
 * Template part for displaying Blog Section
 *
 *@package Wisdom Academy
 */
?>
<?php 
    $featured_posts_section_title      = wisdom_academy_get_option( 'featured_posts_section_title' );
	$featured_posts_category 		   = wisdom_academy_get_option( 'featured_posts_category' );
	$featured_posts_number		       = wisdom_academy_get_option( 'featured_posts_number' );
    $featured_posts_column             = wisdom_academy_get_option( 'featured_posts_column' );
    $show_featured_posts_image         = wisdom_academy_get_option( 'show_featured_posts_image' );
    $show_featured_posts_category      = wisdom_academy_get_option( 'show_featured_posts_category' );
    $show_featured_posts_title         = wisdom_academy_get_option( 'show_featured_posts_title' );
    $show_featured_posts_content       = wisdom_academy_get_option( 'show_featured_posts_content' );
    $show_featured_posts_button        = wisdom_academy_get_option( 'show_featured_posts_button' );
    $featured_posts_title_font_weight       = wisdom_academy_get_option( 'featured_posts_title_font_weight' );
    $featured_posts_title_text_transform    = wisdom_academy_get_option( 'featured_posts_title_text_transform' );
    $featured_posts_content_font_weight     = wisdom_academy_get_option( 'featured_posts_content_font_weight' );
    $featured_posts_content_text_transform  = wisdom_academy_get_option( 'featured_posts_content_text_transform' );
    $featured_posts_button_font_weight      = wisdom_academy_get_option( 'featured_posts_button_font_weight' );
    $featured_posts_button_text_transform   = wisdom_academy_get_option( 'featured_posts_button_text_transform' );
?> 
    <?php if( !empty($featured_posts_section_title) ):?>
        <div class="section-header">
            <h2 class="section-title"><?php echo esc_html($featured_posts_section_title);?></h2>
        </div><!-- .section-header -->
    <?php endif;?>

  	<div class="section-content <?php echo esc_attr($show_featured_posts_image); ?> <?php echo esc_attr($show_featured_posts_category); ?> <?php echo esc_attr($show_featured_posts_title); ?> <?php echo esc_attr($show_featured_posts_content); ?> <?php echo esc_attr($show_featured_posts_button); ?> <?php echo esc_attr($featured_posts_column); ?> <?php echo esc_attr($featured_posts_title_font_weight); ?> <?php echo esc_attr($featured_posts_content_font_weight); ?> <?php echo esc_attr($featured_posts_title_text_transform); ?> <?php echo esc_attr($featured_posts_content_text_transform); ?> <?php echo esc_attr($featured_posts_button_font_weight); ?> <?php echo esc_attr($featured_posts_button_text_transform); ?> clear">
	  	<?php
			$featured_posts_args = array(
				'posts_per_page' =>absint( $featured_posts_number ),				
				'post_type' => 'post',
	            'post_status' => 'publish',
	            'paged' => 1,
				);

				if ( absint( $featured_posts_category ) > 0 ) {
					$featured_posts_args['cat'] = absint( $featured_posts_category );
				}
			
			$loop = new WP_Query( $featured_posts_args );
			
			if ( $loop->have_posts() ) : 
			$i=-1; $j=0;	
				while ( $loop->have_posts() ) : $loop->the_post(); $i++; $j++; ?>    

			    <article class="<?php echo has_post_thumbnail() ? 'has-post-thumbnail' : 'no-post-thumbnail'; ?>">
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
								<h2 class="entry-title">
									<a href="<?php the_permalink();?>"><?php the_title();?></a>
								</h2>
					        </header>

					        <div class="entry-content">
			 				    <?php
									$excerpt = wisdom_academy_the_excerpt( 15 );
									echo wp_kses_post( wpautop( $excerpt ) );
								?>
					        </div><!-- .entry-content -->

					        <?php $readmore_text = wisdom_academy_get_option( 'readmore_text' );?>
                            <?php if (!empty($readmore_text) ) :?>
                                <div class="read-more">
                                    <a href="<?php the_permalink();?>" class="btn"><?php echo esc_html($readmore_text);?></a>
                                </div><!-- .read-more -->
                            <?php endif; ?>
				        </div><!-- .entry-container -->
				    </div><!-- .post-item -->
			    </article>
		    	<?php endwhile;?>
	    	<?php endif; ?>
		<?php wp_reset_postdata(); ?>
  	</div><!-- .section-content -->