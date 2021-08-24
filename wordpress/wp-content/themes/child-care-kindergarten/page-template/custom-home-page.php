<?php
/**
 * Template Name: Custom Home
 */

get_header(); ?>

<main id="skip-content" role="main">

	<?php do_action( 'child_care_kindergarten_above_slider' ); ?>

	<?php if( get_theme_mod('child_care_kindergarten_slider_hide_show') != ''){ ?>
		<section id="slider">
          	<svg viewBox="0 0 147.19 145.45" class="slider-svg1"><defs><style>.cls-2{fill:#af78e6;}</style></defs><g id="Layer_2" data-name="Layer 2"><circle class="cls-2" cx="15" cy="15" r="15"/></g></svg>
          	<svg viewBox="0 0 147.19 145.45" class="slider-svg2"><defs><style>.cls-2{fill:#af78e6;}</style></defs><g id="Layer_2" data-name="Layer 2"><circle class="cls-2" cx="15" cy="15" r="15"/></g></svg>
			<div id="carouselExampleIndicators" class="carousel" data-ride="carousel"> 
			    <?php $child_care_kindergarten_slider_pages = array();
			    for ( $count = 1; $count <= 4; $count++ ) {
			        $mod = intval( get_theme_mod( 'child_care_kindergarten_slider'. $count ));
			        if ( 'page-none-selected' != $mod ) {
			          $child_care_kindergarten_slider_pages[] = $mod;
			        }
			    }
		      	if( !empty($child_care_kindergarten_slider_pages) ) :
			        $args = array(
			          	'post_type' => 'page',
			          	'post__in' => $child_care_kindergarten_slider_pages,
			          	'orderby' => 'post__in'
			        );
		        	$query = new WP_Query( $args );
		        if ( $query->have_posts() ) :
		          	$i = 1;
		    	?>     
			    <div class="carousel-inner" role="listbox">
			      	<?php  while ( $query->have_posts() ) : $query->the_post(); ?>
			        <div <?php if($i == 1){echo 'class="carousel-item fade-in-image active"';} else{ echo 'class="carousel-item fade-in-image"';}?>>
			        	<div class="row">
			        		<div class="col-lg-6 col-md-6">
					            <div class="inner-carousel">
					              	<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					              	<p><?php $child_care_kindergarten_excerpt = get_the_excerpt(); echo esc_html( child_care_kindergarten_string_limit_words( $child_care_kindergarten_excerpt,20 ) ); ?></p>
					              	<a href="<?php the_permalink(); ?>" class="read-btn"><?php esc_html_e('Read More','child-care-kindergarten'); ?><span class="screen-reader-text"><?php esc_html_e('Read More','child-care-kindergarten'); ?></span></a>
					              	<svg viewBox="0 0 147.19 145.45" class="slider-svg3"><defs><style>.cls-2{fill:#af78e6;}</style></defs><g id="Layer_2" data-name="Layer 2"><circle class="cls-2" cx="30" cy="30" r="30"/></g></svg>
			            		</div>
			            	</div>
			            	<div class="col-lg-6 col-md-6">
				        		<div class="slider-bg"></div>
			            		<div class="slider-img">
		            				<img src="<?php esc_url(the_post_thumbnail_url('full')); ?>" alt="<?php the_title_attribute(); ?> "/>
		            			</div>
		            		</div>
		            	</div>
			        </div>
			      	<?php $i++; endwhile; 
			      	wp_reset_postdata();?>
			    </div>
			    <?php else : ?>
			    <div class="no-postfound"></div>
		      		<?php endif;
			    endif;?>
			    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
			      	<span class="carousel-control-prev-icon" aria-hidden="true"><i class="fas fa-arrow-left"></i></span>
			      	<span class="screen-reader-text"><?php esc_html_e( 'Prev','child-care-kindergarten' );?></span>
			    </a>
			    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
			      	<span class="carousel-control-next-icon" aria-hidden="true"><i class="fas fa-arrow-right"></i></span>
			      	<span class="screen-reader-text"><?php esc_html_e( 'Next','child-care-kindergarten' );?></span>
			    </a>
			</div>
		  	<div class="clearfix"></div>
		</section>
	<?php }?>

	<?php do_action('child_care_kindergarten_below_slider'); ?>

	<?php if( get_theme_mod('child_care_kindergarten_feature_category') != '' || get_theme_mod('child_care_kindergarten_feature_section_title') != ''){ ?>
		<section id="feature-section">
			<div class="container">
				<div class="feature-head text-center">
					<?php if(get_theme_mod('child_care_kindergarten_feature_section_title')) {?>
						<h3><?php echo esc_html(get_theme_mod('child_care_kindergarten_feature_section_title')); ?></h3>
						<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/title-border.png" class="title-design" alt="<?php echo esc_html('Title Border image', 'child-care-kindergarten'); ?> "/>
					<?php }?>
				</div>
	            <div class="row">
		      		<?php $child_care_kindergarten_catData1 =  get_theme_mod('child_care_kindergarten_feature_category');
	  				if($child_care_kindergarten_catData1){ 
						$args = array(
							'post_type' => 'post',
							'category_name' => esc_html($child_care_kindergarten_catData1 ,'child-care-kindergarten'),
				          'posts_per_page' => get_theme_mod('child_care_kindergarten_feature_number', 4)
				        );
				        $i=1;
				        $page_query = new WP_Query( $args);?>
		        		<?php while( $page_query->have_posts() ) : $page_query->the_post(); ?>	
		          			<div class="col-lg-6 col-md-6">
		          				<div class="feature-box <?php if($i % 2 == 0) {?> right <?php }?>  row">
	          						<div class="<?php if($i % 2 == 0) {?> order-md-2 <?php }?> col-lg-9 col-md-8">
				      					<div class="feature-content">
						            		<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
						            		<p><?php $child_care_kindergarten_excerpt = get_the_excerpt(); echo esc_html( child_care_kindergarten_string_limit_words( $child_care_kindergarten_excerpt,15 ) ); ?></p>
						            	</div>
						            </div>
		          					<div class="<?php if($i % 2 == 0) {?> order-md-1 <?php }?> col-lg-3 col-md-4">
		          						<div class="feature-icon">
	          								<i class="<?php echo esc_attr(get_theme_mod('child_care_kindergarten_feature_icon' . $i, 'fas fa-heart')); ?>"></i>
	          							</div>
	          						</div>
		          				</div>
						    </div>
		          		<?php $i++; endwhile; 
		          		wp_reset_postdata();
		      		}?>
	      		</div>
				<div class="clearfix"></div>
			</div>
		</section>
	<?php }?>

	<?php do_action('child_care_kindergarten_below_service_section'); ?>

	<div class="container">
	  	<?php while ( have_posts() ) : the_post(); ?>
	  		<div class="lz-content">
	        	<?php the_content(); ?>
	        </div>
	    <?php endwhile; // end of the loop. ?>
	</div>
</main>

<?php get_footer(); ?>