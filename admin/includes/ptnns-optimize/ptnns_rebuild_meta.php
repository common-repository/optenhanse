<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//ajax function
if(!function_exists('ptnns_rebuild_attachment_meta')){
	
	function ptnns_rebuild_attachment_meta() {
		
		global $ptnns_optenhanse_options_array;
		
		if(!current_user_can('update_core') || empty($ptnns_optenhanse_options_array['optenhanse_pro'])) {return;}
		
		if(isset($_POST['ptnns_rebuild_meta_id'])) {
			
			//check nonce (if fails, dies)
			check_ajax_referer('ptnns-rebuild-meta-nonce', 'ptnns_rebuild_meta_nonce');	
			
			$ptnns_involved_meta_id = sanitize_text_field($_POST['ptnns_rebuild_meta_id']);
			
			if(!is_numeric($ptnns_involved_meta_id)) {
				
				return;
				
			}
			
			//get post title
			$ptnns_meta_title = get_post_field('post_title', $ptnns_involved_meta_id);
			//get alt title
			$ptnns_meta_alt = get_post_meta($ptnns_involved_meta_id, '_wp_attachment_image_alt', true);			
			//get post excerpt
			$ptnns_meta_excerpt = get_post_field('post_excerpt', $ptnns_involved_meta_id);			
			//get post content
			$ptnns_meta_content = get_post_field('post_content', $ptnns_involved_meta_id);		
			//clean post title
			$ptnns_meta_title_cleaned = str_replace(array('-','_'), ' ', $ptnns_meta_title);
			
			//update title
			wp_update_post(
				array(
					'ID' => $ptnns_involved_meta_id, 
					'post_title' => $ptnns_meta_title_cleaned
					)
				);	
			
			//update alt title, if empty
			if(empty($ptnns_meta_alt)) {
				
				//set alt title
				update_post_meta($ptnns_involved_meta_id,'_wp_attachment_image_alt', $ptnns_meta_title_cleaned);
				
			}
			
			//update post excerpt, if empty
			if(empty($ptnns_meta_excerpt)) {

				wp_update_post(
					array(
						'ID' => $ptnns_involved_meta_id, 
						'post_excerpt' => $ptnns_meta_title_cleaned
						)
					);	
	
			}
			
			//update post content, if empty
			if(empty($ptnns_meta_content)) {

				wp_update_post(
					array(
						'ID' => $ptnns_involved_meta_id, 
						'post_content' => $ptnns_meta_title_cleaned
						)
					);	
				
			}		

			echo json_encode('media rebuilt for image '.$ptnns_involved_meta_id);			
		

		} else {
				
			check_ajax_referer('ptnns-rebuild-meta-nonce', 'ptnns_rebuild_meta_nonce');	

			$ptnns_media_to_rebuild = new WP_Query(
				array(
					'post_type' => 'attachment',
					'posts_per_page' => -1,
					'orderby' => 'date',
					'order' => 'ASC',
					'suppress_filters' => false,
					'offset' => 0,
					'post_status' => 'inherit',
					'ignore_sticky_posts' => true,
					'no_found_rows' => true,
					'fields' => 'ids',
				)
			);
			
			//get post id array
			$ptnns_media_to_rebuild_post_ids = $ptnns_media_to_rebuild->posts;
			
			$ptnns_media_to_rebuild_involved_post_ids = array();
			
			//loop into post id array
			foreach($ptnns_media_to_rebuild_post_ids as $ptnns_media_to_rebuild_post_id) {
				
				//get post title
				$ptnns_meta_title = get_post_field('post_title', $ptnns_media_to_rebuild_post_id);
				//get alt title
				$ptnns_meta_alt = get_post_meta($ptnns_media_to_rebuild_post_id, '_wp_attachment_image_alt', true);			
				//get post excerpt
				$ptnns_meta_excerpt = get_post_field('post_excerpt', $ptnns_media_to_rebuild_post_id);			
				//get post content
				$ptnns_meta_content = get_post_field('post_content', $ptnns_media_to_rebuild_post_id);	
				
				//include in array only elements with at least one meta to fill
				if(empty($ptnns_meta_title) || empty($ptnns_meta_alt) || empty($ptnns_meta_excerpt) || empty($ptnns_meta_content)) {
					
					$ptnns_media_to_rebuild_involved_post_ids[] = $ptnns_media_to_rebuild_post_id;
					
				}
				
			}
			
			wp_reset_postdata();
				
			echo json_encode($ptnns_media_to_rebuild_involved_post_ids);
			
		}
		
		wp_die();	
		
	}
	
	add_action('wp_ajax_ptnns_rebuild_attachment_meta', 'ptnns_rebuild_attachment_meta');
	
}  else {
	
	error_log('function: "ptnns_rebuild_attachment_meta" already exists');
	
}

