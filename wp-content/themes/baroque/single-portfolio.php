<?php
/**
 * Template for displaying single projects
 *
 * @package TA Project
 */

get_header();

$portfolio_layout = baroque_get_option( 'single_portfolio_layout' );

if ( get_post_meta( get_the_ID(), 'custom_portfolio_layout', true ) ) {
	$portfolio_layout = get_post_meta( get_the_ID(), 'portfolio_layout', true );
}

$copy = baroque_get_option( 'single_portfolio_copyright' );

?>

<div id="primary" class="content-area <?php baroque_content_columns() ?>">

	<?php
	/*
	 * baroque_single_portfolio_thumb - 10
	 */
	do_action( 'baroque_before_single_portfolio' );
	?>

	<?php if ( $portfolio_layout == '3' ) { ?>
		<div class="fixed-portfolio-info">
			<div class="portfolio-info-wrapper">
				<div class="portfolio-info">
		<?php baroque_single_portfolio_nav(); ?>
	<?php } ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'parts/content-single-portfolio' ); ?>

		<?php
		// If comments are open or we have at least one comment, load up the comment template
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
		?>

	<?php endwhile; ?>

	<?php
	if ( $portfolio_layout == '1' || $portfolio_layout == '4' ) {
		baroque_single_portfolio_nav();
	}
	?>

	<?php if ( $portfolio_layout == '3' ) { ?>
					<div class="portfolio-copy">
						<?php echo do_shortcode( wp_kses( $copy, wp_kses_allowed_html('post') ) ); ?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

	<!-- #content -->
</div><!-- #primary -->
<?php get_footer(); ?>
