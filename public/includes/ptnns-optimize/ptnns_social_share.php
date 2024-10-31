<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

if(!function_exists('ptnns_get_social_image_url')){

	function ptnns_get_social_image_url() {
		
		global $ptnns_optimize_options_array;
		global $ptnns_enhance_options_array;
		
		//get current page id
		$ptnns_current_page_id = get_the_ID();
		
		$ptnns_splash_page_id = $ptnns_enhance_options_array['splash_page_id'];	
		
		//if is splash page, get_the_ID is empty
		if(empty($ptnns_current_page_id) && is_numeric($ptnns_splash_page_id)) {
			
			$ptnns_current_page_id = $ptnns_splash_page_id;
		}
				
		//get featured image thumbnail
		$ptnns_social_image_url = wp_get_attachment_url(get_post_thumbnail_id($ptnns_current_page_id));
			
		//if featured image is not set, get the alternative media image
		if(empty($ptnns_social_image_url)) {
			
			if(!empty($ptnns_optimize_options_array['alternative_social_image_id'])) {
				
				$ptnns_alternative_social_image_id = esc_attr($ptnns_optimize_options_array['alternative_social_image_id']);
				
				//get alternative social image first
				if(!empty($ptnns_alternative_social_image_id) && is_numeric($ptnns_alternative_social_image_id)) {
					
					//get media url by id
					$ptnns_social_image_url = esc_url_raw(wp_get_attachment_url($ptnns_alternative_social_image_id));
					
				}
				
			}
			
		}
		
		//if alternative image is not set, get a random media image			
		if(empty($ptnns_social_image_url)) {			
				
			//if no alternativa image is set, get a random image
			$ptnns_random_media_images_args = array(
				'post_type' => 'attachment',
				'post_status' => 'any',
				'orderby' => 'rand',
				'posts_per_page' => 1,
				'post_mime_type' => array('image/png', 'image/x-png', 'image/jpeg', 'image/jpg', 'image/gif', 'image/bmp')
			);
		 
			$ptnns_random_media_images = get_posts($ptnns_random_media_images_args);
			
			if(!empty($ptnns_random_media_images)) {
				
				$ptnns_social_image_url = wp_get_attachment_url($ptnns_random_media_images[0]->ID);
				
			}

		}
		
		//return value or false if empty
		if(!empty($ptnns_social_image_url)) {
		
			return $ptnns_social_image_url; 
		
		} else {
			
			return false;
			
		}
				
	}
	
} else {
	
	error_log('function: "ptnns_get_social_image_url" already exists');
	
}


if(!function_exists('ptnns_social_description')){

	function ptnns_social_description() {
		
		global $ptnns_enhance_options_array;
		$ptnns_splash_page_id = $ptnns_enhance_options_array['splash_page_id'];
		$ptnns_current_page_id = get_the_ID();
		
		//if is splash page, get_the_ID is empty
		if(empty($ptnns_current_page_id) && is_numeric($ptnns_splash_page_id)) {
			
			$ptnns_current_page_id = $ptnns_splash_page_id;
		}
		
		global $ptnns_optimize_options_array;
		
		if(!empty($ptnns_optimize_options_array['description_tag']) && $ptnns_optimize_options_array['description_tag'] === '1') {
		
			//get meta description content, if is set
			$ptnns_social_description = esc_attr(get_post_meta($ptnns_current_page_id, '_ptnns_meta_description', true));
			
			//backward compatibility with previous version of Optenhance plugin
			if(empty($ptnns_social_description)) {
				
				$ptnns_social_description = esc_html(get_post_meta($ptnns_current_page_id, '_optenhance_description', true));
			}
			
			//if meta description is not set, get site description
			if(empty($ptnns_social_description)) {
				
				$ptnns_social_description = get_bloginfo('description');
				
			}
			
		} else {
			
			$ptnns_social_description = get_bloginfo('description');
			
		}
		
		//return value or false if empty
		if(!empty($ptnns_social_description)) {
		
			return $ptnns_social_description; 
		
		} else {
			
			return false;
			
		}
		
	}
	
} else {
	
	error_log('function: "ptnns_social_description" already exists');
	
}


if(!function_exists('ptnns_social_title')){

	function ptnns_social_title() {
		
		global $ptnns_enhance_options_array;
		$ptnns_splash_page_id = $ptnns_enhance_options_array['splash_page_id'];
		$ptnns_current_page_id = get_the_ID();
		
		//if is splash page, get_the_ID is empty
		if(empty($ptnns_current_page_id) && is_numeric($ptnns_splash_page_id)) {
			
			$ptnns_current_page_id = $ptnns_splash_page_id;
		}
		
		global $ptnns_optimize_options_array;
		
		if(!empty($ptnns_optimize_options_array['title_tag']) && $ptnns_optimize_options_array['title_tag'] === '1') {
		
			$ptnns_title = esc_html(get_post_meta($ptnns_current_page_id, '_ptnns_meta_title', true));
			$ptnns_title_blogname = esc_html(get_post_meta($ptnns_current_page_id, '_ptnns_meta_title_blogname', true));
			
			if(!empty($ptnns_title)){
				
				if($ptnns_title_blogname !== '0') {
					
					$ptnns_social_title = $ptnns_title. ' | '.get_bloginfo('name');
					
				} else {
					
					$ptnns_social_title = $ptnns_title;
					
				}
				
				return $ptnns_social_title; 
				
			} else {
				
				
				return get_the_title($ptnns_current_page_id);
			}
			
		} else {
			
			return get_the_title($ptnns_current_page_id);
			
		}
		
	}
	
} else {
	
	error_log('function: "ptnns_social_title" already exists');
	
}


if(!function_exists('ptnns_add_social_tags')){

	function ptnns_add_social_tags() {
				
		global $ptnns_enhance_options_array;
		$ptnns_splash_page_id = $ptnns_enhance_options_array['splash_page_id'];	
		$ptnns_page_url = get_the_permalink();
				
		//if is splash page, get_the_permalink is empty
		if(empty($ptnns_page_url) && is_numeric($ptnns_splash_page_id)) {
			
			$ptnns_page_url = get_the_permalink($ptnns_splash_page_id);
		}

		global $ptnns_optimize_options_array;
		
		//if at least one of the social tag has to be added, get results of functions above
		if((!empty($ptnns_optimize_options_array['facebook_share']) && $ptnns_optimize_options_array['facebook_share'] === '1') || 
		(!empty($ptnns_optimize_options_array['twitter_share']) && $ptnns_optimize_options_array['twitter_share'] === '1')) {
		
			$ptnns_social_image_url = ptnns_get_social_image_url();
			$ptnns_social_description = ptnns_social_description();
			$ptnns_social_title = ptnns_social_title();
			
		}
		
		//if facebook share is set
		if(isset($ptnns_optimize_options_array['facebook_share']) && $ptnns_optimize_options_array['facebook_share'] === '1') {

			echo '<meta property="og:locale" content="'.get_locale().'">'."\r\n";
			echo '<meta property="og:site_name" content="'.get_bloginfo('name').'">'."\r\n";
			echo '<meta property="og:title" content="'.$ptnns_social_title.'">'."\r\n";
			echo '<meta property="og:url" content="'.$ptnns_page_url.'">'."\r\n";
			echo '<meta property="og:type" content="website">'."\r\n";
			
			if($ptnns_social_description) {	
				
				echo '<meta property="og:description" content="'.$ptnns_social_description.'">'."\r\n";
			
			}			
										
			if($ptnns_social_image_url) {	
				
				echo '<meta property="og:image" content="'.$ptnns_social_image_url.'">'."\r\n";
			
			}
		
		}
		
		//if twitter share is set
		if(isset($ptnns_optimize_options_array['twitter_share']) && $ptnns_optimize_options_array['twitter_share'] === '1') {
		
			echo '<meta name="twitter:card" content="summary">'."\r\n";
			echo '<meta name="twitter:site" content="'.site_url().'">'."\r\n";
			echo '<meta name="twitter:creator" content="'.get_bloginfo('name').'">'."\r\n";
			echo '<meta name="twitter:title" content="'.$ptnns_social_title.'">'."\r\n";

			if($ptnns_social_description) {
				
				echo '<meta name="twitter:description" content="'.$ptnns_social_description.'">'."\r\n";
			
			} 
			
			if($ptnns_social_image_url) {
				
				echo '<meta name="twitter:image" content="'.$ptnns_social_image_url.'">'."\r\n";
			
			} 
		
		}
		
	}
	
	add_action('wp_head', 'ptnns_add_social_tags');	
	
} else {
	
	error_log('function: "ptnns_add_social_tags" already exists');
	
}