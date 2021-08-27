<?php
// Get each of our panels and show the post data.
if ( 0 !== twentyseventeen_panel_count() || is_customize_preview() ) : // If we have pages to show.

	/**
	 * Filter number of front page sections in Twenty Seventeen.
	 *
	 * @since Twenty Seventeen 1.0
	 *
	 * @param $num_sections integer
	 */
	$num_sections = apply_filters( 'twentyseventeen_front_page_sections', 4 );
	$twentyseventeencounter = 0;

	// Create a setting and control for each of the sections available in the theme.
	for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
		$twentyseventeencounter = $i;

		/**
		 * The following function has been copied from /themes/twentyseventeen/inc/template-tags.php
		 */
		//twentyseventeen_front_page_section( null, $i );

		// Starts - twentyseventeen_front_page_section()
		$partial = null;
		$id = $i;

		if ( is_a( $partial, 'WP_Customize_Partial' ) ) {
			// Find out the id and set it up during a selective refresh.
			global $twentyseventeencounter;
			$id = str_replace( 'panel_', '', $partial->id );
			$twentyseventeencounter = $id;
		}

		global $post; // Modify the global post object before setting up post data.
		if ( get_theme_mod( 'panel_' . $id ) ) {
			global $post;
			$post = get_post( get_theme_mod( 'panel_' . $id ) );
			setup_postdata( $post );
			set_query_var( 'panel', $id );
			/**
			 * Following template part has been copied from
			 * /themes/twentyseventeen/template-parts/page/content-front-page-panels.php
			 */
			//get_template_part( 'template-parts/page/content', 'front-page-panels' );

			// Starts - content-front-page-panels
?>
			<article id="panel<?php echo $twentyseventeencounter; ?>" <?php post_class( 'twentyseventeen-panel ' ); ?> >

				<?php if ( has_post_thumbnail() ) :
					$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'twentyseventeen-featured-image' );

					// Calculate aspect ratio: h / w * 100%.
					$ratio = $thumbnail[2] / $thumbnail[1] * 100;
					?>

					<div class="panel-image" style="background-image: url(<?php echo esc_url( $thumbnail[0] ); ?>);">
						<div class="panel-image-prop" style="padding-top: <?php echo esc_attr( $ratio ); ?>%"></div>
					</div><!-- .panel-image -->

				<?php endif; ?>

				<div class="panel-content">
					<div class="wrap">
						<header class="entry-header">
							<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>

							<?php twentyseventeen_edit_link( get_the_ID() ); ?>

						</header><!-- .entry-header -->

						<div class="entry-content">
							<?php
							/* translators: %s: Name of current post */
							/*the_content( sprintf(
								__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ),
								get_the_title()
							) );*/

							/*echo apply_filters( 'the_content', get_the_content( sprintf(
								__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ),
								get_the_title()
							) ) );*/

							echo apply_filters( 'the_content', $post->post_content );
							?>
						</div><!-- .entry-content -->

						<?php
						// Show recent blog posts if is blog posts page (Note that get_option returns a string, so we're casting the result as an int).
						if ( get_the_ID() === (int) get_option( 'page_for_posts' )  ) : ?>

							<?php // Show four most recent posts.
							$recent_posts = new WP_Query( array(
								'posts_per_page'      => 3,
								'post_status'         => 'publish',
								'ignore_sticky_posts' => true,
								'no_found_rows'       => true,
							) );
							?>

							<?php if ( $recent_posts->have_posts() ) : ?>

								<div class="recent-posts">

									<?php
									while ( $recent_posts->have_posts() ) : $recent_posts->the_post();
										get_template_part( 'template-parts/post/content', 'excerpt' );
									endwhile;
									wp_reset_postdata();
									?>
								</div><!-- .recent-posts -->
							<?php endif; ?>
						<?php endif; ?>

					</div><!-- .wrap -->
				</div><!-- .panel-content -->

			</article><!-- #post-## -->
<?php
			// Ends - content-front-page-panels

			wp_reset_postdata();
		} elseif ( is_customize_preview() ) {
			// The output placeholder anchor.
			echo '<article class="panel-placeholder panel twentyseventeen-panel twentyseventeen-panel' . $id . '" id="panel' . $id . '"><span class="twentyseventeen-panel-title">' . sprintf( __( 'Front Page Section %1$s Placeholder', 'twentyseventeen' ), $id ) . '</span></article>';
		}
		// Ends - twentyseventeen_front_page_section()
	}

endif; // The if ( 0 !== twentyseventeen_panel_count() ) ends here. ?>