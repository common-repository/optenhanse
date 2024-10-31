<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

if(!function_exists('ptnns_set_attachment_meta')) {

	//auto set attachment meta
	function ptnns_set_attachment_meta($ptnns_media_id) {
			
		//get post title
		$ptnns_attachment_title = get_post_field('post_title', $ptnns_media_id);
		
		//clean post title
		$ptnns_attachment_title_cleaned = str_replace(array('-','_'), ' ', $ptnns_attachment_title);
		
		//set alt title
		update_post_meta($ptnns_media_id,'_wp_attachment_image_alt', $ptnns_attachment_title_cleaned);
		
		//set excerpt, content and update title
		wp_update_post(
			array(
				'ID' => $ptnns_media_id, 
				'post_title' => $ptnns_attachment_title_cleaned, 
				'post_excerpt' => $ptnns_attachment_title_cleaned, 
				'post_content' => $ptnns_attachment_title_cleaned
				)
			);
			
	} 
	
	add_action('add_attachment', 'ptnns_set_attachment_meta');	

} else {
	
	error_log('function: "ptnns_set_attachment_meta" already exists');
	
}