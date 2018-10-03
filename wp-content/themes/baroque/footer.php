<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Baroque
 */
?>
	<?php
	/*
	 *  baroque_site_content_close - 100
	 */
	do_action( 'baroque_site_content_close' );
	?>
</div><!-- #content -->

	<?php
	/*
	 * baroque_footer_newsletter - 10
	 */
	do_action( 'baroque_before_footer' );
	?>

	<footer id="colophon" class="site-footer">
		<?php do_action( 'baroque_footer' ) ?>
	</footer><!-- #colophon -->

	<?php do_action( 'baroque_after_footer' ) ?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
