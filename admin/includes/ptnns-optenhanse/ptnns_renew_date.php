<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//renew Optenhanse PRO date schedulation
if(!function_exists('ptnns_renew_date_schedule')){

	function ptnns_renew_date_schedule() {
		
		global $ptnns_optenhanse_options_array;
		
		if(empty(wp_next_scheduled('ptnns_renew_date_hook'))) {
			
			if(!empty($ptnns_optenhanse_options_array['optenhanse_pro'])) {
			
				wp_schedule_event(current_time('timestamp'), 'daily', 'ptnns_renew_date_hook');
				
			} else {
				
				wp_clear_scheduled_hook('ptnns_renew_date_hook');
				
			}
			
		} else {
			
			if(empty($ptnns_optenhanse_options_array['optenhanse_pro'])) {

				wp_clear_scheduled_hook('ptnns_renew_date_hook');
				
			}			
			
		}
		
		//this is usefull for removing old cron instance (when PRO plugin was separated)
		if(!empty(wp_next_scheduled('ptnnsp_renew_date_hook'))) { 
		
			wp_clear_scheduled_hook('ptnnsp_renew_date_hook');
		
		}

	}

	add_action('init', 'ptnns_renew_date_schedule');
	
} else {
	
	error_log('function: "ptnns_renew_date_schedule" already exists');
}

//renew Optenhanse PRO date function
if(!function_exists('ptnns_renew_date')){

	function ptnns_renew_date() {
				
		global $ptnns_optenhanse_options_array;
		
		if(empty($ptnns_optenhanse_options_array) || empty($ptnns_optenhanse_options_array['optenhanse_pro'])) {
						
			//if no option or no token is found
			echo json_encode('no token to check');
			return;

		}
		
		$ptnns_token_to_recheck = $ptnns_optenhanse_options_array['optenhanse_pro'];
		$ptnns_decoded_token_to_recheck = base64_decode($ptnns_token_to_recheck);
		
		//start curl
		$ptnns_curl = curl_init();
		curl_setopt($ptnns_curl, CURLOPT_URL,'https://optenhanse.com/ptnns-check-license.php');
		curl_setopt($ptnns_curl, CURLOPT_POST, 1);
		//curl_setopt($ptnns_curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Accept: application/json'));
		curl_setopt($ptnns_curl, CURLOPT_POSTFIELDS, http_build_query(array(
			'token' => $ptnns_decoded_token_to_recheck,
			'domain' => site_url(),
			'type' => 'check',
			)
		));

		//get curl response
		curl_setopt($ptnns_curl, CURLOPT_RETURNTRANSFER, true);
		$ptnns_curl_response = curl_exec($ptnns_curl);

		//close curl
		curl_close ($ptnns_curl);

		//
		if($ptnns_curl_response === 'ok') { 
		
			//error_log('curl response ok');

			//update option, reset previous fail and reason
			update_option('_ptnns_optenhanse',array(
				'optenhanse_pro' => $ptnns_token_to_recheck,
				'optenhanse_pro_last_check' => current_time('timestamp'),
				'optenhanse_pro_renew_fail' => '0',
				'optenhanse_pro_fail_reason' => null
				),
				false
			);
			
			//pass success to ajax
			echo json_encode(true);
		
		} else { 
		
			//error_log($ptnns_curl_response);
					
			if(!empty($ptnns_optenhanse_options_array['optenhanse_pro_renew_fail'])) {
				
				$ptnns_renew_previous_fails = $ptnns_optenhanse_options_array['optenhanse_pro_renew_fail'];
				
				if((int)$ptnns_renew_previous_fails >= 3) {
					
					//delete option
					delete_option('_ptnns_optenhanse');
					//pass error to ajax
					echo json_encode($ptnns_curl_response);
					
				} else {
					
					$ptnns_renew_current_fail = (int)$ptnns_renew_previous_fails + 1;
					
					update_option('_ptnns_optenhanse',array(
						'optenhanse_pro' => $ptnns_token_to_recheck,
						'optenhanse_pro_last_check' => current_time('timestamp'),
						'optenhanse_pro_renew_fail' => $ptnns_renew_current_fail,
						'optenhanse_pro_fail_reason' => $ptnns_curl_response
						),
						false
					);
					
					echo json_encode(true);
					
				}
				
			} else {
				
				update_option('_ptnns_optenhanse',array(
					'optenhanse_pro' => $ptnns_token_to_recheck,
					'optenhanse_pro_last_check' => current_time('timestamp'),
					'optenhanse_pro_renew_fail' => '1',
					'optenhanse_pro_fail_reason' => $ptnns_curl_response
					),
					false
				);
				
				echo json_encode(true);

			}
		
		}
		
	}	

	add_action('ptnns_renew_date_hook', 'ptnns_renew_date');
	
}  else {
	
	error_log('function: "ptnns_renew_date" already exists');
	
}