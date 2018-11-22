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
		<span class="page-header__surtitle">Réalisations</span>
		<h1>Nos derniers projets</h1>
	</div>
</div>