<?php
/**
 * MailPoet Paid Memberships Pro Add-on Core Functions
 *
 * General core functions available on both the front-end and admin.
 *
 * @author 		Sebs Studio
 * @category 	Core
 * @package 	MailPoet Paid Memberships Pro Add-on/Functions
 * @version 	1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Include core functions
include( 'mailpoet-paid-memberships-pro-addon-conditional-functions.php' );
include( 'mailpoet-paid-memberships-pro-addon-formatting-functions.php' );

/**
 * Gets all enabled lists in MailPoet
 */
if( ! function_exists( 'mailpoet_lists' ) ) {
	function mailpoet_lists(){
		// This will return an array of results with the name and list_id of each mailing list
		$model_list = WYSIJA::get('list','model');
		$mailpoet_lists = $model_list->get(array('name','list_id'), array('is_enabled' => 1));

		return $mailpoet_lists;
	}
}

?>