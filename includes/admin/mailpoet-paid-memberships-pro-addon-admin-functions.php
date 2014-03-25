<?php
/**
 * MailPoet Paid Memberships Pro Add-on Admin Functions
 *
 * @author 		Sebs Studio
 * @category 	Core
 * @package 	MailPoet Paid Memberships Pro Add-on/Admin/Functions
 * @version 	1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Get all MailPoet Paid Memberships Pro Add-on screen ids
 *
 * @return array
 */
function mailpoet_paid_memberships_pro_addon_get_screen_ids() {
	$mailpoet_paid_memberships_pro_addon_screen_id = strtolower( 'MailPoet Paid Memberships Pro Add-on');

	return array(
		'toplevel_page_' . $mailpoet_paid_memberships_pro_addon_screen_id,
		'settings_page_pmpro-mailpoet',
	);
}

/**
 * Output admin fields.
 *
 * Loops though the MailPoet Paid Memberships Pro Add-on options array and outputs each field.
 *
 * @param array $options Opens array to output
 */
function mailpoet_paid_memberships_pro_addon_admin_fields( $options ) {
	if ( ! class_exists( 'MailPoet_Paid_Memberships_Pro_Addon_Admin_Settings' ) ) {
		include 'class-mailpoet-paid-memberships-pro-add-on-admin-settings.php';
	}

	MailPoet_Paid_Memberships_Pro_Addon_Admin_Settings::output_fields( $options );
}

/**
 * Update all settings which are passed.
 *
 * @access public
 * @param array $options
 * @return void
 */
function mailpoet_paid_memberships_pro_addon_update_options( $options ) {
	if ( ! class_exists( 'MailPoet_Paid_Memberships_Pro_Addon_Admin_Settings' ) ) {
		include 'class-mailpoet-paid-memberships-pro-add-on-admin-settings.php';
	}

	MailPoet_Paid_Memberships_Pro_Addon_Admin_Settings::save_fields( $options );
}

/**
 * Get a setting from the settings API.
 *
 * @param mixed $option
 * @return string
 */
function mailpoet_paid_memberships_pro_addon_settings_get_option( $option_name, $default = '' ) {
	if ( ! class_exists( 'MailPoet_Paid_Memberships_Pro_Addon_Admin_Settings' ) ) {
		include 'class-mailpoet-paid-memberships-pro-add-on-admin-settings.php';
	}

	return MailPoet_Paid_Memberships_Pro_Addon_Admin_Settings::get_option( $option_name, $default );
}

?>