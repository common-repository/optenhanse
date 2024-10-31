<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

if(!function_exists('ptnns_register_secure_settings_action')) {
	
	function ptnns_register_secure_settings_action() {

		if(!function_exists('ptnns_sanitize_secure_entries')) {
		
			function ptnns_sanitize_secure_entries($ptnns_posted_values) {
				
				//prepare array for saving sanitized data
				$ptnns_values_to_save = array();
				
				//introduce a varible to control errors
				$ptnns_erros_found = 0;
				
				//we need this to verify pro activation
				global $ptnns_optenhanse_options_array;
				
				//loop into posted data
				foreach($ptnns_posted_values as $ptnns_posted_key => $ptnns_posted_value){
					
					//filter by key
					switch($ptnns_posted_key) {
						
						//deal with check_login
						case 'check_login':
						
						//check value is not different from 0 and 1
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['check_login'] = $ptnns_posted_value;
						
						break;						
						
						//deal with login_attempts
						case 'login_attempts':
						
						
						//check a valid value is set
						$ptnns_accepted_values = array('2','3','4','5','6','7','8','9','10','14','19','24','29','34','39','44','49','74','99');
						if(!in_array($ptnns_posted_value, $ptnns_accepted_values)){
							
							$ptnns_posted_value = null;
							$ptnns_erros_found++;
							
						}
						elseif(!empty($ptnns_optenhanse_options_array['optenhanse_pro'])) {
						
							//add sanitized value to array to save
							$ptnns_values_to_save['login_attempts'] = $ptnns_posted_value;
						}
						else {

							//add sanitized value to array to save
							$ptnns_values_to_save['login_attempts'] = '14';							
							
						}
						
						break;							
						
						//deal with login_investigation
						case 'login_investigation':
						
						//check a valid value is set
						$ptnns_accepted_values_minutes = array('5','10','15','20','25','30','35','40','45','50','55');
						$ptnns_accepted_values_hours = array('60','120','180','240','480','720');
						$ptnns_accepted_values_days = array('1440','2880','4320','5760','7200','14400','28800','43200');
						$ptnns_accepted_values = array_merge($ptnns_accepted_values_minutes, $ptnns_accepted_values_hours, $ptnns_accepted_values_days);
						if(!in_array($ptnns_posted_value, $ptnns_accepted_values)){
							
							$ptnns_posted_value = null;
							$ptnns_erros_found++;
							
						} 
						
						//add sanitized value to array to save
						$ptnns_values_to_save['login_investigation'] = $ptnns_posted_value;
						
						break;	

						//deal with login_warn
						case 'login_warn':
						
						//check value is not different from 0 and 1
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['login_warn'] = $ptnns_posted_value;
						
						break;								
						
						//deal with login_lock
						case 'login_lock':
						
						//check a valid value is set
						$ptnns_accepted_values_minutes = array('5','10','15','20','25','30','35','40','45','50','55');
						$ptnns_accepted_values_hours = array('60','120','180','240','480','720');
						$ptnns_accepted_values_days = array('1440','2880','4320','5760','7200','14400','28800','43200');
						$ptnns_accepted_values = array_merge($ptnns_accepted_values_minutes, $ptnns_accepted_values_hours, $ptnns_accepted_values_days);

						if(!in_array($ptnns_posted_value, $ptnns_accepted_values)){
							
							$ptnns_posted_value = null;
							$ptnns_erros_found++;
							
						} 
						elseif(!empty($ptnns_optenhanse_options_array['optenhanse_pro'])) {
						
							//add sanitized value to array to save
							$ptnns_values_to_save['login_lock'] = $ptnns_posted_value;
						}
						else {

							//add sanitized value to array to save
							$ptnns_values_to_save['login_lock'] = '120';							
							
						}
						
						break;	
						
						//deal with lock_down_message
						case 'lock_down_message':
						
						if(!empty($ptnns_posted_value)) {
							
							//using esc attr since value could be html
							$ptnns_posted_value = esc_attr($ptnns_posted_value);
							
						} else {
							
							$ptnns_posted_value = __('You have exceeded the login attempts conceded, please try again later','ptnnslang');
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['lock_down_message'] = $ptnns_posted_value;
						
						break;	

						//deal with login_ban
						case 'login_ban':
						
						//check a valid value is set
						$ptnns_accepted_values = array('0','1','2','3','4','5','6','7','8','9','10','15','20','25','30','50');

						if(!in_array($ptnns_posted_value, $ptnns_accepted_values)){
							
							$ptnns_posted_value = null;
							$ptnns_erros_found++;
							
						} 

						//add sanitized value to array to save
						$ptnns_values_to_save['login_ban'] = $ptnns_posted_value;
						
						break;

						//deal with ban_message
						case 'ban_message':
						
						if(!empty($ptnns_posted_value)) {
							
							//using esc attr since value could be html
							$ptnns_posted_value = esc_attr($ptnns_posted_value);
							
						} else {
							
							$ptnns_posted_value = __('You are permanently banned from trying again to login','ptnnslang');
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['ban_message'] = $ptnns_posted_value;
						
						break;						
						
						//deal with disable_xmlrpc
						case 'disable_xmlrpc':
						
						//check value is not different from 0 and 1
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['disable_xmlrpc'] = $ptnns_posted_value;
						
						break;
						
						//deal with disable_author
						case 'disable_author':
						
						//check value is not different from 0 and 1
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['disable_author'] = $ptnns_posted_value;
						
						break;
						
						//deal with disable_users_rest
						case 'disable_users_rest':
						
						//check value is not different from 0 and 1
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['disable_users_rest'] = $ptnns_posted_value;
						
						break;

						//deal with invalid_username_login_errors
						case 'invalid_username_login_errors':
						
						if(!empty($ptnns_posted_value)) {
							
							//using esc attr since value could be html
							$ptnns_posted_value = esc_attr($ptnns_posted_value);
							//add sanitized value to array to save
							$ptnns_values_to_save['invalid_username_login_errors'] = $ptnns_posted_value;
							
						} 
						
						break;	

						//deal with invalid_email_login_errors
						case 'invalid_email_login_errors':
						
						if(!empty($ptnns_posted_value)) {
							
							//using esc attr since value could be html
							$ptnns_posted_value = esc_attr($ptnns_posted_value);
							//add sanitized value to array to save
							$ptnns_values_to_save['invalid_email_login_errors'] = $ptnns_posted_value;
							
						} 
						
						break;	

						//deal with incorrect_password_login_errors
						case 'incorrect_password_login_errors':
						
						if(!empty($ptnns_posted_value)) {
							
							//using esc attr since value could be html
							$ptnns_posted_value = esc_attr($ptnns_posted_value);
							//add sanitized value to array to save
							$ptnns_values_to_save['incorrect_password_login_errors'] = $ptnns_posted_value;
							
						} 
						
						break;	

						//deal with empty_username_login_errors
						case 'empty_username_login_errors':
						
						if(!empty($ptnns_posted_value)) {
							
							//using esc attr since value could be html
							$ptnns_posted_value = esc_attr($ptnns_posted_value);
							//add sanitized value to array to save
							$ptnns_values_to_save['empty_username_login_errors'] = $ptnns_posted_value;
							
						} 
						
						break;	

						//deal with empty_password_login_errors
						case 'empty_password_login_errors':
						
						if(!empty($ptnns_posted_value)) {
							
							//using esc attr since value could be html
							$ptnns_posted_value = esc_attr($ptnns_posted_value);
							//add sanitized value to array to save
							$ptnns_values_to_save['empty_password_login_errors'] = $ptnns_posted_value;
							
						} 
						
						break;

						//deal with success_login_notification
						case 'success_login_notification':
						
						//check value is not different from 0 and 1
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['success_login_notification'] = $ptnns_posted_value;
						
						break;	

						//deal with change_role_notification
						case 'change_role_notification':
						
						//check value is not different from 0 and 1
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['change_role_notification'] = $ptnns_posted_value;
						
						break;	

						//deal with delete_user_notification
						case 'delete_user_notification':
						
						//check value is not different from 0 and 1
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['delete_user_notification'] = $ptnns_posted_value;
						
						break;	

						//deal with register_user_notification
						case 'register_user_notification':
						
						//check value is not different from 0 and 1
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['register_user_notification'] = $ptnns_posted_value;
						
						break;							
						
						//deal with lock_user_notification
						case 'lock_user_notification':
						
						//check value is not different from 0 and 1
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} 					
						elseif(!empty($ptnns_optenhanse_options_array['optenhanse_pro'])) {
						
							//add sanitized value to array to save
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						else {

							//add sanitized value to array to save
							$ptnns_posted_value = 0;							
							
						}

						//add sanitized value to array to save
						$ptnns_values_to_save['lock_user_notification'] = $ptnns_posted_value;
						
						break;	
						
						//deal with ban_user_notification
						case 'ban_user_notification':
						
						//check value is not different from 0 and 1
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} 					
						elseif(!empty($ptnns_optenhanse_options_array['optenhanse_pro'])) {
						
							//add sanitized value to array to save
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						else {

							//add sanitized value to array to save
							$ptnns_posted_value = 0;							
							
						}

						//add sanitized value to array to save
						$ptnns_values_to_save['ban_user_notification'] = $ptnns_posted_value;
						
						break;

						//deal with notification_address
						case 'notification_address':
							
						//check a valid value is set
						if(!empty($ptnns_posted_value) && !is_email($ptnns_posted_value)) {

							$ptnns_posted_value = null;
							$ptnns_erros_found++;					
							
						} else {
							
							$ptnns_posted_value = sanitize_email($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['notification_address'] = $ptnns_posted_value;
						
						break;							
						
					}
						 
				}
				
				if($ptnns_erros_found > 0) {
				
					//info message
					$ptnns_message_text = __('One or more values entered were not accepted, so they were set to a default value. Please check it out','ptnnslang').'!';
					$ptnns_message_type = 'warning';
								
					add_settings_error(
						'ptnns-info',
						'ptnns-info',
						$ptnns_message_text,
						$ptnns_message_type				
					);
				
				}
				
				//return array to save
				return $ptnns_values_to_save;
			
			}
		
		}
		

		if(!empty($_POST['ptnns-save-secure-options'])) {
			
			/*can't find out if nonce is checkd on register_setting, so let's check it "manually"*/
			if(!empty($_POST['ptnns-options-nonce']) && wp_verify_nonce($_POST['ptnns-options-nonce'], 'ptnns-options-nonce')) {

				//create an empty option first, otherwise register_setting acts twice
				update_option('_ptnns_secure', '', false);

				//register settings
				$ptnns_register_secure_options_args = array(
					'type' => 'string', 
					'sanitize_callback' => 'ptnns_sanitize_secure_entries',
					);
					
				register_setting('secure-section', '_ptnns_secure', $ptnns_register_secure_options_args); 
				
				//save temporary option
				update_option('ptnns_secure_options_updated', '1');
				
				//update message
				$ptnns_message_text = __( 'Settings Saved', 'ptnnslang' ).'!';
				$ptnns_message_type = 'updated';
						
				add_settings_error(
					'ptnns-message',
					'ptnns-message',
					$ptnns_message_text,
					$ptnns_message_type
				);
				
			}

		}

	}
	
	add_action('admin_init', 'ptnns_register_secure_settings_action');

} else {
	
	error_log('function: "ptnns_register_secure_settings_action" already exists');
	
}

