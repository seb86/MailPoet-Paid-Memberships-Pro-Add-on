<?php
/**
 * Display notices in admin.
 *
 * @author 		Sebs Studio
 * @category 	Admin
 * @package 	MailPoet Paid Memberships Pro Add-on/Admin
 * @version 	1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'MailPoet_Paid_Memberships_Pro_Addon_Admin_Notices' ) ) {

/**
 * MailPoet_Paid_Memberships_Pro_Addon_Admin_Notices Class
 */
class MailPoet_Paid_Memberships_Pro_Addon_Admin_Notices {

	/**
	 * Hook in tabs.
	 */
	public function __construct() {
		add_action( 'admin_print_styles', array( &$this, 'add_notices' ) );
	}

	/**
	 * Add notices + styles if needed.
	 */
	public function add_notices() {
		if ( get_option( '_mailpoet_paid_memberships_pro_add_on_needs_update' ) == 1 ) {
			wp_enqueue_style( 'plugin-name-activation', MailPoet_Paid_Memberships_Pro_Addon()->plugin_url() . '/assets/css/activation.css' );
			add_action( 'admin_notices', array( &$this, 'install_notice' ) );
		}
	}

	/**
	 * Show the install notices
	 */
	function install_notice() {
		// If we need to update, include a message with the update button
		if ( get_option( '_mailpoet_paid_memberships_pro_add_on_needs_update' ) == 1 ) {
			include( 'views/html-notice-update.php' );
		}
	}

}

} // end if class exists.

return new MailPoet_Paid_Memberships_Pro_Addon_Admin_Notices();

?>