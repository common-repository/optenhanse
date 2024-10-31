<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

if(!function_exists('ptnns_delete_user_notify')) {
	
	function ptnns_delete_user_notify($ptnns_involved_user_id, $ptnns_destination_user_id) {
		
		global $ptnns_secure_options_array;
		if(is_email($ptnns_secure_options_array['notification_address'])) {
			
			$ptnns_delete_user_notification_address = sanitize_email($ptnns_secure_options_array['notification_address']);
			
			$ptnns_involved_user_data = get_userdata($ptnns_involved_user_id);
			$ptnns_user_login = $ptnns_involved_user_data->user_login;

			//send mail to inform about successful login
			$ptnns_delete_user_notification_subject = __('User deleted in','ptnnslang').' '.get_bloginfo('name');
			$ptnns_delete_user_notification_body = '<html><body><p>'.__('A user, with user login','ptnnslang').' <strong>'.$ptnns_user_login.'</strong>, '.__('was just deleted from','ptnnslang').' '.get_bloginfo('name').' ('.get_bloginfo('url').')</p></body></html>';
			$ptnns_delete_user_notification_headers = array('Content-Type: text/html; charset=UTF-8');
			wp_mail($ptnns_delete_user_notification_address, $ptnns_delete_user_notification_subject, $ptnns_delete_user_notification_body, $ptnns_delete_user_notification_headers);		

		} else {
			
			error_log("notification email is not a valid address");
			
		}		

	}
	
	add_action('delete_user', 'ptnns_delete_user_notify',10 ,2);

} else {
	
	error_log('function: "ptnns_delete_user_notify" already exists');
	
}