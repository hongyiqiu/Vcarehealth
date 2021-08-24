<?php 
    $course_title       = kiddie_care_get_option( 'course_title' );
    $course_category = kiddie_care_get_option( 'course_category' );
?>
<?php if( !empty($course_title)  ):?>
    <div class="section-header">
        <?php if( !empty($course_title)):?>
            <h2 class="section-title"><?php echo esc_html($course_title);?></h2>
        <?php endif;?>
    </div>
<?php endif;?>

<div class="section-content clear">
    <div class="wrapper courses-slider" data-slick='{"slidesToShow": 3, "slidesToScroll": 1, "infinite": true, "speed": 1200, "dots": true, "arrows":false, "autoplay": true, "fade": false }'>
        <?php 
            $args = array (

                'posts_per_page' =>3,              
                'post_type' => 'post',
                'post_status' => 'publish',
                'paged' => 1,
                'ignore_sticky_posts' => true, 
                );
                if ( absint( $course_category ) > 0 ) {
                    $args['cat'] = absint( $course_category );
                }

            $loop = new WP_Query($args);                        
            if ( $loop->have_posts() ) :
                $i=0;  
                while ($loop->have_posts()) : $loop->the_post(); $i++;?>           
                    <article>
                        <div class="post-item-wrapper">
                            <header class="entry-header">
                                <h2 class="entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                            </header>
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="featured-image" style="background-image: url('<?php the_post_thumbnail_url( 'blog-thumbnails');?>');">
                                    <a href="<?php the_permalink();?>" class="post-thumbnail-link"></a>
                                </div><!-- .featured-image -->
                            <?php endif; ?>

                            <div class="entry-container">
                                <div class="entry-meta">
                                    <?php  
                                       kiddie_care_entry_meta();
                                    ?>
                                </div><!-- .entry-meta -->
                            </div><!-- .entry-container -->
                        </div><!-- .post-item-wrapper -->
                    </article>

                <?php endwhile;?>
            <?php endif; ?>
        <?php wp_reset_postdata(); ?>
            
    </div>
</div><!-- .section-content -->