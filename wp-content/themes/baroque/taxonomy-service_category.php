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

?>

<div id="primary" class="content-area <?php baroque_content_columns(); ?>">

	<?php do_action( 'baroque_service_category_content_before' ); ?>

	<?php if ( have_posts() ) : ?>

		<?php /* Start the Loop */ ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php
			/* Include the Post-Format-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
			 */
			get_template_part( 'parts/content', 'service' );
			?>

		<?php endwhile; ?>

		<?php baroque_numeric_pagination(); ?>

	<?php else : ?>

		<?php get_template_part( 'parts/content', 'none' ); ?>

	<?php endif; ?>

	<?php do_action( 'baroque_service_category_content_after' ); ?>

</div><!-- #primary -->

<?php get_footer(); ?>

