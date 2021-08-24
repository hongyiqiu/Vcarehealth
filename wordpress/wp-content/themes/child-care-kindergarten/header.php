<?php
/**
 * The header for our theme
 *
 * @subpackage Child Care Kindergarten
 * @since 1.0
 * @version 0.1
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
} else {
    do_action( 'wp_body_open' );
}?>

<a class="screen-reader-text skip-link" href="#skip-content"><?php esc_html_e( 'Skip to content', 'child-care-kindergarten' ); ?></a>

<div id="header">
	<div class="container">
		<div class="row">
			<div class="col-lg-2 col-md-12 logo px-md-0">
				<div class="inner-logo">
					<?php if ( has_custom_logo() ) : ?>
	            		<?php the_custom_logo(); ?>
		            <?php endif; ?>
	             	<?php if (get_theme_mod('child_care_kindergarten_show_site_title',true)) {?>
	          			<?php $blog_info = get_bloginfo( 'name' ); ?>
		                <?php if ( ! empty( $blog_info ) ) : ?>
		                  	<?php if ( is_front_page() && is_home() ) : ?>
		                    	<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		                  	<?php else : ?>
	                      		<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
	                  		<?php endif; ?>
		                <?php endif; ?>
		            <?php }?>
		            <?php if (get_theme_mod('child_care_kindergarten_show_tagline',true)) {?>
		                <?php
	                  		$description = get_bloginfo( 'description', 'display' );
		                  	if ( $description || is_customize_preview() ) :
		                ?>
	                  	<p class="site-description">
	                    	<?php echo esc_attr($description); ?>
	                  	</p>
	              		<?php endif; ?>
	          		<?php }?>
				</div>
			</div>
			<div class="col-lg-9 col-md-12 pl-lg-0">
				<div class="top-header py-2">
					<div class="row mx-md-0">
						<div class="col-lg-3 col-md-4">
							<?php if(get_theme_mod('child_care_kindergarten_topheader_phone_no')) {?>
								<a href="tel:<?php echo esc_attr(get_theme_mod('child_care_kindergarten_topheader_phone_no')); ?>"><p class="callno mb-0 text-md-left text-center"><i class="fas fa-phone"></i><?php echo esc_html(get_theme_mod('child_care_kindergarten_topheader_phone_no')); ?></p><span class="screen-reader-text"><?php echo esc_html(get_theme_mod('child_care_kindergarten_topheader_phone_no')); ?></span></a>
							<?php }?>
						</div>
						<div class="col-lg-3 col-md-4 pl-md-0">
							<?php if(get_theme_mod('child_care_kindergarten_topheader_mail')) {?>
								<a href="mailto:<?php echo esc_attr(get_theme_mod('child_care_kindergarten_topheader_mail')); ?>"><p class="mail mb-0 text-md-left text-center"><i class="far fa-envelope"></i><?php echo esc_html(get_theme_mod('child_care_kindergarten_topheader_mail')); ?></p><span class="screen-reader-text"><?php echo esc_html(get_theme_mod('child_care_kindergarten_topheader_mail')); ?></span></a>
							<?php }?>
						</div>
						<div class="col-lg-6 col-md-4">
							<div class="header-search text-md-right text-center">
					        	<?php get_search_form(); ?>
				        	</div>
						</div>
					</div>
				</div>
				<div class="menu-section py-2">
					<div class="row">
						<div class="col-lg-9 col-md-9 col-3">
							<div class="toggle-menu responsive-menu">
								<?php if(has_nav_menu('primary')){ ?>
					            	<button onclick="child_care_kindergarten_open()" role="tab" class="mobile-menu"><i class="fas fa-bars"></i><span class="screen-reader-text"><?php esc_html_e('Open Menu','child-care-kindergarten'); ?></span></button>
					            <?php }?>
					        </div>
							<div id="sidelong-menu" class="nav sidenav">
				                <nav id="primary-site-navigation" class="nav-menu" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'child-care-kindergarten' ); ?>">
				                  	<?php if(has_nav_menu('primary')){
					                    wp_nav_menu( array( 
											'theme_location' => 'primary',
											'container_class' => 'main-menu-navigation clearfix' ,
											'menu_class' => 'clearfix',
											'items_wrap' => '<ul id="%1$s" class="%2$s mobile_nav">%3$s</ul>',
											'fallback_cb' => 'wp_page_menu',
					                    ) ); 
				                  	} ?>
				                  	<a href="javascript:void(0)" class="closebtn responsive-menu" onclick="child_care_kindergarten_close()"><i class="fas fa-times"></i><span class="screen-reader-text"><?php esc_html_e('Close Menu','child-care-kindergarten'); ?></span></a>
				                </nav>
				            </div>
						</div>
						<div class="col-lg-3 col-md-3 col-9">
							<div class="social-icons text-right my-2">
								<?php if(get_theme_mod('child_care_kindergarten_topheader_twitter_url')) {?>
									<a href="<?php echo esc_url(get_theme_mod('child_care_kindergarten_topheader_twitter_url')); ?>" class="mr-2"><i class="fab fa-twitter"></i><span class="screen-reader-text"><?php echo esc_html('Twitter', 'child-care-kindergarten'); ?></span></a>
								<?php }?>
								<?php if(get_theme_mod('child_care_kindergarten_topheader_facebook_url')) {?>
									<a href="<?php echo esc_url(get_theme_mod('child_care_kindergarten_topheader_facebook_url')); ?>" class="mr-2"><i class="fab fa-facebook-f"></i><span class="screen-reader-text"><?php echo esc_html('Facebook', 'child-care-kindergarten'); ?></span></a>
								<?php }?>
								<?php if(get_theme_mod('child_care_kindergarten_topheader_instagram_url')) {?>
									<a href="<?php echo esc_url(get_theme_mod('child_care_kindergarten_topheader_instagram_url')); ?>"><i class="fab fa-instagram"></i><span class="screen-reader-text"><?php echo esc_html('Instagram', 'child-care-kindergarten'); ?></span></a>
								<?php }?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>