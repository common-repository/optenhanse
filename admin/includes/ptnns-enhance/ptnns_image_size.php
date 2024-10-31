<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

if(!function_exists('ptnns_add_size_on_upload')) {

	function ptnns_add_size_on_upload($ptnns_uploaded_image_id) {

		//check if uploaded media is an image
		if(wp_attachment_is_image($ptnns_uploaded_image_id)) {
					
			global $ptnns_enhance_options_array;
					
			//get defined resolution for resizing
			$ptnns_uploaded_image_resize_value = sanitize_text_field($ptnns_enhance_options_array['image_size']);
			
			//get selected size
			if($ptnns_uploaded_image_resize_value === 'HD') {
				
				$ptnns_uploaded_image_resize_width = 1280;
				$ptnns_uploaded_image_resize_height = 720;
				
			} 
			
			elseif($ptnns_uploaded_image_resize_value === 'UXGA') {
				
				$ptnns_uploaded_image_resize_width = 1600;
				$ptnns_uploaded_image_resize_height = 900;
				
			} 
			
			elseif($ptnns_uploaded_image_resize_value === 'FHD') {
				
				$ptnns_uploaded_image_resize_width = 1920;
				$ptnns_uploaded_image_resize_height = 1080;
				
			} 

			elseif($ptnns_uploaded_image_resize_value === 'QHD' || empty($ptnns_uploaded_image_resize_value)) {

				$ptnns_uploaded_image_resize_width = 2560;
				$ptnns_uploaded_image_resize_height = 1440;				
				
			}
			
			elseif($ptnns_uploaded_image_resize_value === 'UHD') {

				$ptnns_uploaded_image_resize_width = 3840;
				$ptnns_uploaded_image_resize_height = 2160;				
				
			}

			//get uploaded file path
			$ptnns_uploaded_image_id_original_path = get_attached_file($ptnns_uploaded_image_id);
			
			//deal with WordPress version (wp_get_original_image_path exists from 5.3) 
			if(function_exists('wp_get_original_image_path')) {
				
				//get original image path
				$ptnns_uploaded_image_id_original_path = wp_get_original_image_path($ptnns_uploaded_image_id);	

				//deactivate big_image_size_threshold
				add_filter('big_image_size_threshold', '__return_false');				

			}
			
			//get image editor
			$ptnns_uploaded_image_image_editor = wp_get_image_editor($ptnns_uploaded_image_id_original_path);
			
			if(is_wp_error($ptnns_uploaded_image_image_editor)) {
				
				$ptnns_uploaded_image_image_editor_error = $ptnns_uploaded_image_image_editor->get_error_message();
				error_log('wp_get_image_editor throw this error: '.$ptnns_uploaded_image_image_editor_error);
				return;
				
			} else {
				
				if(!empty($ptnns_enhance_options_array['skip_gif'])) {
				
					$ptnns_uploaded_image_skip_gif = sanitize_text_field($ptnns_enhance_options_array['skip_gif']);
					
					if($ptnns_uploaded_image_skip_gif === '1') {
					
						//get image mime type
						$ptnns_uploaded_image_type = get_post_mime_type($ptnns_uploaded_image_id);
						
						//check if image is a gif
						if($ptnns_uploaded_image_type === 'image/gif') {
							
							//return to prevent from breaking animated gifs
							return;
							
						}		

					}

				}				
				
				//get uploaded image sizes
				$ptnns_uploaded_image_size = $ptnns_uploaded_image_image_editor->get_size();
				$ptnns_uploaded_image_width = $ptnns_uploaded_image_size['width'];
				$ptnns_uploaded_image_height = $ptnns_uploaded_image_size['height'];
				
				$ptnns_uploaded_image_ratio = $ptnns_uploaded_image_width/$ptnns_uploaded_image_height;
						
				//if is landscape
				if($ptnns_uploaded_image_width > $ptnns_uploaded_image_height) {
								
					//if is larger the resize width
					if($ptnns_uploaded_image_width > $ptnns_uploaded_image_resize_width) {
						
						//define temporary image size
						$ptnns_tempory_image_width = $ptnns_uploaded_image_resize_width;
						$ptnns_tempory_image_height = $ptnns_tempory_image_width/$ptnns_uploaded_image_ratio;
						
						//add temporary image size with new size
						add_image_size('ptnns-scaled', $ptnns_tempory_image_width, $ptnns_tempory_image_height, false);
						
					} else {
						
						//add temporary image size with original size
						add_image_size('ptnns-scaled', $ptnns_uploaded_image_width, $ptnns_uploaded_image_height, false);
						
					}
				
				//if is portrait				
				} else {
					
					//if is taller tha resize height
					if($ptnns_uploaded_image_height > $ptnns_uploaded_image_resize_height) {

						//define temporary image size
						$ptnns_tempory_image_height = $ptnns_uploaded_image_resize_height;
						$ptnns_tempory_image_width = $ptnns_tempory_image_height*$ptnns_uploaded_image_ratio;										

						//add temporary image size 
						add_image_size('ptnns-scaled', $ptnns_tempory_image_width, $ptnns_tempory_image_height, false);
				
					} else {
						
						//add temporary image size with original size
						add_image_size('ptnns-scaled', $ptnns_uploaded_image_width, $ptnns_uploaded_image_height, false);
						
					}					
					
				}
				
			}
					
		}

	}
	
	add_action('add_attachment', 'ptnns_add_size_on_upload');
	
} else {
	
	error_log('function: "ptnns_add_size_on_upload" already exists');
	
}


if(!function_exists('ptnns_use_new_size_as_original')) {

	function ptnns_use_new_size_as_original($ptnns_attachment_metadata, $ptnns_attachment_id) {
		
		//before doing anything else, check ptnns-scaled image: if  exists, image have to be treated
		if(!empty($ptnns_attachment_metadata['sizes']['ptnns-scaled'])) {
			
			//check if upload started from a post editing
			if(!empty(($_REQUEST['post_id'])) && get_post_type($_REQUEST['post_id']) !== 'page'){
				
				$ptnns_current_post_id = absint(($_REQUEST['post_id']));
				$ptnns_current_creation_date = get_the_date('Y/m',$ptnns_current_post_id);
				
			} else {
				
				$ptnns_current_creation_date = null;
			}
			
			//get WordPress upload dir
			$ptnns_upload_dir = wp_upload_dir($ptnns_current_creation_date);
			
			//get original and scaled path
			$ptnns_attachment_path = $ptnns_upload_dir['basedir'].'/'.$ptnns_attachment_metadata['file'];
			$ptnns_attachment_scaled_path = $ptnns_upload_dir['path'].'/'.$ptnns_attachment_metadata['sizes']['ptnns-scaled']['file'];
			$ptnns_attachment_subdir = ltrim($ptnns_upload_dir['subdir'], '/');

			//big_image_size_threshold filter deactivated on add_attachment, so act as if WordPress version was previous then 5.3
			
			//deal with WordPress version (wp_get_original_image_path exists from 5.3) 
			/*if(function_exists('wp_get_original_image_path')) {
				
				//delete scaled image
				unlink($ptnns_attachment_path);

				//replace temporary image size with scaled image
				rename($ptnns_attachment_scaled_path, $ptnns_attachment_path);		
				
			} else {*/
				
				//get temporary image size 
				$ptnns_attachment_scaled_width = $ptnns_attachment_metadata['sizes']['ptnns-scaled']['width'];
				$ptnns_attachment_scaled_height = $ptnns_attachment_metadata['sizes']['ptnns-scaled']['height'];
				
				//get temporary image file name 
				$ptnns_attachment_scaled_file_name = $ptnns_attachment_metadata['sizes']['ptnns-scaled']['file'];
				
				//get old image file name 
				$ptnns_attachment_file_name = str_replace('-'.$ptnns_attachment_scaled_width.'x'.$ptnns_attachment_scaled_height,'',$ptnns_attachment_scaled_file_name);
				
				//replace temporary image filename substring "width x height" with "scaled", as if WordPress version was at least 5.3
				$ptnns_attachment_scaled_new_file_name = str_replace($ptnns_attachment_scaled_width.'x'.$ptnns_attachment_scaled_height,'scaled',$ptnns_attachment_scaled_file_name);
				
				//rename temporary image
				//rename($ptnns_attachment_scaled_path, $ptnns_upload_dir['path'].'/'.$ptnns_attachment_scaled_new_file_name);
				
				copy($ptnns_attachment_scaled_path,$ptnns_upload_dir['path'].'/'.$ptnns_attachment_scaled_new_file_name);
				
				//update file entry
				$ptnns_attachment_metadata['file']  = $ptnns_attachment_subdir.'/'.$ptnns_attachment_scaled_new_file_name;
				
				//update _wp_attached_file
				update_post_meta($ptnns_attachment_id,'_wp_attached_file',$ptnns_attachment_subdir.'/'.$ptnns_attachment_scaled_new_file_name);
				
				//create original image value, as if WordPress version was at least 5.3
				$ptnns_attachment_metadata['original_image'] = $ptnns_attachment_file_name;
				
			//}

			//update image metadata
			$ptnns_attachment_metadata['width']  = $ptnns_attachment_metadata['sizes']['ptnns-scaled']['width'];
			$ptnns_attachment_metadata['height'] = $ptnns_attachment_metadata['sizes']['ptnns-scaled']['height'];

			//unset temporary image metadata
			//unset($ptnns_attachment_metadata['sizes']['ptnns-scaled']);
			
		}
		
		//return metadata
		return $ptnns_attachment_metadata;

	}
	
	add_action('wp_generate_attachment_metadata', 'ptnns_use_new_size_as_original', 10, 2);
	
} else {
	
	error_log('function: "ptnns_use_new_size_as_original" already exists');
	
}