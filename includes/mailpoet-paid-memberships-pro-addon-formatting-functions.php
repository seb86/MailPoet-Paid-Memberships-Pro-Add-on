<?php
/**
 * MailPoet Paid Memberships Pro Addon Formatting
 *
 * Functions for formatting data.
 *
 * @author 		Sebs Studio
 * @category 	Core
 * @package 	MailPoet Paid Memberships Pro Addon/Functions
 * @version 	1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Clean variables
 *
 * @access public
 * @param string $var
 * @return string
 */
function mailpoet_paid_memberships_pro_addon_clean( $var ) {
	return sanitize_text_field( $var );
}

?>