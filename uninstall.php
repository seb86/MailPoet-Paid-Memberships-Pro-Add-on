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

	delete_option( 'mailpoet_paid_memberships_pro_add_on_enable_checkout' );
	delete_option( 'mailpoet_paid_memberships_pro_add_on_checkout_label' );
	delete_option( 'mailpoet_paid_memberships_pro_subscribe_too' );

	// Delete user meta data from all users.
	$all_user_ids = get_users( 'fields=ID' );
	foreach ( $all_user_ids as $user_id ) {
		delete_user_meta( $user_id, 'pmpro_user_subscribe_to_mailpoet' );
	}

} 
// For Multisite
else {
	global $wpdb;

	$blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
	$original_blog_id = get_current_blog_id();

	foreach ( $blog_ids as $blog_id ) {
		switch_to_blog( $blog_id );

		delete_site_option( 'mailpoet_paid_memberships_pro_add_on_enable_checkout' );
		delete_site_option( 'mailpoet_paid_memberships_pro_add_on_checkout_label' );
		delete_site_option( 'mailpoet_paid_memberships_pro_subscribe_too' );
	}

	switch_to_blog( $original_blog_id );
}
?>