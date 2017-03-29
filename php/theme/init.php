<?php
/**
 * Contains all the overriding of any undesirable default behaviour of wordpress
 * as well as any generic initialising
 *
 * @package functions/reset
 */

/**
 * Perform resets on the initialization of wordpress
 *
 * @ignore
 */
function dt_init() {
	// Remove unecessary meta tags.
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'rsd_link' );

	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );

	// Remove content filters.
	remove_filter( 'the_content', 'wpautop' );
	remove_filter( 'acf_the_content', 'wpautop' );
	remove_filter( 'the_content', 'wptexturize' );
	remove_filter( 'the_content', 'convert_chars' );

	// Enable featured images.
	add_theme_support( 'post-thumbnails' );

	// Enable widgets.
	register_sidebar( array( 'name' => '' ) );

	// Load assets.
	wp_enqueue_style( 'index', get_base( 'index.css' ), array(), get_version( 'index.css' ), 'all' );
	wp_enqueue_script( 'index', get_base( 'index.js' ), array(), get_version( 'index.js' ) );

	// Define the dimensions for each image size.
	add_filter( 'image_size_names_choose', 'custom_image_sizes' );
	add_image_size( 'thumbnail', 100, 100, true );
	add_image_size( 'small', 250, 0 );
	add_image_size( 'medium', 540, 0 );
	add_image_size( 'large', 1170, 0 );

	// Create the default menus.
	wp_create_nav_menu( 'Header' );
	wp_create_nav_menu( 'Footer' );
}

add_action( 'init', 'dt_init', 100 );

