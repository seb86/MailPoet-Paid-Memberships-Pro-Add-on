<?php
/**
 * This provides a help tab for the plugin.
 *
 * @author 		Sebs Studio
 * @category 	Admin
 * @package 	MailPoet Paid Memberships Pro Add-on/Admin
 * @version 	1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'MailPoet_Paid_Memberships_Pro_Addon_Admin_Help' ) ) {

/**
 * MailPoet_Paid_Memberships_Pro_Addon_Admin_Help Class
 */
class MailPoet_Paid_Memberships_Pro_Addon_Admin_Help {

	/**
	 * Hook in tabs.
	 */
	public function __construct() {
		add_action( 'current_screen', array( &$this, 'add_tabs' ), 50 );
	}

	/**
	 * Add help tabs
	 */
	public function add_tabs() {
		$screen = get_current_screen();

		if ( ! in_array( $screen->id, mailpoet_paid_memberships_pro_addon_get_screen_ids() ) )
			return;

		$screen->add_help_tab( array(
			'id'	=> 'MailPoet_Paid_Memberships_Pro_Addon_docs_tab',
			'title'	=> __( 'Documentation', MAILPOET_PAID_MEMBERSHIPS_PRO_ADDON_TEXT_DOMAIN ),
			'content'	=>

				'<p>' . __( 'Thank you for using MailPoet Paid Memberships Pro Add-on :) Should you need help using MailPoet Paid Memberships Pro Add-on please read the documentation.', MAILPOET_PAID_MEMBERSHIPS_PRO_ADDON_TEXT_DOMAIN ) . '</p>' .

				'<p><a href="' . MailPoet_Paid_Memberships_Pro_Addon()->doc_url . '" class="button button-primary">' . __( 'MailPoet Paid Memberships Pro Add-on Documentation', MAILPOET_PAID_MEMBERSHIPS_PRO_ADDON_TEXT_DOMAIN ) . '</a></p>'

		) );

		$screen->add_help_tab( array(
			'id'	=> 'MailPoet_Paid_Memberships_Pro_Addon_support_tab',
			'title'	=> __( 'Support', MAILPOET_PAID_MEMBERSHIPS_PRO_ADDON_TEXT_DOMAIN ),
			'content'	=>

				'<p>' . sprintf(__( 'After <a href="%s">reading the documentation</a>, for further assistance you can use the <a href="%s">community forum</a>.', MAILPOET_PAID_MEMBERSHIPS_PRO_ADDON_TEXT_DOMAIN ), MailPoet_Paid_Memberships_Pro_Addon()->doc_url, 'http://wordpress.org/support/plugin/mailpoet-paid-memberships-pro-add-on' ) . '</p>' .

				'<p><a href="' . 'http://wordpress.org/support/plugin/mailpoet-paid-memberships-pro-add-on' . '" class="button">' . __( 'Community Support', MAILPOET_PAID_MEMBERSHIPS_PRO_ADDON_TEXT_DOMAIN ) . '</a></p>'

		) );

		$screen->add_help_tab( array(
			'id'	=> 'MailPoet_Paid_Memberships_Pro_Addon_bugs_tab',
			'title'	=> __( 'Found a bug?', MAILPOET_PAID_MEMBERSHIPS_PRO_ADDON_TEXT_DOMAIN ),
			'content'	=>

				'<p>' . sprintf(__( 'If you find a bug within MailPoet Paid Memberships Pro you can create a ticket via <a href="%s">Github issues</a>. Ensure you read the <a href="%s">contribution guide</a> prior to submitting your report. Be as descriptive as possible.', MAILPOET_PAID_MEMBERSHIPS_PRO_ADDON_TEXT_DOMAIN ), GITHUB_REPO_URL . 'issues?state=open', GITHUB_REPO_URL . 'blob/master/CONTRIBUTING.md' ) . '</p>' .

				'<p><a href="' . GITHUB_REPO_URL . 'issues?state=open" class="button button-primary">' . __( 'Report a bug', MAILPOET_PAID_MEMBERSHIPS_PRO_ADDON_TEXT_DOMAIN ) . '</a></p>'

		) );

		$screen->set_help_sidebar(
			'<p><strong>' . __( 'For more information:', MAILPOET_PAID_MEMBERSHIPS_PRO_ADDON_TEXT_DOMAIN ) . '</strong></p>' .
			'<p><a href="http://wordpress.org/plugins/mailpoet-paid-memberships-pro-add-on/" target="_blank">' . __( 'Project on WordPress.org', MAILPOET_PAID_MEMBERSHIPS_PRO_ADDON_TEXT_DOMAIN ) . '</a></p>' .
			'<p><a href="' . GITHUB_REPO_URL . '" target="_blank">' . __( 'Project on Github', MAILPOET_PAID_MEMBERSHIPS_PRO_ADDON_TEXT_DOMAIN ) . '</a></p>'
		);
	}

}

} // end if class exists.

return new MailPoet_Paid_Memberships_Pro_Addon_Admin_Help();

?>