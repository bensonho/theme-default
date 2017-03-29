<?php
/**
 * Contains a bunch of functions which disable a bunch of unecessary
 * functionality from wordpress
 *
 * @package functions/disable
 */

/**
 * Disable support for comments and trackbacks in post types
 *
 * @ignore
 */
function dt_disable_comments_post_types_support() {
	$post_types = get_post_types();

	foreach ( $post_types as $post_type ) {
		if ( post_type_supports( $post_type, 'comments' ) ) {
			remove_post_type_support( $post_type, 'comments' );
			remove_post_type_support( $post_type, 'trackbacks' );
		}
	}
}

/**
 * Close comments on the front-end
 *
 * @ignore
 */
function dt_disable_comments_status() {
	return false;
}

/**
 * Hide existing comments
 *
 * @ignore
 */
function dt_disable_comments_hide_existing_comments( $comments ) {
	$comments = array();

	return $comments;
}

/**
 * Remove comments page in menu
 *
 * @ignore
 */
function dt_disable_comments_admin_menu() {
	remove_menu_page( 'edit-comments.php' );
}

/**
 * Redirect any user trying to access comments page
 *
 * @ignore
 */
function dt_disable_comments_admin_menu_redirect() {
	global $pagenow;

	if ( $pagenow === 'edit-comments.php' ) {
		wp_redirect( admin_url() );
		exit;
	}
}

/**
 * Remove comments metabox from dashboard
 *
 * @ignore
 */
function dt_disable_comments_dashboard() {
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
}

/**
 * Remove comments links from admin bar
 *
 * @ignore
 */
function dt_disable_comments_admin_bar() {
	if ( is_admin_bar_showing() ) {
		remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
	}
}

/**
 * Disable custom fields
 *
 * @ignore
 */
function dt_customize_meta_boxes() {
	remove_meta_box( 'postcustom', 'post', 'normal' );
}

/**
 * Disable categories
 *
 * @ignore
 */
function dt_disable_categories() {
	register_taxonomy( 'category', array() );
}

/**
 * Remove tags functionality across the board
 *
 * @ignore
 */
function dt_remove_tags() {
	register_taxonomy( 'post_tag', array() );
}

