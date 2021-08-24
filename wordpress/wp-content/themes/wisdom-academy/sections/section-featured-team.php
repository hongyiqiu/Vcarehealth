<?php 
/**
 * Template part for displaying Featured Team Section
 *
 *@package Wisdom Academy
 */
    $featured_team_section_title           = wisdom_academy_get_option( 'featured_team_section_title' );
    $featured_team_content_type            = wisdom_academy_get_option( 'featured_team_content_type' );
    $number_of_featured_team_items         = wisdom_academy_get_option( 'number_of_featured_team_items' );
    $featured_team_column                  = wisdom_academy_get_option( 'featured_team_column' );
    $featured_team_category                = wisdom_academy_get_option( 'featured_team_category' );
    $show_featured_team_image              = wisdom_academy_get_option( 'show_featured_team_image' );
    $show_featured_team_position           = wisdom_academy_get_option( 'show_featured_team_position' );
    $show_featured_team_title              = wisdom_academy_get_option( 'show_featured_team_title' );
    $show_featured_team_content            = wisdom_academy_get_option( 'show_featured_team_content' );
    $featured_team_title_font_weight       = wisdom_academy_get_option( 'featured_team_title_font_weight' );
    $featured_team_title_text_transform    = wisdom_academy_get_option( 'featured_team_title_text_transform' );
    $featured_team_content_font_weight     = wisdom_academy_get_option( 'featured_team_content_font_weight' );
    $featured_team_content_text_transform  = wisdom_academy_get_option( 'featured_team_content_text_transform' );

    if( $featured_team_content_type == 'featured_team_page' ) :
        for( $i=1; $i<=$number_of_featured_team_items; $i++ ) :
            $featured_team_posts[] = wisdom_academy_get_option( 'featured_team_page_'.$i );
        endfor;  
    elseif( $featured_team_content_type == 'featured_team_post' ) :
        for( $i=1; $i<=$number_of_featured_team_items; $i++ ) :
            $featured_team_posts[] = wisdom_academy_get_option( 'featured_team_post_'.$i );
        endfor;
    endif;
    ?>

    <?php if( !empty($featured_team_section_title) ):?>
        <div class="section-header">
            <h2 class="section-title"><?php echo esc_html($featured_team_section_title);?></h2>
        </div><!-- .section-header -->
    <?php endif;?>

    <?php if( $featured_team_content_type == 'featured_team_page' ) : ?>
        <div class="section-content <?php echo esc_attr($show_featured_team_image); ?> <?php echo esc_attr($show_featured_team_position); ?> <?php echo esc_attr($show_featured_team_title); ?> <?php echo esc_attr($show_featured_team_content); ?> <?php echo esc_attr($featured_team_title_font_weight); ?> <?php echo esc_attr($featured_team_content_font_weight); ?> <?php echo esc_attr($featured_team_title_text_transform); ?> <?php echo esc_attr($featured_team_content_text_transform); ?>" data-slick='{"slidesToShow": <?php echo esc_attr($featured_team_column); ?>, "slidesToScroll": 1, "infinite": false, "speed": 1000, "dots": true, "arrows": false, "autoplay": false, "fade": false }'>
            <?php $args = array (
                'post_type'     => 'page',
                'posts_per_page' => absint( $number_of_featured_team_items ),
                'post__in'      => $featured_team_posts,
                'orderby'       =>'post__in',
            );        
            $loop = new WP_Query($args);                        
            if ( $loop->have_posts() ) :
            $i=-1; $j=0; 
                while ($loop->have_posts()) : $loop->the_post(); $i++; $j++;
                $featured_team_position[$j] = wisdom_academy_get_option( 'featured_team_position_'.$j ); ?>            
                
                <article class="<?php echo has_post_thumbnail() ? 'has-post-thumbnail' : 'no-post-thumbnail'; ?>">
                    <div class="featured-team-item">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="featured-image">
                                <a href="<?php the_permalink();?>"><?php the_post_thumbnail(); ?></a>
                            </div><!-- .featured-image -->
                        <?php endif; ?>

                        <div class="entry-container">
                            <?php if( !empty($featured_team_position[$j]) ):?>
                                <span class="team-position"><?php echo esc_html($featured_team_position[$j]);?></span>
                            <?php endif;?>

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
                    </div><!-- .featured-team-item -->
                </article>

                <?php endwhile; ?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div><!-- .section-content -->
    
    <?php else: ?>
        <div class="section-content <?php echo esc_attr($show_featured_team_image); ?> <?php echo esc_attr($show_featured_team_position); ?> <?php echo esc_attr($show_featured_team_title); ?> <?php echo esc_attr($show_featured_team_content); ?> <?php echo esc_attr($featured_team_title_font_weight); ?> <?php echo esc_attr($featured_team_content_font_weight); ?> <?php echo esc_attr($featured_team_title_text_transform); ?> <?php echo esc_attr($featured_team_content_text_transform); ?>" data-slick='{"slidesToShow": <?php echo esc_attr($featured_team_column); ?>, "slidesToScroll": 1, "infinite": false, "speed": 1000, "dots": true, "arrows": false, "autoplay": false, "fade": false }'>
            <?php $args = array (
                'post_type'     => 'post',
                'posts_per_page' => absint( $number_of_featured_team_items ),
                'post__in'      => $featured_team_posts,
                'orderby'       =>'post__in',
                'ignore_sticky_posts' => true,
            );        
            $loop = new WP_Query($args);                        
            if ( $loop->have_posts() ) :
            $i=-1; $j=0; 
                while ($loop->have_posts()) : $loop->the_post(); $i++; $j++;
                $featured_team_position[$j] = wisdom_academy_get_option( 'featured_team_position_'.$j ); ?>               
                
                <article class="<?php echo has_post_thumbnail() ? 'has-post-thumbnail' : 'no-post-thumbnail'; ?>">
                    <div class="featured-team-item">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="featured-image">
                                <a href="<?php the_permalink();?>"><?php the_post_thumbnail(); ?></a>
                            </div><!-- .featured-image -->
                        <?php endif; ?>

                        <div class="entry-container">
                            <?php if( !empty($featured_team_position[$j]) ):?>
                                <span class="team-position"><?php echo esc_html($featured_team_position[$j]);?></span>
                            <?php endif;?>

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
                    </div><!-- .featured-team-item -->
                </article>

                <?php endwhile; ?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div><!-- .section-content -->
    <?php endif;