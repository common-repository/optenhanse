<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

if(!function_exists('ptnns_register_user_notify')) {
	
	function ptnns_register_user_notify($ptnns_involved_user_id) {
		
		global $ptnns_secure_options_array;
		if(is_email($ptnns_secure_options_array['notification_address'])) {
			
			$ptnns_register_user_notification_address = sanitize_email($ptnns_secure_options_array['notification_address']);
			
			$ptnns_involved_user_data = get_userdata($ptnns_involved_user_id);
			$ptnns_user_login = $ptnns_involved_user_data->user_login;
			$ptnns_user_roles = ucwords(implode(', ', $ptnns_involved_user_data->roles));

			//send mail to inform about successful login
			$ptnns_register_user_notification_subject = __('User registered to','ptnnslang').' '.get_bloginfo('name');
			$ptnns_register_user_notification_body = '<html><body><p>'.__('A user, with user login','ptnnslang').' <strong>'.$ptnns_user_login.'</strong> and role <strong>'.$ptnns_user_roles.'</strong> '.__('has just registered to','ptnnslang').' '.get_bloginfo('name').' ('.get_bloginfo('url').')</p></body></html>';
			$ptnns_register_user_notification_headers = array('Content-Type: text/html; charset=UTF-8');
			wp_mail($ptnns_register_user_notification_address, $ptnns_register_user_notification_subject, $ptnns_register_user_notification_body, $ptnns_register_user_notification_headers);		

		} else {
			
			error_log("notification email is not a valid address");
			
		}		

	}
	
	//add_action('user_register', 'ptnns_register_user_notify',10 ,1);
	add_action('register_new_user', 'ptnns_register_user_notify', 10, 1);

} else {
	
	error_log('function: "ptnns_register_user_notify" already exists');
	
}