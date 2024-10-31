<?php
//ajax function
if(!function_exists('ptnns_login_ajax')){
	
	function ptnns_login_ajax() {
					
		if(!empty($_POST['ptnns_login_form_nonce'])){
			
			//check nonce (if fails, dies)
			check_ajax_referer('ptnns-login-form-nonce', 'ptnns_login_form_nonce');

			//get posted data from ajax (don't need to escape, because wp_signon sanitize iteslf)
			$ptnns_posted_data = array();
			$ptnns_posted_data['user_login'] = sanitize_user($_POST['ptnns-login-user-input']);
			$ptnns_posted_data['user_password'] = trim($_POST['ptnns-login-password-input']);
			$ptnns_posted_data['remember'] = true;		
			
			//check user with wp_signon
			$ptnns_signon = wp_signon($ptnns_posted_data);
			if(is_wp_error($ptnns_signon)){
				
				global $ptnns_secure_options_array;	
				
				//deal with wp_signon errors and add custom errors, if set
				switch($ptnns_signon->get_error_code()) {
					
					case ('invalid_username'):
					
					if (!empty($ptnns_secure_options_array['invalid_username_login_errors'])){
						
						$ptnns_login_error = wp_kses_post($ptnns_secure_options_array['invalid_username_login_errors']);
						
					} else {
						
						$ptnns_login_error = $ptnns_signon->get_error_message();
					}
					
					break;
					
					case ('invalid_email'):
					
					if (!empty($ptnns_secure_options_array['invalid_email_login_errors'])){
						
						$ptnns_login_error = wp_kses_post($ptnns_secure_options_array['invalid_email_login_errors']);
						
					} else {
						
						$ptnns_login_error = $ptnns_signon->get_error_message();
					}
					
					break;
					
					case ('incorrect_password'):
					
					if (!empty($ptnns_secure_options_array['incorrect_password_login_errors'])){
						
						$ptnns_login_error = wp_kses_post($ptnns_secure_options_array['incorrect_password_login_errors']);
						
					} else {
						
						$ptnns_login_error = $ptnns_signon->get_error_message();
					}
					
					break;

					case ('empty_username'):
					
					if (!empty($ptnns_secure_options_array['empty_username_login_errors'])){
						
						$ptnns_login_error = wp_kses_post($ptnns_secure_options_array['empty_username_login_errors']);
						
					} else {
						
						$ptnns_login_error = $ptnns_signon->get_error_message();
					}
					
					break;
					
					case ('empty_password'):
					
					if (!empty($ptnns_secure_options_array['empty_password_login_errors'])){
						
						$ptnns_login_error = wp_kses_post($ptnns_secure_options_array['empty_password_login_errors']);
						
					} else {
						
						$ptnns_login_error = $ptnns_signon->get_error_message();
					}
					
					break;
					
					default:
					$ptnns_login_error = $ptnns_signon->get_error_message().' ('.$ptnns_signon->get_error_code().')';
					break;
				}	
				
				
				//append message if check_login is enabled or display lock and ban messages if they are set
				if(!empty($ptnns_secure_options_array['check_login']) && esc_attr($ptnns_secure_options_array['check_login']) === '1') {
					
					//deal again with login errors
					if (
					$ptnns_signon->get_error_code() === 'invalid_username' ||
					$ptnns_signon->get_error_code() === 'invalid_email' ||
					$ptnns_signon->get_error_code() === 'incorrect_password' ||
					$ptnns_signon->get_error_code() === 'authentication_failed')
					{
						
						global $ptnns_get_attempts_left;
						global $ptnns_do_things_on_signon_fail;
						
						//echo '<script>console.log("ptnns_get_attempts_left: '.$ptnns_get_attempts_left.' ptnns_do_things_on_fail: '.$ptnns_do_things_on_signon_fail.'")</script>';
						
						if(
							!empty($ptnns_secure_options_array['login_warn']) && 
							$ptnns_secure_options_array['login_warn'] === '1' &&
							$ptnns_get_attempts_left > 0
							)
						{
							$ptnns_login_error = $ptnns_login_error.'<br>'.__('Be careful','ptnnslang').': '.__('you have only','ptnnslang').' '.$ptnns_get_attempts_left.' '.__('attempts left','ptnnslang');
								
						} 
						
						elseif(
							!empty($ptnns_secure_options_array['lock_down_message']) &&
							$ptnns_get_attempts_left <= 0
							)
						{
							
							if($ptnns_do_things_on_signon_fail === 'ban') {

								$ptnns_login_error = esc_attr($ptnns_secure_options_array['ban_message']);
								//prevent from further authentication
								//remove_filter('authenticate','wp_authenticate_username_password',20,3);
								echo json_encode(array(
									'ptnns_login_result' => false, 
									'ptnns_login_message' => $ptnns_login_error)
									);
								wp_die();								
								
							}
							
							elseif($ptnns_do_things_on_signon_fail === 'lock') {
								
								$ptnns_login_error = esc_attr($ptnns_secure_options_array['lock_down_message']);
								//prevent from further authentication
								//remove_filter('authenticate','wp_authenticate_username_password',20,3);
								echo json_encode(array(
									'ptnns_login_result' => false, 
									'ptnns_login_message' => $ptnns_login_error)
									);
								wp_die();															
								
							}
							
	
						} 
						
					
					}
				
				}				
				
				
				//print error message
				echo json_encode(array(
					'ptnns_login_result' => false, 
					'ptnns_login_message' => $ptnns_login_error)
					);
			
			} else {
				
				//print json message
				$ptnns_login_confirm = __('Logged in, please wait','ptnnslang');
				echo json_encode(array(
					'ptnns_login_result' => true, 
					'ptnns_login_message' => $ptnns_login_confirm)
					);	
				
			}
			
			
			wp_die();	
			
		}
		
	}
	
	add_action('wp_ajax_nopriv_ptnns_login_ajax', 'ptnns_login_ajax');
	
}  else {
	
	error_log('function: "ptnns_login_ajax" already exists');
	
}