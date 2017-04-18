<?php
/**
 * General helpers
 *
 * @package helpers/utilities
 */

/**
 *
 *
 * @param string $value The string to debug.
 */
function d( $value ) {
	echo '<pre>';
	print_r( $value );
	echo '</pre>';
}

/**
 *
 */
function e( $value ) {
	_e( $value );
}

/**
 * Remove all superfluous whitespace in a string.
 *
 * @param string $value The string to strip.
 */
function strip( $value ) {
	$value = preg_replace( '/\s+/', ' ', $value );

	return $value;
}

/**
 *
 */
function get_body_id() {
	$url = 'body-' . str_replace( '/', '', $_SERVER[ 'REQUEST_URI' ] );

	return $url;
}

/**
 *
 */
function body_id() {
	e( get_body_id() );
}

/**
 * Convert any string into a url slug.
 *
 * @param string $value The string to slugify.
 */
function slugify( $value ) {
	// Replace non letter or digits by dash.
	$value = preg_replace( '~[^\\pL\d]+~u', '-', $value );

	// Trim the value.
	$value = trim( $value, '-' );

	// Transliterate.
	$value = iconv( 'utf-8', 'us-ascii//TRANSLIT', $value );

	// Lowercase.
	$value = strtolower( $value );

	// Remove unwanted characters.
	$value = preg_replace( '~[^-\w]+~', '', $value );

	if ( empty( $value ) ) {
		return 'n-a';
	}

	return $value;
}

/**
 * Determines whether an array is associative or sequential.
 *
 * @param array $value The array to test.
 */
function is_assoc( $value ) {
	return array_keys( $value ) !== range( 0, count( $value ) - 1 );
}
