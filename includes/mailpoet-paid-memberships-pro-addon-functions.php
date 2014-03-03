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
				<input type="checkbox" id="pmpro_user_subscribe_to_mailpoet" name="pmpro_user_subscribe_to_mailpoet" value="1" /> 
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

// Get fields on checkout page
function mailpoet_pmpro_addon_valid_gateways( $gateways ) {
	global $subscribe;

	if( !empty( $_REQUEST['pmpro_user_subscribe_to_mailpoet'] ) ) {
		$pmpro_user_subscribe_to_mailpoet = true;	//we'll get the fields further down below
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
	$firstname = get_user_meta($user_id, "pmpro_bfirstname", true);
	$lastname = get_user_meta($user_id, "pmpro_blastname", true);
	$email = get_user_meta($user_id, "user_email", true);

	$mailpoet_checkout_subscribe = isset($_POST['pmpro_user_subscribe_to_mailpoet']) ? 1 : 0;

	// If the check box has been ticked then the customer is added to the MailPoet lists enabled.
	if($mailpoet_checkout_subscribe == 1){
		$checkout_lists = get_option('');

		$user_data = array(
			'email' 	=> $email,
			'firstname' => $firstname,
			'lastname' 	=> $lastname
		);

		$data_subscriber = array(
			'user' 		=> $user_data,
			'user_list' => array('list_ids' => array($checkout_lists))
		);

		$userHelper = &WYSIJA::get('user','helper');
		$userHelper->addSubscriber($data_subscriber);
	}
	
	update_user_meta($user_id, "pmpro_user_subscribe_to_mailpoet", $mailpoet_checkout_subscribe);
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
			$body = str_replace("Billing Information:", "Subscribed to Newsletter:<br />" . $subscribed . "<br /><br />Billing Information:", $body);
		}
		else {
			$body = str_replace("Log in to your membership", "Subscribed to Newsletter:<br />" . $subscribed . "<br /><br />Log in to your membership", $body);
		}
	}

	return $body;
}

function label_checkbox_on_checkout() {
	$label = get_option('mailpoet_paid_memberships_pro_add_on_checkout_label', true);

	if( !empty( $label ) ) {
		return $label;
	}
	else{
		return;
	}
}
?>