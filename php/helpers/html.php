<?php
/**
 * Helpers that generate HTML tags
 *
 * @package helpers/html
 */

/**
 * Outputs a html link
 *
 * @param string $text The text for the link.
 * @param string $url The url of the link.
 * @param array  $options An associative array of options to configure the link.
 */
function link_to( $text, $url, $options = null ) {
	$class  = isset( $options['class'] )  ? "class={$options['class']}" : '';
	$target = isset( $options['target'] ) ? "target={$options['target']}" : '';

	e( "<a href='$url' $class $target>$text</a>" );
}

/**
 * Return a url relative to the website
 *
 * @param string $url The url of the website.
 */
function get_url( $url = '' ) {
	return get_site_url() . '/' . $url;
}

/**
 * Outputs a url relative to the website
 *
 * @param string $url The url of the website.
 */
function url( $url = '' ) {
	e( get_url( $url ) );
}

/**
 * Outputs the correct URL for making a WordPress AJAX call
 *
 * @param string $action The name of the action.
 * @param string $params Parameters for the action.
 */
function ajax_url( $action, $params = '' ) {
	e( get_ajax_url( $action, $params ) );
}

/**
 * Returns the correct URL for making a WordPress AJAX call
 *
 * @param string $action The name of the action.
 * @param string $params Parameters for the action.
 */
function get_ajax_url( $action, $params = '' ) {
	$params = isset( $params ) ? "&$params" : '';

	return admin_url( "admin-ajax.php?action=$action$params" );
}

/**
 * Returns the base path of the website
 *
 * @param string $url The URL path to append to the base.
 *
 * @todo consider naming this "URL" or "DOMAIN" to be more semantic.
 */
function get_base( $url = '' ) {
	return get_template_directory_uri() . "/$url";
}

/**
 * Outputs the base path of the website
 *
 * @param string $url The URL path to append to the base.
 */
function base( $url = '' ) {
	e( get_base( $url ) );
}

/**
 * Returns the absolute path of the WordPress theme
 *
 * @param string $url The URL path to append to the base.
 */
function get_theme_path( $url = '' ) {
	return get_stylesheet_directory() . "/$url";
}

/**
 * Outputs the absolute path of the WordPress theme
 *
 * @param string $url The URL path to append to the base.
 */
function theme_path( $url = '' ) {
	e( get_theme_path( $url ) );
}

/**
 * Returns the version number of a file based on its updated on timestamp.
 *
 * @param string $file_name The name of the file to version.
 */
function get_version( $file_name ) {
	return filemtime( get_theme_path( $file_name ) );
}

/**
 * Return a HTML image tag
 *
 * @param array $image An array of acf images.
 * @param array $options An associative array of options to configure the image tag.
 */
function get_img_tag( $image, $options = null ) {
	$image_size = isset( $options['image_size'] ) ? $options['image_size'] : 'large';
	$render_div = isset( $options['render_div'] ) && $options['render_div'] === true;

	$url = get_img_url( $image, $image_size );

	if ( $render_div ) {
		return "<div class='image' style='background-image: url($url)'></div>";
	} else {
		return "<img src='$url' class='img'>";
	}
}

/**
 * Output a HTML image tag
 *
 * @param array $images An array of acf images.
 * @param array $options An associative array of options to configure the image tag.
 */
function img_tag( $images, $options = null ) {
	e( get_img_tag( $images, $options ) );
}

/**
 * Return the absolute url of an image
 *
 * @param array $images An array of acf images.
 * @param array $size size of the image.
 *
 // TODO: This function is poorly named, it should be for the use of ACF Image objects.
 */
function get_img_url( $images, $size ) {
	if ( empty( $images ) ) {
		return;
	} else {
		return $images;
	}
}

/**
 * Outputs the contents of an SVG file
 *
 * @param string $url the url of the svg.
 */
function svg( $url ) {
	e( get_svg( $url ) );
}

/**
 * Returns the contents of an SVG file. In the case of ie8, output the png equivalent in the same directory.
 *
 * @param string $url the url of the svg.
 * @todo revise this function, dont think its applicable to replace svg with pngs
 */
function get_svg( $url, $dimensions = null ) {

	$theme_dir = get_base();

	$png = str_replace( '.svg', '.png', $url );

	$width  = isset( $dimensions ) ? $dimensions[0] : '';
	$height = isset( $dimensions ) ? $dimensions[1] : '';

	$return  = "<!--[if gte IE 9]><!-->";
	$return .= file_get_contents( "$theme_dir/$url", true );
	$return .= "<![endif]-->";
	$return .= "<!--[if lte IE 8]><img width='$width' height='$height' src='$theme_dir/$png' class='svg_png'><![endif]-->";

	return $return;
}

/**
 * Return the css background image attribute
 *
 * @param string $image_url The image url.
 */
function get_css_background_image( $image_url = '' ) {
	return empty( $image_url ) ? '' : "background-image: url($image_url)";
}

/**
 * Return the background image to be used in a HTML tag.
 *
 * @param string $image_url The image url.
 * @todo Look into how this function compares to the WP version and see if its worth actually replacing
 */
function get_background_img( $image_url = null ) {
	global $post;

	$return = '';

	// Attempts to retrieve the image from a post's feature image.
	if ( empty( $image_url ) ) {
		$image_url = get_the_thumbnail_url( $post->ID );
	} else {
		$image_url = get_css_background_image( $image_url );

		$return = " style='$image_url'";
	}

	return $return;
}

/**
 * Output the background image to be used in a HTML tag
 *
 * @param string $image_url The image url.
 */
function background_img( $image_url = null ) {
	e( get_background_img( $image_url ) );
}

/**
 * Convert a piece of text into an excerpt but cutting it off.
 *
 * @param string $text The text to be excerpted.
 * @param number $limit The number of characters to cut off by (Default is 100).
 */
function get_excerpt( $text, $limit = 100 ) {
	if ( empty( $text ) ) {
		return '';
	}

	return substr( strip_tags( $text ), 0, $limit ) . ' ...';
}

/**
 *
 */
function get_the_featured_image_url( $post_object = 0, $size = '' ) {
	if ( ! is_object( $post_object ) ) {
		$post_object = get_post( $post_object );
	}
	if ( empty( $post_object ) ) {
		return '';
	}

	$feature_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_object->ID ), $size );

	if ( ! empty( $feature_image_url ) ) {
		return reset( $feature_image_url );
	} else {
		return '';
	}
}

/**
 *
 */
function the_featured_image_url( $post_object = 0, $size = '' ) {
	e( get_the_featured_image_url( $post_object, $size ) );
}

/**
 * Return the HTML template of a page's breadcrumb
 *
 * @param page $page The page.
 */
function get_breadcrumb( $page ) {
	$separator = " » ";
	$return = '';

	if ( ! is_front_page() ) {
		if ( is_page() && $page->post_parent ) {
			$home = get_the_page( get_option( 'page_on_front' ) );
			for ( $i = count( $page->ancestors )-1; $i >= 0; $i-- ) {
				if ( ( $home->ID ) !== ( $page->ancestors[ $i ] ) ) {
					$return .= '<a href="';
					$return .= get_permalink( $page->ancestors[ $i ] );
					$return .= '">';
					$return .= get_the_title( $page->ancestors[ $i ] );
					$return .= '</a>' . $separator;
				}
			}
		} elseif ( is_404() ) {
			$return .= '404';
		}
	} else {
		$return .= get_bloginfo( 'name' );
	}

	if ( $return === '' ) {
		return;
	}

	return "<div class='breadcrumb'>$return</div>";
}

/**
 * Output the HTML template of a page's breadcrumb
 *
 * @param page $page The page.
 */
function breadcrumb( $page ) {
	e( get_breadcrumb( $page ) );
}
