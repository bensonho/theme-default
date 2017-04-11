<?php
/**
 * Overriding the default wordpress menu to provide BEM style class names.
 *
 * @package functions/bem-nav-menu
 */
class BEM_Nav_Menu extends Walker_Nav_Menu {

	/**
	 * Override the default behaviour of navigation links.
	 *
	 * @param String  $output pointer to the output of the menu.
	 * @param Object  $item current menu item.
	 * @param Integer $depth current depth of the item's nesting.
	 * @param Array   $args arguments of the item.
	 * @param Integer $id item's post id.
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		if ( empty( $item->classes ) ) {
			return '';
		}

		$block_name = ! empty( $args->menu_class ) ? $args->menu_class : '';
		$item_class = reset( $item->classes );
		$item_slug  = '';
		$item_title = apply_filters( 'the_title', $item->title, $item->ID );
		$link_class = '';
		$link_slug  = '';

		// Add the selected class.
		if ( array_search( 'current-menu-item', $item->classes ) ) {
			$item_class .= " $block_name-item--selected";
			$link_class .= " $block_name-link--selected";
		}

		// Add the parent selected class.
		if ( array_search( 'current-menu-parent', $item->classes ) ) {
			$item_class .= " $block_name-item-parent--selected";
			$link_class .= " $block_name-link-parent--selected";
		}

		// Add the has-children class.
		if ( array_search( 'menu-item-has-children', $item->classes ) ) {
			$item_class .= " $block_name-item-has-children";
			$link_class .= " $block_name-link-has-children";
		}

		if ( ! empty( $args->slug_class ) ) {
			$item_slug .= "$block_name-item-{slugify( $item->title )}";
			$link_slug .= "$block_name-link-{slugify( $item->title )}";
		}

		// Link attributes.
		$attributes           = array();
		$attributes['class']  = "$block_name-link $link_slug $link_class";
		$attributes['href']   = ! empty( $item->url ) ? $item->url : '';
		$attributes['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
		$attributes['target'] = ! empty( $item->target ) ? $item->target : '';
		$attributes['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';

		// Filter to allow more attributes to be added.
		$attributes = apply_filters( 'nav_menu_link_attributes', $attributes, $item, $args, $depth );

		// Flatten out the attributes list into a string.
		$attributes_output = '';

		foreach ( $attributes as $attribute => $value ) {
			if ( ! empty( $value ) ) {
				$value = 'href' === $attribute ? esc_url( $value ) : esc_attr( $value );
				$attributes_output .= " $attribute='$value'";
			}
		}

		$output .= "<li class='$block_name-item $item_slug $item_class'>";

		$link_output = "
		{$args->before}
		<a $attributes_output>
			{$args->link_before}
			$item_title
			{$args->link_after}
		</a>
		{$args->after}
		";

		// Filter to add more stuff after the link.
		$output .= apply_filters( 'walker_nav_menu_start_el', $link_output, $item, $depth, $args );
	}

	/**
	 * Override the default behaviour of navigation child list.
	 *
	 * @param String  $output pointer to the output of the menu.
	 * @param Integer $depth current depth of the item's nesting.
	 * @param Array   $args arguments of the item.
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$block_name = ! empty( $args->menu_class ) ? $args->menu_class : '';

		$output .= "<ul class='$block_name-child'>";
	}

}
