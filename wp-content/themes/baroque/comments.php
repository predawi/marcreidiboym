<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Baroque
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

$col       = baroque_get_option( 'single_post_col' );
$offset    = baroque_get_option( 'single_post_col_offset' );
$colOffset = '';
if ( $offset != 0 ) {
	$colOffset = 'col-md-offset-' . $offset;
}

?>

<div id="comments" class="comments-area">
	<div class="container">
		<div class="row">
			<div class="col-md-<?php echo esc_attr( $col ) ?> <?php echo esc_attr( $colOffset ); ?>">
				<?php // You can start editing here -- including this comment! ?>

				<?php if ( have_comments() ) : ?>
					<h2 class="comments-title">
						<?php
						printf( // WPCS: XSS OK.
							esc_html( _nx( 'No Comments', '%1$s Comments', get_comments_number(), 'comments title', 'baroque' ) ),
							number_format_i18n( get_comments_number() )
						);
						?>
					</h2>

					<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
						<nav id="comment-nav-above" class="navigation comment-navigation">
							<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'baroque' ); ?></h2>
							<div class="nav-links">

								<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'baroque' ) ); ?></div>
								<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'baroque' ) ); ?></div>

							</div><!-- .nav-links -->
						</nav><!-- #comment-nav-above -->
					<?php endif; // Check for comment navigation. ?>

					<ol class="comment-list clearfix">
						<?php
						wp_list_comments( array(
							'style'      => 'ol',
							'short_ping' => true,
							'callback'   => 'baroque_comment',
						) );
						?>
					</ol><!-- .comment-list -->

					<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
						<nav id="comment-nav-below" class="navigation comment-navigation">
							<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'baroque' ); ?></h2>
							<div class="nav-links">

								<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'baroque' ) ); ?></div>
								<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'baroque' ) ); ?></div>

							</div><!-- .nav-links -->
						</nav><!-- #comment-nav-below -->
					<?php endif; // Check for comment navigation. ?>

				<?php endif; // Check for have_comments(). ?>

				<?php
				// If comments are closed and there are comments, let's leave a little note, shall we?
				if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
					?>
					<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'baroque' ); ?></p>
				<?php endif; ?>

				<?php

				$args = array(
					'comment_field'        => '<p class="comment-form-comment"><textarea placeholder="' . esc_attr__( 'Comment', 'baroque' ) . '" required id="comment" name="comment" cols="45" rows="6" aria-required="true">' .
					                          '</textarea></p>',
					'comment_notes_before' => '<p class="comment-notes">' .
					                          esc_html__( 'Your email address will not be published.', 'baroque' ) .
					                          '</p>',
					'format'               => 'xhtml',
				);

				comment_form( $args );
				?>
			</div>
		</div>
	</div>
</div><!-- #comments -->
