<?php 
/**
 * Template part for displaying Featured Services Section
 *
 *@package Wisdom Academy
 */
    $featured_services_column                  = wisdom_academy_get_option( 'featured_services_column' );
    $featured_services_content_type            = wisdom_academy_get_option( 'featured_services_content_type' );
    $number_of_featured_services_items         = wisdom_academy_get_option( 'number_of_featured_services_items' );
    $featured_services_category                = wisdom_academy_get_option( 'featured_services_category' );
    $show_featured_services_icon               = wisdom_academy_get_option( 'show_featured_services_icon' );
    $show_featured_services_title              = wisdom_academy_get_option( 'show_featured_services_title' );
    $show_featured_services_content            = wisdom_academy_get_option( 'show_featured_services_content' );
    $featured_services_title_font_weight       = wisdom_academy_get_option( 'featured_services_title_font_weight' );
    $featured_services_title_text_transform    = wisdom_academy_get_option( 'featured_services_title_text_transform' );
    $featured_services_content_font_weight     = wisdom_academy_get_option( 'featured_services_content_font_weight' );
    $featured_services_content_text_transform  = wisdom_academy_get_option( 'featured_services_content_text_transform' );

    if( $featured_services_content_type == 'featured_services_page' ) :
        for( $i=1; $i<=$number_of_featured_services_items; $i++ ) :
            $featured_services_posts[] = wisdom_academy_get_option( 'featured_services_page_'.$i );
        endfor;  
    elseif( $featured_services_content_type == 'featured_services_post' ) :
        for( $i=1; $i<=$number_of_featured_services_items; $i++ ) :
            $featured_services_posts[] = wisdom_academy_get_option( 'featured_services_post_'.$i );
        endfor;
    endif;
    ?>

    <?php if( $featured_services_content_type == 'featured_services_page' ) : ?>
        <div class="section-content <?php echo esc_attr($show_featured_services_icon); ?> <?php echo esc_attr($show_featured_services_title); ?> <?php echo esc_attr($show_featured_services_content); ?> <?php echo esc_attr($featured_services_title_font_weight); ?> <?php echo esc_attr($featured_services_content_font_weight); ?> <?php echo esc_attr($featured_services_title_text_transform); ?> <?php echo esc_attr($featured_services_content_text_transform); ?> <?php echo esc_attr($featured_services_column); ?> clear">
            <?php $args = array (
                'post_type'     => 'page',
                'posts_per_page' => absint( $number_of_featured_services_items ),
                'post__in'      => $featured_services_posts,
                'orderby'       =>'post__in',
            );        
            $loop = new WP_Query($args);                        
            if ( $loop->have_posts() ) :
            $i=-1; $j=0; 
                while ($loop->have_posts()) : $loop->the_post(); $i++; $j++;
                $featured_services_icon[$j] = wisdom_academy_get_option( 'featured_services_icon_'.$j ); ?>          
                
                <article>
                    <div class="featured-service-item">
                        <div class="entry-container">
                            <?php if( !empty( $featured_services_icon[$j] ) ) : ?>
                                <div class="icon-container">
                                    <a href="<?php the_permalink(); ?>">
                                        <i class="<?php echo esc_attr( $featured_services_icon[$j] )?>"></i>
                                    </a>
                                </div><!-- .icon-container -->
                            <?php endif; ?>

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
                    </div><!-- .featured-service-item -->
                </article>

                <?php endwhile; ?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div><!-- .section-content -->
    
    <?php else: ?>
        <div class="section-content <?php echo esc_attr($show_featured_services_icon); ?> <?php echo esc_attr($show_featured_services_title); ?> <?php echo esc_attr($show_featured_services_content); ?> <?php echo esc_attr($featured_services_title_font_weight); ?> <?php echo esc_attr($featured_services_content_font_weight); ?> <?php echo esc_attr($featured_services_title_text_transform); ?> <?php echo esc_attr($featured_services_content_text_transform); ?> <?php echo esc_attr($featured_services_column); ?> clear">
            <?php $args = array (
                'post_type'     => 'post',
                'posts_per_page' => absint( $number_of_featured_services_items ),
                'post__in'      => $featured_services_posts,
                'orderby'       =>'post__in',
                'ignore_sticky_posts' => true,
            );        
            $loop = new WP_Query($args);                        
            if ( $loop->have_posts() ) :
            $i=-1; $j=0; 
                while ($loop->have_posts()) : $loop->the_post(); $i++; $j++;
                $featured_services_icon[$j] = wisdom_academy_get_option( 'featured_services_icon_'.$j ); ?>  
                
                <article>
                    <div class="featured-service-item">
                        <div class="entry-container">
                            
                                <div class="icon-container">
                                    <a href="<?php the_permalink(); ?>">
                                        <i class="<?php echo esc_attr( $featured_services_icon[$j] )?>"></i>
                                    </a>
                                </div><!-- .icon-container -->


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
                    </div><!-- .featured-service-item -->
                </article>

                <?php endwhile; ?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div><!-- .section-content -->
    <?php endif;