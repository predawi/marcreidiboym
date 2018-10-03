<?php
/**
 * Baroque functions and definitions
 *
 * @package Baroque
 */


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @since  1.0
 *
 * @return void
 */
function baroque_setup() {
	// Sets the content width in pixels, based on the theme's design and stylesheet.
	$GLOBALS['content_width'] = apply_filters( 'baroque_content_width', 840 );

	// Make theme available for translation.
	load_theme_textdomain( 'baroque', get_template_directory() . '/lang' );

	// Supports WooCommerce plugin.
	add_theme_support( 'woocommerce' );

	// Theme supports
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'post-formats', array( 'gallery', 'video' ) );
	add_theme_support(
		'html5', array(
			'comment-list',
			'search-form',
			'comment-form',
			'gallery',
		)
	);

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors.
 	 */
	add_editor_style( array( 'css/editor-style.css' ) );

	$image_sizes = baroque_get_option( 'image_sizes_default' );

	if ( in_array( 'blog_classic', $image_sizes ) || in_array( 'portfolio_list', $image_sizes ) ) {
		add_image_size( 'baroque-blog-classic', 1170, 613, true );
	}
	if ( in_array( 'blog_grid', $image_sizes ) ) {
		add_image_size( 'baroque-blog-grid', 592, 424, true );
	}
	if ( in_array( 'blog_list', $image_sizes ) ) {
		add_image_size( 'baroque-blog-list', 1170, 843, true );
	}
	if ( in_array( 'blog_masonry', $image_sizes ) ) {
		add_image_size( 'baroque-blog-masonry-1', 575, 540, true );
		add_image_size( 'baroque-blog-masonry-2', 575, 408, true );
		add_image_size( 'baroque-blog-masonry-3', 575, 699, true );
	}

	// Add image size
	add_image_size( 'baroque-portfolio-single', 1880, 850, true );
	if ( in_array( 'portfolio_single_2', $image_sizes ) ) {
		add_image_size( 'baroque-portfolio-single-2', 1405, 880, true );
	}
	if ( in_array( 'portfolio_carousel', $image_sizes ) || in_array( 'portfolio_masonry', $image_sizes ) || in_array( 'portfolio_metro', $image_sizes ) ) {
		add_image_size( 'baroque-portfolio-carousel', 755, 755, true );
	}

	if ( in_array( 'portfolio_grid_wide', $image_sizes ) ) {
		add_image_size( 'baroque-portfolio-grid-wide', 455, 600, true );
	}
	if ( in_array( 'portfolio_masonry', $image_sizes ) ) {
		add_image_size( 'baroque-portfolio-masonry-2', 455, 723, true );
		add_image_size( 'baroque-portfolio-masonry-3', 455, 248, true );
	}
	if ( in_array( 'portfolio_metro', $image_sizes ) ) {
		add_image_size( 'baroque-portfolio-metro-2', 570, 272, true );
	}

	// Register theme nav menu
	register_nav_menus(
		array(
			'primary'   => esc_html__( 'Primary Menu', 'baroque' ),
			'secondary' => esc_html__( 'Secondary Menu', 'baroque' ),
			'third'     => esc_html__( 'Third Menu', 'baroque' ),
			'primary_2' => esc_html__( 'Primary Menu 2', 'baroque' ),
		)
	);

	new Baroque_WooCommerce;
}

add_action( 'after_setup_theme', 'baroque_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 *
 * @since 1.0
 *
 * @return void
 */
function baroque_register_sidebar() {
	$sidebars = array(
		'blog-sidebar' => esc_html__( 'Blog Sidebar', 'baroque' ),
		'page-sidebar' => esc_html__( 'Page Sidebar', 'baroque' ),
		'shop-sidebar' => esc_html__( 'Shop Sidebar', 'baroque' ),
		'header-info'  => esc_html__( 'Header Content', 'baroque' ),
	);

	// Register sidebars
	foreach ( $sidebars as $id => $name ) {
		register_sidebar(
			array(
				'name'          => $name,
				'id'            => $id,
				'description'   => esc_html__( 'Add widgets here in order to display on pages', 'baroque' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
	}

	// Register footer sidebars
	for ( $i = 1; $i <= 6; $i++ ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer', 'baroque' ) . " $i",
				'id'            => "footer-sidebar-$i",
				'description'   => esc_html__( 'Add widgets here in order to display on footer', 'baroque' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
	}
}

add_action( 'widgets_init', 'baroque_register_sidebar' );

/**
 * Load theme
 */

// Widgets
require get_template_directory() . '/inc/widgets/widgets.php';

// Customizer
require get_template_directory() . '/inc/backend/customizer.php';

// Woocommerce hooks
require get_template_directory() . '/inc/frontend/woocommerce.php';


if ( is_admin() ) {
	require get_template_directory() . '/inc/libs/class-tgm-plugin-activation.php';
	require get_template_directory() . '/inc/backend/plugins.php';
	require get_template_directory() . '/inc/backend/meta-boxes.php';
	require get_template_directory() . '/inc/mega-menu/class-mega-menu.php';
} else {
	// Frontend functions and shortcodes
	require get_template_directory() . '/inc/functions/media.php';
	require get_template_directory() . '/inc/functions/nav.php';
	require get_template_directory() . '/inc/functions/entry.php';
	require get_template_directory() . '/inc/functions/header.php';
	require get_template_directory() . '/inc/functions/comments.php';
	require get_template_directory() . '/inc/functions/options.php';
	require get_template_directory() . '/inc/functions/breadcrumbs.php';

	// Frontend hooks
	require get_template_directory() . '/inc/frontend/layout.php';
	require get_template_directory() . '/inc/frontend/header.php';
	require get_template_directory() . '/inc/frontend/footer.php';
	require get_template_directory() . '/inc/frontend/nav.php';
	require get_template_directory() . '/inc/frontend/entry.php';
	require get_template_directory() . '/inc/mega-menu/class-mega-menu-walker.php';
}
