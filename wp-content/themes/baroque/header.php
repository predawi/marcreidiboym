<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Baroque
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">

	<?php do_action( 'baroque_before_header' ); ?>

	<header id="masthead" class="site-header">
		<?php do_action( 'baroque_header' ); ?>
	</header><!-- #masthead -->

	<?php
	/*
	 *  baroque_page_header - 10
	 *  baroque_blog_featured - 20
	 */
	do_action( 'baroque_after_header' );
	?>

	<div id="content" class="site-content">
		<?php
		/*
		 *	baroque_single_post_format - 10
		 *  baroque_site_content_open - 20
		 *
		 */
		do_action( 'baroque_site_content_open' );
		?>
