<?php 
/**
 * Template part for displaying Gallery Section
 *
 *@package Kiddie Care
 */

    $gallery_title       = kiddie_care_get_option( 'gallery_title' );
    for( $i=1; $i<=6; $i++ ) :
        $gallery_page_posts[] = absint(kiddie_care_get_option( 'gallery_page_'.$i ) );
    endfor;
    ?>
    <div class="wrapper"> 
        <?php if( !empty($gallery_title) ):?>
            <div class="section-header">
                <?php if( !empty($gallery_title)):?>
                    <h2 class="section-title"><?php echo esc_html($gallery_title);?></h2>
                <?php endif;?>
            </div>       
        <?php endif;?>       
        <div class="section-content gallery-popup col-3">
            <?php $args = array (
                'post_type'     => 'page',
                'post_per_page' => count( $gallery_page_posts ),
                'post__in'      => $gallery_page_posts,
                'orderby'       =>'post__in', 
            ); 
                $loop = new WP_Query($args);                        
                if ( $loop->have_posts() ) :
                    $i=0;  
                    while ($loop->have_posts()) : $loop->the_post(); ?> 
                        <article>
                            <div class="gallery-item-wrapper">
                                <div class="gallery-overlay">
                                    <div class="overlay-bg"></div>
                                </div><!-- .gallery-overlay -->
                                <img class="gallery-cloud" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/shape-one.png' ) ?>">
                                <div class="featured-image">
                                    <img src="<?php the_post_thumbnail_url('kiddie-care-gallery');?>">
                                </div><!-- .featured-image -->
                                <div class="entry-container">
                                    <a href="<?php the_post_thumbnail_url('full');?>" class="popup"><i class="fa fa-plus"></i></a>
                                    <header class="entry-header">
                                        <h2 class="entry-title"><?php the_title(); ?></h2>
                                    </header>
                                </div><!-- .entry-container -->
                            </div><!-- .gallery-item-wrapper -->
                        </article>      
                        <?php $i++; ?>
                    <?php endwhile;?> 
                <?php endif;?>
            <?php wp_reset_postdata(); ?>
        </div>  
    </div>
