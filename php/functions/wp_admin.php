<?php
/**
 * Contains all the overriding of any undesirable default behaviour
 *
 * @package wp_admin
 */

/**
 * Load custom stylesheets for Admin
 *
 * @ignore
 */
function load_custom_wp_admin_style() {
	wp_register_style( 'custom_wp_admin_css', get_template_directory_uri() . '/wp-admin.css', false, '1.0.0' );
	wp_enqueue_style( 'custom_wp_admin_css' );
}

add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );
// add_action('admin_bar_init', 'load_custom_wp_admin_style');
// add_action('login_init', 'load_custom_wp_admin_style');

/**
 * Custom configure Tiny MCE
 *
 * @ignore
 */
function tiny_mce_options( $init ) {
	$stylesheets = array(
		home_url() . '/wp-includes/js/tinymce/skins/lightgray/content.min.css',
		home_url() . '/wp-includes/css/dashicons.min.css',
		home_url() . '/wp-includes/js/tinymce/skins/wordpress/wp-content.css',
		get_template_directory_uri() . '/wp_admin.css',
	);

	$init['content_css']             = join( ',', $stylesheets );
	$init['toolbar1']                = 'formatselect,bold,italic,underline,bullist,numlist,alignleft,aligncenter,alignright,link,unlink,hr';
	$init['toolbar2']                = '';
	$init['block_formats']           = 'HEADER 1=h1;Header 2=h2;Header 3=h3;Header 4=h4;Text=p';
	$init['valid_elements']          = '*[*]';
	$init['extended_valid_elements'] = '*[*]';
	$init['custom_shortcuts']        = false;
	$init['force_p_newlines']        = true;
	$init['force_br_newlines']       = true;
	$init['remove_linebreaks']       = false;
	$init['convert_newlines_to_brs'] = true;
	$init['remove_redundant_brs']    = false;
	$init['verify_html']             = false;
	$init['cleanup_on_startup']      = false;
	$init['cleanup']                 = false;

	return $init;
}

add_filter( 'tiny_mce_before_init', 'tiny_mce_options' );
add_filter( 'acf/fields/wysiwyg/toolbars' , 'tiny_mce_options' );

/**
 * Disable the replacing of p tags in the case of double line breaks when tinymce is loaded
 */
function disable_wp_editor_formatting() {
	remove_filter( 'the_editor_content', 'wp_htmledwp_it_pre' );
	remove_filter( 'the_editor_content', 'wp_richedit_pre' );
}
add_action( 'media_buttons', 'disable_wp_editor_formatting' );

/**
 * Disable Shortcut keys for Tiny MCE
 *
 * @ignore
 */
function tiny_mce_disable_shortcuts() {
	echo "
	<script type='text/javascript'>
		tinymce.on('SetupEditor', function (ed) {
			ed.shortcuts = {
				add: function() {}
			};
		});
	</script>";
}
add_filter( 'after_wp_tiny_mce', 'tiny_mce_disable_shortcuts' );


