<?php
add_action( 'wp_enqueue_scripts', 'baroque_child_enqueue_scripts', 50 );

function baroque_child_enqueue_scripts() {
	wp_enqueue_style( 'baroque-child-style', get_stylesheet_uri() );

	if ( is_rtl() ) {
		wp_enqueue_style( 'baroque-rtl', get_template_directory_uri() . '/rtl.css', array(), '20180418' );
	}
}

