<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Baroque
 */
if ( 'full-content' == baroque_get_layout() ) {
	return;
}

$offset = '';

if ( baroque_is_catalog() ) {
	$offset = '';
} else {
	if ( 'content-sidebar' == baroque_get_layout() ) {
		$offset = 'col-md-offset-1';
	}
}

$sidebar = 'blog-sidebar';

if( is_page() ) {
	$sidebar = 'page-sidebar';
} elseif ( baroque_is_catalog() || (function_exists('is_product') && is_product()) ) {
	$sidebar = 'shop-sidebar';
} elseif ( baroque_is_service() || is_singular( 'service' ) ) {
	$sidebar = 'service-sidebar';
}

?>
<aside id="primary-sidebar" class="widgets-area primary-sidebar <?php echo esc_attr( $sidebar ) ?> col-xs-12 col-sm-12 col-md-3 <?php echo esc_attr( $offset ) ?>">
	<?php
	if (is_active_sidebar($sidebar)) {
		dynamic_sidebar($sidebar);
	}
	?>
</aside><!-- #secondary -->
