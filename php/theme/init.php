<?php
/**
 * Contains all the overriding of any undesirable default behaviour of wordpress
 * as well as any generic initialising
 *
 * @package theme/init
 */

/**
 * Initialization
 *
 * @ignore
 */
function dt_init() {
	// Only initialize for the public site.
	if ( is_admin() ) {
		return;
	}

	// Remove unecessary meta tags.
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_head', 'rest_output_link_wp_head' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );

	// Remove content filters.
	remove_filter( 'the_content', 'convert_chars' );
	remove_filter( 'the_content', 'wpautop' );
	remove_filter( 'the_content', 'wptexturize' );
	remove_filter( 'acf_the_content', 'wpautop' );

	// Enable featured images.
	add_theme_support( 'post-thumbnails' );

	// Replace the default gallery.
	add_filter( 'use_default_gallery_style', '__return_false' );
	remove_shortcode( 'gallery' );
	add_shortcode( 'gallery', 'dt_gallery' );

	// Replace the default gallery with a slider.
	// add_filter( 'use_default_gallery_style', '__return_false' );
	// remove_shortcode( 'gallery' );
	// add_shortcode( 'gallery', 'dt_gallery_slider' );

	// Load assets.
	wp_enqueue_style( 'index', get_base( 'index.css' ), array(), get_file_version( 'index.css' ), 'all' );
	wp_enqueue_script( 'index', get_base( 'index.js' ), array(), get_file_version( 'index.js' ) );

	// Load the Internet Explorer compatibility script.
	wp_enqueue_script( 'internet-explorer', get_base( 'ie.js' ), array(), get_file_version( 'ie.js' ) );
	wp_script_add_data( 'internet-explorer', 'conditional', 'lt IE 9' );

	// Disable default assets.
	wp_deregister_script( 'wp-embed' );

	// Define the dimensions for each image size.
	add_filter( 'image_size_names_choose', 'custom_image_sizes' );

	add_image_size( 'thumbnail', 100, 100, true );
	add_image_size( 'small', 250, 0 );
	add_image_size( 'medium', 540, 0 );
	add_image_size( 'large', 1170, 0 );
}

add_action( 'init', 'dt_init' );
