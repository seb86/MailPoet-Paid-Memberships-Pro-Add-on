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
		add_action( 'mailpoet_paid_memberships_pro_add_on_sections_' . $this->id, array( $this, 'output_sections' ) );
		add_action( 'mailpoet_paid_memberships_pro_add_on_settings_' . $this->id, array( &$this, 'output' ) );
		add_action( 'mailpoet_paid_memberships_pro_add_on_settings_save_' . $this->id, array( &$this, 'save' ) );
	}

	/**
	 * Get sections
	 *
	 * @return array
	 */
	public function get_sections() {
		$sections = array(
			'' => __( 'General', 'mailpoet_paid_memberships_pro_add_on' ),
			'lists' => __( 'Lists', 'mailpoet_paid_memberships_pro_add_on' )
		);

		return $sections;
	}

	/**
	 * Get settings array
	 *
	 * @return array
	 */
	public function get_settings( $current_section = '' ) {

		if( $current_section == 'lists' ) {

			return apply_filters('mailpoet_paid_memberships_pro_add_on_list_settings', array(

				array(
					'title' 	=> __('Lists', 'mailpoet_paid_memberships_pro_add_on'), 
					'type' 		=> 'title', 
					'desc' 		=> __('Here you can assign the customer to the lists you enable when they subscribe. Simply tick the lists you want your customers to subscribe to and press "Save Changes".', 'mailpoet_paid_memberships_pro_add_on'), 
					'id' 		=> 'mailpoet_paid_memberships_pro_add_on_newsletters_options'
				),

				array(
					'type' 		=> 'sectionend', 
					'id' 		=> 'mailpoet_paid_memberships_pro_add_on_newsletters_options'
				),

			));

		}
		else{

			return apply_filters( 'mailpoet_paid_memberships_pro_add_on_settings', array(

				array(
					'title' => __( 'Settings Title', 'mailpoet_paid_memberships_pro_add_on' ), 
					'type' => 'title', 
					'desc' => __('Now your customers can subscribe to newsletters you have created with MailPoet. Simple setup your settings below and press "Save Changes".', 'mailpoet_paid_memberships_pro_add_on'),
					'id' => 'general_options'
				),

				array(
					'title' => __( 'Enable subscribe on checkout', 'mailpoet_paid_memberships_pro_add_on' ),
					'desc' 		=> __( 'Add a subscribe checkbox to your checkout page.', 'mailpoet_paid_memberships_pro_add_on' ),
					'id' 		=> 'mailpoet_paid_memberships_pro_add_on_enable_checkout',
					'default'	=> 'no',
					'type' 		=> 'checkbox'
				),

				array(
					'title' => __( 'Checkbox label', 'mailpoet_paid_memberships_pro_add_on' ),
					'desc' 		=> __('Enter a message to place next to the checkbox.', 'mailpoet_paid_memberships_pro_add_on' ),
					'id' 		=> 'mailpoet_paid_memberships_pro_add_on_checkout_label',
					'default' 	=> __('Yes, please subscribe me to your newsletter.', 'mailpoet_paid_memberships_pro_add_on' ),
					'type' 		=> 'text',
					'css' 		=> 'min-width:300px;',
					'autoload'  => false
				),

				array( 'type' => 'sectionend', 'id' => 'general_options'),

			)); // End general settings

		}
	}

	/**
	 * Output the settings
	 */
	public function output() {
		global $current_section;

		if ( $current_section == 'lists' ) {
			$this->output_lists();
 		}
		else {
			$settings = $this->get_settings();

			MailPoet_Paid_Memberships_Pro_Addon_Admin_Settings::output_fields( $settings );
		}
	}

	/**
	 * Save settings
	 */
	public function save() {
		global $current_section;

		if ( $current_section == 'lists' ) {
			// Each list of newsletters that have been ticked will be saved.
			if(isset($_POST['checkout_lists'])){
				$checkout_lists = $_POST['checkout_lists'];
				update_option('mailpoet_paid_memberships_pro_subscribe_too', $checkout_lists);
			}
			else{
				delete_option('mailpoet_paid_memberships_pro_subscribe_too');
			}
 		}
		else {
			$settings = $this->get_settings();

			MailPoet_Paid_Memberships_Pro_Addon_Admin_Settings::save_fields( $settings );
		}
	}

	/**
	 * Output MailPoet lists tables
	 */
	public function output_lists() {
		global $current_section, $wpdb;
		?>
		<h3><?php _e( 'Lists', 'mailpoet_paid_memberships_pro_add_on' ); ?></h3>
		<p><?php _e( 'Here you can assign the customer to the lists you enable when they subscribe. Simply tick the lists you want your customers to subscribe to and press "Save Changes".', 'mailpoet_paid_memberships_pro_add_on' ); ?></p>
		<table class="widefat">
			<thead>
				<tr valign="top">
					<td class="forminp" colspan="2">
						<table class="mailpoet widefat" cellspacing="0">
							<thead>
								<tr>
									<th width="1%"><?php _e('Enabled', 'mailpoet_paid_memberships_pro_add_on'); ?></th>
									<th><?php _e('Lists', 'mailpoet_paid_memberships_pro_add_on'); ?></th>
								</tr>
							</thead>
							<tbody>
							<?php
							$checkout_lists = get_option('mailpoet_paid_memberships_pro_subscribe_too');
							foreach(mailpoet_lists() as $key => $list){
								$list_id = $list['list_id'];
								$checked = '';
								if(isset($checkout_lists) && !empty($checkout_lists)){
									if(in_array($list_id, $checkout_lists)){ $checked = ' checked="checked"'; }
								}
								echo '<tr>
									<td width="1%" class="checkbox">
										<input type="checkbox" name="checkout_lists[]" value="'.esc_attr($list_id).'"'.$checked.' />
									</td>
									<td>
										<p><strong>'.$list['name'].'</strong></p>
									</td>
								</tr>';
							}
							?>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}

}

} // end if class exists

return new MailPoet_Paid_Memberships_Pro_Addon_Settings();

?>