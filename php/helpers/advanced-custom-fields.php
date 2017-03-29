<?php
/**
 * Advance Custom Fields related helpers
 *
 * @package helpers/advanced-custom-fields
 */

/**
 * Return the URL of an image from an ACF image object.
 *
 * @param acf_object $image The ACF image object.
 * @param string     $size The size of image.
 */
function get_acf_image_url( $image, $size = '' ) {
	if ( empty( $image ) ) {
		return '';
	}

	// Return the original size's URL if the none is specified.
	if ( empty( $size ) ) {
		return $image['url'];
	} else {
		// Return the specified size.
		if ( empty( $image['sizes'][ $size ] ) ) {
			return $image['sizes'][ $size ];
		}
	}
}

/**
 * Return an ACF image's url in the context of a css background.
 *
 * @param acf_object $image The ACF image object.
 * @param string $size The size of the image.
 */
function get_acf_css_background_image( $image, $size = '' ) {
	return get_css_background_image( get_acf_image_url( $image, $size ) );
}

/**
 * Return an ACF page
 *
 * @param acf_object $content The ACF content object which contains a page's content.
 */
function get_acf_page( $content ) {
	global $post;

	$return = '';

	if ( empty( $content ) ) {
		return '';
	}

	foreach ( $content as $section ) {
		if ( ! empty( $section['heading'] ) ) {
			$section_id = slugify( $section['heading'] );
			$section_id = "id='section-{$section_id}'";
		} else {
			$section_id = '';
		}

		switch ( $section['acf_fc_layout'] ) {
			case 'content' :
				$return .= get_acf_content( $section );
				break;

			default: break;
		}
	}

	return strip( $return );
}

/**
 * Returns the HTML template for an image gallery
 *
 * @param array $images An array of ACF images
 * @param array $options An associative array of options to configure the gallery
 *
 * @todo Update to reflect new JQuery plugin
 * @todo Adapt WooCommerce to use new jQuery plugin markup
 */
function get_acf_gallery( $images, $options = null ) {
	$name = isset( $options['name'] ) ? $options['name'] : '';

	$links_output  = '';
	$images_output = '';

	$img_url   = get_img_url( $images[0], 'large' );
	$blank_url = get_base() . '/images/blank.gif';

	for ( $i = 0; $i < count( $images ); $i++ ) {
		$thumbnail_url = get_img_url( $images[ $i ], 'thumbnail' );
		$fullsize_url  = get_img_url( $images[ $i ], 'large' );

		$links_output .= "
		<a data-rel='prettyPhoto[product-gallery-$name]' href='$fullsize_url' class='col-sm-2'>
			<img data-src='$thumbnail_url' src='$blank_url'>
		</a>";
	}

	$return = "
	<div class='gallery row'>
		<div class='images'>
			<a itemprop='image' data-rel='prettyPhoto[product-gallery-$name]' href='$fullsize_url'>
				<img data-src='$img_url' src='$blank_url'>
			</a>
		</div>
		<div class='thumbnails row'>
			$links_output
		</div>
	</div>";

	return strip( $return );
}

/**
 * Returns the HTML template for an image gallery.
 *
 * @param array $images an array of ACF images.
 */
function get_acf_carousel( $images ) {
	$links_output  = '';
	$images_output = '';

	for ( $i = 0; $i < count( $images ); $i++ ) {
		$img_tag = get_img_tag( $images[0] );
		$active  = 0 === $i ? 'active' : '';

		$links_output .= "<li data-target='#album' data-slide-to='$i'></li>";
		$images_output .= "<div class='item $active'>$img_tag</div>";
	}

	$return = "
	<div class='carousel slide' data-ride='carousel'>
		<ol class='carousel-indicators'>$links_output</ol>
		<div class='carousel-inner' role='listbox'>$images_output</div>
	</div>";

	return strip( $return );
}
