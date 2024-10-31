<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

if(!function_exists('ptnns_change_role_notify')) {
	
	function ptnns_change_role_notify($ptnns_involved_user_id, $ptnns_new_role, $ptnns_old_roles) {
		
		//set this condition for only triggering role change and not user creation
		if(!empty($ptnns_old_roles)) {
		
			global $ptnns_secure_options_array;
			if(is_email($ptnns_secure_options_array['notification_address'])) {
				
				$ptnns_change_role_notification_address = sanitize_email($ptnns_secure_options_array['notification_address']);
				
				$ptnns_involved_user_data = get_userdata($ptnns_involved_user_id);
				$ptnns_user_login = $ptnns_involved_user_data->user_login;

				//send mail to inform about successful login
				$ptnns_change_role_notification_subject = __('Role changed in','ptnnslang').' '.get_bloginfo('name');
				$ptnns_change_role_notification_body = '<html><body><p>'.__('A user, with user login','ptnnslang').' <strong>'.$ptnns_user_login.'</strong>, '.__('has now','ptnnslang').' "<strong>'.$ptnns_new_role.'</strong>" '.__('role','ptnnslang').' '.__('in','ptnnslang').' '.get_bloginfo('name').' ('.get_bloginfo('url').')</p></body></html>';
				$ptnns_change_role_notification_headers = array('Content-Type: text/html; charset=UTF-8');
				wp_mail($ptnns_change_role_notification_address, $ptnns_change_role_notification_subject, $ptnns_change_role_notification_body, $ptnns_change_role_notification_headers);		

			} else {
				
				error_log("notification email is not a valid address");
				
			}				
		
		}			

	}
	
	add_action('set_user_role', 'ptnns_change_role_notify', 10, 3);

} else {
	
	error_log('function: "ptnns_change_role_notify" already exists');
	
}