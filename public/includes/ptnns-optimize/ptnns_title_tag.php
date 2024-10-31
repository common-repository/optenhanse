<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');


//get custom title tag
if(!function_exists('ptnns_get_custom_title_tag')) {
	
	function ptnns_get_custom_title_tag($ptnns_post_meta_title) {
		
		global $ptnns_enhance_options_array;
		$ptnns_splash_page_id = $ptnns_enhance_options_array['splash_page_id'];
		$ptnns_current_page_id = get_the_ID();
		
		//if is splash page, get_the_ID is empty
		if(empty($ptnns_current_page_id) && is_numeric($ptnns_splash_page_id)) {
			
			$ptnns_current_page_id = $ptnns_splash_page_id;
		}

		$ptnns_title = esc_html(get_post_meta($ptnns_current_page_id, '_ptnns_meta_title', true));
		$ptnns_title_blogname = esc_html(get_post_meta($ptnns_current_page_id, '_ptnns_meta_title_blogname', true));
		
		if(!empty($ptnns_title)){
			
			if($ptnns_title_blogname !== '0') {
				
				$ptnns_post_meta_title = $ptnns_title. ' | '.get_bloginfo('name');
				
			} else {
				
				$ptnns_post_meta_title = $ptnns_title;
				
			}
			
		}
		
		return $ptnns_post_meta_title;
	
	}
	
} else {
	
	error_log('function: "ptnns_get_custom_title_tag" already exists');
	
}

//add description to head
if(!function_exists('ptnns_add_custom_title_tag')) {
	
	function ptnns_add_custom_title_tag($ptnns_post_meta_title) {
				
		add_filter('pre_get_document_title', 'ptnns_get_custom_title_tag', 10, 2);
	
	}
	
	add_action('wp', 'ptnns_add_custom_title_tag');
	
} else {
	
	error_log('function: "ptnns_add_custom_title_tag" already exists');
	
}