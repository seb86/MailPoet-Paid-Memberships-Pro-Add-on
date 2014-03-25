<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div id="message" class="updated mailpoet-paid-memberships-pro-add-on-message">
	<p><?php echo sprintf( __( '<strong>%s Data Update Required</strong> &#8211; We just need to update your install to the latest version', 'mailpoet_paid_memberships_pro_addon' ), MailPoet_Paid_Memberships_Pro_Addon()->name ); ?></p>
	<p class="submit"><a href="<?php echo add_query_arg( 'do_update_mailpoet_paid_memberships_pro_add_on', 'true', admin_url('options-general.php?page=pmpro-mailpoet') ); ?>" class="mailpoet-paid-memberships-pro-add-on-update-now button-primary"><?php _e( 'Run the updater', 'mailpoet_paid_memberships_pro_addon' ); ?></a></p>
</div>
<script type="text/javascript">
	jQuery('.mailpoet-paid-memberships-pro-add-on-update-now').click('click', function(){
		var answer = confirm( '<?php _e( 'It is strongly recommended that you backup your database before proceeding. Are you sure you wish to run the updater now?', 'mailpoet_paid_memberships_pro_addon' ); ?>' );
		return answer;
	});
</script>