<?php
/**
 * Setup menu in WP admin.
 *
 * @author 		Sebs Studio
 * @category 	Admin
 * @package 	MailPoet Paid Memberships Pro Add-on/Admin
 * @version 	1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'MailPoet_Paid_Memberships_Pro_Addon_Admin_Menus' ) ) {

/**
 * MailPoet_Paid_Memberships_Pro_Addon_Admin_Menus Class
 */
class MailPoet_Paid_Memberships_Pro_Addon_Admin_Menus {

	/**
	 * Hook in tabs.
	 */
	public function __construct() {
		// Add menus
		add_action( 'admin_menu', array( &$this, 'admin_menu' ), 9 );
	}

	/**
	 * Add menu items
	 */
	public function admin_menu() {
		$settings_page = add_submenu_page( 'paid-memberships-pro', __( 'MailPoet Paid Memberships Pro Settings', 'mailpoet_paid_memberships_pro_addon' ),  __( 'MailPoet PMPro', 'mailpoet_paid_memberships_pro_addon' ) , 'manage_options', 'paid-memberships-pro-settings', array( &$this, 'settings_page' ) );
	}

	/**
	 * Init the settings page
	 */
	public function settings_page() {
		include_once( 'class-mailpoet-paid-memberships-pro-addon-admin-settings.php' );
		MailPoet_Paid_Memberships_Pro_Addon_Admin_Settings::output();
	}

}

} // end if class exists.

return new MailPoet_Paid_Memberships_Pro_Addon_Admin_Menus();

?>