<?php
/**
 * MailPoet Paid Memberships Pro Add-on Uninstall
 *
 * Uninstalling MailPoet Paid Memberships Pro Add-on 
 * deletes profile fields and options.
 *
 * @author 		Sebs Studio
 * @category 	Core
 * @package 	MailPoet Paid Memberships Pro Add-on/Uninstaller
 * @version 	1.0.0
 */
if( !defined('WP_UNINSTALL_PLUGIN') ) exit();

// For Single site
if ( !is_multisite() ) {

	// Your uninstall code goes here.
	// List each option to delete here.
	delete_option( 'option_name' );
} 
// For Multisite
else {
	global $wpdb;

	$blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
	$original_blog_id = get_current_blog_id();

	foreach ( $blog_ids as $blog_id ) {
		switch_to_blog( $blog_id );

		// Your uninstall code goes here.
		// List each option to delete here.
		delete_site_option( 'option_name' );
	}

	switch_to_blog( $original_blog_id );
}
?>