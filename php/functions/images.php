<?php
/**
 *
 * @package functions/images
 */

/**
 *
 */
function dt_add_featured_image_column_head( $defaults ) {

	$ordered = array();

	foreach ( $defaults as $key => $value ) {
		if ( 'title' === $key ) {
			$ordered['featured_image'] = ' ';
		}
		$ordered[ $key ] = $value;
	}

	return $ordered;
}

/**
 *
 */
function dt_add_featured_image_column( $column_name, $post_id ) {
	if ( 'featured_image' === $column_name ) {
		$featured_image_url = get_the_featured_image_url( $post_id, 'thumbnail' );

		if ( $featured_image_url ) {
			e( "<img src=$featured_image_url width=50 />" );
		}
	}
}

/**
 *
 */
function dt_add_featured_image_column_style() {
	echo '<style type="text/css">#featured_image { width: 50px; }</style>';
}

/**
 * Return BEM style css class names when inserting images via WordPress content editor
 */
function dt_get_image_tag_classes( $classes ) {
	list( $align, $size, $id ) = explode( ' ', $classes );

	$size = str_replace( 'size-', '', $size );

	return "img $align img__$size";
}

/**
 * Define the image sizes and their dimensions
 *
 * @ignore
 */
function dt_image_sizes() {
	return array(
		'thumbnail' => __( 'Thumbnail' ),
		'small'     => __( 'Small' ),
		'medium'    => __( 'Medium' ),
		'large'     => __( 'Large' ),
		'full'      => __( 'Original' ),
	);
}
