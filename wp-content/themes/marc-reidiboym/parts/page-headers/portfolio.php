<?php
$p_style = baroque_get_option( 'portfolio_style' );
$page_header = baroque_get_option( 'portfolio_page_header' );

if ( ! intval( $page_header ) ) {
	return;
}

if ( $p_style == 'parallax' || $p_style == 'carousel' || $p_style == 'masonry' ) {
	return;
}

?>
<div class="page-header portfolio-page-header">
	<div class="container">
		<?php
		if( get_the_archive_title() == 'Projets' ) {
			echo '<span class="page-header__surtitle">Réalisations</span>';
		}
		the_archive_title( '<h1>', '</h1>' );
		?>
	</div>
</div>