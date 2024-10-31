<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//add filter to define jpeg quality, only if jpeg qaulity is set and it is different than 82 (default value)
if(!function_exists('ptnns_jpeg_quality_filter')) {

	function ptnns_jpeg_quality_filter() {
		
		global $ptnns_enhance_options_array;

		if(!empty($ptnns_enhance_options_array['image_treating']) && esc_attr($ptnns_enhance_options_array['image_treating']) === '1' && !empty($ptnns_enhance_options_array['jpeg_quality']) && $ptnns_enhance_options_array['jpeg_quality'] !== 82) {
			
			function ptnns_custom_jpeg_quality() {
				
				global $ptnns_enhance_options_array;
				return sanitize_text_field($ptnns_enhance_options_array['jpeg_quality']);
					
			} 

			add_filter('jpeg_quality', 'ptnns_custom_jpeg_quality');
			
		}
		
	}
	
	add_action('plugins_loaded', 'ptnns_jpeg_quality_filter');
	
} else {
	
	error_log('function: "ptnns_jpeg_quality_filter" already exists');
	
}


if(!function_exists('ptnns_jpeg_quality_postmeta')) {

	function ptnns_jpeg_quality_postmeta($ptnns_uploaded_jpeg_id) {
		
		//update post meta only if jpeg quality is set
		global $ptnns_enhance_options_array;

		if(!empty($ptnns_enhance_options_array['image_treating']) && esc_attr($ptnns_enhance_options_array['image_treating']) === '1' && !empty($ptnns_enhance_options_array['jpeg_quality'])) {
					
			$ptnns_current_jpeg_quality = sanitize_text_field($ptnns_enhance_options_array['jpeg_quality']);
			update_post_meta($ptnns_uploaded_jpeg_id, '_ptnns_current_jpeg_quality', $ptnns_current_jpeg_quality);
			
		} 

	}

	add_action('add_attachment', 'ptnns_jpeg_quality_postmeta');
	
} else {
	
	error_log('function: "ptnns_jpeg_quality_postmeta" already exists');
	
}
