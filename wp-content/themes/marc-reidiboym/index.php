<?php

/**

 * The main template file.

 *

 * This is the most generic template file in a WordPress theme

 * and one of the two required files for a theme (the other being style.css).

 * It is used to display a page when nothing more specific matches a query.

 * E.g., it puts together the home page when no home.php file exists.

 * Learn more: http://codex.wordpress.org/Template_Hierarchy

 *

 * @package Baroque

 */



get_header();



$blog_view = baroque_get_option( 'blog_style' );

$type_nav  = baroque_get_option( 'type_nav' );

$css       = 'clearfix';

$row_css   = '';



if ( $blog_view == 'grid' ) {

$row_css = 'row';

} elseif ( $blog_view == 'masonry' ) {

$row_css = 'baroque-post-row';

}



$col = 'col-md-8 col-xs-12 col-sm-12';



?>



<div id="primary" class="content-area <?php baroque_content_columns(); ?>">

	<main id="main" class="site-main <?php echo esc_attr( $blog_view == 'text' ? 'row' : '' ); ?>">



		<?php

		/* baroque_blog_text_categories

		 *

		 */

		do_action( 'baroque_before_post_list' );

		?>



		<?php if ( have_posts() ) : ?>



			<?php /* Start the Loop */ ?>



			<div class="ba-blog-content <?php echo esc_attr( $blog_view == 'text' ? $col : '' ); ?>">

				<div class="ba-blog-loading">

					<span class="loading-icon">

						<span class="bubble"><span class="dot"></span></span>

						<span class="bubble"><span class="dot"></span></span>

						<span class="bubble"><span class="dot"></span></span>

					</span>

				</div>

				<div class="blog-description">
					<div class="container">
						<h2>Un archi pour quoi faire ?</h2>
						<p>Avoir recours à un architecte d’intérieur ne va pas toujours de soi. On peut craindre de voir le projet nous échapper, d’aller trop loin avec un professionnel qu’on imagine abonné aux solutions coûteuses. Pourtant, un œil extérieur avisé peut vous aider à régler un problème en apparence insoluble. Il peut vous ouvrir de nouvelles perspectives et même vous faire faire des économies. Illustration avec quelques exemples…</p>
					</div>
				</div>

				<div class="<?php echo esc_attr( $row_css ) ?>">

					<div class="container">

						<div class="baroque-post-list <?php echo esc_attr( $css ) ?>">

							<?php while ( have_posts() ) : the_post(); ?>



								<?php

								/* Include the Post-Format-specific template for the content.

								* If you want to override this in a child theme, then include a file

								* called content-___.php (where ___ is the Post Format name) and that will be used instead.

								*/

								get_template_part( 'parts/content', get_post_format() );

								?>



							<?php endwhile; ?>



						</div>

					</div>

					<!--.baroque-post-list-->



				</div>

				<!--.row-->



				<?php

				if ( $type_nav == 'numeric' ) {

					baroque_numeric_pagination();

				} else {

					baroque_paging_nav();

				}

				?>



			</div><!--.ba-blog-content-->



		<?php else : ?>



			<?php get_template_part( 'parts/content', 'none' ); ?>



		<?php endif; ?>





	</main>

	<!-- #main -->

</div><!-- #primary -->



<?php get_sidebar(); ?>

<?php get_footer(); ?>



