<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//ajax function
if(!function_exists('ptnns_check_token')){
	
	function ptnns_check_token() {
		
		//check role
		if(!current_user_can('update_core')) {return;}
						
		//get token to activate from ajax
		if(!empty($_POST['ptnns_token_to_activate']) && !empty($_POST['ptnns_check_token_action'])) {
			
			//check nonce (if fails, dies)
			check_ajax_referer('ptnns-check-token-nonce', 'ptnns_check_token_nonce');		
			
			$ptnns_token_to_activate = sanitize_text_field($_POST['ptnns_token_to_activate']);
			$ptnns_check_token_action = sanitize_text_field($_POST['ptnns_check_token_action']);
			
			//start curl
			$ptnns_curl = curl_init();
			curl_setopt($ptnns_curl, CURLOPT_URL,'https://optenhanse.com/ptnns-check-license.php');
			curl_setopt($ptnns_curl, CURLOPT_POST, 1);
			//curl_setopt($ptnns_curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Accept: application/json'));
			curl_setopt($ptnns_curl, CURLOPT_POSTFIELDS, http_build_query(array(
				'token' => $ptnns_token_to_activate,
				'domain' => site_url(),
				'type' => $ptnns_check_token_action,
				)
			));

			//get curl response
			curl_setopt($ptnns_curl, CURLOPT_RETURNTRANSFER, true);
			$ptnns_curl_response = curl_exec($ptnns_curl);

			//close curl
			curl_close ($ptnns_curl);

			//
			if($ptnns_curl_response === 'ok') { 

				//add/update option with current token
				update_option('_ptnns_optenhanse',array('optenhanse_pro' => base64_encode($ptnns_token_to_activate)), false);
				
				//pass success to ajax
				echo json_encode(true);
			
			} else { 
			
				//pass error to ajax
				echo json_encode($ptnns_curl_response);

				//delete option with current token
				delete_option('_ptnns_optenhanse');
			
			}			

		
		} else {

			//just for debug
			echo json_encode('no token is passed');
			
			
		}
		
		wp_die();	
		
	}
	
	add_action('wp_ajax_ptnns_check_token', 'ptnns_check_token');
	
} else {
	
	error_log('function: "ptnns_check_token" already exists');
	
}