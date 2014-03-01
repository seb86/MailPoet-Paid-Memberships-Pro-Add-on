<?php
/**
 * MailPoet Paid Memberships Pro Add-on Hooks
 *
 * Hooks for various functions used.
 *
 * @author 		Sebs Studio
 * @category 	Core
 * @package 	MailPoet Paid Memberships Pro Add-on/Functions
 * @version 	1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Actions
add_action( 'pmpro_checkout_after_billing_fields', array( &$this, 'mailpoet_pmproship_addon_checkout_checkbox' ) );
add_action( 'pmpro_after_checkout', array( &$this, 'pmproship_pmpro_after_checkout' ) );

// Filters
add_filter( 'pmpro_email_body', array( &$this, 'pmproship_pmpro_email_body' ), 10, 2 );

?>