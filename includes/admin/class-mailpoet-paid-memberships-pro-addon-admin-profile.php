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
		 * Get Address Fields for the edit user pages.
		 *
		 * @return array Fields to display which are filtered through mailpoet_paid_memberships_pro_addon_user_meta_fields before being returned
		 */
		public function get_user_meta_fields() {
			$show_fields = apply_filters('mailpoet_paid_memberships_pro_addon_user_meta_fields', array(
				'billing' => array(
					'title' => __( 'MailPoet', 'mailpoet_paid_memberships_pro_addon' ),
					'fields' => array(
						'user_subscribe_to_mailpoet' => array(
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
			if ( ! current_user_can( 'manage_options' ) )
				return;

			$show_fields = $this->get_user_meta_fields();

			foreach( $show_fields as $fieldset ) {
			?>
			<h3><?php echo $fieldset['title']; ?></h3>
			<table class="form-table">
				<?php
				foreach( $fieldset['fields'] as $key => $field ) {
					switch( $field['type'] ) {
						case 'checkbox':
				?>
				<tr>
					<th><label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field['label'] ); ?></label></th>
					<td>
						<input type="checkbox" name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>" value="yes"<?php $check_value = get_user_meta( $user->ID, $key, true ); if(isset($check_value) && $check_value != ''){ echo ' checked="checked"'; } ?> />
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
						update_user_meta( $user_id, $key, mailpoet_paid_memberships_pro_addon_clean( $_POST[ $key ] ) );
					}
				}
			}
		}

	} // end class

} // end if class exists.

return new MailPoet_Paid_Memberships_Pro_Addon_Admin_Profile();

?>
