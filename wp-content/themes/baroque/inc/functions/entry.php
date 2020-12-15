<?php
/**
 * Custom functions for entry.
 *
 * @package Baroque
 */

/**
 * Prints HTML with meta information for the social share and tags.
 *
 * @since 1.0.0
 */
function baroque_entry_footer() {
	if ( ! has_tag() && ! intval( baroque_get_option( 'show_post_social_share' ) ) ) {
		return;
	}

	$col       = baroque_get_option( 'single_post_col' );
	$offset    = baroque_get_option( 'single_post_col_offset' );
	$colOffset = '';
	if ( $offset != 0 ) {
		$colOffset = 'col-md-offset-' . esc_attr( $offset );
	}


	echo '<footer class="entry-footer">' .
		'<div class="container">' .
		'<div class="row">' .
		'<div class="col-md-' . esc_attr( $col ) . ' col-xs-12 col-sm-12 ' . $colOffset . '">';

	if ( has_tag() ) :
		the_tags( '<div class="tag-list"><span class="tag-title">' . esc_html__( 'Tags: ', 'baroque' ) . '</span>', ', ', '</div>' );
	endif;

	if ( function_exists( 'baroque_addons_share_link_socials' ) && intval( baroque_get_option( 'show_post_social_share' ) ) ) {
		echo '<div class="baroque-single-post-socials-share">';
		echo baroque_addons_share_link_socials( get_the_title(), get_the_permalink(), get_the_post_thumbnail() );
		echo '</div>';
	};

	echo '</div></div></div></footer>';

}


/**
 * Get or display limited words from given string.
 * Strips all tags and shortcodes from string.
 *
 * @since 1.0.0
 *
 * @param integer $num_words The maximum number of words
 * @param string  $more      More link.
 * @param bool    $echo      Echo or return output
 *
 * @return string|void Limited content.
 */
function baroque_content_limit( $num_words, $more = "&hellip;" ) {
	$content = get_the_excerpt();

	// Strip tags and shortcodes so the content truncation count is done correctly
	$content = strip_tags( strip_shortcodes( $content ), apply_filters( 'baroque_content_limit_allowed_tags', '<script>,<style>' ) );

	// Remove inline styles / scripts
	$content = trim( preg_replace( '#<(s(cript|tyle)).*?</\1>#si', '', $content ) );

	// Truncate $content to $max_char
	$content = wp_trim_words( $content, $num_words );

	if ( $more ) {
		echo sprintf(
			'<p>%s <a href="%s" class="more-link" title="%s">%s</a></p>',
			$content,
			get_permalink(),
			sprintf( esc_html__( 'Continue reading &quot;%s&quot;', 'baroque' ), the_title_attribute( 'echo=0' ) ),
			esc_html( $more )
		);
	} else {
		echo sprintf( '<p>%s</p>', $content );
	}

}


/**
 * Show entry thumbnail base on its format
 *
 * @since  1.0
 */
function baroque_entry_thumbnail( $size = 'thumbnail' ) {
	$html = '';

	$css_post = '';

	if ( $post_format = get_post_format() ) {
		$css_post = 'format-' . $post_format;
	}

	if ( get_post_format() != 'gallery' && get_post_format() != 'video' ) {
		$css_post = 'format-default';
	}

	switch ( get_post_format() ) {
		case 'gallery':
			$images = get_post_meta( get_the_ID(), 'images' );

			$gallery = array();
			if ( empty( $images ) ) {
				$thumb = get_the_post_thumbnail( get_the_ID(), $size );

				$html .= '<div class="single-image">' . $thumb . '</div>';
			} else {
				foreach ( $images as $image ) {
					$thumb = wp_get_attachment_image_src( $image, $size );
					if ( $thumb ) {
						$gallery[] = sprintf(
							'<div class="item-gallery">
								<a href="%s" class="photoswipe" data-large_image_width="%s" data-large_image_height="%s"><img src="%s" alt="post-gallery"/></a>
							</div>',
							$thumb[0],
							$thumb[1],
							$thumb[2],
							$thumb[0]
						);
					}
				}

				$html .= implode( '', $gallery );
			}

			break;

		case 'video':
			$video = get_post_meta( get_the_ID(), 'video', true );
			if ( is_singular( 'post' ) ) {
				if ( ! $video ) {
					break;
				}

				// If URL: show oEmbed HTML
				if ( filter_var( $video, FILTER_VALIDATE_URL ) ) {
					if ( $oembed = @wp_oembed_get( $video, array( 'width' => 1170 ) ) ) {
						$html .= $oembed;
					} else {
						$atts = array(
							'src'   => $video,
							'width' => 1170,
						);

						if ( has_post_thumbnail() ) {
							$atts['poster'] = get_the_post_thumbnail_url( get_the_ID(), 'full' );
						}
						$html .= wp_video_shortcode( $atts );
					}
				} // If embed code: just display
				else {
					$html .= $video;
				}
			} else {
				$image_src = get_the_post_thumbnail( get_the_ID(), $size );
				if ( $video ) {
					$html = sprintf( '<a href="%s">%s</a>', esc_url( $video ), $image_src );
				} else {
					$html = $image_src;
				}
			}

			break;

		default:
			$html = get_the_post_thumbnail( get_the_ID(), $size );

			if ( ! is_singular( 'post' ) ) {
				$html = sprintf( '<a href="%s">%s</a>', esc_url( get_the_permalink() ), $html );
			} else {
				$html = sprintf( '<div class="single-image">%s</div>', $html );
			}

			break;
	}

	if ( $html ) {
		$html = sprintf( '<div  class="entry-format %s">%s</div>', esc_attr( $css_post ), $html );
	}

	echo apply_filters( __FUNCTION__, $html, get_post_format() );
}

/**
 * Get author meta
 *
 * @since  1.0
 *
 */
function baroque_author_box() {
	if ( baroque_get_option( 'show_author_box' ) == 0 ) {
		return;
	}

	if ( ! get_the_author_meta( 'description' ) ) {
		return;
	}

	$socials = array(
		'facebook'   => esc_html__( 'Facebook', 'baroque' ),
		'twitter'    => esc_html__( 'Twitter', 'baroque' ),
		'googleplus' => esc_html__( 'Google Plus', 'baroque' ),
		'pinterest'  => esc_html__( 'Pinterest', 'baroque' ),
		'rss'        => esc_html__( 'Rss', 'baroque' ),
	);

	$links = array();
	foreach ( $socials as $social => $name ) {
		$link = get_the_author_meta( $social, get_the_author_meta( 'ID' ) );
		if ( empty( $link ) ) {
			continue;
		}
		$links[] = sprintf(
			'<li><a href="%s" target="_blank">%s</a></li>',
			esc_url( $link ),
			esc_html( $name )
		);
	}

	?>
	<div class="post-author">
		<div class="post-author-box clearfix">
			<div class="post-author-avatar">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 130 ); ?>
			</div>
			<div class="post-author-info">
				<h3 class="author-name"><?php the_author_meta( 'display_name' ); ?></h3>

				<p><?php the_author_meta( 'description' ); ?></p>
				<?php

				if ( ! empty( $links ) ) {
					echo sprintf( '<ul class="author-socials">%s</ul>', implode( '', $links ) );
				}
				?>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Get single entry meta
 *
 * @since  1.0
 *
 */
function baroque_entry_meta( $single_post = false ) {
	$fields = (array) baroque_get_option( 'blog_entry_meta' );

	if ( $single_post ) {
		$fields = (array) baroque_get_option( 'post_entry_meta' );
	}

	if ( empty ( $fields ) ) {
		return;
	}

	foreach ( $fields as $field ) {
		switch ( $field ) {

			case 'date':
				$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

				$time_string = sprintf(
					$time_string,
					esc_attr( get_the_date( 'c' ) ),
					esc_html( get_the_date() )
				);

				echo '<span class="meta date">' . $time_string . '</span>';

				break;

			case 'cat':
				$category = get_the_terms( get_the_ID(), 'category' );

				$cat_html = '';

				if ( ! is_wp_error( $category ) && $category ) {
					$cat_html = sprintf( '<a href="%s" class="cat-links">%s</a>', esc_url( get_term_link( $category[0], 'category' ) ), esc_html( $category[0]->name ) );
				}

				if ( $cat_html ) {
					echo '<span class="meta cat">' . $cat_html . '</span>';
				}

				break;
		}
	}
}

/**
 * Print HTML of language switcher
 * It requires plugin WPML installed
 */

if ( ! function_exists( 'baroque_language_switcher' ) ) :
	function baroque_language_switcher( $show_name = false ) {
		$language_dd = '';
		if ( function_exists( 'icl_get_languages' ) ) {
			$languages = icl_get_languages();
			if ( $languages ) {
				$lang_list = array();
				$current   = '';
				foreach ( (array) $languages as $code => $language ) {
					if ( ! $language['active'] ) {
						$lang_list[] = sprintf(
							'<li class="%s"><a href="%s">%s</a></li>',
							esc_attr( $code ),
							esc_url( $language['url'] ),
							$show_name ? esc_html( $language['translated_name'] ) : esc_html( $code )
						);
					} else {
						$current = $language;
						array_unshift(
							$lang_list, sprintf(
								'<li class="active %s"><a href="%s">%s</a></li>',
								esc_attr( $code ),
								esc_url( $language['url'] ),
								$show_name ? esc_html( $language['translated_name'] ) : esc_html( $code )
							)
						);
					}
				}

				$language_dd = sprintf(
					'<span class="current">%s<span class="toggle-children i-icon arrow_carrot-down"></span></span>' .
					'<ul>%s</ul>',
					$show_name ? esc_html( $current['translated_name'] ) : esc_html( $current['language_code'] ),
					implode( "\n\t", $lang_list )
				);
			}
		}

		return $language_dd;
		?>

		<?php
	}
endif;

/**
 * Get socials
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
function baroque_get_socials() {
	$socials = array(
		'facebook'   => esc_html__( 'Facebook', 'baroque' ),
		'twitter'    => esc_html__( 'Twitter', 'baroque' ),
		'google'     => esc_html__( 'Google', 'baroque' ),
		'tumblr'     => esc_html__( 'Tumblr', 'baroque' ),
		'flickr'     => esc_html__( 'Flickr', 'baroque' ),
		'vimeo'      => esc_html__( 'Vimeo', 'baroque' ),
		'youtube'    => esc_html__( 'Youtube', 'baroque' ),
		'linkedin'   => esc_html__( 'LinkedIn', 'baroque' ),
		'pinterest'  => esc_html__( 'Pinterest', 'baroque' ),
		'dribbble'   => esc_html__( 'Dribbble', 'baroque' ),
		'spotify'    => esc_html__( 'Spotify', 'baroque' ),
		'instagram'  => esc_html__( 'Instagram', 'baroque' ),
		'tumbleupon' => esc_html__( 'Tumbleupon', 'baroque' ),
		'wordpress'  => esc_html__( 'WordPress', 'baroque' ),
		'rss'        => esc_html__( 'Rss', 'baroque' ),
		'deviantart' => esc_html__( 'Deviantart', 'baroque' ),
		'share'      => esc_html__( 'Share', 'baroque' ),
		'skype'      => esc_html__( 'Skype', 'baroque' ),
		'behance'    => esc_html__( 'Behance', 'baroque' ),
		'apple'      => esc_html__( 'Apple', 'baroque' ),
		'yelp'       => esc_html__( 'Yelp', 'baroque' ),
	);

	$socials = apply_filters( 'baroque_header_socials', $socials );

	return $socials;
}

// Rating reviews

function baroque_rating_stars( $score ) {
	$score     = min( 10, abs( $score ) );
	$full_star = $score / 2;
	$half_star = $score % 2;
	$stars     = array();

	for ( $i = 1; $i <= 5; $i ++ ) {
		if ( $i <= $full_star ) {
			$stars[] = '<i class="fa fa-star"></i>';
		} elseif ( $half_star ) {
			$stars[]   = '<i class="fa fa-star-half-o"></i>';
			$half_star = false;
		} else {
			$stars[] = '<i class="fa fa-star-o"></i>';
		}
	}

	echo join( "\n", $stars );
}

/**
 * Check is blog
 *
 * @since  1.0
 */

if ( ! function_exists( 'baroque_is_blog' ) ) :
	function baroque_is_blog() {
		if ( ( is_archive() || is_author() || is_category() || is_home() || is_tag() ) && 'post' == get_post_type() ) {
			return true;
		}

		return false;
	}

endif;

/**
 * Check is catalog
 *
 * @return bool
 */
if ( ! function_exists( 'baroque_is_catalog' ) ) :
	function baroque_is_catalog() {

		if ( function_exists( 'is_shop' ) && ( is_shop() || is_product_category() || is_product_tag() ) ) {
			return true;
		}

		return false;
	}
endif;

/**
 * Check is portfolio
 *
 * @since  1.0
 */

if ( ! function_exists( 'baroque_is_portfolio' ) ) :
	function baroque_is_portfolio() {
		if ( is_post_type_archive( 'portfolio' ) || is_tax( 'portfolio_category' ) || is_tax( 'portfolio_tag' ) ) {
			return true;
		}

		return false;
	}
endif;

/**
 * Check is services
 *
 * @since  1.0
 */

if ( ! function_exists( 'baroque_is_service' ) ) :
	function baroque_is_service() {
		if ( is_post_type_archive( 'service' ) || is_tax( 'service_category' ) ) {
			return true;
		}

		return false;
	}
endif;

/**
 * Check is homepage
 *
 * @since  1.0
 */

if ( ! function_exists( 'baroque_is_homepage' ) ) :
	function baroque_is_homepage() {
		if ( is_page_template( 'template-home-boxed.php' ) ||
			is_page_template( 'template-homepage.php' )
		) {
			return true;
		}

		return false;
	}

endif;

/**
 * Check is homepage
 *
 * @since  1.0
 */

if ( ! function_exists( 'baroque_is_page_template' ) ) :
	function baroque_is_page_template() {
		if ( is_page_template( 'template-home-boxed.php' ) ||
			is_page_template( 'template-fullwidth.php' ) ||
			is_page_template( 'template-coming-soon-page.php' ) ||
			is_page_template( 'template-homepage.php' )
		) {
			return true;
		}

		return false;
	}

endif;

/**
 * Check has post format
 *
 * @since  1.0
 */

if ( ! function_exists( 'baroque_has_post_format' ) ) :
	function baroque_single_post_has_post_format() {
		if ( ! has_post_thumbnail() && get_post_format() != 'gallery' && get_post_format() != 'video' && is_singular( 'post' ) ) {
			return false;
		}

		return true;
	}
endif;

/**
 * show taxonomy filter
 *
 * @return string
 */

if ( ! function_exists( 'baroque_taxs_list' ) ) :
	function baroque_taxs_list( $taxonomy = 'category' ) {

		$term_id   = 0;
		$cats      = $output = '';
		$found     = false;
		$number    = baroque_get_option( 'blog_categories_numbers' );
		$cats_slug = baroque_get_option( 'blog_categories' );
		$id        = 'baroque-taxs-list';


		if ( baroque_is_catalog() ) {
			$id        = 'ba-catalog-taxs-filter';
			$number    = baroque_get_option( 'catalog_categories_numbers' );
			$cats_slug = baroque_get_option( 'catalog_categories' );

		} elseif ( baroque_is_blog() ) {
			$id = 'ba-blog-taxs-filter';

		} elseif ( baroque_is_portfolio() ) {
			$id        = 'ba-portfolio-taxs-filter';
			$number    = baroque_get_option( 'portfolio_categories_numbers' );
			$cats_slug = baroque_get_option( 'portfolio_categories' );
		}

		if ( is_tax( $taxonomy ) || is_category() ) {

			$queried_object = get_queried_object();
			if ( $queried_object ) {
				$term_id = $queried_object->term_id;
			}
		}

		if ( $cats_slug ) {
			$cats_slug = explode( ',', $cats_slug );

			foreach ( $cats_slug as $slug ) {
				$cat = get_term_by( 'slug', $slug, $taxonomy );

				if ( $cat ) {
					$cat_selected = '';
					if ( $cat->term_id == $term_id ) {
						$cat_selected = 'selected';
						$found        = true;
					}

					$cats .= sprintf( '<li><a href="%s" class="%s">%s</a></li>', esc_url( get_term_link( $cat ) ), esc_attr( $cat_selected ), esc_html( $cat->name ) );
				}
			}

		} else {
			$args = array(
				'number'  => $number,
				'orderby' => 'count',
				'order'   => 'DESC',

			);

			$categories = get_terms( $taxonomy, $args );
			if ( ! is_wp_error( $categories ) && $categories ) {
				foreach ( $categories as $cat ) {
					$cat_selected = '';
					if ( $cat->term_id == $term_id ) {
						$cat_selected = 'selected';
						$found        = true;
					}

					$cats .= sprintf( '<li><a href="%s" class="%s">%s</a></li>', esc_url( get_term_link( $cat ) ), esc_attr( $cat_selected ), esc_html( $cat->name ) );
				}
			}
		}

		$cat_selected = $found ? '' : 'selected';

		if ( $cats ) {
			$url = get_page_link( get_option( 'page_for_posts' ) );
			if ( 'posts' == get_option( 'show_on_front' ) ) {
				$url = home_url();
			} elseif ( baroque_is_portfolio() ) {
				$url = get_post_type_archive_link( 'portfolio' );
			} elseif ( baroque_is_catalog() ) {
				$url = get_permalink( wc_get_page_id( 'shop' ) );
			}

			$output = sprintf(
				'<ul>
					<li><a href="%s" class="%s">%s</a></li>
					 %s
				</ul>',
				esc_url( $url ),
				esc_attr( $cat_selected ),
				esc_html__( 'All', 'baroque' ),
				$cats
			);
		}

		if ( $output ) {
			$output = apply_filters( 'baroque_tax_html', $output );

			printf( '<div id="%s" class="baroque-taxs-list">%s</div>', esc_attr( $id ), $output );
		}
	}

endif;


/**
 * Get blog description
 *
 * @since  1.0
 */

if ( ! function_exists( 'baroque_blog_description' ) ) :
	function baroque_blog_description() {
		$blog_style = baroque_get_option( 'blog_style' );

		if ( ! baroque_is_blog() ) {
			return;
		}

		if ( $blog_style == 'masonry' || $blog_style == 'classic' ) {
			return;
		}

		$blog_text = do_shortcode( wp_kses( baroque_get_option( 'blog_description' ), wp_kses_allowed_html( 'post' ) ) );

		if ( is_category() ) {
			if ( $cat_desc = category_description() ) {
				$blog_text = $cat_desc;
			}
		}

		if ( empty( $blog_text ) ) {
			return;
		}

		printf( '<div class="page-desc">%s</div>', $blog_text );
	}

endif;


/**
 * Get portfolio meta
 *
 * @since  1.0
 */

if ( ! function_exists( 'baroque_portfolio_meta' ) ) :
	function baroque_portfolio_meta() {
		$portfolio_meta = baroque_get_option( 'single_portfolio_meta' );

		if ( ! intval( $portfolio_meta ) ) {
			return;
		}

		$client_text     = baroque_get_option( 'single_portfolio_client_text' );
		$location_text   = baroque_get_option( 'single_portfolio_location_text' );
		$completion_text = baroque_get_option( 'single_portfolio_completion_text' );
		$area_text       = baroque_get_option( 'single_portfolio_area_text' );

		$client     = get_post_meta( get_the_ID(), 'client', true );
		$location   = get_post_meta( get_the_ID(), 'location', true );
		$completion = get_post_meta( get_the_ID(), 'completion', true );
		$area       = get_post_meta( get_the_ID(), 'area', true );
		$categories = get_the_terms( get_the_ID(), 'portfolio_category' );
		$tags       = get_the_terms( get_the_ID(), 'portfolio_tag' );

		$portfolio_layout = baroque_get_option( 'single_portfolio_layout' );

		if ( get_post_meta( get_the_ID(), 'custom_portfolio_layout', true ) ) {
			$portfolio_layout = get_post_meta( get_the_ID(), 'portfolio_layout', true );
		}

		$output = array();

		if ( $client ) {
			$output[] = sprintf(
				'<div class="meta client"><h5>%s</h5><div class="meta-content">%s</div></div>',
				wp_kses( $client_text, wp_kses_allowed_html( 'post' ) ),
				$client
			);
		}

		if ( ! is_wp_error( $categories ) && $categories ) {
			$cats = array();
			foreach ( $categories as $cat ) {
				$cats[] = sprintf( '<a href="%s">%s</a>', esc_url( get_term_link( $cat ) ), esc_html( $cat->name ) );
			}

			$output[] = sprintf(
				'<div class="meta cat"><h5>%s</h5><div class="portfolio-cat">%s</div></div>',
				apply_filters( 'ba_portfolio_meta_categories_label', esc_html__( 'CATEGORIES', 'baroque' ) ),
				implode( ',', $cats )
			);
		}

		if ( ! is_wp_error( $tags ) && $tags ) {
			$t = array();
			foreach ( $tags as $tag ) {
				$t[] = sprintf( '<a href="%s">%s</a>', esc_url( get_term_link( $tag ) ), esc_html( $tag->name ) );
			}

			$output[] = sprintf(
				'<div class="meta tag"><h5>%s</h5><div class="portfolio-tag">%s</div></div>',
				apply_filters( 'ba_portfolio_meta_tags_label', esc_html__( 'TAGS', 'baroque' ) ),
				implode( ',', $t )
			);
		}

		if ( $completion ) {
			$output[] = sprintf(
				'<div class="meta completion"><h5>%s</h5><div class="meta-content">%s</div></div>',
				wp_kses( $completion_text, wp_kses_allowed_html( 'post' ) ),
				$completion
			);
		}

		if ( $location ) {
			$output[] = sprintf(
				'<div class="meta location"><h5>%s</h5><div class="meta-content">%s</div></div>',
				wp_kses( $location_text, wp_kses_allowed_html( 'post' ) ),
				$location
			);
		}

		if ( $area ) {
			$output[] = sprintf(
				'<div class="meta area"><h5>%s</h5><div class="meta-content">%s</div></div>',
				wp_kses( $area_text, wp_kses_allowed_html( 'post' ) ),
				$area
			);
		}

		if ( intval( baroque_get_option( 'show_portfolio_social_share' ) ) && $portfolio_layout != '4' ) {
			if ( function_exists( 'baroque_addons_share_link_socials' ) ) {
				$output[] = sprintf(
					'<div class="meta socials"><h5>%s</h5>%s</div>',
					apply_filters( 'ba_portfolio_meta_socials_label', esc_html__( 'SHARE', 'baroque' ) ),
					baroque_addons_share_link_socials( get_the_title(), get_the_permalink(), get_the_post_thumbnail() )
				);
			}
		}

		$meta_html = '';

		$output = ( array ) apply_filters( 'baroque_portfolio_meta', $output );

		if ( ! empty( $output ) ) {
			$meta_html = sprintf( '<div class="portfolio-meta">%s</div>', implode( '', $output ) );
		}

		return $meta_html;
	}

endif;

/**
 * Get current page URL for layered nav items.
 * @return string
 */
if ( ! function_exists( 'baroque_get_page_base_url' ) ) :
	function baroque_get_page_base_url() {
		if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
			$link = home_url();
		} elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id( 'shop' ) ) ) {
			$link = get_post_type_archive_link( 'product' );
		} elseif ( is_product_category() ) {
			$link = get_term_link( get_query_var( 'product_cat' ), 'product_cat' );
		} elseif ( is_product_tag() ) {
			$link = get_term_link( get_query_var( 'product_tag' ), 'product_tag' );
		} else {
			$queried_object = get_queried_object();
			$link           = get_term_link( $queried_object->slug, $queried_object->taxonomy );
		}

		return $link;
	}
endif;

/**
 * Display products link
 *
 * @since 1.0
 */

if ( ! function_exists( 'baroque_products_links' ) ) :
	function baroque_products_links() {

		if ( ! function_exists( 'is_product' ) ) {
			return;
		}

		if ( ! is_product() ) {
			return;
		}

		$prev_link = '<span class="icon-arrow-left"></span>';
		$next_link = '<span class="icon-arrow-right"></span>';

		?>
		<div class="products-links">
			<?php
			previous_post_link( '<div class="nav-previous">%link</div>', $prev_link );
			next_post_link( '<div class="nav-next">%link</div>', $next_link );
			?>
		</div>
		<?php
	}

endif;