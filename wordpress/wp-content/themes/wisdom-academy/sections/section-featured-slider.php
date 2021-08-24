<?php 
/**
 * Template part for displaying Slider Section
 *
 *@package Wisdom Academy
 */

    $data_slick_speed                        = wisdom_academy_get_option( 'data_slick_speed' );
    $data_slick_infinite                     = wisdom_academy_get_option( 'data_slick_infinite' );
    $data_slick_dots                         = wisdom_academy_get_option( 'data_slick_dots' );
    $data_slick_arrows                       = wisdom_academy_get_option( 'data_slick_arrows' );
    $data_slick_autoplay                     = wisdom_academy_get_option( 'data_slick_autoplay' );
    $data_slick_draggable                    = wisdom_academy_get_option( 'data_slick_draggable' );
    $data_slick_fade                         = wisdom_academy_get_option( 'data_slick_fade' );
    $featured_slider_content_type            = wisdom_academy_get_option( 'featured_slider_content_type' );
    $number_of_featured_slider_items         = wisdom_academy_get_option( 'number_of_featured_slider_items' );
    $show_featured_slider_title              = wisdom_academy_get_option( 'show_featured_slider_title' );
    $show_featured_slider_content            = wisdom_academy_get_option( 'show_featured_slider_content' );
    $show_featured_slider_button             = wisdom_academy_get_option( 'show_featured_slider_button' );
    $featured_slider_category                = wisdom_academy_get_option( 'featured_slider_category' );
    $featured_slider_title_font_weight       = wisdom_academy_get_option( 'featured_slider_title_font_weight' );
    $featured_slider_title_text_transform    = wisdom_academy_get_option( 'featured_slider_title_text_transform' );
    $featured_slider_content_font_weight     = wisdom_academy_get_option( 'featured_slider_content_font_weight' );
    $featured_slider_content_text_transform  = wisdom_academy_get_option( 'featured_slider_content_text_transform' );
    $featured_slider_button_font_weight      = wisdom_academy_get_option( 'featured_slider_button_font_weight' );
    $featured_slider_button_text_transform   = wisdom_academy_get_option( 'featured_slider_button_text_transform' );

    if( $featured_slider_content_type == 'featured_slider_page' ) :
        for( $i=1; $i<=$number_of_featured_slider_items; $i++ ) :
            $featured_slider_posts[] = wisdom_academy_get_option( 'featured_slider_page_'.$i );
        endfor;  
    elseif( $featured_slider_content_type == 'featured_slider_post' ) :
        for( $i=1; $i<=$number_of_featured_slider_items; $i++ ) :
            $featured_slider_posts[] = wisdom_academy_get_option( 'featured_slider_post_'.$i );
        endfor;
    endif;
    ?>

    <?php
        if( $data_slick_infinite == 0 )
            $data_slick_infinite = 'false';
        else
            $data_slick_infinite = 'true';
    ?>

    <?php
        if( $data_slick_dots == 0 )
            $data_slick_dots = 'false';
        else
            $data_slick_dots = 'true';
    ?>

    <?php
        if( $data_slick_arrows == 0 )
            $data_slick_arrows = 'false';
        else
            $data_slick_arrows = 'true';
    ?>

    <?php
        if( $data_slick_autoplay == 0 )
            $data_slick_autoplay = 'false';
        else
            $data_slick_autoplay = 'true';
    ?>

    <?php
        if( $data_slick_draggable == 0 )
            $data_slick_draggable = 'false';
        else
            $data_slick_draggable = 'true';
    ?>

    <?php
        if( $data_slick_fade == 0 )
            $data_slick_fade = 'false';
        else
            $data_slick_fade = 'true';
    ?>

    <?php if( $featured_slider_content_type == 'featured_slider_page' ) : ?>
        <div class="section-content <?php echo esc_attr($show_featured_slider_title); ?> <?php echo esc_attr($show_featured_slider_content); ?> <?php echo esc_attr($show_featured_slider_button); ?> <?php echo esc_attr($featured_slider_title_font_weight); ?> <?php echo esc_attr($featured_slider_content_font_weight); ?> <?php echo esc_attr($featured_slider_title_text_transform); ?> <?php echo esc_attr($featured_slider_content_text_transform); ?> <?php echo esc_attr($featured_slider_button_font_weight); ?> <?php echo esc_attr($featured_slider_button_text_transform); ?>" data-slick='{"slidesToShow": 1, "slidesToScroll": 1, "infinite": <?php echo esc_attr( $data_slick_infinite ); ?>, "speed": <?php echo esc_attr( $data_slick_speed ); ?>, "dots": <?php echo esc_attr( $data_slick_dots ); ?>, "arrows": <?php echo esc_attr( $data_slick_arrows ); ?>, "autoplay": <?php echo esc_attr( $data_slick_autoplay ); ?>, "draggable": <?php echo esc_attr( $data_slick_draggable ); ?>, "fade": <?php echo esc_attr( $data_slick_fade ); ?> }'>
            <?php $args = array (
                'post_type'     => 'page',
                'posts_per_page' => absint( $number_of_featured_slider_items ),
                'post__in'      => $featured_slider_posts,
                'orderby'       =>'post__in',
            );        
            $loop = new WP_Query($args);                        
            if ( $loop->have_posts() ) :
            $i=-1; $j=0; 
                while ($loop->have_posts()) : $loop->the_post(); $i++; $j++;

                $class='';
                if ($i==0) {
                    $class='display-block';
                } else{
                    $class='display-none';}
                ?>        
                
                <article class="<?php echo esc_attr($class); ?>" style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');">
                    <div class="overlay"></div>
                    <div class="wrapper">
                        <div class="entry-container">
                            <header class="entry-header">
                                <h2 class="entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                            </header>

                            <div class="entry-content">
                                <?php
                                    $excerpt = wisdom_academy_the_excerpt( 40 );
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
                    </div><!-- .wrapper -->
                </article>

                <?php endwhile; ?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div><!-- .section-content -->
    
    <?php else: ?>
        <div class="section-content <?php echo esc_attr($show_featured_slider_title); ?> <?php echo esc_attr($show_featured_slider_content); ?> <?php echo esc_attr($show_featured_slider_button); ?> <?php echo esc_attr($featured_slider_title_font_weight); ?> <?php echo esc_attr($featured_slider_content_font_weight); ?> <?php echo esc_attr($featured_slider_title_text_transform); ?> <?php echo esc_attr($featured_slider_content_text_transform); ?> <?php echo esc_attr($featured_slider_button_font_weight); ?> <?php echo esc_attr($featured_slider_button_text_transform); ?>" data-slick='{"slidesToShow": 1, "slidesToScroll": 1, "infinite": <?php echo esc_attr( $data_slick_infinite ); ?>, "speed": <?php echo esc_attr( $data_slick_speed ); ?>, "dots": <?php echo esc_attr( $data_slick_dots ); ?>, "arrows": <?php echo esc_attr( $data_slick_arrows ); ?>, "autoplay": <?php echo esc_attr( $data_slick_autoplay ); ?>, "draggable": <?php echo esc_attr( $data_slick_draggable ); ?>, "fade": <?php echo esc_attr( $data_slick_fade ); ?> }'>
            <?php $args = array (
                'post_type'     => 'post',
                'posts_per_page' => absint( $number_of_featured_slider_items ),
                'post__in'      => $featured_slider_posts,
                'orderby'       =>'post__in',
                'ignore_sticky_posts' => true,
            );        
            $loop = new WP_Query($args);                        
            if ( $loop->have_posts() ) :
            $i=-1; $j=0; 
                while ($loop->have_posts()) : $loop->the_post(); $i++; $j++;

                $featured_slider_post_readmore_text[$j] = wisdom_academy_get_option( 'featured_slider_post_readmore_text_'.$j );

                $class='';
                if ($i==0) {
                    $class='display-block';
                } else{
                    $class='display-none';}
                ?>            
                
                <article class="<?php echo esc_attr($class); ?>" style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');">
                    <div class="overlay"></div>
                    <div class="wrapper">
                        <div class="entry-container">
                            <header class="entry-header">
                                <h2 class="entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                            </header>

                            <div class="entry-content">
                                <?php
                                    $excerpt = wisdom_academy_the_excerpt( 40 );
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
                    </div><!-- .wrapper -->
                </article>

                <?php endwhile; ?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div><!-- .section-content -->
    <?php endif;