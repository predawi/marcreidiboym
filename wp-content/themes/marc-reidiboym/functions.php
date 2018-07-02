<?php
add_action( 'wp_enqueue_scripts', 'baroque_child_enqueue_scripts', 50 );

function baroque_child_enqueue_scripts() {
	wp_enqueue_style( 'baroque-child-style', get_stylesheet_uri() );
	wp_enqueue_script( 'wow', get_stylesheet_directory_uri() . '/assets/js/vendor/wow.min.js', array ( 'jquery' ), 1.1, true);
	wp_enqueue_script( 'script', get_stylesheet_directory_uri() . '/assets/js/scripts-domready.js', array ( 'jquery' ), 1.0, true);

	if ( is_rtl() ) {
		wp_enqueue_style( 'baroque-rtl', get_template_directory_uri() . '/rtl.css', array(), '20180418' );
	}
}

