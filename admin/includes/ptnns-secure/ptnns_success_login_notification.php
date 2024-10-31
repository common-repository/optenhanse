<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

if(!function_exists('ptnns_success_login_notify')) {
	
	function ptnns_success_login_notify($ptnns_user_login, $ptnns_user_object) {
		
		global $ptnns_secure_options_array;
		if(is_email($ptnns_secure_options_array['notification_address'])) {
			
			$ptnns_success_login_notification_address = sanitize_email($ptnns_secure_options_array['notification_address']);

			//send mail to inform about successful login
			$ptnns_success_login_notification_subject = __('Successful login to','ptnnslang').' '.get_bloginfo('name');
			$ptnns_success_login_notification_body = '<html><body><p>'.__('A visitor, with user login','ptnnslang').' <strong>'.$ptnns_user_login.'</strong>, '.__('logged in successfully to','ptnnslang').' '.get_bloginfo('name').' ('.get_bloginfo('url').')</p></body></html>';
			$ptnns_success_login_notification_headers = array('Content-Type: text/html; charset=UTF-8');
			wp_mail($ptnns_success_login_notification_address, $ptnns_success_login_notification_subject, $ptnns_success_login_notification_body, $ptnns_success_login_notification_headers);		

		} else {
			
			error_log("notification email is not a valid address");
			
		}

	}
	
	add_action('wp_login', 'ptnns_success_login_notify', 10, 2);

} else {
	
	error_log('function: "ptnns_success_login_notify" already exists');
	
}