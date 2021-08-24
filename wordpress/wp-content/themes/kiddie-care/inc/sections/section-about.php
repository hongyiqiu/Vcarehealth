<?php 
/**
 * Template part for displaying Services Section
 *
 *@package Kiddie Care
 */ 
    $btn_text = kiddie_care_get_option( 'about_btn_text');

    ?>  

<div class="section-content has-post-thumbnail <?php has_post_thumbnail() ? 'has-post-thumbnail' : 'no-post-thumbnail'; ?> ">
    <?php 
        $about_id = kiddie_care_get_option( 'about_page' );
            $args = array (
            'post_type'     => 'page',
            'posts_per_page' => 1,
            'p' => $about_id,
            
        ); 
        $the_query = new WP_Query( $args );

        // The Loop
        while ( $the_query->have_posts() ) : $the_query->the_post();
        ?>
        <article>
            <?php if(has_post_thumbnail()) : ?>
                <img class="about-cloud" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/shape-about.png' ) ?>">
                <div class="featured-image" style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');">
                        <a href="<?php the_permalink();?>" class="post-thumbnail-link"></a>
                    </div><!-- .featured-image -->
            <?php endif; ?>

            <div class="entry-container" <?php echo !has_post_thumbnail() ? 'style="width:100%; padding:0;"' : ''; ?> >
                <div class="section-header">
                    <h2 class="section-title separator"><?php the_title(); ?></h2>
                </div><!-- .section-header -->
                <div class="section-content">
                    <style type="text/css">
                        
                    </style>
                    <?php  
                        $excerpt = kiddie_care_the_excerpt( 50 );
                        echo wp_kses_post( wpautop( $excerpt ) );
                    ?>
                </div><!-- .entry-content -->

                <?php if ( ! empty( $btn_text ) ) : ?>
                    <div class="more-link">
                        <a href="<?php the_permalink(); ?>" class="btn btn-primary"><?php echo esc_html( $btn_text ); ?></a>
                    </div><!-- .more-link -->
                <?php endif; ?>
            </div><!-- .entry-container -->
        </article>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
</div>   