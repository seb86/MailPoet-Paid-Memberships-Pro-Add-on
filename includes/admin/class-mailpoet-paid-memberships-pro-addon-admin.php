<?php
/**
 * MailPoet Paid Memberships Pro Add-on Admin.
 *
 * @author 		Sebs Studio
 * @category 	Admin
 * @package 	MailPoet Paid Memberships Pro Add-on/Admin
 * @version 	1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'MailPoet_Paid_Memberships_Pro_Addon_Admin' ) ) {

	class MailPoet_Paid_Memberships_Pro_Addon_Admin {

		/**
		 * Constructor
		 */
		public function __construct() {
			// Actions
			add_action( 'init', array( &$this, 'includes' ) );
			add_action( 'current_screen', array( $this, 'conditonal_includes' ) );
		}

		/**
		 * Include any classes we need within admin.
		 */
		public function includes() {
			// Functions
			include( 'mailpoet-paid-memberships-pro-addon-admin-functions.php' );

			// Classes we only need if the ajax is not-ajax
			if ( ! is_ajax() ) {
				include( 'class-mailpoet-paid-memberships-pro-addon-admin-menus.php' );
				include( 'class-mailpoet-paid-memberships-pro-addon-admin-notices.php' );

				// Help
				if ( apply_filters( 'mailpoet_paid_memberships_pro_add_on_enable_admin_help_tab', true ) ) {
					include( 'class-mailpoet-paid-memberships-pro-addon-admin-help.php' );
				}
			}
		}

		/**
		 * Include admin files conditionally
		 */
		public function conditonal_includes() {
			$screen = get_current_screen();

			switch ( $screen->id ) {
				case 'users' :
				case 'user' :
				case 'profile' :
				case 'user-edit' :
					//include( 'class-mailpoet-paid-memberships-pro-addon-admin-profile.php' );
				break;
			}
		}

	} // end class.

} // end if class exists.

return new MailPoet_Paid_Memberships_Pro_Addon_Admin();

?>