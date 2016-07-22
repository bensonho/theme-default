<?php

/**
 * Overriding the default wordpress menu to provide BEM style class names
 */
class BEM_Nav_Menu extends Walker_Nav_Menu {

  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    $slug       = slugify($item->title);
    $block_name = $args->menu_class;

    $selected_item = "";
    $selected_link = "";

    if (array_search("current-menu-item", $item->classes)) {
      $selected_item = "$block_name-item--selected";
      $selected_link = "$block_name-link--selected";
    }

    if (array_search("current-menu-parent", $item->classes)) {
      $selected_item .= " $block_name-item-parent--selected";
      $selected_link .= " $block_name-link-parent--selected";
    }

    $output .= "<li class='$block_name-item $block_name-item-$slug $selected_item'>";

    $atts = array();
    $atts['target'] = ! empty( $item->target ) ? $item->target : '';
    $atts['rel']    = ! empty( $item->xfn )    ? $item->xfn    : '';
    $atts['href']   = ! empty( $item->url )    ? $item->url    : '';
    // TODO: add $block_name-link-$slug as an ID instead of class
    $atts['class']  = "$block_name-link $block_name-link-$slug $selected_link";

    $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

    $attributes = '';

    foreach ( $atts as $attr => $value ) {
      if ( ! empty( $value ) ) {
        $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
        $attributes .= ' ' . $attr . '="' . $value . '"';
      }
    }

    $item_output = $args->before;
    $item_output .= '<a'. $attributes .'>';
    $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
    $item_output .= '</a>';
    $item_output .= $args->after;

    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }

  function start_lvl( &$output, $depth = 0, $args = array() ) {
    $block_name = $args->menu_class;

    $output .= "<ul class='$block_name-child'>";
  }

  function end_lvl( &$output, $depth = 0, $args = array() ) {
    $output .= "</ul>";
  }
}
