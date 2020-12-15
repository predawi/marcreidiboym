<?php

/**

 * Custom functions for nav menu

 *

 * @package Baroque

 */





/**

 * Display numeric pagination

 *

 * @since 1.0

 * @return void

 */

function baroque_numeric_pagination() {

	global $wp_query;



	if( $wp_query->max_num_pages < 2 ) {

        return;

	}



	$type_nav  = baroque_get_option( 'portfolio_type_nav' );

	$p_style = baroque_get_option( 'portfolio_style' );

	$view_more = apply_filters( 'baroque_portfolio_view_more_text', esc_html__( 'MORE', 'baroque' ) );



	$next_html = sprintf(

		'<span id="baroque-portfolio-previous-ajax" class="nav-previous-ajax">

			<span class="nav-text">%s</span>

			<span class="loading-icon">

				<span class="bubble">

					<span class="dot"></span>

				</span>

				<span class="bubble">

					<span class="dot"></span>

				</span>

				<span class="bubble">

					<span class="dot"></span>

				</span>

			</span>

		</span>',

		$view_more

	);



	$blog_view = baroque_get_option( 'blog_style' );

	$css = '';



	if ( baroque_is_blog() && $blog_view == 'text' ) {

		$css = 'col-md-8 col-md-offset-4 col-sm-12 col-xs-12';

	}



	if ( $type_nav == 'view_more' && baroque_is_portfolio() ) {

		$css = 'portfolio-nav-ajax';

	}



	?>

	<nav class="navigation paging-navigation numeric-navigation <?php echo esc_attr( $css ) ?>">

		<?php

		$big = 999999999;

		$args = array(

			'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),

			'total'     => $wp_query->max_num_pages,

			'current'   => max( 1, get_query_var( 'paged' ) ),

			'prev_text' => '<i class="ion-ios-arrow-left"></i>',

			'next_text' => '<i class="ion-ios-arrow-right"></i>',

			'type'      => 'plain',

		);



		if ( baroque_is_portfolio() && $p_style != 'carousel' && $type_nav == 'view_more' ) {

			$args['prev_text'] = '';

			$args['next_text'] = $next_html;

		}



		echo paginate_links( $args );

		?>

	</nav>

<?php

}



/**

 * Display navigation to next/previous set of posts when applicable.

 *

 * @since 1.0

 * @return void

 */

function baroque_paging_nav() {

	// Don't print empty markup if there's only one page.

	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {

		return;

	}

	$css = '';

	$type_nav  = baroque_get_option( 'type_nav' );

	$blog_view = baroque_get_option( 'blog_style' );

	$style  = baroque_get_option( 'view_more_style' );

	$view_more = wp_kses( baroque_get_option( 'view_more_text' ), wp_kses_allowed_html( 'post' ) );



	if ( $type_nav == 'view_more' ) {

		$css .= ' blog-view-more style-' . $style;

	}



	?>

	<nav class="navigation paging-navigation <?php echo esc_attr( $css ); ?>">

		<div class="nav-links">



			<?php if ( get_next_posts_link() ) : ?>

				<?php if ( $type_nav == 'view_more' ) : ?>

					<div id="baroque-blog-previous-ajax" class="nav-previous-ajax">

						<?php next_posts_link( sprintf( '%s', $view_more ) ); ?>

						<span class="loading-icon">

							<span class="bubble">

								<span class="dot"></span>

							</span>

							<span class="bubble">

								<span class="dot"></span>

							</span>

							<span class="bubble">

								<span class="dot"></span>

							</span>

						</span>

					</div>

				<?php else : ?>

					<div class="nav-previous"><?php next_posts_link( sprintf( '<span class="meta-nav"><i class="icon-arrow-left"></i> </span> %s', esc_html__( 'Older posts', 'baroque' ) ) ); ?></div>

				<?php endif; ?>



			<?php endif; ?>



			<?php if ( get_previous_posts_link() ) : ?>

				<?php if ( $type_nav != 'view_more'  ) : ?>

					<div class="nav-next"><?php previous_posts_link( sprintf( '%s <span class="meta-nav"><i class="icon-arrow-right"></i></span>', esc_html__( 'Newer posts', 'baroque' ) ) ); ?></div>

				<?php endif; ?>

			<?php endif; ?>



		</div><!-- .nav-links -->

	</nav><!-- .navigation -->

<?php

}



/**

 * Display navigation to next/previous post when applicable.

 *

 * @since 1.0

 * @return void

 */

function baroque_post_nav() {

	// Don't print empty markup if there's nowhere to navigate.

	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );

	$next     = get_adjacent_post( false, '', false );



	if ( ! $next && ! $previous ) {

		return;

	}

	?>

	<nav class="navigation post-navigation">

		<div class="nav-links">

			<?php

			previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav"><i class="fa fa-chevron-left" aria-hidden="true"></i></span>' . esc_html__( 'Prev', 'baroque' ), 'Previous post link', 'baroque' ) );

			next_post_link(     '<div class="nav-next">%link</div>',     _x( esc_html__( 'Next', 'baroque' ) . '<span class="meta-nav"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>', 'Next post link', 'baroque' ) );

			?>

		</div><!-- .nav-links -->

	</nav><!-- .navigation -->

<?php

}







function baroque_single_portfolio_nav() {

	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );

	$next     = get_adjacent_post( false, '', false );



	if ( ! $next && ! $previous ) {

		return;

	}



	$next_icon = '<span>' . esc_html__( 'Suivant', 'baroque' ) . '</span><i class="icon-arrow-right"></i>';

	$prev_icon = '<i class="icon-arrow-left"></i><span>' . esc_html__( 'Précédent', 'baroque' ) . '</span>';



	$portfolio_layout = baroque_get_option( 'single_portfolio_layout' );



	if ( get_post_meta( get_the_ID(), 'custom_portfolio_layout', true ) ) {

		$portfolio_layout = get_post_meta( get_the_ID(), 'portfolio_layout', true );

	}



	if ( $portfolio_layout == '3' ) {

		$next_icon = '<i class="icon-chevron-right"></i>';

		$prev_icon = '<i class="icon-chevron-left"></i>';

	}



	$url = get_post_type_archive_link( 'portfolio' );

	$text = esc_html__('Tous les projets', 'baroque');



	if ( ! empty(baroque_get_option( 'single_portfolio_nav_url' )) ) {

		$url = baroque_get_option( 'single_portfolio_nav_url' );

	}



	if ( ! empty(baroque_get_option( 'single_portfolio_nav_text' )) ) {

		$text = baroque_get_option( 'single_portfolio_nav_text' );

	}



	?>

	<nav class="navigation portfolio-navigation">

		<div class="container">

			<div class="nav-links">

				<div class="nav-previous">

				<?php previous_post_link( '%link', $prev_icon ); ?>

				</div>



				<a class="portfolio-link" href="<?php echo esc_url( $url ); ?>"><?php echo '' . $text; ?></a>



				<div class="nav-next">

				<?php next_post_link( '%link', $next_icon ); ?>

				</div>

			</div><!-- .nav-links -->

		</div>

	</nav><!-- .navigation -->

	<?php

}



function baroque_single_service_nav() {

	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );

	$next     = get_adjacent_post( false, '', false );



	if ( ! $next && ! $previous ) {

		return;

	}



	$next_icon = '<span>' . esc_html__( 'Suivant', 'baroque' ) . '</span><i class="icon-arrow-right"></i>';

	$prev_icon = '<i class="icon-arrow-left"></i><span>' . esc_html__( 'Précédent', 'baroque' ) . '</span>';



	$url = get_post_type_archive_link( 'service' );

	$text = esc_html__('All Services', 'baroque');



	if ( ! empty(baroque_get_option( 'single_service_nav_url' )) ) {

		$url = baroque_get_option( 'single_service_nav_url' );

	}



	if ( ! empty(baroque_get_option( 'single_service_nav_text' )) ) {

		$text = baroque_get_option( 'single_service_nav_text' );

	}



	?>

	<nav class="navigation service-navigation">

		<div class="container">

			<div class="nav-links">

				<div class="nav-previous">

					<?php previous_post_link( '%link', $prev_icon ); ?>

				</div>



				<a class="portfolio-link" href="<?php echo esc_url( $url ); ?>"><?php echo '' . $text; ?></a>



				<div class="nav-next">

					<?php next_post_link( '%link', $next_icon ); ?>

				</div>

			</div><!-- .nav-links -->

		</div>

	</nav><!-- .navigation -->

	<?php

}