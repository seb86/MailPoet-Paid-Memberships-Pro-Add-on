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
function mailpoet_pmproship_addon_checkout_checkbox() {
	global $sfirstname, $slastname;
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

			</td>
		</tr>
	</tbody>
	</table>
<?php
}

// Update a user meta value on checkout
function mailpoet_pmproship_addon_after_checkout($user_id) {
	global $sfirstname, $slastname;

	if( !empty( $sameasbilling ) ) {
		//set the shipping fields to be the same as the billing fields		
		$sfirstname = get_user_meta($user_id, "pmpro_bfirstname", true);
		$slastname = get_user_meta($user_id, "pmpro_blastname", true);
		$saddress1 = get_user_meta($user_id, "pmpro_baddress1", true);
		$saddress2 = get_user_meta($user_id, "pmpro_baddress2", true);
		$scity = get_user_meta($user_id, "pmpro_bcity", true);
		$sstate = get_user_meta($user_id, "pmpro_bstate", true);
		$szipcode = get_user_meta($user_id, "pmpro_bzipcode", true);			
		$scountry = get_user_meta($user_id, "pmpro_bcountry", true);					
	}

	if( !empty( $saddress1 ) ) {
		//update the shipping user meta
		update_user_meta($user_id, "pmpro_sfirstname", $sfirstname);
		update_user_meta($user_id, "pmpro_slastname", $slastname);	
		update_user_meta($user_id, "pmpro_saddress1", $saddress1);
		update_user_meta($user_id, "pmpro_saddress2", $saddress2);
		update_user_meta($user_id, "pmpro_scity", $scity);
		update_user_meta($user_id, "pmpro_sstate", $sstate);
		update_user_meta($user_id, "pmpro_szipcode", $szipcode);		
		update_user_meta($user_id, "pmpro_scountry", $scountry);		
	}
}

//adding shipping address to confirmation email
function pmproship_pmpro_email_body($body, $pmpro_email)
{
	global $wpdb;
 
	//get the user_id from the email
	$user_id = $wpdb->get_var("SELECT ID FROM $wpdb->users WHERE user_email = '" . $pmpro_email->data['user_email'] . "' LIMIT 1");
	
	if(!empty($user_id))
	{
		//does the user being emailed have a shipping address?		
		$sfirstname = get_user_meta($user_id, "pmpro_sfirstname", true);
		$slastname = get_user_meta($user_id, "pmpro_slastname", true);
		$saddress1 = get_user_meta($user_id, "pmpro_saddress1", true);
		$saddress2 = get_user_meta($user_id, "pmpro_saddress2", true);
		$scity = get_user_meta($user_id, "pmpro_scity", true);
		$sstate = get_user_meta($user_id, "pmpro_sstate", true);
		$szipcode = get_user_meta($user_id, "pmpro_szipcode", true);
		$scountry = get_user_meta($user_id, "pmpro_scountry", true);
		
		if(!empty($scity) && !empty($sstate))
		{
			$shipping_address = $sfirstname . " " . $slastname . "<br />" . $saddress1 . "<br />";
			if($saddress2)
				$shipping_address .= $saddress2 . "<br />";
			$shipping_address .= $scity . ", " . $sstate . " " . $szipcode;								
		}
		$shipping_address .= "<br />" . $scountry;
		
		if(!empty($shipping_address))
		{
			//squeeze the shipping address above the billing information or above the log link
			if(strpos($body, "Billing Information:"))
				$body = str_replace("Billing Information:", "Shipping Address:<br />" . $shipping_address . "<br /><br />Billing Information:", $body);
			else
				$body = str_replace("Log in to your membership", "Shipping Address:<br />" . $shipping_address . "<br /><br />Log in to your membership", $body);
		}		
	}
 
	return $body;
}

?>