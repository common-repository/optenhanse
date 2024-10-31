<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

if(!function_exists('ptnns_register_optimize_settings_action')) {
	
	function ptnns_register_optimize_settings_action() {

		if(!function_exists('ptnns_sanitize_optimize_entries')) {
		
			function ptnns_sanitize_optimize_entries($ptnns_posted_values) {
				
				//prepare array for saving sanitized data
				$ptnns_values_to_save = array();
				
				//introduce a varible to control errors
				$ptnns_erros_found = 0;
				
				//we need this to verify pro activation
				global $ptnns_optenhanse_options_array;
				
				//loop into posted data
				foreach($ptnns_posted_values as $ptnns_posted_key => $ptnns_posted_value){
					
					//filter by key
					switch($ptnns_posted_key) {

						//deal with title_tag
						case 'title_tag':
						
						//check value is not different from 0 and 1
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['title_tag'] = $ptnns_posted_value;
						
						break;
						
						//deal with description_tag
						case 'description_tag':
						
						//check value is not different from 0 and 1
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['description_tag'] = $ptnns_posted_value;
						
						break;
						
						//deal with description_tag
						case 'no_index':
						
						//check value is not different from 0 and 1
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['no_index'] = $ptnns_posted_value;
						
						break;
						
						//deal with facebook_share
						case 'facebook_share':
						
						//check value is not different from 0 and 1
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['facebook_share'] = $ptnns_posted_value;
						
						break;
						
						//deal with twitter_share
						case 'twitter_share':
						
						//check value is not different from 0 and 1
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['twitter_share'] = $ptnns_posted_value;
						
						break;
						
						//deal with alternative_social_image
						case 'alternative_social_image_id':
						
						//check if posted value is not empty
						if(!empty($ptnns_posted_value)){
							
							if(!is_numeric($ptnns_posted_value)) {

								$ptnns_posted_value = null;
								$ptnns_erros_found++;								
								
							} else {
							
								//sanitize url
								$ptnns_posted_value = esc_attr($ptnns_posted_value);
								$ptnns_alternative_social_image_url = esc_url_raw(get_the_guid($ptnns_posted_value));
								
								//check if url entered is a valid media attachment
								if(!get_post_status($ptnns_posted_value)) {
								
									$ptnns_posted_value = null;

									//info message
									$ptnns_message_text = __('Unique social image does not contain a valid media gallery element. Please check it out','ptnnslang').'!';
									$ptnns_message_type = 'warning';
												
									add_settings_error(
										'ptnns-info',
										'ptnns-info',
										$ptnns_message_text,
										$ptnns_message_type				
									);
								
								} else {
									
									//get attachment filetype
									$ptnns_check_filetype = wp_check_filetype($ptnns_alternative_social_image_url);
									$ptnns_current_filetype = explode('/',$ptnns_check_filetype['type']);
									
									//check if media attachment is an image
									if($ptnns_current_filetype[0] != 'image') {
										
										$ptnns_posted_value = null;

										//info message
										$ptnns_message_text = __('Unique Social Image does not contain a valid image. Please check it out','ptnnslang').'!';
										$ptnns_message_type = 'warning';
													
										add_settings_error(
											'ptnns-info',
											'ptnns-info',
											$ptnns_message_text,
											$ptnns_message_type				
										);
										
									}

								}
								
							}
							
						} else {
							
							$ptnns_posted_value = null;
						}

						//add sanitized value to array to save
						$ptnns_values_to_save['alternative_social_image_id'] = $ptnns_posted_value;					
						
						break;

						//deal with sitemap
						case 'sitemap':
						
						//check value is not different from 0 and 1
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['sitemap'] = $ptnns_posted_value;
						
						break;

						//deal with attachment_meta
						case 'attachment_meta':
						
						//check value is not different from 0 and 1
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['attachment_meta'] = $ptnns_posted_value;
						
						break;	

						//deal with thumbnails rebuild
						case 'rebuild_meta':
							
						//check value is not different from 0 and 1
						if(is_numeric($ptnns_posted_value) && ($ptnns_posted_value === '1') && !empty($ptnns_optenhanse_options_array['optenhanse_pro'])){
							
							//save temporary option
							update_option('_ptnns_rebuild_meta', '1');
							
								//info message
								$ptnns_message_text = '<span class="ptnns-rebuild-in-progress-message" style="display:inline">'.__('Meta rebuild in progress','ptnnslang').':</span>
								<span class="ptnns-rebuild-calculating-message">'.__('Please wait','ptnnslang').'</span>
								<span class="ptnns-rebuild-in-progress-step"></span>
								<span class="ptnns-rebuild-completed-message">'.__('Meta rebuild completed','ptnnslang').'!</span>
								<span class="ptnns-rebuild-no-entry-message">'.__('Good News, no meta needs to be rebuilt','ptnnslang').'!</span>';
								$ptnns_message_type = 'warning';
											
								add_settings_error(
									'ptnns-info',
									'ptnns-info',
									$ptnns_message_text,
									$ptnns_message_type				
								);
							
						} 									
						break;		

						//deal with html_minification
						case 'html_minification':
						
						//check value is not different from 0 and 1
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['html_minification'] = $ptnns_posted_value;
						
						break;	
						
						//deal with browser_cache
						case 'browser_cache':
						
						//check value is not different from 0 and 1
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['browser_cache'] = $ptnns_posted_value;
						
						break;			

						//deal with media_cache
						case 'media_cache':
						
						//check value is numeric
						if(!is_numeric($ptnns_posted_value)){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['media_cache'] = $ptnns_posted_value;
						
						break;	

						//deal with script_cache
						case 'script_cache':
						
						//check value is numeric
						if(!is_numeric($ptnns_posted_value)){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['script_cache'] = $ptnns_posted_value;
						
						break;

						//deal with code_cache
						case 'code_cache':
						
						//check value is numeric
						if(!is_numeric($ptnns_posted_value)){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['code_cache'] = $ptnns_posted_value;
						
						break;							
						
					}
	 
				}
				
				if($ptnns_erros_found > 0) {
				
					//info message
					$ptnns_message_text = __('One or more values entered were not accepted, so they were set to a default value. Please check it out','ptnnslang').'!';
					$ptnns_message_type = 'warning';
								
					add_settings_error(
						'ptnns-info',
						'ptnns-info',
						$ptnns_message_text,
						$ptnns_message_type				
					);
				
				}
				
				//return array to save
				return $ptnns_values_to_save;
			
			}
		
		}
		

		if(!empty($_POST['ptnns-save-optimize-options'])) {
			
			//can't find out if nonce is checkd on register_setting, so let's check it "manually"
			if(!empty($_POST['ptnns-options-nonce']) && wp_verify_nonce($_POST['ptnns-options-nonce'], 'ptnns-options-nonce')) {
					
				//create an empty option first, otherwise register_setting acts twice
				update_option('_ptnns_optimize', '', false);
					
				//register settings
				$ptnns_register_optimize_options_args = array(
					'type' => 'string', 
					'sanitize_callback' => 'ptnns_sanitize_optimize_entries',
					);
					
				register_setting('optimize-section', '_ptnns_optimize', $ptnns_register_optimize_options_args);

				//save temporary option
				update_option('ptnns_optimize_options_updated', '1');				
				
				//update message
				$ptnns_message_text = __( 'Settings Saved', 'ptnnslang' ).'!';
				$ptnns_message_type = 'updated';
						
				add_settings_error(
					'ptnns-message',
					'ptnns-message',
					$ptnns_message_text,
					$ptnns_message_type
				);
				
			}

		}

	}
	
	add_action('admin_init', 'ptnns_register_optimize_settings_action');

} else {
	
	error_log('function: "ptnns_register_optimize_settings_action" already exists');
	
}