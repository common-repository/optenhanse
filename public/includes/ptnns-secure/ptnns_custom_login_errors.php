<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

if(!function_exists('ptnns_custom_login_error_public')) {
	
	function ptnns_custom_login_error_public($ptnns_login_form_errors) {	
	
		if(!empty($ptnns_login_form_errors)) {
			
			global $ptnns_secure_options_array;
			
			if(isset($ptnns_login_form_errors->errors['empty_username']) && !empty($ptnns_secure_options_array['empty_username_login_errors'])){
				
				$ptnns_login_form_errors->errors['empty_username'][0] = esc_html($ptnns_secure_options_array['empty_username_login_errors']);
			
			}
			
			if(isset($ptnns_login_form_errors->errors['empty_password']) && !empty($ptnns_secure_options_array['empty_password_login_errors'])){
				
				$ptnns_login_form_errors->errors['empty_password'][0] = esc_html($ptnns_secure_options_array['empty_password_login_errors']);
			
			}
		
			if(isset($ptnns_login_form_errors->errors['invalid_username']) && !empty($ptnns_secure_options_array['invalid_username_login_errors'])){
				
				$ptnns_login_form_errors->errors['invalid_username'][0] = esc_html($ptnns_secure_options_array['invalid_username_login_errors']);
			
			}
			
			if(isset($ptnns_login_form_errors->errors['invalid_email']) && !empty($ptnns_secure_options_array['invalid_email_login_errors'])){
				
				$ptnns_login_form_errors->errors['invalid_email'][0] = esc_attr($ptnns_secure_options_array['invalid_email_login_errors']);
			
			}
			
			if(isset($ptnns_login_form_errors->errors['incorrect_password']) && !empty($ptnns_secure_options_array['incorrect_password_login_errors'])){
				
				$ptnns_login_form_errors->errors['incorrect_password'][0] = esc_attr($ptnns_secure_options_array['incorrect_password_login_errors']);
			
			}			
			
			//return $ptnns_attempts_left_message;
			return $ptnns_login_form_errors;
		
		}	
		
	}
	
	add_filter('wp_login_errors', 'ptnns_custom_login_error_public',10,1);
	

} else {
	
	error_log('function: "ptnns_custom_login_error_public" already exists');
	
}

/*
if(!function_exists('ptnns_custom_login_error_public_woocommerce')) {
	
	function ptnns_custom_login_error_public_woocommerce($ptnns_login_form_errors_woocommerce) {	
	
		if(!empty($ptnns_login_form_errors_woocommerce)) {
			
			error_log('not empty: '.var_export($ptnns_login_form_errors_woocommerce, true));
		
		}	
		
		error_log('error: '.var_export($ptnns_login_form_errors_woocommerce, true));
		
		return $ptnns_login_form_errors_woocommerce;
		
	}
	
	add_filter('woocommerce_process_login_errors', 'ptnns_custom_login_error_public_woocommerce',10,1);
	

} else {
	
	error_log('function: "ptnns_custom_login_error_public_woocommerce" already exists');
	
}
*/