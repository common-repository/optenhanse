<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

 
//add custom column to post type list
if(!function_exists('ptnns_decription_post_column_header')) {
	
	function ptnns_decription_post_column_header($ptnns_default_wp_columns) {
		
		//keep this condition to hide column only on some post types
		$ptnns_excluded_post_types = array('elementor_library');
		global $current_screen;
		
		if(!in_array($current_screen->post_type,$ptnns_excluded_post_types)) {
			
			$ptnns_default_wp_columns['pttns_optenhanse_summary'] = __('Optenhanse Summary','ptnnslang');
			
		}
		
		return $ptnns_default_wp_columns;
		
	}
	
	add_filter('manage_posts_columns', 'ptnns_decription_post_column_header');
	
} else {
	
	error_log('function: "ptnns_decription_post_column_header" already exists');
	
}

//add custom column to page list
if(!function_exists('ptnns_decription_page_column_header')) {
	
	function ptnns_decription_page_column_header($ptnns_default_wp_columns) {
		
		$ptnns_decription_page_column_header = array(
			
			'pttns_optenhanse_summary' => __('Optenhanse Summary','ptnnslang')
			
		);
		
		$ptnns_all_page_columns = array_merge($ptnns_default_wp_columns, $ptnns_decription_page_column_header);

		return $ptnns_all_page_columns;
		
	}
	
	add_filter('manage_pages_columns', 'ptnns_decription_page_column_header');

} else {
	
	error_log('function: "ptnns_decription_page_column_header" already exists');
	
}


//deal with custom column content
if(!function_exists('ptnns_decription_postand_page_column_content')) {
	
function ptnns_decription_postand_page_column_content($ptnns_column_name, $ptnns_involved_post_id) {
	
		if($ptnns_column_name === 'pttns_optenhanse_summary') {
				
			global $ptnns_optimize_options_array;
			
			if(!empty($ptnns_optimize_options_array['title_tag']) && $ptnns_optimize_options_array['title_tag'] === '1') {

				$ptnns_get_title = esc_attr(get_post_meta($ptnns_involved_post_id, '_ptnns_meta_title', true));
				
				if(!empty($ptnns_get_title)) {
					
					$ptnns_meta_title = $ptnns_get_title;
					
					$ptnns_get_meta_title_blogname = esc_attr(get_post_meta($ptnns_involved_post_id, '_ptnns_meta_title_blogname', true));
								
					if($ptnns_get_meta_title_blogname === '1') {
						
						$ptnns_meta_title = $ptnns_meta_title.' | '.get_bloginfo('name');
						
					} 
					
				} else {
					
					$ptnns_meta_title = get_the_title($ptnns_involved_post_id);
				}
				
			} else  {
				
				$ptnns_meta_title = get_the_title($ptnns_involved_post_id);
				
			}
			
					
			if(!empty($ptnns_optimize_options_array['description_tag']) && $ptnns_optimize_options_array['description_tag'] === '1') {

				$ptnns_description = esc_attr(get_post_meta($ptnns_involved_post_id, '_ptnns_meta_description', true));
				
				//backward compatibility with previous version of Optenhance plugin
				if(empty($ptnns_description)) {
					
					$ptnns_description = esc_html(get_post_meta(get_the_ID(), '_optenhance_description', true));
				}			
			
			} else {
				
				$ptnns_description = null;
				
			}
			

			$ptnns_title_length = strlen($ptnns_meta_title);
			$ptnns_description_length = strlen($ptnns_description);
			
			if((int)$ptnns_title_length > 60 != (int)$ptnns_title_length < 5) {
				
				$ptnns_title_length = '<span style="color:#a00">'.$ptnns_title_length.'</span>';
				
			}
			
			if((int)$ptnns_description_length > 160 || (int)$ptnns_description_length < 100) {
				
				$ptnns_description_length = '<span style="color:#a00">'.$ptnns_description_length.'</span>';
				
			}

			$pttns_optenhanse_summary = '<strong>'.__('Title','ptnnslang').'</strong>: '.$ptnns_meta_title. ' (<strong>'.$ptnns_title_length.'</strong>)';
			$pttns_optenhanse_summary .= '<br><strong>'.__('Description','ptnnslang').'</strong>: '.$ptnns_description. ' (<strong>'.$ptnns_description_length.'</strong>)';

			if(!empty($ptnns_optimize_options_array['no_index']) && $ptnns_optimize_options_array['no_index'] === '1') {

				$ptnns_get_no_index = esc_attr(get_post_meta($ptnns_involved_post_id, '_ptnns_no_index', true));
				
				if($ptnns_get_no_index === '1') {
					
					$pttns_optenhanse_summary .= '<br><strong><span style="color:#a00;">No Index</span></strong>';
					
				}
				
			}
		
			echo $pttns_optenhanse_summary;

		}
		
	}
	
	add_action('manage_posts_custom_column', 'ptnns_decription_postand_page_column_content', 10, 2);
	add_action('manage_pages_custom_column', 'ptnns_decription_postand_page_column_content', 10, 2);

} else {
	
	error_log('function: "ptnns_decription_postand_page_column_content" already exists');
	
}