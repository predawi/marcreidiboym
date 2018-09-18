<?php
/**
 * Hooks for template single post format
 *
 * @package Baroque
 */

if ( ! baroque_single_post_has_post_format() ) {
	return;
}

if ( ! intval( baroque_get_option( 'show_post_format' ) ) ) {
	return;
}

$size = 'full';
$container = 'container';

if ( get_post_format() == 'gallery' ) {
	$size = 'full';
	$container = 'baroque-container';
}

?>
	<div class="entry-thumbnail">
		<div class="<?php echo esc_attr( $container ); ?>">
			<div class="content-area col-md-8 col-sm-12 col-xs-12">
				<?php baroque_entry_thumbnail( $size ) ?>
			</div>
		</div>
	</div>
<?php

