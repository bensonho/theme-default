<?php
/**
 * Contains any additional default functionality or overriding of any
 * undesirable default functionality.
 *
 * @package theme/admin-init
 */

/**
 * Initialize all callbacks in the admin_init
 *
 * @ignore
 */
function dt_wp_admin_init() {

	// Load admin specific styles.
	wp_enqueue_style( 'wp-admin', get_base( 'wp-admin/wp-admin.css' ), array(), get_file_version( 'wp-admin/wp-admin.css' ), 'all' );

	// Hide Administrator accounts.
	add_action( 'pre_user_query', 'hide_administrators' );
	add_filter( 'editable_roles', 'remove_administrator_role' );

	// Tiny MCE settings.
	add_action( 'media_buttons', 'dt_tiny_mce_disable_wp_editor_formatting' );
	add_filter( 'after_wp_tiny_mce', 'dt_tiny_mce_disable_shortcuts' );
	add_filter( 'tiny_mce_before_init', 'dt_tiny_mce_options' );
	add_filter( 'acf/fields/wysiwyg/toolbars', 'dt_tiny_mce_acf_options' );

	// Display post thumbnail in the column.
	add_filter( 'manage_posts_columns', 'dt_add_featured_image_column_head' );
	add_action( 'manage_posts_custom_column', 'dt_add_featured_image_column', 10, 2 );
	add_action( 'admin_head', 'dt_add_featured_image_column_style' );

	// Override image tag classes.
	add_filter( 'get_image_tag_class', 'dt_get_image_tag_classes' );

	// Turn off all plugin update warnings.
	remove_action( 'load-update-core.php', 'wp_update_plugins' );
	add_filter( 'pre_site_transient_update_plugins', '__return_null' );
}

add_action( 'admin_init', 'dt_wp_admin_init' );

