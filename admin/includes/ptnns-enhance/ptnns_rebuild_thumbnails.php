<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//ajax function
if(!function_exists('ptnns_rebuild_and_resize_images')){
	
	function ptnns_rebuild_and_resize_images() {
		
		//check role
		if(!current_user_can('update_core')) {return;}
						
		//rebuild or resize by id
		if(!empty($_POST['ptnns_rebuild_thumbnails_id']) && 
			!empty($_POST['ptnns_rebuild_thumbnails_compression']) && 
			!empty($_POST['ptnns_rebuild_thumbnails_width']) && 
			!empty($_POST['ptnns_rebuild_thumbnails_height']) && 
			!empty($_POST['ptnns_rebuild_thumbnails_orientation']) && 
			!empty($_POST['ptnns_rebuild_thumbnails_nonce'])) {				

			//check nonce (if fails, dies)
			check_ajax_referer('ptnns-rebuild-thumbnails-nonce', 'ptnns_rebuild_thumbnails_nonce');				
			
			$ptnns_involved_image_id = sanitize_text_field($_POST['ptnns_rebuild_thumbnails_id']);
			$ptnns_current_jpeg_quality = sanitize_text_field($_POST['ptnns_rebuild_thumbnails_compression']);
			$ptnns_involved_image_resize_width = sanitize_text_field($_POST['ptnns_rebuild_thumbnails_width']);
			$ptnns_involved_image_resize_height = sanitize_text_field($_POST['ptnns_rebuild_thumbnails_height']);
			$ptnns_involved_image_orientation = sanitize_text_field($_POST['ptnns_rebuild_thumbnails_orientation']);
			
			if(!is_numeric($ptnns_involved_image_id) || 
				!is_numeric($ptnns_current_jpeg_quality) || 
				!is_numeric($ptnns_involved_image_resize_width) || 
				!is_numeric($ptnns_involved_image_resize_height)) {
				
				return;
				
			}
			
			if(wp_attachment_is_image($ptnns_involved_image_id)) {
				
				//get attached file metadata
				$ptnns_get_attachment_metadata = get_post_meta($ptnns_involved_image_id, '_wp_attachment_metadata', true);
				
				//get attached file path
				$ptnns_involved_image_id_attachment_path = get_attached_file($ptnns_involved_image_id);
				
				//deal with WordPress version
				if(function_exists('wp_get_original_image_path')) {
					
					//WordPress version is at least 5.3, we have a new function to deal with
					$ptnns_involved_image_id_original_path = wp_get_original_image_path($ptnns_involved_image_id);
					
					//WordPress version is at least 5.3, we have a filter to disable large image scaling
					add_filter('big_image_size_threshold', '__return_false');
					
					//WordPress version is at least 5.3, we have a filter to rotate images by exif
					//add_filter('wp_image_maybe_exif_rotate', '__return_false');
					
					//WordPress version is at least 5.3, get original image from metadata
					if(!empty($ptnns_get_attachment_metadata['original_image'])) {
						
						$ptnns_attachment_original_image = $ptnns_get_attachment_metadata['original_image'];
						
					}

				} else {
					
					//original path and attached path are the same
					$ptnns_involved_image_id_original_path = $ptnns_involved_image_id_attachment_path;
					
				}							

				global $ptnns_enhance_options_array;
				
				//add new compression, only if different than 82 (WordPress default)
				if(!empty($ptnns_enhance_options_array['jpeg_quality']) && sanitize_text_field($ptnns_enhance_options_array['jpeg_quality']) !== '82') {					
					
					function ptnns_custom_jpeg_quality() {
						
						global $ptnns_enhance_options_array;
						return $ptnns_enhance_options_array['jpeg_quality'];
							
					}
					
					add_filter('jpeg_quality', 'ptnns_custom_jpeg_quality');
					
				}

				//resize with image editor, using scaled image as source if exists (WordPress 5.3)
				//$ptnns_involved_jpeg_image_editor = wp_get_image_editor($ptnns_involved_image_id_attachment_path);
				
				//resize with image editor, using original image
				$ptnns_involved_jpeg_image_editor = wp_get_image_editor($ptnns_involved_image_id_original_path);
				
				if(is_wp_error($ptnns_involved_jpeg_image_editor)) {
					
					$ptnns_involved_jpeg_image_editor_error = $ptnns_involved_jpeg_image_editor->get_error_message();
					error_log('wp_get_image_editor throw this error before resizing image '.$ptnns_involved_image_id.': '.$ptnns_involved_jpeg_image_editor_error);
					return;
					
				} else {
				
				//if(!is_wp_error($ptnns_involved_jpeg_image_editor)) {
					
					if($ptnns_involved_image_orientation === 'landscape') {
						
						$ptnns_involved_jpeg_image_editor->resize($ptnns_involved_image_resize_width, $ptnns_involved_image_resize_width);
						
					}
					
					elseif($ptnns_involved_image_orientation === 'portrait') {
						
						$ptnns_involved_jpeg_image_editor->resize($ptnns_involved_image_resize_height, $ptnns_involved_image_resize_height);
						
					}
					
					
					//save using scaled image as source if exists (WordPress 5.3)
					$ptnns_involved_jpeg_id_destination_path = $ptnns_involved_jpeg_image_editor->save($ptnns_involved_image_id_attachment_path);
					
				}	
							
				//recreate thumbnails, starting from original image (in WordPress 5.3)
				$ptnns_involved_image_meta = wp_generate_attachment_metadata($ptnns_involved_image_id, $ptnns_involved_image_id_original_path);
					
				//deal with errors
				if(is_wp_error($ptnns_involved_image_meta)){
					
					//echo json_encode($ptnns_involved_image_meta->get_error_message());
					$ptnns_involved_image_meta_error = $ptnns_involved_image_meta->get_error_message();
					error_log('wp_get_image_editor throw this error before resizing image '.$ptnns_involved_image_id.': '.$ptnns_involved_image_meta_error);
					return;
					
				}
				
				//deal with empty meta
				elseif(empty($ptnns_involved_image_meta)){
					
					//echo json_encode('metadata is empty');
					error_log('attachement metadata are empty for image id: '.$ptnns_involved_image_id);
					return;
					
				} 
				
				
				//deal again with WordPress version
				if(!empty($ptnns_attachment_original_image)) {									
					
					//get image value, to prevent from naming thumbnails with "-scaled" suffix
					$ptnns_involved_image_meta['original_image'] = $ptnns_attachment_original_image;
					
				}
				
				//get image editor
				$ptnns_involved_jpeg_image_editor = wp_get_image_editor($ptnns_involved_image_id_attachment_path);
				
				//deal with errors
				if(is_wp_error($ptnns_involved_jpeg_image_editor)) {

					//echo json_encode($ptnns_involved_jpeg_image_editor->get_error_message());	
					$ptnns_involved_jpeg_image_editor_error = $ptnns_involved_jpeg_image_editor->get_error_message();
					error_log('wp_get_image_editor throw this error while getting image '.$ptnns_involved_image_id.' size: '.$ptnns_involved_jpeg_image_editor_error);
					return;			
					
				} 
				
				//get involved image sizes, otherwise original image width will be written to metadata
				$ptnns_involved_image_size = $ptnns_involved_jpeg_image_editor->get_size();
				$ptnns_involved_image_meta['width'] = $ptnns_involved_image_size['width'];
				$ptnns_involved_image_meta['height'] = $ptnns_involved_image_size['height'];				
				
				//update meta data, adding original image (WordPress 5.3) and involved image sizes
				wp_update_attachment_metadata($ptnns_involved_image_id, $ptnns_involved_image_meta);
				
				//add/update post meta with current jpeg quality compression
				update_post_meta($ptnns_involved_image_id, '_ptnns_current_jpeg_quality', $ptnns_current_jpeg_quality);
				
				//just for debug
				echo json_encode('resized '.$ptnns_involved_image_orientation.' image '.$ptnns_involved_image_id.' to '.$ptnns_involved_image_resize_width.'x'.$ptnns_involved_image_resize_height.' and rebuilted thumbnails to '.$ptnns_current_jpeg_quality.' compression %');
				
			
			} else {
			
				echo json_encode('involed id is not an image');
			
			}

		} 
		
		//get ids to be rebuilt or resized
		elseif(empty($_POST['ptnns_rebuild_thumbnails_id']) && 
			empty($_POST['ptnns_rebuild_thumbnails_width']) && 
			empty($_POST['ptnns_rebuild_thumbnails_height']) && 
			empty($_POST['ptnns_rebuild_thumbnails_orientation']) && 
			!empty($_POST['ptnns_rebuild_thumbnails_compression']) && 
			!empty($_POST['ptnns_rebuild_thumbnails_nonce'])) {
								
			//check nonce (if fails, forbibbend is returned)
			check_ajax_referer('ptnns-rebuild-thumbnails-nonce', 'ptnns_rebuild_thumbnails_nonce');			
			
			$ptnns_current_jpeg_quality = sanitize_text_field($_POST['ptnns_rebuild_thumbnails_compression']);
			
			if(!is_numeric($ptnns_current_jpeg_quality)) {return;}
				
			//get images to recompress
			$ptnns_images_to_recompress = new WP_Query(
				array(
					'post_type' => 'attachment',
					'posts_per_page' => -1,
					'orderby' => 'date',
					'order' => 'ASC',
					'post_mime_type' => 'image/jpeg',
					'suppress_filters' => false,
					'offset' => 0,
					'post_status' => 'inherit',
					'ignore_sticky_posts' => true,
					'no_found_rows' => true,
					'fields' => 'ids',
					'meta_query' => array(
						'relation'=> 'OR',
							array(
								'key' => '_ptnns_current_jpeg_quality',
								'value' => $ptnns_current_jpeg_quality,
								'compare' => '!='
							),
							array(
								'key' => '_ptnns_current_jpeg_quality',
								'value' => '',
								'compare' => 'NOT EXISTS'
							)
						)
				)
			);
					
			//images to recompress
			$ptnns_media_to_recompress_post_ids = $ptnns_images_to_recompress->posts;
			
			wp_reset_postdata();
			
			$ptnns_media_to_recompress = array();
			$ptnns_media_to_recompress_orientation = array();
			
			//loop into post id array
			foreach($ptnns_media_to_recompress_post_ids as $ptnns_media_to_recompress_post_id) {
				
				/*global $ptnns_enhance_options_array;
				$ptnns_media_image_skip_gif = sanitize_text_field($ptnns_enhance_options_array['skip_gif']);
				
				if($ptnns_media_image_skip_gif === '1') {
				
					//get image mime type
					$ptnns_media_image_type = get_post_mime_type($ptnns_media_to_recompress_post_id);
					
					//check if image is a gif
					if($ptnns_media_image_type === 'image/gif') {
						
						//continue to prevent from breaking animated gifs
						continue;
						
					}		

				}	*/
											
				//get media info
				$ptnns_media_info = get_post_meta($ptnns_media_to_recompress_post_id, '_wp_attachment_metadata', true);
								
				//get image size
				$ptnns_media_info_width = $ptnns_media_info['width'];
				$ptnns_media_info_height = $ptnns_media_info['height'];
				
				//if image is landscape
				if($ptnns_media_info_width > $ptnns_media_info_height) {
									
					$ptnns_media_to_recompress[] = $ptnns_media_to_recompress_post_id;
					$ptnns_media_to_recompress_orientation[] = 'landscape';				

				//if image is portrait	
				} else {
										
					$ptnns_media_to_recompress[] = $ptnns_media_to_recompress_post_id;
					$ptnns_media_to_recompress_orientation[] = 'portrait';
					
				}				
				
			}
			
			$ptnns_media_to_recompress_associative = array_combine($ptnns_media_to_recompress, $ptnns_media_to_recompress_orientation);
			
			//get resize setting
			global $ptnns_enhance_options_array;
				
			$ptnns_uploaded_jpeg_resize_value = sanitize_text_field($ptnns_enhance_options_array['image_size']);

			if($ptnns_uploaded_jpeg_resize_value === 'HD') {
				
				$ptnns_uploaded_jpeg_resize_width = 1280;
				$ptnns_uploaded_jpeg_resize_height = 720;
				
			} 
			
			elseif($ptnns_uploaded_jpeg_resize_value === 'UXGA') {
				
				$ptnns_uploaded_jpeg_resize_width = 1600;
				$ptnns_uploaded_jpeg_resize_height = 900;
				
			} 
			
			elseif($ptnns_uploaded_jpeg_resize_value === 'FHD') {
				
				$ptnns_uploaded_jpeg_resize_width = 1920;
				$ptnns_uploaded_jpeg_resize_height = 1080;
				
			} 

			elseif($ptnns_uploaded_jpeg_resize_value === 'QHD' || empty($ptnns_uploaded_jpeg_resize_value)) {

				$ptnns_uploaded_jpeg_resize_width = 2560;
				$ptnns_uploaded_jpeg_resize_height = 1440;				
				
			}
			
			elseif($ptnns_uploaded_jpeg_resize_value === 'UHD') {

				$ptnns_uploaded_jpeg_resize_width = 3840;
				$ptnns_uploaded_jpeg_resize_height = 2160;				
				
			}	
				
			$ptnns_images_to_resize = new WP_Query(
				array(
					'post_type' => 'attachment',
					'posts_per_page' => -1,
					'orderby' => 'date',
					'order' => 'ASC',						
					'post_mime_type' => 'image',
					'suppress_filters' => false,
					'offset' => 0,
					'post_status' => 'inherit',
					'ignore_sticky_posts' => true,
					'no_found_rows' => true,
					'fields' => 'ids'
				)
			);
			
			//get post id array
			$ptnns_media_to_resize_post_ids = $ptnns_images_to_resize->posts;
			
			wp_reset_postdata();
						
			$ptnns_media_to_resize = array();
			$ptnns_media_to_resize_orientation = array();
			
			//loop into post id array
			foreach($ptnns_media_to_resize_post_ids as $ptnns_media_to_resize_post_id) {
				
				if(!empty($ptnns_enhance_options_array['skip_gif'])) {
				
					$ptnns_media_skip_gif = sanitize_text_field($ptnns_enhance_options_array['skip_gif']);
				
				}
				
				
				if(!empty($ptnns_media_skip_gif) && $ptnns_media_skip_gif === '1') {
				
					//get image mime type
					$ptnns_media_type = get_post_mime_type($ptnns_media_to_resize_post_id);
					
					//check if image is a gif
					if($ptnns_media_type === 'image/gif') {
						
						//exclude gif from images to recompress to prevent from breaking animated gifs
						continue;
						
					}
				}
											
				//get media info
				$ptnns_media_info = get_post_meta($ptnns_media_to_resize_post_id, '_wp_attachment_metadata', true);
				
				//get image size
				$ptnns_media_info_width = $ptnns_media_info['width'];
				$ptnns_media_info_height = $ptnns_media_info['height'];
				
				//get attached original file path
				$ptnns_original_image_id_attachment_path = get_attached_file($ptnns_media_to_resize_post_id);
				
				//deal with WordPress version
				if(function_exists('wp_get_original_image_path')) {
					
					//WordPress version is at least 5.3, we have a new function to deal with
					$ptnns_image_id_original_path = wp_get_original_image_path($ptnns_media_to_resize_post_id);
					

				} else {
					
					//original path and attached path are the same
					$ptnns_image_id_original_path = $ptnns_original_image_id_attachment_path;
					
				}	

				
				$ptnns_original_jpeg_image_editor = wp_get_image_editor($ptnns_image_id_original_path);
				
				if(is_wp_error($ptnns_original_jpeg_image_editor)) {
					
					$ptnns_original_jpeg_image_editor_error = $ptnns_original_jpeg_image_editor->get_error_message();
					error_log('wp_get_image_editor throw this error before resizing image '.$ptnns_media_to_resize_post_id.': '.$ptnns_original_jpeg_image_editor_error);
					continue;
					
				} 

				//get original image sizes, to check if resize is need
				$ptnns_original_image_size = $ptnns_original_jpeg_image_editor->get_size();
				$ptnns_original_image_size_width = $ptnns_original_image_size['width'];
				$ptnns_original_image_size_height = $ptnns_original_image_size['height'];	
		
				
				//if image is landscape
				if($ptnns_media_info_width > $ptnns_media_info_height) {

					//if landscape image is different then defined and original image is wider then defined
					//if($ptnns_media_info_width > $ptnns_uploaded_jpeg_resize_width && !in_array($ptnns_media_to_resize_post_id,$ptnns_media_to_recompress)) {
					if($ptnns_media_info_width !== $ptnns_uploaded_jpeg_resize_width && 
						$ptnns_original_image_size_width > $ptnns_uploaded_jpeg_resize_width && 
						!in_array($ptnns_media_to_resize_post_id,$ptnns_media_to_recompress)) {
										
						$ptnns_media_to_resize[] = $ptnns_media_to_resize_post_id;
						$ptnns_media_to_resize_orientation[] = 'landscape';
					
					}					

				//if image is portrait	
				} else {
					
					//if portrait image is different then defined and original image is higher then defined
					//if($ptnns_media_info_height > $ptnns_uploaded_jpeg_resize_height && !in_array($ptnns_media_to_resize_post_id,$ptnns_media_to_recompress)) {
					if($ptnns_media_info_height !== $ptnns_uploaded_jpeg_resize_height && 
					$ptnns_original_image_size_height > $ptnns_uploaded_jpeg_resize_height &&
					!in_array($ptnns_media_to_resize_post_id,$ptnns_media_to_recompress)) {
										
						$ptnns_media_to_resize[] = $ptnns_media_to_resize_post_id;
						$ptnns_media_to_resize_orientation[] = 'portrait';
					
					}
					
				}				
				
			}
			
			$ptnns_media_to_resize_associative = array_combine($ptnns_media_to_resize, $ptnns_media_to_resize_orientation);
			
			$ptnns_media_to_work_with_associative = $ptnns_media_to_recompress_associative + $ptnns_media_to_resize_associative;
			
			//debug
			//echo 'recompress: '.var_export($ptnns_media_to_recompress_associative, true);
			//echo 'resize: '.var_export($ptnns_media_to_resize_associative, true);
			//echo 'all: '.var_export($ptnns_media_to_work_with_associative, true);
			
			$ptnns_media_to_work_with = array_keys($ptnns_media_to_work_with_associative);
			$ptnns_orientation_to_work_with = array_values($ptnns_media_to_work_with_associative);			
			
			//debug
			//echo 'media: '.var_export($ptnns_media_to_work_with, true);
			//echo 'orientation: '.var_export($ptnns_orientation_to_work_with, true);
			
			echo json_encode(array($ptnns_media_to_work_with,$ptnns_uploaded_jpeg_resize_width,$ptnns_uploaded_jpeg_resize_height,$ptnns_orientation_to_work_with));	
			
		}
		
		wp_die();	
		
	}
	
	add_action('wp_ajax_ptnns_rebuild_and_resize_images', 'ptnns_rebuild_and_resize_images');
	
} else {
	
		error_log('function: "ptnns_rebuild_and_resize_images" already exists');
}