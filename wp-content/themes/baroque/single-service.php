<?php
/**
 * Template for displaying single services
 *
 * @package Services
 */

get_header();
?>

<div id="primary" class="content-area <?php baroque_content_columns(); ?>">
	<?php while ( have_posts() ) : the_post(); ?>

		<?php
		do_action( 'baroque_single_service_before' );
		?>

		<div <?php post_class() ?>>
			<?php the_content(); ?>
		</div>

		<?php
		do_action( 'baroque_single_service_after' );
		?>

		<?php
		// If comments are open or we have at least one comment, load up the comment template
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
		?>

		<?php baroque_single_service_nav(); ?>

	<?php endwhile; ?>
</div><!-- #primary -->
<?php get_footer(); ?>
