<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die;

//get the IP of the user trying to authenticate
if(!function_exists('ptnns_check_login_get_ip')){
	
	function ptnns_check_login_get_ip() {

		if(!empty($_SERVER['HTTP_CLIENT_IP'])) {return $_SERVER['HTTP_CLIENT_IP'];} 
		elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {return $_SERVER['HTTP_X_FORWARDED_FOR'];} 
		else{return $_SERVER['REMOTE_ADDR'];}
		
	}
	
} else {
	
	error_log('function: "ptnns_check_login_get_ip" already exists');
	
}

//print the lock down message
if(!function_exists('ptnns_custom_lock_down_message')) {
	
	function ptnns_custom_lock_down_message($ptnns_wp_login_error) {	
						
		global $ptnns_secure_options_array;			
		$ptnns_wp_login_error = esc_attr($ptnns_secure_options_array['lock_down_message']);
		
		return $ptnns_wp_login_error;
	}

} else {
	
	error_log('function: "ptnns_custom_lock_down_message" already exists');
	
}

//print the ban message
if(!function_exists('ptnns_custom_ban_message')) {
	
	function ptnns_custom_ban_message($ptnns_wp_login_error) {	
						
		global $ptnns_secure_options_array;			
		$ptnns_wp_login_error = esc_attr($ptnns_secure_options_array['ban_message']);
		
		return $ptnns_wp_login_error;
	}

} else {
	
	error_log('function: "ptnns_custom_ban_message" already exists');
	
}

//append attempts left message to login error, only if login_warn is set and only if at least one attempt is available
if(!function_exists('ptnns_attempts_left_message')) {
	
	function ptnns_attempts_left_message($ptnns_login_form_errors) {	
			
		if(!empty($ptnns_login_form_errors)) {	

			//get needed data
			global $ptnns_get_attempts_left;		
					
			if(isset($ptnns_login_form_errors->errors['invalid_username'])){
				
				$ptnns_login_form_errors->errors['invalid_username'][0] = $ptnns_login_form_errors->errors['invalid_username'][0].'<br>'.__('Be careful','ptnnslang').': '.__('you have only','ptnnslang').' <b>'.$ptnns_get_attempts_left.' '.__('attempts left','ptnnslang').'</b>';
			
			}
			
			elseif(isset($ptnns_login_form_errors->errors['invalid_email'])){
				
				$ptnns_login_form_errors->errors['invalid_email'][0] = $ptnns_login_form_errors->errors['invalid_email'][0].'<br>'.__('Be careful','ptnnslang').': '.__('you have only','ptnnslang').' <b>'.$ptnns_get_attempts_left.' '.__('attempts left','ptnnslang').'</b>';
				
			}
			
			elseif(isset($ptnns_login_form_errors->errors['incorrect_password'])){
				
				$ptnns_login_form_errors->errors['incorrect_password'][0] = $ptnns_login_form_errors->errors['incorrect_password'][0].'<br>'.__('Be careful','ptnnslang').': '.__('you have only','ptnnslang').' <b>'.$ptnns_get_attempts_left.' '.__('attempts left','ptnnslang').'</b>';
				
			} 	
			
			return $ptnns_login_form_errors;		
		
		}
			
	}
	


} else {
	
	error_log('function: "ptnns_attempts_left_message" already exists');
	
}

//deal with login errors
if(!function_exists('ptnns_do_things_on_fail')){
	
	function ptnns_do_things_on_fail($ptnns_check_login_username) {
			
		//check if authenticate filter is enamble		
		if(has_filter('authenticate','wp_authenticate_username_password')) {
							
			global $wpdb;
			$ptnns_check_login_table = $wpdb->prefix.'ptnns_failed_login_attempts';	
			$ptnns_login_history_table = $wpdb->prefix.'ptnns_failed_login_history';	

			//get needed data
			global $ptnns_secure_options_array;	
			global $ptnns_optenhanse_options_array;
			global $ptnns_do_things_on_fail;
			
			//encode ip
			$ptnns_check_login_username_ip = base64_encode(ptnns_check_login_get_ip());				
			
			//work on anonymize IP only if is ban or lock down
			if($ptnns_do_things_on_fail !== 'inform') {			
				
				//anonymize user IP
				$ptnns_check_login_anonymized_ip = null;
				$ptnns_check_login_get_ip = ptnns_check_login_get_ip();
				
				if(!empty($ptnns_check_login_get_ip) && strpos($ptnns_check_login_get_ip, '.') !== false) {
					
					$ptnns_check_login_get_ip_exploded = explode('.',$ptnns_check_login_get_ip);
					
				}
				
				if(!empty($ptnns_check_login_get_ip) && strpos($ptnns_check_login_get_ip, ':') !== false) {
					
					$ptnns_check_login_get_ip_exploded = explode(':',$ptnns_check_login_get_ip);
					
				}
				
				if(!empty($ptnns_check_login_get_ip_exploded)) {
				
					$ptnns_check_login_get_ip_exploded_end = end($ptnns_check_login_get_ip_exploded);
					$ptnns_check_login_get_ip_exploded_end_anonymized = str_repeat('X', strlen($ptnns_check_login_get_ip_exploded_end));
					$ptnns_check_login_anonymized_ip = str_replace(
						$ptnns_check_login_get_ip_exploded_end,
						$ptnns_check_login_get_ip_exploded_end_anonymized,
						$ptnns_check_login_get_ip
					);
				
				}
				
			}
			
			//
			if($ptnns_do_things_on_fail === 'ban') {
						
				//register ban
				$wpdb->insert( 
					$ptnns_login_history_table, 
					array( 
						'time' => current_time('mysql'), 
						'ip' => $ptnns_check_login_username_ip,
						'username' => $ptnns_check_login_username
					), 
					array( 
						'%s', 
						'%s',
						'%s'
					) 
				);

				//send ban mail, if is pro and if notification message is set
				if(!empty($ptnns_optenhanse_options_array['optenhanse_pro'])) {
					
					if(!empty($ptnns_secure_options_array['ban_user_notification']) && $ptnns_secure_options_array['ban_user_notification'] === '1') {
						
						if(is_email($ptnns_secure_options_array['notification_address'])) {
							
							$ptnns_banned_user_notification_address = sanitize_email($ptnns_secure_options_array['notification_address']);
								
							//send mail to inform about successful login
							$ptnns_banned_user_notification_subject = __('User banned from','ptnnslang').' '.get_bloginfo('name');
							$ptnns_banned_user_notification_body = '<html><body>';
							$ptnns_banned_user_notification_body .= '<p>'.__('A user was definitively banned for having exceeded lock downs conceeded','ptnnslang').'.</p><p>'.__('Last username used was','ptnnslang').': <strong>'.$ptnns_check_login_username.'</strong></p>';
							if(!empty($ptnns_check_login_anonymized_ip)) {
								
								$ptnns_banned_user_notification_body .= '<p>'.__('Anonymized user IP is','ptnnslang').': <b>'.$ptnns_check_login_anonymized_ip.'</b></p>';
								
							}
							$ptnns_banned_user_notification_body .= '</body></html>';
							$ptnns_banned_user_notification_headers = array('Content-Type: text/html; charset=UTF-8');
							wp_mail($ptnns_banned_user_notification_address, $ptnns_banned_user_notification_subject, $ptnns_banned_user_notification_body, $ptnns_banned_user_notification_headers);		
						
						}
						
					}
				
				}
				
				if(!empty($ptnns_secure_options_array['ban_message'])) {
				
					//display ban message
					add_filter('login_errors', 'ptnns_custom_ban_message');
					
				}				
			
			}
			
			elseif($ptnns_do_things_on_fail === 'lock') {

				if(
					is_email($ptnns_secure_options_array['notification_address']) && 
					!empty($ptnns_secure_options_array['lock_user_notification']) && 
					$ptnns_secure_options_array['lock_user_notification'] === '1' &&
					!empty($ptnns_optenhanse_options_array['optenhanse_pro']))
				{
					
					$ptnns_locked_user_notification_address = sanitize_email($ptnns_secure_options_array['notification_address']);
						
					//send email if lock_user_notification is true and PRO features are available
					$ptnns_locked_user_notification_subject = __('User locked down from','ptnnslang').' '.get_bloginfo('name');
					$ptnns_locked_user_notification_body = '<html><body>';
					$ptnns_locked_user_notification_body .= '<p>'.__('A user was locked out for having exceeded login attempts conceeded','ptnnslang').'.</p><p>'.__('Last username used was','ptnnslang').': <strong>'.$ptnns_check_login_username.'</strong></p>';
					if(!empty($ptnns_check_login_anonymized_ip)) {
						
						$ptnns_locked_user_notification_body .= '<p>'.__('Anonymized user IP is','ptnnslang').': <b>'.$ptnns_check_login_anonymized_ip.'</b></p>';
						
					}
					$ptnns_locked_user_notification_body .= '</body></html>';
					$ptnns_locked_user_notification_headers = array('Content-Type: text/html; charset=UTF-8');
					wp_mail($ptnns_locked_user_notification_address, $ptnns_locked_user_notification_subject, $ptnns_locked_user_notification_body, $ptnns_locked_user_notification_headers);		

					//show lock down message only if is set
					if(!empty($ptnns_secure_options_array['lock_down_message'])) {					
					
						add_filter('login_errors', 'ptnns_custom_lock_down_message');

						
					}

				}

				//register history entry
				$wpdb->insert( 
					$ptnns_login_history_table, 
					array( 
						'time' => current_time('mysql'), 
						'ip' => $ptnns_check_login_username_ip,
						'username' => $ptnns_check_login_username
					), 
					array( 
						'%s', 
						'%s',
						'%s'
					) 
				);				
				
			}
			
			elseif($ptnns_do_things_on_fail === 'inform') {
						
				//show attempts left, indipendently of previous attempts, only if login_warn is true and only if there are one or more attempts left
				if(!empty($ptnns_secure_options_array['login_warn']) && $ptnns_secure_options_array['login_warn'] === '1') {	

						add_filter('wp_login_errors', 'ptnns_attempts_left_message',10,1);				
					
				} 
			
			}
			
			//register failed login attempt into database
			$wpdb->insert( 
				$ptnns_check_login_table, 
				array( 
					'time' => current_time('mysql'), 
					'ip' => $ptnns_check_login_username_ip,
					'username' => $ptnns_check_login_username
				), 
				array( 
					'%s', 
					'%s',
					'%s'
				) 
			);					

		}


		
	}
	
} else {
	
	error_log('function: "ptnns_do_things_on_fail" already exists');
	
}

//remove failed login attempts from database when user login successfully
if(!function_exists('ptnns_remove_failed_login')){
	
	function ptnns_remove_failed_login() {
		
		if(!empty(ptnns_check_login_get_ip())) {
			
			global $wpdb;
			$ptnns_check_login_table = $wpdb->prefix.'ptnns_failed_login_attempts';
			$ptnns_login_history_table = $wpdb->prefix.'ptnns_failed_login_history';
			
			//encode ip
			$ptnns_check_login_username_ip = base64_encode(ptnns_check_login_get_ip());				
			
			//remove failed login attempts from database when user login successfully
			$wpdb->query("
				DELETE 
				FROM $ptnns_check_login_table 
				WHERE ip = '$ptnns_check_login_username_ip'
			");
			
			$wpdb->query("
				DELETE 
				FROM $ptnns_login_history_table 
				WHERE ip = '$ptnns_check_login_username_ip'
			");
				
		}
			
	}
		
	add_action('wp_login', 'ptnns_remove_failed_login'); 	
	
} else {
	
	error_log('function: "ptnns_remove_failed_login" already exists');
	
}


//deal with authentication procedure
if(!function_exists('ptnns_check_login_attempt')){
	
	//function ptnns_check_login($ptnns_check_login_username) {
	function ptnns_check_login_attempt($ptnns_check_login_username, $ptnns_check_login_password) {
	
		//act only if username and password are entered and user ip is detected
		if(
			!empty($ptnns_check_login_username) && 
			!empty($ptnns_check_login_password) &&
			!empty(ptnns_check_login_get_ip()))
		{
			
			global $wpdb;
			$ptnns_check_login_table = $wpdb->prefix.'ptnns_failed_login_attempts';
			$ptnns_login_history_table = $wpdb->prefix.'ptnns_failed_login_history';	
			
			//encode ip
			$ptnns_check_login_username_ip = base64_encode(ptnns_check_login_get_ip());	
			
			//get needed data
			global $ptnns_secure_options_array;	
			global $ptnns_optenhanse_options_array;
			
			//define 
			global $ptnns_get_attempts_left;
									
			if(!empty($ptnns_secure_options_array['login_ban'])) {
				
				$ptnns_login_lock_ban = $ptnns_secure_options_array['login_ban'];
				
			} else {
				
				$ptnns_login_lock_ban = '0';
			}
			
			if(!empty($ptnns_optenhanse_options_array['optenhanse_pro'])) {
				
				$ptnns_login_attempts_conceded = $ptnns_secure_options_array['login_attempts'];
				$ptnns_login_lock_time = $ptnns_secure_options_array['login_lock'];
			
			} else {
				
				$ptnns_login_attempts_conceded = '14';
				$ptnns_login_lock_time = '120';
				
			}
			
			//initially set attempts left to attempts conceded
			$ptnns_get_attempts_left = $ptnns_login_attempts_conceded;				
			
			//get investigation period
			$ptnns_login_investigation_time = $ptnns_secure_options_array['login_investigation'];
			
			//define current time
			$ptnns_current_time_mysql = current_time('mysql');
			$ptnns_current_time_timestamp = current_time('timestamp');
			
			//delete all failed login attempts out of investigation period
			$wpdb->query("
				DELETE 
				FROM $ptnns_check_login_table 
				WHERE TIMESTAMPDIFF(MINUTE, time, '$ptnns_current_time_mysql') >= '$ptnns_login_investigation_time'
			");	
			
			global $ptnns_do_things_on_fail;
			global $ptnns_do_things_on_signon_fail;
			$ptnns_do_things_on_fail = 'inform';
			$ptnns_do_things_on_signon_fail = null;
			
			//check if ban is enabled
			if($ptnns_login_lock_ban !== '0') {
				
				//get history entries
				$ptnns_get_history_entries = $wpdb->get_results("
					SELECT id 
					FROM $ptnns_login_history_table 
					WHERE ip = '$ptnns_check_login_username_ip' 
				");
				
				//count total hisotry entries
				$ptnns_history_entries = $wpdb->num_rows;
				
				//display ban message and end authentication process if user is banned 
				if((int)$ptnns_history_entries >= (int)$ptnns_login_lock_ban) {
					
					$ptnns_get_attempts_left = 0;
					
					if(!empty($ptnns_secure_options_array['ban_message'])) {
					
						//display ban message
						add_filter('login_errors', 'ptnns_custom_ban_message');
						$ptnns_do_things_on_signon_fail = 'ban';
					
					}
					
					//prevent from further authentication
					remove_filter('authenticate','wp_authenticate_username_password',20,3);
					return null;			
				
				}						
				
			}
			
			//get previous attempts (first the newest)
			$ptnns_get_previous_failed_logins = $wpdb->get_results("
				SELECT time 
				FROM $ptnns_check_login_table 
				WHERE ip = '$ptnns_check_login_username_ip' 
				ORDER BY time DESC
			");
			
			//count total attempts
			$ptnns_previous_failed_logins = $wpdb->num_rows;
			
			if(!empty($ptnns_previous_failed_logins) && $ptnns_previous_failed_logins > 0) {
			
				//redefine attempts left
				$ptnns_get_attempts_left = (int)$ptnns_login_attempts_conceded - $ptnns_previous_failed_logins;
				
				//get last attempt time
				$ptnns_get_last_failed_login_time = $ptnns_get_previous_failed_logins[0]->time;
				
				//count minutes passed from the last fail
				$ptnns_minutes_passed_from_last_fail = ($ptnns_current_time_timestamp - strtotime($ptnns_get_last_failed_login_time))/60;
			
				//lock down only if time passed from the last fail excedes locked down time
				if($ptnns_minutes_passed_from_last_fail <= (int)$ptnns_login_lock_time) {
				
					//display lock down message and end authentication process if user is locked down 
					if((int)$ptnns_previous_failed_logins > (int)$ptnns_login_attempts_conceded) {
											
						//keep showing lock down message only if is set
						if(!empty($ptnns_secure_options_array['lock_down_message'])) {
						
							add_filter('login_errors', 'ptnns_custom_lock_down_message');
							$ptnns_do_things_on_signon_fail = 'lock';
							
						}
					
						//prevent from further authentication
						remove_filter('authenticate','wp_authenticate_username_password',20,3);
						return null;					

					}	
					
					//define what to do on wp_login_failed, if user has to be locked down
					elseif((int)$ptnns_previous_failed_logins === (int)$ptnns_login_attempts_conceded) {

						//define what to do on wp_login_failed, if user has to be banned
						if((int)$ptnns_history_entries + 1 === (int)$ptnns_login_lock_ban && $ptnns_login_lock_ban !== '0') {
							
							if(!empty($ptnns_secure_options_array['ban_message'])) {
							
								$ptnns_do_things_on_fail = 'ban';
								$ptnns_do_things_on_signon_fail = 'ban';
							
							}
									
						
						} else {				
						
							$ptnns_do_things_on_fail = 'lock';
							$ptnns_do_things_on_signon_fail = 'lock';
							
						}
						
					}
					
				}
				
			}
							
		}
		
		add_action('wp_login_failed', 'ptnns_do_things_on_fail'); 
	
	}

	add_filter('wp_authenticate', 'ptnns_check_login_attempt', 50, 2);
	
} else {
	
	error_log('function: "ptnns_check_login_attempt" already exists');
	
}