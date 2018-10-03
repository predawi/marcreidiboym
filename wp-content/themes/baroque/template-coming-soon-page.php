<?php
/**
 * Template Name: Coming Soon Page
 *
 * The template file for displaying Coming Soon page.
 *
 * @package Baroque
 */

get_header(); ?>

<?php
if ( have_posts() ) :
	while ( have_posts() ) : the_post();
		the_content();
	endwhile;

endif;
?>
<?php
do_action( 'baroque_coming_soon_page_content' );
?>

<?php get_footer(); ?>
