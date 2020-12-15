<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Baroque
 */

get_header();

$img = baroque_get_option( 'not_found_img' );

if ( ! $img ) {
	$img = get_template_directory_uri() . '/img/bg-404.jpg';
}

?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">

		<section class="error-404 not-found">
			<div class="page-content col-md-12 col-xs-12 col-sm-12">
				<?php printf( '<img src="%s" alt="%s">', esc_url( $img ), esc_attr__( 'page not found', 'baroque' ) ); ?>

				<h3 class="page-title"><?php esc_html_e( 'ohh! page not found', 'baroque' ); ?></h3>

				<p>
					<?php esc_html_e( "It seems we can't find what you're looking for. Perhaps searching can help or go back to ", 'baroque' ); ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Homepage', 'baroque' ); ?></a>
				</p>

				<?php get_search_form(); ?>

			</div>
			<!-- .page-content -->
		</section>
		<!-- .error-404 -->

	</main>
	<!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
