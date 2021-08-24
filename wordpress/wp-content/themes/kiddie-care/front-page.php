<?php
/**
 * The template for displaying home page.
 * @package Kiddie Care
 */

if ( 'posts' != get_option( 'show_on_front' ) || 'posts' == get_option( 'show_on_front' ) ){ 
    get_header(); ?>
    <?php $enabled_sections = kiddie_care_get_sections();
    if( 'posts' != get_option( 'show_on_front' ) && is_array( $enabled_sections ) ) {
        foreach( $enabled_sections as $section ) {
            $cloud_enable = kiddie_care_get_option('disable_homepage_cloud_section');
            if( ( $section['id'] == 'featured-slider' ) ){ ?>
                <?php $disable_featured_slider = kiddie_care_get_option( 'disable_featured-slider_section' );
                if( true == $disable_featured_slider): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>">
                        <?php get_template_part( 'inc/sections/section', esc_attr( $section['id'] ) ); ?>
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/team-cloud.png' ) ?>" class="cloud-bg">
                    </section>
            <?php endif; ?>

            <?php } elseif( $section['id'] == 'services' ) { ?>
                <?php $disable_services_section = kiddie_care_get_option( 'disable_services_section' );
                if( true ==$disable_services_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" class="page-section relative">
                        <div class="cloud-down">
                            <?php kiddie_care_svg_cloud(); ?>
                        </div>
                        <div class="services-wrapper">
                            <div class="wrapper">
                                <?php get_template_part( 'inc/sections/section', esc_attr( $section['id'] ) ); ?> 
                            </div>
                        </div>
                    </section>
            <?php endif; ?>

            <?php } elseif( $section['id'] == 'about' ) { ?>
                <?php $disable_about_section = kiddie_care_get_option( 'disable_about_section' );
                if( true ==$disable_about_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" class="page-section relative">
                        
                        <div class="wrapper">
                            <?php get_template_part( 'inc/sections/section', esc_attr( $section['id'] ) ); ?>  
                        </div>
                    </section>
            <?php endif; ?>

        <?php } elseif( $section['id'] == 'cta' ) { ?>
                <?php $disable_cta_section = kiddie_care_get_option( 'disable_cta_section' );
                $background_cta_section = kiddie_care_get_option( 'background_cta_section' );
                if( true ==$disable_cta_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" style="background-image: url('<?php echo esc_url( $background_cta_section );?>');">
                        <div class="overlay"></div>
                        <div class="cloud-down">
                            <?php kiddie_care_svg_curve(); ?>
                        </div>
                        <div class="wrapper">
                            <?php get_template_part( 'inc/sections/section', esc_attr( $section['id'] ) ); ?>
                        </div>
                        <div class="cloud-up">
                            <?php kiddie_care_svg_cloud(); ?>
                        </div>
                    </section>
            <?php endif; ?>

             <?php } elseif( $section['id'] == 'course' ) { ?>
                <?php $disable_course_section = kiddie_care_get_option( 'disable_course_section' );
                if( true ==$disable_course_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" class=" relative">
                        <?php get_template_part( 'inc/sections/section', esc_attr( $section['id'] ) ); ?>  
                        <div class="cloud-up">
                            <?php kiddie_care_svg_cloud(); ?>
                        </div>
                    </section>
            <?php endif; ?>           


            <?php } elseif( $section['id'] == 'team' ) { ?>
            <?php $disable_team_section = kiddie_care_get_option( 'disable_team_section' );
            if( true ==$disable_team_section): ?>
                <section id="<?php echo esc_attr( $section['id'] ); ?>" class="page-section clear">
                    <?php get_template_part( 'inc/sections/section', esc_attr( $section['id'] ) ); ?>
                </section>
            <?php endif; ?>

            <?php } elseif( $section['id'] == 'gallery' ) { ?>
                <?php $disable_gallery_section = kiddie_care_get_option( 'disable_gallery_section' );
                if( true ==$disable_gallery_section): ?>
                    
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" class="page-section clear">
                        <div class="cloud-down">
                            <?php kiddie_care_svg_curve(); ?>
                        </div>
                        <?php get_template_part( 'inc/sections/section', esc_attr( $section['id'] ) ); ?>
                    </section>
            <?php endif; ?>

           <?php } elseif ( $section['id'] == 'blog' ) { ?>
                <?php $disable_blog_section = kiddie_care_get_option( 'disable_blog_section' );
                if( true === $disable_blog_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" class="relative page-section">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/cloud-up.png' ) ?>" class="cloud-shape">
                        <div class="wrapper">
                            <?php get_template_part( 'inc/sections/section', esc_attr( $section['id'] ) ); ?>
                        </div>
                        <div class="cloud-down">
                            <?php kiddie_care_svg_curve(); ?>
                        </div>
                    </section>
                <?php endif;                 
            }
        }
    }
    $disable_homepage_content_section = kiddie_care_get_option( 'disable_homepage_content_section' );
    if('posts' == get_option( 'show_on_front' )){ ?>
        <div class="wrapper">
       <?php include( get_home_template() ); ?>
        </div>
    <?php } elseif(($disable_homepage_content_section == true ) && ('posts' != get_option( 'show_on_front' ))) { ?>
        <div class="wrapper">
           <?php include( get_page_template() ); ?>
        <div class="wrapper">
     <?php  }
    get_footer();
} 
