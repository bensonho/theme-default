<?php
/**
 * Define all functions
 *
 * @package functions
 */

// Functions.
require_once( 'functions/class.bem-nav-menu.php' );
require_once( 'functions/scale-up-image.php' );
require_once( 'functions/administrator-settings.php' );
require_once( 'functions/images.php' );
require_once( 'functions/disable.php' );

// Helpers.
require_once( 'helpers/html.php' );
require_once( 'helpers/utilities.php' );
require_once( 'helpers/post.php' );
require_once( 'helpers/navigation.php' );
require_once( 'helpers/gallery.php' );
require_once( 'helpers/advanced-custom-fields.php' );

// Theme specific functionality.
// require_once( 'theme/' );

// Initialize Theme.
require_once( 'theme/admin-init.php' );
require_once( 'theme/init.php' );
