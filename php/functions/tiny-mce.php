<?php
/**
 *
 *
 * @package functions/tiny-mce
 */

/**
 * Disable the replacing of p tags in the case of double line breaks when tinymce is loaded
 *
 * @ignore
 */
function dt_tiny_mce_disable_wp_editor_formatting() {
	remove_filter( 'the_editor_content', 'wp_htmledwp_it_pre' );
	remove_filter( 'the_editor_content', 'wp_richedit_pre' );
	remove_filter( 'the_content', 'wpautop' );
	remove_filter( 'acf_the_content', 'wpautop' );
	remove_filter( 'the_content', 'wptexturize' );
	remove_filter( 'the_content', 'convert_chars' );
}

/**
 * Disable Shortcut keys for Tiny MCE
 *
 * @ignore
 */
function dt_tiny_mce_disable_shortcuts() {
	$return = "
	<script type='text/javascript'>
		tinymce.on('SetupEditor', function (ed) {
			ed.shortcuts = {
				add: function() {}
			};
		});
	</script>";

	e( strip( $return ) );
}

/**
 * Load custom tiny_mce stylesheets
 *
 * @ignore
 */
function dt_tiny_mce_stylesheets() {
	$stylesheets = array(
		get_url( 'wp-includes/js/tinymce/skins/lightgray/content.min.css' ),
		get_url( 'wp-includes/css/dashicons.min.css' ),
		get_url( 'wp-includes/js/tinymce/skins/wordpress/wp-content.css' ),
		get_base( 'wp-admin/tiny-mce.css' ),
	);

	return join( ',', $stylesheets );
}

/**
 * Load custom tiny_mce toolbar configuration
 *
 * @ignore
 * @todo add callback to allow the toolbar to be overwritten
 */
function dt_tiny_mce_toolbar() {
	$toolbar = array(
		'formatselect',
		'bold',
		'italic',
		'|',
		'bullist',
		'numlist',
		'indent',
		'outdent',
		'|',
		'alignleft',
		'aligncenter',
		'alignright',
		'|',
		'link',
		'unlink',
		'|',
		'table',
		'shortcodedrop',
		'|',
		'removeformat',
		'fullscreen',
	);

	return join( ',', $toolbar );
}

/**
 * Load custom tiny_mce block formats configuration
 *
 * @ignore
 * @todo add callback to allow the toolbar to be overwritten
 */
function dt_tiny_mce_block_formats() {
	$formats = array(
		'Heading 1=h1',
		'Heading 2=h2',
		'Heading 3=h3',
		'Heading 4=h4',
		'Text=p',
	);

	return join( ';', $formats );
}

/**
 * Load custom tiny_mce style formats configuration
 *
 * @ignore
 * @todo add callback to allow the toolbar to be overwritten
 */
function dt_tiny_mce_style_formats() {

	$style_formats = json_encode(
		array(
			array(
				'title'    => '',
				'selector' => '',
				'classes'  => '',
			),
		)
	);

	return $style_formats;
}

/**
 *
 */
function dt_tiny_mce_valid_elements() {
	$valid_elements = array(
		'h1[class|style]',
		'h2[class|style]',
		'h3[class|style]',
		'h4[class|style]',
		'h5[class|style]',
		'h6[class|style]',
		'img[class|width|height|alt|title|style]',
		'a[target|href|title|name|style]',
		'br',
		'b',
		'strong',
		'em',
		'i',
		'p[class|style]',
		'ol[class|style]',
		'ul[class|style]',
		'li[class|style]',
		'div[id|class|style]',
		'table[class|style]',
		'tr[class|style]',
		'td[colspan|rowspan|style]',
	);

	return join( ';', $valid_elements );
}



/**
 * Custom configure Tiny MCE
 *
 * @param object $init Tiny MCE configuration options to override.
 *
 * @ignore
 */
function dt_tiny_mce_options( $init ) {
	$init['content_css']             = dt_tiny_mce_stylesheets();
	$init['toolbar1']                = dt_tiny_mce_toolbar();
	$init['block_formats']           = dt_tiny_mce_block_formats();
	$init['style_formats']           = dt_tiny_mce_style_formats();
	$init['valid_elements']          = dt_tiny_mce_valid_elements();
	$init['invalid_styles']          = 'color font-size line-height letter-spacing margin padding';
	$init['paste_as_text']           = true;
	$init['custom_shortcuts']        = false;
	$init['force_p_newlines']        = true;
	$init['force_br_newlines']       = true;
	$init['remove_linebreaks']       = false;
	$init['convert_newlines_to_brs'] = true;
	$init['remove_redundant_brs']    = false;
	$init['verify_html']             = true;
	$init['cleanup_on_startup']      = false;
	$init['cleanup']                 = false;

	return $init;
}

/**
 * Custom configure Tiny MCE for ACF
 *
 * @param object $init Tiny MCE configuration options to override.
 *
 * @ignore
 */
function dt_tiny_mce_acf_options( $init ) {
	$init['Full']    = array();
	$init['Full'][1] = preg_split( '/,/', dt_tiny_mce_toolbar() );

	return $init;
}
