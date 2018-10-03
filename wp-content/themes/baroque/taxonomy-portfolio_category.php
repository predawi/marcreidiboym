<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Baroque
 */

get_header();

$p_style = baroque_get_option( 'portfolio_style' );
$css = 'list-portfolio';

if ( $p_style == 'grid' ) {
	$css .= ' row';
}

?>

<div id="primary" class="content-area all-project <?php baroque_content_columns(); ?>">
	<main id="main" class="site-main">

		<?php
		/*
		 *	baroque_portfolio_taxes_list - 10
		 * 	baroque_open_wrapper_portfolio_carousel - 15
		 *  baroque_open_frame_portfolio_carousel - 20
		 */
		do_action( 'baroque_before_archive_portfolio_content' );

		?>

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>

			<?php if ( $p_style != 'carousel' ) : ?>
				<div class="ba-portfolio-content">
					<div class="ba-portfolio-loading">
						<span class="loading-icon">
							<span class="bubble"><span class="dot"></span></span>
							<span class="bubble"><span class="dot"></span></span>
							<span class="bubble"><span class="dot"></span></span>
						</span>
					</div>
			<?php endif; ?>

			<div class="<?php echo esc_attr( $css ) ?>">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php
				/* Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'parts/content', 'portfolio' );
				?>

			<?php endwhile; ?>
			</div>
			<?php
			/*
			 *  baroque_close_frame_portfolio_carousel - 10
			 * 	baroque_option_portfolio_carousel - 20
			 * 	baroque_close_wrapper_portfolio_carousel - 50
			 */
			do_action( 'baroque_after_archive_portfolio_content' );
			?>

			<?php baroque_numeric_pagination(); ?>

		<?php if ( $p_style != 'carousel' ) : ?>
			</div>
		<?php endif; ?>

		<?php else : ?>

			<?php get_template_part( 'parts/content', 'none' ); ?>

		<?php endif; ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
