<?php
/**
 * MailPoet Paid Memberships Pro Addon Settings
 *
 * @author 		Sebs Studio
 * @category 	Admin
 * @package 	MailPoet Paid Memberships Pro Addon/Admin
 * @version 	1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'MailPoet_Paid_Memberships_Pro_Addon_Settings' ) ) {

/**
 * MailPoet_Paid_Memberships_Pro_Addon_Admin_Settings
 */
class MailPoet_Paid_Memberships_Pro_Addon_Settings extends MailPoet_Paid_Memberships_Pro_Addon_Settings_Page {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id    = 'general';
		$this->label = __( 'Settings', 'mailpoet_paid_memberships_pro_add_on' );

		add_filter( 'mailpoet_paid_memberships_pro_add_on_settings_tabs_array', array( &$this, 'add_settings_page' ), 20 );
		add_action( 'mailpoet_paid_memberships_pro_add_on_settings_' . $this->id, array( &$this, 'output' ) );
		add_action( 'mailpoet_paid_memberships_pro_add_on_settings_save_' . $this->id, array( &$this, 'save' ) );
	}

	/**
	 * Get settings array
	 *
	 * @return array
	 */
	public function get_settings() {
		return apply_filters( 'mailpoet_paid_memberships_pro_add_on_settings', array(

			array( 'title' => __( 'Settings Title', 'mailpoet_paid_memberships_pro_add_on' ), 'type' => 'title', 'desc' => '', 'id' => 'general_options' ),

			array(
				'title' => __( 'Single Checkbox', 'mailpoet_paid_memberships_pro_add_on' ),
				'desc' 		=> __( 'Can come in handy to display more options.', 'mailpoet_paid_memberships_pro_add_on' ),
				'id' 		=> 'mailpoet_paid_memberships_pro_add_on_checkbox',
				'default'	=> 'no',
				'type' 		=> 'checkbox'
			),

			array(
				'title' => __( 'Single Input (Text) ', 'mailpoet_paid_memberships_pro_add_on' ),
				'desc' 		=> '',
				'id' 		=> 'mailpoet_paid_memberships_pro_add_on_input_text',
				'default'	=> __( 'This admin setting can be hidden via the checkbox above.', 'mailpoet_paid_memberships_pro_add_on' ),
				'type' 		=> 'text',
				'css' 		=> 'min-width:300px;',
				'autoload'  => false
			),

			array( 'type' => 'sectionend', 'id' => 'general_options'),

		)); // End general settings
	}

	/**
	 * Save settings
	 */
	public function save() {
		$settings = $this->get_settings();

		MailPoet_Paid_Memberships_Pro_Addon_Admin_Settings::save_fields( $settings );
	}

}

} // end if class exists

return new MailPoet_Paid_Memberships_Pro_Addon_Settings();

?>