<?php
/**
 * MailPoet Paid Memberships Pro Add-on Functions
 *
 * @author 		Sebs Studio
 * @category 	Core
 * @package 	MailPoet Paid Memberships Pro Add-on/Functions
 * @version 	1.0.0
 */

// Add a checkbox field to the checkout page.
function mailpoet_pmpro_addon_checkout_checkbox() {
	global $gateway, $pmpro_user_subscribe_to_mailpoet;
?>
	<table id="pmpro_mailpoet_fields" class="pmpro_checkout top1em" width="100%" cellpadding="0" cellspacing="0" border="0">
	<thead>
		<tr>
			<th><?php _e('Newsletter', 'mailpoet_pro_memberships_pro_addon');?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<p id="pmpro_user_subscribe_to_mailpoet_wrapper">
				<input type="checkbox" id="pmpro_user_subscribe_to_mailpoet" name="pmpro_user_subscribe_to_mailpoet" value="1" <?php if( !empty( $pmpro_user_subscribe_to_mailpoet ) ) { echo ' checked="checked"'; } ?> /> 
				<label for="pmpro_user_subscribe_to_mailpoet">
				<?php echo apply_filters( 'mailpoet_pmpro_addon_subscribe_to_newsletter_label', __('Subscribe to our Newsletter', 'mailpoet_paid_memberships_pro_addon') ); ?>
				</label>
				</p>
			</td>
		</tr>
	</tbody>
	</table>
<?php
}

/*
 * Require the username and email address fields
 */
function mailpoet_pmpro_registration_checks($okay) {
	//only check if we're okay so far
	if( !empty( $_REQUEST['pmpro_user_subscribe_to_mailpoet'] ) ) {
		global $pmpro_msg, $pmpro_msgt, $pmpro_error_fields;

		$required_fields = array( 'bemail' );

		//Check for username field while registration
		if ( ! is_user_logged_in() ) {
			$required_fields[] = 'username';
		}

		foreach($required_fields as $field) {
			if(empty($_REQUEST[$field])){
				$okay = false;
				pmpro_setMessage(__('Please complete all required fields.', 'mailpoet_paid_memberships_pro_addon'), "pmpro_error");
				$pmpro_error_fields[] = $field;
			}
		}
	}

	return $okay;
}

// Get fields on checkout page
function mailpoet_pmpro_addon_valid_gateways( $gateways ) {
	global $pmpro_user_subscribe_to_mailpoet;

	if( !empty( $_REQUEST['pmpro_user_subscribe_to_mailpoet'] ) ) {
		$pmpro_user_subscribe_to_mailpoet = true; //we'll get the fields further down below
	}
	elseif( !empty( $_SESSION['pmpro_user_subscribe_to_mailpoet'] ) ) {
		// coming back from PayPal.
		$pmpro_user_subscribe_to_mailpoet = true;
		unset($_SESSION['pmpro_user_subscribe_to_mailpoet']);
	}

	return $gateways;
}

// Update a user meta value on checkout
function mailpoet_pmpro_addon_after_checkout( $user_id ) {
	global $pmpro_user_subscribe_to_mailpoet;

	$user_info = get_userdata( $user_id );

	// If the check box has been ticked then the customer is added to the MailPoet lists enabled.
	if( !empty( $pmpro_user_subscribe_to_mailpoet ) ) {
		$firstname = $user_info->first_name;
		$lastname = $user_info->last_name;
		$username = $user_info->user_login;
		$email = $user_info->user_email;

		// If firstname is empty then use the users username
		if( empty( $firstname ) ) {
			$firstname = $username;
		}
		// If lastname is empty then leave it blank.
		if( empty( $lastname ) ) {
			$lastname = '';
		}

		$mailpoet_checkout_subscribe = isset($_POST['pmpro_user_subscribe_to_mailpoet']) ? 1 : 0;

		// If the check box has been ticked then the customer is added to the MailPoet lists enabled.
		if($mailpoet_checkout_subscribe == 1){
			$checkout_lists = get_option('mailpoet_paid_memberships_pro_subscribe_too');

			$user_data = array(
				'email' 	=> $email,
				'firstname' => $firstname,
				'lastname' 	=> $lastname
			);

			$data_subscriber = array(
				'user' 		=> $user_data,
				'user_list' => array('list_ids' => $checkout_lists)
			);

			$userHelper = &WYSIJA::get('user','helper');
			$userHelper->addSubscriber($data_subscriber);
		}

		update_user_meta($user_id, "pmpro_user_subscribe_to_mailpoet", $mailpoet_checkout_subscribe);
	}
}

// Adding subscription confirmation to email
function mailpoet_pmpro_addon_email_body( $body, $pmpro_email ) {
	global $wpdb;
 
	// Get the user_id from the email
	$user_id = $wpdb->get_var("SELECT ID FROM $wpdb->users WHERE user_email = '" . $pmpro_email->data['user_email'] . "' LIMIT 1");
	
	if( !empty( $user_id ) ) {
		$firstname = get_user_meta($user_id, "pmpro_bfirstname", true);
		$lastname = get_user_meta($user_id, "pmpro_blastname", true);
		$subscribed = get_user_meta($user_id, "pmpro_user_subscribe_to_mailpoet", true);

		if( $subscribed == '1' ) { $subscribed = __('Yes', 'mailpoet_paid_memberships_pro_addon'); }
		else{ $subscribed = __('No', 'mailpoet_paid_memberships_pro_addon'); }

		// Add subscription confirmation above the billing information or above the log link
		if( strpos( $body, "Billing Information:" ) ) {
			$body = str_replace("Billing Information:", "Subscribed to Newsletter: " . $subscribed . "<br /><br />Billing Information:", $body);
		}
		else {
			$body = str_replace("Log in to your membership", "Subscribed to Newsletter: " . $subscribed . "<br /><br />Log in to your membership", $body);
		}
	}

	return $body;
}

// This filters the checkbox label on the checkout page.
function label_checkbox_on_checkout() {
	$label = get_option('mailpoet_paid_memberships_pro_add_on_checkout_label', true);

	if( !empty( $label ) ) {
		return $label;
	}
	else{
		return __('Subscribe to our Newsletter', 'mailpoet_paid_memberships_pro_addon');
	}
}

// Adds a bulletpoint to the confirmation page.
function mailpoet_pmpro_addon_confirmation() {
	global $current_user, $pmpro_invoice;

	$subscribed = get_user_meta($current_user->id, "pmpro_user_subscribe_to_mailpoet", true);

	if( !empty( $subscribed ) && $subscribed == '1' ) { $subscribed = __('Yes', 'mailpoet_paid_memberships_pro_addon'); }
	else{ $subscribed = __('No', 'mailpoet_paid_memberships_pro_addon'); }

	echo '<li><strong>'.__('Subscribed to Newsletter', 'mailpoet_paid_memberships_pro_addon').':</strong> '. $subscribed .'</li>';
}

// Add subscription confirmation to confirmation page
function mailpoet_pmpro_confirmation_message($confirmation_message, $pmpro_invoice) {
	global $current_user;
 
	$subscribed = get_user_meta($current_user->id, "pmpro_user_subscribe_to_mailpoet", true);

	if( !empty( $subscribed ) && $subscribed == '1' ) { 
		$subscribed = __('Yes', 'mailpoet_paid_memberships_pro_addon');
	}
	else{
		$subscribed = __('No', 'mailpoet_paid_memberships_pro_addon');
	}

	$confirmation_message .= '<li><strong>'.__('Newsletter Subscription', 'mailpoet_paid_memberships_pro_addon').':</strong> ' . $subscribed . '</li>';

	return $confirmation_message;
}

?>