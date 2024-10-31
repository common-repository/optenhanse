<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//ajax function
if(!function_exists('ptnns_smtp_do_test')){
	
	function ptnns_smtp_do_test() {
		
		if(!current_user_can('update_core')) {return;}

		if(!empty($_POST['ptnns_smtp_test_nonce'])) {

			//check nonce (if fails, dies)
			check_ajax_referer('ptnns-smtp-test-nonce', 'ptnns_smtp_test_nonce');					
			
			//get global option variabiles
			global $ptnns_enhance_options_array;
			//get smtp_test_address
			$ptnns_smtp_test_address = $ptnns_enhance_options_array['smtp_test_address'];
			
			if(!is_email($ptnns_smtp_test_address)){
				
				echo json_encode(false);
			
			} else {
				
				$ptnns_smtp_test_address = sanitize_email($ptnns_smtp_test_address);
				$ptnns_smtp_test_headers = 'Content-Type: text/html; charset=UTF-8';
				$ptnns_smtp_test_subject = 'Mail test form '.get_bloginfo('name');
				$ptnns_smtp_test_message = '
				<html>
					<body style="width:100%; margin:0; padding:0">
						<table style="width:100%; background:#f2f2f2; text-align:center">
							<tr>
								<td>
									<h1 >Good News, this mail is from '.get_bloginfo('name').'</h1>
								</td>
							</tr>
							<tr>
								<td>
									<h2>Mail test from <a href="'.get_bloginfo('url').'" title="'.get_bloginfo('name').'">'.get_bloginfo('name').'</a> completed successfully!</h2>
								</td>
							</tr>	
						</table>
					</body>
				</html>
				';
				
				$ptnns_smtp_mail_test = wp_mail($ptnns_smtp_test_address, $ptnns_smtp_test_subject, $ptnns_smtp_test_message, $ptnns_smtp_test_headers);
				
					if($ptnns_smtp_mail_test === false){
									
						//$ptnns_smtp_mail_test_error = $ptnns_smtp_mail_test->get_error_message();

						//retrurn false
						echo json_encode(false);
				
			
					} else {
						
						//return true
						echo json_encode(true);
						
					}

			}
			
		} else {
			
			echo json_encode('nonce is not set');
			
		}
	
		wp_die();	
		
	}
	
	add_action('wp_ajax_ptnns_smtp_do_test', 'ptnns_smtp_do_test');
	
} else {
	
	error_log('function: "ptnns_smtp_do_test" already exists');
}