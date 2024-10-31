<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die;

//LOAD FRONTEND FUNCTIONS BY SETTINGS
if(!function_exists('ptnns_public_dependencies_by_settings')){

	function ptnns_public_dependencies_by_settings() {
	
		//get global option variabiles
		global $ptnns_optimize_options_array;
		global $ptnns_enhance_options_array;
		
		//set two new global variables
		global $ptnns_is_sitemap;
		global $ptnns_is_404;
		
		//switch new global variables to false
		$ptnns_is_sitemap = false;
		$ptnns_is_404 = false;
		
		//load dependencies by optenhanse options

		//load dependencies by optimize options

		if((!empty($ptnns_enhance_options_array['custom_404']) && esc_attr($ptnns_enhance_options_array['custom_404']) === '1') || (!empty($ptnns_optimize_options_array['sitemap']) && esc_attr($ptnns_optimize_options_array['sitemap']) === '1')) {

			if(is_404()) {
				
				//switch ptnns_is_404 to true, if requested page is 404
				$ptnns_is_404 = true;
				
				global $wp;
				$ptnns_current_url = home_url($wp->request);
				
				if($ptnns_current_url == home_url().'/sitemap.xml' && !empty($ptnns_optimize_options_array['sitemap']) && esc_attr($ptnns_optimize_options_array['sitemap']) === '1') {

					//switch ptnns_is_sitemap to true, if requested page is sitemap.xml
					//$ptnns_is_sitemap = true;

				}
			
			}			
			
		}
		

		if(!empty($ptnns_optimize_options_array['html_minification'])) {
			
			if(esc_attr($ptnns_optimize_options_array['html_minification']) === '1') {
						
				if(!is_admin()){
					
					//include fronted functions
					require_once plugin_dir_path(__DIR__).'public/includes/ptnns-optimize/ptnns_html_minification.php';
				
				}
				
			}
			
		}
					
	}
	
} else {
	
	error_log('function: "ptnns_public_dependencies_by_settings" already exists');
	
}