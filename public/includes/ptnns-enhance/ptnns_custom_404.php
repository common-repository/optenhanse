<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//redirect to custom 404
if(!function_exists('ptnns_custom_404')) {
	
	function ptnns_custom_404() {
		
		//get global option variabiles
		global $ptnns_enhance_options_array;
		global $ptnns_is_sitemap;
		global $ptnns_is_404;
		
		if($ptnns_is_404 === true && $ptnns_is_sitemap === false ) {
			
			$ptnns_custom_404_id = esc_attr($ptnns_enhance_options_array['custom_404_id']);
			
			//check if redirect page exists and it is published
			if(get_post_status($ptnns_custom_404_id) == 'publish' && is_numeric($ptnns_custom_404_id)) {
				
				wp_safe_redirect(get_permalink($ptnns_custom_404_id));
				die();
				
			} else {

				wp_safe_redirect(home_url());
				die();				
				
			}
			
		}
	
	}
	
	add_action('template_redirect', 'ptnns_custom_404', 10);
	
} else {
	
	error_log('function: "ptnns_custom_404" already exists');
	
}