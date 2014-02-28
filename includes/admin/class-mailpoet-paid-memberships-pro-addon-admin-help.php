<?php
/**
 * Add some content to the help tab.
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

		if ( ! in_array( $screen->id, MailPoet_Paid_Memberships_Pro_Addon_get_screen_ids() ) )
			return;

		$screen->add_help_tab( array(
			'id'	=> 'MailPoet_Paid_Memberships_Pro_Addon_docs_tab',
			'title'	=> __( 'Documentation', 'mailpoet_paid_memberships_pro_add_on' ),
			'content'	=>

				'<p>' . __( 'Thank you for using Plugin Name :) Should you need help using MailPoet Paid Memberships Pro Add-on please read the documentation.', 'mailpoet_paid_memberships_pro_add_on' ) . '</p>' .

				'<p><a href="' . MailPoet_Paid_Memberships_Pro_Addon()->doc_url . '" class="button button-primary">' . __( 'Plugin Name Documentation', 'mailpoet_paid_memberships_pro_add_on' ) . '</a></p>'

		) );

		$screen->add_help_tab( array(
			'id'	=> 'MailPoet_Paid_Memberships_Pro_Addon_support_tab',
			'title'	=> __( 'Support', 'mailpoet_paid_memberships_pro_add_on' ),
			'content'	=>

				'<p>' . sprintf(__( 'After <a href="%s">reading the documentation</a>, for further assistance you can use the <a href="%s">community forum</a>.', 'mailpoet_paid_memberships_pro_add_on' ), MailPoet_Paid_Memberships_Pro_Addon()->doc_url, 'http://wordpress.org/support/plugin/plugin-name' ) . '</p>' .

				'<p><a href="' . 'http://wordpress.org/support/plugin/plugin-name' . '" class="button">' . __( 'Community Support', 'mailpoet_paid_memberships_pro_add_on' ) . '</a></p>'

		) );

		$screen->add_help_tab( array(
			'id'	=> 'MailPoet_Paid_Memberships_Pro_Addon_bugs_tab',
			'title'	=> __( 'Found a bug?', 'mailpoet_paid_memberships_pro_add_on' ),
			'content'	=>

				'<p>' . sprintf(__( 'If you find a bug within MailPoet Paid Memberships Pro core you can create a ticket via <a href="%s">Github issues</a>. Ensure you read the <a href="%s">contribution guide</a> prior to submitting your report. Be as descriptive as possible.', 'mailpoet_paid_memberships_pro_add_on' ), GITHUB_REPO_URL . 'issues?state=open', GITHUB_REPO_URL . 'blob/master/CONTRIBUTING.md' ) . '</p>' .

				'<p><a href="' . GITHUB_REPO_URL . 'issues?state=open" class="button button-primary">' . __( 'Report a bug', 'mailpoet_paid_memberships_pro_add_on' ) . '</a></p>'

		) );

		$screen->set_help_sidebar(
			'<p><strong>' . __( 'For more information:', 'mailpoet_paid_memberships_pro_add_on' ) . '</strong></p>' .
			'<p><a href="http://www.yourdomain.com/plugin-name/" target="_blank">' . __( 'About MailPoet Paid Memberships Pro Add-on', 'mailpoet_paid_memberships_pro_add_on' ) . '</a></p>' .
			'<p><a href="http://wordpress.org/plugins/plugin-name/" target="_blank">' . __( 'Project on WordPress.org', 'mailpoet_paid_memberships_pro_add_on' ) . '</a></p>' .
			'<p><a href="' . GITHUB_REPO_URL . '" target="_blank">' . __( 'Project on Github', 'mailpoet_paid_memberships_pro_add_on' ) . '</a></p>'
		);
	}

}

} // end if class exists.

return new MailPoet_Paid_Memberships_Pro_Addon_Admin_Help();

?>