<?php
/**
 * General helpers
 *
 * @package utilities
 */


/**
 * Output the contents of a variable in a readable format
 *
 * @param object $value The value to output.
 */
function o( $value ) {
	echo '<pre>';
	print_r( $value );
	echo '</pre>';

	// var_dump($value);
}


/**
 *
 */
function strip( $text ) {
	$text = preg_replace( '/\s+/', ' ', $text );

	return $text;
}


function get_body_id() {
	$url = 'body-' . str_replace( '/', '', $_SERVER[ 'REQUEST_URI' ] );

	return $url;
}


function body_id() {
	echo get_body_id();
}


/**
 *
 */
function slugify( $text ) {
	// Replace non letter or digits by dash
	$text = preg_replace( '~[^\\pL\d]+~u', '-', $text );

	// Trim the text.
	$text = trim( $text, '-' );

	// Transliterate.
	$text = iconv( 'utf-8', 'us-ascii//TRANSLIT', $text );

	// Lowercase.
	$text = strtolower( $text );

	// Remove unwanted characters.
	$text = preg_replace( '~[^-\w]+~', '', $text );

	if ( empty( $text ) ) {
		return 'n-a';
	}

	return $text;
}


/**
 * Determines whether an array is associative or numeric
 *
 * @param array $arr The array to test.
 */
function is_assoc( $arr ) {
	return array_keys( $arr ) !== range( 0, count( $arr ) - 1 );
}


/**
 * Return a partial template by its name
 *
 * @param string $name The name of the partial template.
 */
function get_partial( $name ) {
	return file_get_contents( locate_template( $name ) );
}


/**
 * Output a partial
 *
 * @param string $name The name of the partial template.
 */
function partial( $name ) {
	echo get_partial( $name );
}


/**
 * Return the HTML template of a page's breadcrumb
 *
 * @param page $page The page.
 */
function get_breadcrumb( $page ) {
	$separator = " » ";
	$output = '';

	if ( ! is_front_page() ) {
		if ( is_page() && $page->post_parent ) {
			$home = get_the_page( get_option( 'page_on_front' ) );
			for ( $i = count( $page->ancestors )-1; $i >= 0; $i-- ) {
				if ( ( $home->ID ) !== ( $page->ancestors[ $i ] ) ) {
					$output .= '<a href="';
					$output .= get_permalink( $page->ancestors[ $i ] );
					$output .= '">';
					$output .= get_the_title( $page->ancestors[ $i ] );
					$output .= '</a>' . $separator;
				}
			}
		} elseif ( is_404() ) {
			$output .= '404';
		}
	} else {
		$output .= get_bloginfo( 'name' );
	}

	if ( $output === '' ) {
		return;
	}

	return "<div class='breadcrumb'>$output</div>";
}


/**
 * Output the HTML template of a page's breadcrumb
 *
 * @param page $page The page.
 */
function breadcrumb( $page ) {
	echo get_breadcrumb( $page );
}


/**
 *
 */
function tags() {
	$tags = get_tags();

	if ( ! empty( $tags ) ) {
		$output = '';
		$output .= "<ul class='tags'>";
		$output .= "<li class='tag__item'><a class='tag__link' href='/whats-new/'>View All</a></li>";

		foreach ( $tags as $tag ) {
			$name = $tag->name;
			$slug = $tag->slug;

			$selected      = '';
			$selected_link = '';

			if ( $tag->term_id === get_queried_object()->term_id ) {
				$selected      = 'tag__item--selected';
				$selected_link = 'tag__link--selected';
			}

			$output .= "<li class='tag__item $selected'><a class='tag__link $selected_link' href='/whats-new/tags/$slug'>$name</a></li>";
		}

		$output .= '</ul>';

		echo $output;
	}
}


/**
 * Return the HTML template of the navigation.
 *
 * @todo this function is incomplete
 */
function get_navigation( $menu = '', $class_name = '' ) {
	$class_name = $class_name !== '' ? $class_name : $menu;

	$navigation = wp_nav_menu( array(
		'menu'            => $menu,
		'menu_class'      => "navigation__$class_name",
		'container_id'    => "navigation__$menu",
		'container_class' => ' ',
		'container'       => 'nav',
		'echo'            => false,
		'walker'          => new BEM_Nav_Menu,
	));

	return strip( $navigation );
}


/**
 * Output the HTML template of the navigation.
 *
 * @todo this function is incomplete
 */
function navigation( $menu = '', $class_name = '' ) {
	echo get_navigation( $menu, $class_name );
}
