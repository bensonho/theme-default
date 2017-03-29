<?php

/**
 * Hide administrators from the list of users unless the current user is an administrator
 */
function hide_administrators( $user_search ) {
	if ( ! current_user_can( 'administrator' ) ) {
		global $wpdb;
		$query = "
		WHERE 1=1 AND {$wpdb->users}.ID IN (
		SELECT {$wpdb->usermeta}.user_id FROM $wpdb->usermeta
		WHERE  {$wpdb->usermeta}.meta_key = '{$wpdb->prefix}capabilities'
		AND    {$wpdb->usermeta}.meta_value NOT LIKE '%administrator%')";

		$user_search->query_where = str_replace( 'WHERE 1=1', $query, $user_search->query_where );
	}
}

/**
 * Disables the ability for any roles other than administrator add the administrator role
 */
function remove_administrator_role( $editable_roles ) {
	if ( ! current_user_can( 'administrator' ) ) {
		unset( $editable_roles['administrator'] );
	}

	return $editable_roles;
}

