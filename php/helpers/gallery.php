<?php
/**
 * Gallery related helpers
 *
 * @package helpers/gallery
 */

/**
 * Overriding wordpress's default gallery HTML template
 *
 * @param Attributes $options post attributes.
 * @todo handle links.
 * @todo make the pinterest link optional.
 */
function dt_gallery( $options ) {
	global $post;
	$columns        = ! empty( $options['columns'] ) && $options['columns'] <= 4 ? $options['columns'] : 3;
	$size           = ! empty( $options['size'] ) ? $options['size'] : 'medium';
	$class_name     = ! empty( $options['class'] ) ? $options['class'] : '';
	$return         = '';
	$images_output  = '';
	$column_classes = array(
		1 => 'full',
		2 => 'half',
		3 => 'third',
		4 => 'quarter',
	);

	if ( empty( $options['ids'] ) ) {
		return '';
	}

	$posts = get_posts( array(
		'include'        => $options['ids'],
		'post_type'      => 'attachment',
		'post_status'    => 'inherit',
		'post_mime_type' => 'image',
		'orderby'        => 'post__in',
	) );

	if ( empty( $posts ) ) {
		return '';
	}

	$permalink   = get_permalink( $post );
	$description = $post->post_title . ' – ' . get_bloginfo( 'name' );

	foreach ( $posts as $index => $image ) {
		$url       = wp_get_attachment_image_src( $image->ID, $size )[0];
		$col_class = $column_classes[ $columns ];
		$remainder = ( $index+1 ) % $columns;
		$title     = $image->post_title;
		$content   = $image->post_content;

		$images_output .= "
		<div class='gallery__col-$col_class'>
			<a href='http://pinterest.com/pin/create/button/?url=$permalink&media=$url&description=$description' class='pinterest-button' target='_blank'>
				<img src='$url' class='gallery__image gallery__image--$size' title='$title' alt='$content'>
			</a>
		</div>";

		if ( 0 === $remainder && 0 !== $index ) {
			$images_output .= "</div><div class='gallery__row'>";
		}
	}

	$return = "
	<div class='gallery $class_name'>
		<div class='gallery__row'>
			$images_output
		</div>
	</div>
	";

	return strip( $return );
}

/**
 * Overriding wordpress's default gallery HTML template to accomodate for the jQuery slider plugin
 *
 * @param object $options post attributes.
 */
function dt_gallery_slider( $options ) {
	$columns       = ! empty( $options['columns'] ) ? $options['columns'] : 0;
	$size          = ! empty( $options['size'] ) ? $options['size'] : 'medium';
	$return        = '';
	$images_output = '';
	$posts         = get_posts( array(
		'include'        => $options['ids'],
		'post_type'      => 'attachment',
		'post_status'    => 'inherit',
		'post_mime_type' => 'image',
		'orderby'        => 'post__in',
	) );

	if ( empty( $options['ids'] ) ) {
		return '';
	}

	if ( empty( $posts ) ) {
		return '';
	}

	foreach ( $posts as $image ) {
		$url = wp_get_attachment_image_src( $image->ID, $size )[0];
		$images_output .= "<img src='$url' class='slide'>";
	}

	$return = "
	<div class='slides'>
		$images_output
	</div>
	";

	return strip( $return );
}
