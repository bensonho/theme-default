<?php
/**
 * General helpers
 *
 * @package helpers/utilities
 */

/**
 *
 */
function e( $value ) {
	_e( $value );
}

/**
 *
 */
function strip( $text ) {
	$text = preg_replace( '/\s+/', ' ', $text );

	return $text;
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
 *
 */
function slugify( $text ) {
	// Replace non letter or digits by dash.
	$text = preg_replace( '~[^\\pL\d]+~u', '-', $text );

	// Trim the text.
	$text = trim( $text, '-' );

	// Transliterate.
	$text = iconv( 'utf-8', 'us-ascii//TRANSLIT', $text );

	// Lowercase.
	$text = strtolower( $text );

	// Remove unwanted characters.
	$text = preg_replace( '~[^-\w]+~', '', $text );

	if ( empty( $text ) ) {
		return 'n-a';
	}

	return $text;
}

/**
 * Determines whether an array is associative or numeric
 *
 * @param array $arr The array to test.
 */
function is_assoc( $arr ) {
	return array_keys( $arr ) !== range( 0, count( $arr ) - 1 );
}
