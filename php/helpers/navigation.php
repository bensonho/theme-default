<?php
/**
 * Navigation helpers
 *
 * @package helpers/navigation
 */

/**
 * Return the HTML template of the navigation
 *
 * @param string $menu The name of the WordPress menu.
 * @param string $class_name The class name for the menu.
 */
function get_navigation( $menu = '', $class_name = '' ) {
	$class_name = $class_name !== '' ? $class_name : $menu;

	$navigation = wp_nav_menu( array(
		'theme_location'  => $menu,
		'menu_class'      => "navigation__$class_name",
		'container_id'    => "navigation__$menu",
		'container_class' => ' ',
		'container'       => 'ul',
		'echo'            => false,
		'walker'          => new BEM_Nav_Menu,
	));

	return strip( $navigation );
}

/**
 * Output the HTML template of the navigation
 *
 * @param string $menu The name of the WordPress menu.
 * @param string $class_name The class name for the menu.
 */
function navigation( $menu = '', $class_name = '' ) {
	e( get_navigation( $menu, $class_name ) );
}
