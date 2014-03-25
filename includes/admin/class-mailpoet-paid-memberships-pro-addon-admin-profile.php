<?php
/**
 * Add extra profile fields for users in admin.
 *
 * @author 		Sebs Studio
 * @category 	Admin
 * @package 	MailPoet Paid Memberships Pro Addon/Admin
 * @version 	1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'MailPoet_Paid_Memberships_Pro_Addon_Admin_Profile' ) ) {

	/**
	 * MailPoet_Paid_Memberships_Pro_Addon_Admin_Profile Class
	 */
	class MailPoet_Paid_Memberships_Pro_Addon_Admin_Profile {

		/**
		 * Hook in tabs.
		 */
		public function __construct() {
			add_action( 'show_user_profile', array( &$this, 'add_user_meta_fields' ) );
			add_action( 'edit_user_profile', array( &$this, 'add_user_meta_fields' ) );

			add_action( 'personal_options_update', array( &$this, 'save_user_meta_fields' ) );
			add_action( 'edit_user_profile_update', array( &$this, 'save_user_meta_fields' ) );
		}

		/**
		 * Get MailPoet Fields for the edit user pages.
		 *
		 * @return array Fields to display which are filtered through mailpoet_paid_memberships_pro_addon_user_meta_fields before being returned
		 */
		public function get_user_meta_fields() {
			$show_fields = apply_filters('mailpoet_paid_memberships_pro_addon_user_meta_fields', array(
				'mailpoet' => array(
					'title' => __( 'MailPoet', 'mailpoet_paid_memberships_pro_addon' ),
					'fields' => array(
						'pmpro_user_subscribe_to_mailpoet' => array(
								'label' 		=> __( 'Subscribe to MailPoet', 'mailpoet_paid_memberships_pro_addon' ),
								'description' 	=> __('If checked, you are subscribed to the newsletters provided by this site.', 'mailpoet_paid_memberships_pro_addon'),
								'type' 			=> 'checkbox'
						),
					)
				),
			));

			return $show_fields;
		}

		/**
		 * Show User Fields on edit user pages.
		 *
		 * @param mixed $user User (object) being displayed
		 */
		public function add_user_meta_fields( $user ) {
			$show_fields = $this->get_user_meta_fields();

			foreach( $show_fields as $fieldset ) {
			?>
			<h3><?php echo $fieldset['title']; ?></h3>
			<table class="form-table">
				<?php
				foreach( $fieldset['fields'] as $key => $field ) {
					switch( $field['type'] ) {
						case 'checkbox':

						$checked_value = get_user_meta( $user->ID, $key, true );
				?>
				<tr>
					<th><label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field['label'] ); ?></label></th>
					<td>
						<input type="checkbox" name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>" value="1" <?php checked('1', $checked_value); ?> />
						<span class="description"><?php echo wp_kses_post( $field['description'] ); ?></span>
					</td>
				</tr>
				<?php
						break;

						// Default is text input
						default:
				?>
				<tr>
					<th><label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field['label'] ); ?></label></th>
					<td>
						<input type="text" name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( get_user_meta( $user->ID, $key, true ) ); ?>" class="regular-text" /><br/>
						<span class="description"><?php echo wp_kses_post( $field['description'] ); ?></span>
					</td>
				</tr>
				<?php
						break;
					} // end switch
				}
				?>
			</table>
			<?php
			}
		}

		/**
		 * Save User Fields on edit user pages
		 *
		 * @param mixed $user_id User ID of the user being saved
		 */
		public function save_user_meta_fields( $user_id ) {
			$save_fields = $this->get_user_meta_fields();

			foreach( $save_fields as $fieldset ) {
				foreach( $fieldset['fields'] as $key => $field ) {
					if ( isset( $_POST[ $key ] ) ) {
						update_user_meta( $user_id, $key, mailpoet_paid_memberships_pro_add_on_clean( $_POST[ $key ] ) );
					}

					// This saves single checkbox field values.
					if ( $field['type'] == 'checkbox' ) {
						update_user_meta( $user_id, $key, mailpoet_paid_memberships_pro_add_on_clean( $_POST[ $key ] ) );
					}

					// This subscribes the user to each MailPoet lists selected under 'Settings -> MailPoet PMPro -> Lists'
					if ( isset( $_POST[ 'pmpro_user_subscribe_to_mailpoet' ] ) || !empty( $_POST[ 'pmpro_user_subscribe_to_mailpoet' ] ) ) {
						$mailpoet_lists = get_option('mailpoet_paid_memberships_pro_subscribe_too');
						foreach( $mailpoet_lists as $list_id ) {
							$this->mailpoet_subscribe_user( $list_id, $user_id );
						}
					}

					// This unsubscribes the user from each MailPoet lists selected under 'Settings -> MailPoet PMPro -> Lists'
					if ( !isset( $_POST[ 'pmpro_user_subscribe_to_mailpoet' ] ) || empty( $_POST[ 'pmpro_user_subscribe_to_mailpoet' ] ) ) {
						$mailpoet_lists = get_option('mailpoet_paid_memberships_pro_subscribe_too');
						foreach( $mailpoet_lists as $list_id ) {
							$this->mailpoet_unsubscribe_user( $list_id, $user_id );
						}
					}
				}
			}
		}

		// This subscribes the user to all lists selected by the admin in this plugin settings.
		public function mailpoet_subscribe_user( $list_ids = '', $userid ) {
			$userHelper = &WYSIJA::get('user','helper');
			$userHelper->subscribe( $userid, true, false, $list_ids );
		}

		// This unsubscribes the user to all lists selected by the admin in this plugin settings.
		public function mailpoet_unsubscribe_user( $list_ids = '', $userid ) {
			$userHelper = &WYSIJA::get('user','helper');
			$userHelper->subscribe( $userid, false, false, $list_ids );
		}

	} // end class

} // end if class exists.

return new MailPoet_Paid_Memberships_Pro_Addon_Admin_Profile();

?>