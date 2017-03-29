<?php
/**
 * Define all functions
 *
 * @package functions
 */

// Functions
// Initial configurations of the wordpress theme.
require_once( 'functions/utilities.php' );
require_once( 'functions/reset.php' );
require_once( 'functions/wp-admin.php' );
require_once( 'functions/disable.php' );

// Helper functions.
require_once( 'helpers/html.php' );
require_once( 'helpers/post.php' );
require_once( 'helpers/advanced-custom-fields.php' );
require_once( 'helpers/slider-gallery.php' );
require_once( 'helpers/bem-nav-menu.php' );

// Theme specific functionality.
require_once( 'theme/theme.php' );
