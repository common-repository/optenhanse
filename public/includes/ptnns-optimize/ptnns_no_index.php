<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//add no index to head
if(!function_exists('ptnns_add_no_index_to_head')) {
	
	function ptnns_add_no_index_to_head() {
		
		global $ptnns_enhance_options_array;
		$ptnns_splash_page_id = $ptnns_enhance_options_array['splash_page_id'];
		$ptnns_current_page_id = get_the_ID();
		
		//if is splash page, get_the_ID is empty
		if(empty($ptnns_current_page_id) && is_numeric($ptnns_splash_page_id)) {
			
			$ptnns_current_page_id = $ptnns_splash_page_id;
		}

		$ptnns_no_index = esc_html(get_post_meta($ptnns_current_page_id, '_ptnns_no_index', true));
				
		if(!empty($ptnns_no_index) && $ptnns_no_index === '1'){
		
			//if a no index is set, display no index meta
			echo '<meta name="robots" content="noindex" />'."\r\n";
		
		}
	
	}
	
	add_action('wp_head', 'ptnns_add_no_index_to_head');
	
} else {
	
	error_log('function: "ptnns_add_no_index_to_head" already exists');
	
}