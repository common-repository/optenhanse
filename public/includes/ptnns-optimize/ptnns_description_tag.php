<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//add description to head
if(!function_exists('ptnns_add_description_to_head')) {
	
	function ptnns_add_description_to_head() {
		
		global $ptnns_enhance_options_array;
		$ptnns_splash_page_id = $ptnns_enhance_options_array['splash_page_id'];
		$ptnns_current_page_id = get_the_ID();
		
		//if is splash page, get_the_ID is empty
		if(empty($ptnns_current_page_id) && is_numeric($ptnns_splash_page_id)) {
			
			$ptnns_current_page_id = $ptnns_splash_page_id;
		}

		$ptnns_description = esc_html(get_post_meta($ptnns_current_page_id, '_ptnns_meta_description', true));
		
		//backward compatibility with previous version of Optenhance plugin
		if(empty($ptnns_description)) {
			
			$ptnns_description = esc_html(get_post_meta($ptnns_current_page_id, '_optenhance_description', true));
		}
		
		if(!empty($ptnns_description)){
		
		//if a custom description is provided, display it as description
			echo '<meta name="description" content="'.$ptnns_description.'">'."\r\n";
		
		}
	
	}
	
	add_action('wp_head', 'ptnns_add_description_to_head');
	
} else {
	
	error_log('function: "ptnns_add_description_to_head" already exists');
	
}