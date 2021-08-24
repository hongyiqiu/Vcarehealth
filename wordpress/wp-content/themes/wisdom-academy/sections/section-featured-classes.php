<?php 
/**
 * Template part for displaying Featured Classes Section
 *
 *@package Wisdom Academy
 */
    $featured_classes_section_title           = wisdom_academy_get_option( 'featured_classes_section_title' );
    $featured_classes_column                  = wisdom_academy_get_option( 'featured_classes_column' );
    $featured_classes_content_type            = wisdom_academy_get_option( 'featured_classes_content_type' );
    $number_of_featured_classes_items         = wisdom_academy_get_option( 'number_of_featured_classes_items' );
    $featured_classes_category                = wisdom_academy_get_option( 'featured_classes_category' );
    $show_featured_classes_image              = wisdom_academy_get_option( 'show_featured_classes_image' );
    $show_featured_classes_title              = wisdom_academy_get_option( 'show_featured_classes_title' );
    $show_featured_classes_content            = wisdom_academy_get_option( 'show_featured_classes_content' );
    $featured_classes_title_font_weight       = wisdom_academy_get_option( 'featured_classes_title_font_weight' );
    $featured_classes_title_text_transform    = wisdom_academy_get_option( 'featured_classes_title_text_transform' );
    $featured_classes_content_font_weight     = wisdom_academy_get_option( 'featured_classes_content_font_weight' );
    $featured_classes_content_text_transform  = wisdom_academy_get_option( 'featured_classes_content_text_transform' );

    if( $featured_classes_content_type == 'featured_classes_page' ) :
        for( $i=1; $i<=$number_of_featured_classes_items; $i++ ) :
            $featured_classes_posts[] = wisdom_academy_get_option( 'featured_classes_page_'.$i );
        endfor;  
    elseif( $featured_classes_content_type == 'featured_classes_post' ) :
        for( $i=1; $i<=$number_of_featured_classes_items; $i++ ) :
            $featured_classes_posts[] = wisdom_academy_get_option( 'featured_classes_post_'.$i );
        endfor;
    endif;
    ?>

    <?php if( !empty($featured_classes_section_title) ):?>
        <div class="section-header">
            <h2 class="section-title"><?php echo esc_html($featured_classes_section_title);?></h2>
        </div><!-- .section-header -->
    <?php endif;?>

    <?php if( $featured_classes_content_type == 'featured_classes_page' ) : ?>
        <div class="section-content <?php echo esc_attr($show_featured_classes_image); ?> <?php echo esc_attr($show_featured_classes_title); ?> <?php echo esc_attr($show_featured_classes_content); ?> <?php echo esc_attr($featured_classes_title_font_weight); ?> <?php echo esc_attr($featured_classes_content_font_weight); ?> <?php echo esc_attr($featured_classes_title_text_transform); ?> <?php echo esc_attr($featured_classes_content_text_transform); ?> <?php echo esc_attr($featured_classes_column); ?> clear">
            <?php $args = array (
                'post_type'     => 'page',
                'posts_per_page' => absint( $number_of_featured_classes_items ),
                'post__in'      => $featured_classes_posts,
                'orderby'       =>'post__in',
            );        
            $loop = new WP_Query($args);                        
            if ( $loop->have_posts() ) :
            $i=-1; $j=0; 
                while ($loop->have_posts()) : $loop->the_post(); $i++; $j++; ?>             
                
                <article class="<?php echo has_post_thumbnail() ? 'has-post-thumbnail' : 'no-post-thumbnail'; ?>">
                    <div class="featured-classes-item">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="featured-image">
                                <a href="<?php the_permalink();?>"><?php the_post_thumbnail(); ?></a>
                            </div><!-- .featured-image -->
                        <?php endif; ?>

                        <div class="entry-container">
                            <header class="entry-header">
                                <h2 class="entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                            </header>

                            <div class="entry-content">
                                <?php
                                    $excerpt = wisdom_academy_the_excerpt( 20 );
                                    echo wp_kses_post( wpautop( $excerpt ) );
                                ?>
                            </div><!-- .entry-content -->
                        </div><!-- .entry-container -->
                    </div><!-- .featured-classes-item -->
                </article>

                <?php endwhile; ?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div><!-- .section-content -->
    
    <?php else: ?>
        <div class="section-content <?php echo esc_attr($show_featured_classes_image); ?> <?php echo esc_attr($show_featured_classes_title); ?> <?php echo esc_attr($show_featured_classes_content); ?> <?php echo esc_attr($featured_classes_title_font_weight); ?> <?php echo esc_attr($featured_classes_content_font_weight); ?> <?php echo esc_attr($featured_classes_title_text_transform); ?> <?php echo esc_attr($featured_classes_content_text_transform); ?> <?php echo esc_attr($featured_classes_column); ?> <?php echo esc_attr($featured_classes_column); ?> clear">
            <?php $args = array (
                'post_type'     => 'post',
                'posts_per_page' => absint( $number_of_featured_classes_items ),
                'post__in'      => $featured_classes_posts,
                'orderby'       =>'post__in',
                'ignore_sticky_posts' => true,
            );        
            $loop = new WP_Query($args);                        
            if ( $loop->have_posts() ) :
            $i=-1; $j=0; 
                while ($loop->have_posts()) : $loop->the_post(); $i++; $j++; ?>                
                
                <article class="<?php echo has_post_thumbnail() ? 'has-post-thumbnail' : 'no-post-thumbnail'; ?>">
                    <div class="featured-classes-item">
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
                                <h2 class="entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                            </header>

                            <div class="entry-content">
                                <?php
                                    $excerpt = wisdom_academy_the_excerpt( 20 );
                                    echo wp_kses_post( wpautop( $excerpt ) );
                                ?>
                            </div><!-- .entry-content -->
                        </div><!-- .entry-container -->
                    </div><!-- .featured-classes-item -->
                </article>

                <?php endwhile; ?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div><!-- .section-content -->
    <?php endif;