<?php
/**
 * MailPoet Paid Memberships Pro Add-on Admin Functions
 *
 * @author 		Sebs Studio
 * @category 	Core
 * @package 	MailPoet Paid Memberships Pro Add-on/Admin/Functions
 * @version 	1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Get all MailPoet Paid Memberships Pro Add-on screen ids
 *
 * @return array
 */
function mailpoet_paid_memberships_pro_addon_get_screen_ids() {
	$mailpoet_paid_memberships_pro_addon_screen_id = strtolower( str_replace ( ' ', '-', __( 'MailPoet Paid Memberships Pro Add-on', 'mailpoet_paid_memberships_pro_addon' ) ) );

	return apply_filters( 'mailpoet_paid_memberships_pro_addon_screen_ids', array(
		'toplevel_page_' . $mailpoet_paid_memberships_pro_addon_screen_id,
	) );
}

?>