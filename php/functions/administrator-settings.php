<?php
/**
 * Functions related specifically to administrator accounts within wp-admin
 *
 * @package functions/administrator-settings
 */

/**
 * Hide administrators from the list of users unless the current user is an administrator
 *
 * @param Object $user_search User search object.
 * @ignore
 */
function hide_administrators( $user_search ) {
	if ( ! current_user_can( 'administrator' ) ) {
		global $wpdb;

		$users_table      = $wpdb->users;
		$metadata_table   = $wpdb->usermeta;
		$capabilities_key = $wpdb->prefix . 'capabilities';

		$query = "
		WHERE 1=1 AND $users_table.ID IN (
			SELECT $users_table.user_id FROM $users_table
			WHERE  $metadata_table.meta_key = '$capabilities_key'
			AND    $metadata_table.meta_value NOT LIKE '%administrator%'
		)
		";

		$user_search->query_where = str_replace( 'WHERE 1=1', $query, $user_search->query_where );
	}
}

/**
 * Disables the ability for any roles other than administrator add the administrator role.
 *
 * @param Array $editable_roles List of editable roles available for the current user.
 * @ignore
 */
function remove_administrator_role( $editable_roles ) {
	// Remove the administrator role.
	if ( ! current_user_can( 'administrator' ) ) {
		unset( $editable_roles['administrator'] );
	}

	return $editable_roles;
}

