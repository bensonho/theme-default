<?php
/**
 * Functions that only are specific to this theme
 *
 * @package theme/theme-settings
 */

/**
 * Initialize styles and scripts
 *
 * @ignore
 */
function dt_init_theme() {
	// Create the default menus.
	register_nav_menus( array(
		'header' => 'Header',
		'footer' => 'Footer',
	) );

}

add_action( 'init', 'dt_init_theme' );
