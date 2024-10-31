<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

if(!function_exists('ptnns_smtp_mail_settings')) {
	
	function ptnns_smtp_mail_settings($ptnns_phpmailer) {
						
		if(!is_object($ptnns_phpmailer)){
			
			$ptnns_phpmailer = (object)$ptnns_phpmailer;
		
		}		

		//get saved data
		global $ptnns_enhance_options_array;
		$ptnns_smtp_encryption = $ptnns_enhance_options_array['smtp_encryption'];
		$ptnns_smtp_port = $ptnns_enhance_options_array['smtp_port'];
		$ptnns_smtp_server = $ptnns_enhance_options_array['smtp_server'];
		$ptnns_smtp_from_name = $ptnns_enhance_options_array['smtp_from_name'];
		$ptnns_smtp_from_address = $ptnns_enhance_options_array['smtp_from_address'];
		$ptnns_smtp_authentication_password = base64_decode($ptnns_enhance_options_array['smtp_authentication_password']);
		$ptnns_smtp_authentication_address = $ptnns_enhance_options_array['smtp_authentication_address'];
		$ptnns_smtp_authentication = $ptnns_enhance_options_array['smtp_authentication'];
	
		//setup SMTP
		$ptnns_phpmailer->isSMTP();
		$ptnns_phpmailer->Mailer = 'smtp';
		$ptnns_phpmailer->Host = $ptnns_smtp_server;
		
		if($ptnns_smtp_authentication === '1') {

			$ptnns_phpmailer->SMTPAuth = true;
			
		}
		
		$ptnns_phpmailer->Port = $ptnns_smtp_port;
		$ptnns_phpmailer->Username = $ptnns_smtp_authentication_address;
		$ptnns_phpmailer->Password = $ptnns_smtp_authentication_password;
		
		//conditional elements
		if($ptnns_smtp_encryption !== 'none') {

			$ptnns_phpmailer->SMTPSecure = strtolower($ptnns_smtp_encryption);
			
		} else {
			
			$ptnns_phpmailer->SMTPAutoTLS = false;

		}
		
		if(!empty($ptnns_smtp_from_address)) {

			$ptnns_phpmailer->From = $ptnns_smtp_from_address;
			
		}
		
		if(!empty($ptnns_smtp_from_name)) {

			$ptnns_phpmailer->FromName = $ptnns_smtp_from_name;
			
		}
		
		//$ptnns_phpmailer->SMTPDebug = true;

		
	}
	
	add_action('phpmailer_init', 'ptnns_smtp_mail_settings');
		
} else {
	
	error_log('function: "ptnns_smtp_mail_settings" already exists');
	
}