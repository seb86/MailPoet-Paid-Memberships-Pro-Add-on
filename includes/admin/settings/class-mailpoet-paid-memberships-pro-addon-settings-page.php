<?php
/**
 * MailPoet Paid Memberships Pro Addon Settings Page/Tab
 *
 * @author 		Sebs Studio
 * @category 	Admin
 * @package 	MailPoet Paid Memberships Pro Addon/Admin
 * @version 	1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'MailPoet_Paid_Memberships_Pro_Addon_Settings_Page' ) ) {

/**
 * MailPoet_Paid_Memberships_Pro_Addon_Settings_Page
 */
class MailPoet_Paid_Memberships_Pro_Addon_Settings_Page {

	protected $id    = '';
	protected $label = '';

	/**
	 * Add this page to settings
	 */
	public function add_settings_page( $pages ) {
		$pages[ $this->id ] = $this->label;

		return $pages;
	}

	/**
	 * Get settings array
	 *
	 * @return array
	 */
	public function get_settings() {
		return array();
	}

	/**
	 * Get sections
	 *
	 * @return array
	 */
	public function get_sections() {
		return array();
	}

	/**
	 * Output sections
	 */
	public function output_sections() {
		global $current_section;

		$sections = $this->get_sections();

		if ( empty( $sections ) )
			return;

		echo '<ul class="subsubsub">';

		$array_keys = array_keys( $sections );

		foreach ( $sections as $id => $label ) {
			echo '<li><a href="' . admin_url( 'options-general.php?page=pmpro-mailpoet&tab=' . $this->id . '&section=' . sanitize_title( $id ) ) . '" class="' . ( $current_section == $id ? 'current' : '' ) . '">' . $label . '</a> ' . ( end( $array_keys ) == $id ? '' : '|' ) . ' </li>';
		}

		echo '</ul><br class="clear" />';
	}

	/**
	 * Output the settings
	 */
	public function output() {
		$settings = $this->get_settings();

		MailPoet_Paid_Memberships_Pro_Addon_Admin_Settings::output_fields( $settings );
	}

	/**
	 * Save settings
	 */
	public function save() {
		global $current_section;

		$settings = $this->get_settings();
		MailPoet_Paid_Memberships_Pro_Addon_Admin_Settings::save_fields( $settings );

		if ( $current_section ) {
			do_action( 'mailpoet_paid_memberships_pro_add_on_update_options_' . $this->id . '_' . $current_section );
		}
	}
}

} // end if class exists.

?>