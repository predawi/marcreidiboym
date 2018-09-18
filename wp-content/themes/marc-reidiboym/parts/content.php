<?php
/**
 * @package Baroque
 */

global $wp_query;

$current = $wp_query->current_post + 1;

$size = 'baroque-blog-grid';
$blog_style = baroque_get_option( 'blog_style' );
$excerpt_length = intval( baroque_get_option( 'excerpt_length' ) );

$css_class = 'post-wrapper';

if ( 'grid' == $blog_style ) {
	$css_class .= ' col-md-4 col-sm-6 col-xs-12';

} elseif ( 'list' == $blog_style ) {
	$size = 'baroque-blog-list';

} elseif ( 'masonry' == $blog_style ) {
	$css_class .= ' blog-masonry-wrapper';
	$size = 'baroque-blog-masonry-1';

} elseif ( 'classic' == $blog_style ) {
	$size = 'baroque-blog-classic';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $css_class ); ?>>
	<div class="blog-wrapper">
		<?php if ( 'text' != $blog_style && has_post_thumbnail() ) : ?>
			<div class="entry-thumbnail">
				<a class="blog-thumb" href="<?php the_permalink() ?>"><?php the_post_thumbnail( $size ) ?></a>
				<?php if ( 'grid' == $blog_style || 'classic' == $blog_style ) : ?>
					<a href="<?php the_permalink() ?>" class="read-more">
						<?php echo apply_filters( 'baroque_blog_read_more_text', esc_html__( 'MORE', 'baroque' ) ); ?>
						<i class="icon-plus"></i>
					</a>
				<?php endif ?>
			</div>
		<?php endif; ?>

		<div class="entry-summary">
			<div class="entry-header">
				<div class="entry-meta">
					<?php baroque_entry_meta() ?>
				</div><!-- .entry-meta -->
				<h2 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>

				<?php if ( 'list' == $blog_style || 'masonry' == $blog_style || 'classic' == $blog_style ) : ?>
					<div class="entry-excerpt"><?php baroque_content_limit( $excerpt_length, '' ); ?></div>
				<?php endif ?>
			</div>
			<?php if ( 'list' == $blog_style || 'masonry' == $blog_style ) : ?>
			<a href="<?php the_permalink() ?>" class="read-more">
				<?php echo apply_filters( 'baroque_blog_read_more_text', esc_html__( 'Voir plus', 'baroque' ) ); ?>
				<i class="icon-plus"></i>
			</a>
			<?php endif ?>
		</div><!-- .entry-content -->
	</div>
</article><!-- #post-## -->
