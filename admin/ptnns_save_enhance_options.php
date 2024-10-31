<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

if(!function_exists('ptnns_register_enhance_settings_action')) {
	
	function ptnns_register_enhance_settings_action() {

		if(!function_exists('ptnns_sanitize_enhance_entries')) {
		
			function ptnns_sanitize_enhance_entries($ptnns_posted_values) {
				
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

						//deal with block_editor
						case 'block_editor':
						
						//check value is not different from 0 and 1
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['block_editor'] = $ptnns_posted_value;
						
						break;
						
						//deal with admin_notices
						case 'admin_notices':
						
						//check value is not different from 0 and 1
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['admin_notices'] = $ptnns_posted_value;
						
						break;
						
						//deal with splash_page
						case 'splash_page':
												
						//check value is not different from 0 and 1
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['splash_page'] = $ptnns_posted_value;
						
						break;
						
						
						//deal with splash_type
						case 'splash_type':
						
						//check value is not different from expected values
						if($ptnns_posted_value === 'splash_type_image' || empty($ptnns_posted_value)){
							
							$ptnns_posted_value = 'splash_type_image';
							
						} 
						
						elseif($ptnns_posted_value === 'splash_type_page')  {
							
							$ptnns_posted_value = 'splash_type_page';
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['splash_type'] = $ptnns_posted_value;
												
						break;
						
						
						//deal with splash_image_id
						case 'splash_image_id':
						
						//check if posted value is not empty
						if(!empty($ptnns_posted_value)){
							
							if(!is_numeric($ptnns_posted_value)) {

								$ptnns_posted_value = null;
								$ptnns_erros_found++;								
								
							} else {
							
								//sanitize url
								$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
								$ptnns_splash_page_image_url = esc_url_raw(get_the_guid($ptnns_posted_value));
								
								//check if url entered is a valid media attachment
								if(!get_post_status($ptnns_posted_value)) {
								
									$ptnns_posted_value = null;

									//info message
									$ptnns_message_text = __('Splash page image does not contain a valid media gallery element. Please check it out','ptnnslang').'!';
									$ptnns_message_type = 'warning';
												
									add_settings_error(
										'ptnns-info',
										'ptnns-info',
										$ptnns_message_text,
										$ptnns_message_type				
									);
								
								} else {
									
									//get attachment filetype
									$ptnns_check_filetype = wp_check_filetype($ptnns_splash_page_image_url);
									$ptnns_current_filetype = explode('/',$ptnns_check_filetype['type']);
									
									//check if media attachment is an image
									if($ptnns_current_filetype[0] != 'image') {
										
										$ptnns_posted_value = null;

										//info message
										$ptnns_message_text = __('Splash page image does not contain a valid image. Please check it out','ptnnslang').'!';
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
						$ptnns_values_to_save['splash_image_id'] = $ptnns_posted_value;					
						
						break;	


						//deal with splash_page_id
						case 'splash_page_id':
						
						//check a page id is set
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value === '0')){
							
							$ptnns_posted_value = null;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['splash_page_id'] = $ptnns_posted_value;
												
						break;	
						
						//deal with splash_page
						case 'splash_login':
						
						//check value is not different from 0 and 1
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['splash_login'] = $ptnns_posted_value;
						
						break;

                        //deal with maintenance_mode
                        case 'maintenance_mode':

                        //check value is not different from 0 and 1
                        if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){

                            $ptnns_posted_value = 0;
                            $ptnns_erros_found++;

                        } else {

                            $ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
                        }

                        //add sanitized value to array to save
                        $ptnns_values_to_save['maintenance_mode'] = $ptnns_posted_value;

                        break;

                        //deal with retry_after
                        case 'retry_after':

                        //check value is numeric
                        if(!is_numeric($ptnns_posted_value)){

                            $ptnns_posted_value = 0;
                            $ptnns_erros_found++;

                        } else {

                            $ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
                        }

                        //add sanitized value to array to save
                        $ptnns_values_to_save['retry_after'] = $ptnns_posted_value;

                        break;

                        //deal with custom_404
						case 'custom_404':
						
						//check value is not different from 0 and 1
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['custom_404'] = $ptnns_posted_value;
						
						break;

						//deal with custom_404_id
						case 'custom_404_id':
						
						//check a page id is set
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value === '0')){
							
							$ptnns_posted_value = null;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
							
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['custom_404_id'] = $ptnns_posted_value;						
												
						break;	

                        //deal with image_treating
						case 'image_treating':
						
						//check value is not different from 0 and 1
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['image_treating'] = $ptnns_posted_value;
						
						break;	

						//deal with image_size
						case 'image_size':
												
						//check a valid value is set
						$ptnns_accepted_values = array('HD','UXGA','FHD','QHD','UHD');
						if(!in_array($ptnns_posted_value, $ptnns_accepted_values)){
							
							$ptnns_posted_value = null;
							$ptnns_erros_found++;
							
						} 
						
						//add sanitized value to array to save
						$ptnns_values_to_save['image_size'] = $ptnns_posted_value;
												
						break;
						
						//deal with skip_gif
						case 'skip_gif':
						
						//check value is not different from 0 and 1
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['skip_gif'] = $ptnns_posted_value;
						
						break;


						//deal with jpeg_quality
						case 'jpeg_quality':
												
						//check a valid value is set
						$ptnns_accepted_values = array('40','50','60','70','80','82','90','100','45','55','65','75','85','95');
						if(!is_numeric($ptnns_posted_value) || !in_array($ptnns_posted_value, $ptnns_accepted_values)){
							
							$ptnns_posted_value = null;
							$ptnns_erros_found++;
							
						} 
						
						//add sanitized value to array to save
						$ptnns_values_to_save['jpeg_quality'] = $ptnns_posted_value;
												
						break;		

						//deal with rebuild_thumbnails
						case 'rebuild_thumbnails':
							
						//save option only if value is 
						if(is_numeric($ptnns_posted_value) && ($ptnns_posted_value === '1') && !empty($ptnns_optenhanse_options_array['optenhanse_pro'])){
							
							//save temporary option
							update_option('_ptnns_rebuild_thumbnails', '1');
							
								//info message
								$ptnns_message_text = '<span class="ptnns-rebuild-in-progress-message" style="display:inline">'.__('Thumbnails rebuild in progress','ptnnslang').':</span>
								<span class="ptnns-rebuild-calculating-message">'.__('Please wait','ptnnslang').'</span>
								<span class="ptnns-rebuild-in-progress-step"></span>
								<span class="ptnns-rebuild-completed-message">'.__('Thumbnails rebuild completed','ptnnslang').'!</span>
								<span class="ptnns-rebuild-no-entry-message">'.__('Good News, no thumbnail needs to be rebuilt','ptnnslang').'!</span>';
								$ptnns_message_type = 'warning';
											
								add_settings_error(
									'ptnns-info',
									'ptnns-info',
									$ptnns_message_text,
									$ptnns_message_type				
								);
							
						} 
						
						break;	

						//deal with smtp_mail
						case 'smtp_mail':
							
						//check value is not different from 0 and 1
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['smtp_mail'] = $ptnns_posted_value;
						
						break;	

						//deal with smtp_encryption
						case 'smtp_encryption':
												
						//check a valid value is set
						$ptnns_accepted_values = array('none','SSL','TLS');
						if(!in_array($ptnns_posted_value, $ptnns_accepted_values)){
							
							$ptnns_posted_value = null;
							$ptnns_erros_found++;
							
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['smtp_encryption'] = $ptnns_posted_value;
												
						break;	

						//deal with smtp_port
						case 'smtp_port':
												
						//check a valid value is set
						$ptnns_accepted_values = array('25','465','587','2525','2526');
						if(!in_array($ptnns_posted_value, $ptnns_accepted_values)){
							
							$ptnns_posted_value = null;
							$ptnns_erros_found++;
							
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['smtp_port'] = $ptnns_posted_value;
												
						break;	

						//deal with smtp_server
						case 'smtp_server':
																	
						$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						
						//add sanitized value to array to save
						$ptnns_values_to_save['smtp_server'] = $ptnns_posted_value;
												
						break;	

						//deal with smtp_from_address
						case 'smtp_from_address':
							
						//check a valid value is set
						if(!empty($ptnns_posted_value) && !is_email($ptnns_posted_value)) {

							$ptnns_posted_value = null;
							$ptnns_erros_found++;						
							
						} else {
							
							$ptnns_posted_value = sanitize_email($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['smtp_from_address'] = $ptnns_posted_value;
						
						break;	

						//deal with smtp_from_name
						case 'smtp_from_name':
													
						//just sanitize e do not controll emptyness, because this field che be empty
						$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
							
						
						//add sanitized value to array to save
						$ptnns_values_to_save['smtp_from_name'] = $ptnns_posted_value;
						
						break;	


						//deal with smtp_authentication
						case 'smtp_authentication':
							
						//check value is not different from 0 and 1
						if(!is_numeric($ptnns_posted_value) || ($ptnns_posted_value !== '0' && $ptnns_posted_value !== '1')){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_text_field($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['smtp_authentication'] = $ptnns_posted_value;
						
						break;	

						//deal with smtp_address
						case 'smtp_authentication_address':
						
						//update address only if value is not empty
						if(!empty($ptnns_posted_value)) {
																			
							$ptnns_posted_value = sanitize_email($ptnns_posted_value);							
						
						} else {
							
							$ptnns_posted_value = null;
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['smtp_authentication_address'] = $ptnns_posted_value;
												
						break;	
						
						//deal with smtp_password
						case 'smtp_authentication_password':
						
						//get_current password
						global $ptnns_enhance_options_array;
						$ptnns_current_smtp_password = $ptnns_enhance_options_array['smtp_authentication_password'];						
						
						//update password only if value is not empty
						if(!empty($ptnns_posted_value)) {
																			
							$ptnns_posted_value = base64_encode($ptnns_posted_value);							
						
						} else {
							
							$ptnns_posted_value = $ptnns_current_smtp_password;	
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['smtp_authentication_password'] = $ptnns_posted_value;
												
						break;	

						//deal with smtp_test
						case 'smtp_test':
							
						//save option only if value is 
						if(is_numeric($ptnns_posted_value) && ($ptnns_posted_value === '1')){
							
							//save temporary option
							update_option('_ptnns_smtp_test', '1');
							
								//info message
								$ptnns_message_text = '<span class="ptnns-test-in-progress-message" style="display:inline">'.__('SMTP test in progress','ptnnslang').':</span>
								<span class="ptnns-test-completed-message">'.__('SMTP test completed successfully','ptnnslang').'!</span>
								<span class="ptnns-test-failed-message">'.__('SMTP test failed, check settings','ptnnslang').'!</span>';
								$ptnns_message_type = 'warning';
											
								add_settings_error(
									'ptnns-info',
									'ptnns-info',
									$ptnns_message_text,
									$ptnns_message_type				
								);
							
						} 
						
						break;

						//deal with smtp_test_address
						case 'smtp_test_address':
							
						//save option only if value is 
						if(!empty($ptnns_posted_value) && !is_email($ptnns_posted_value)){
							
							$ptnns_posted_value = 0;
							$ptnns_erros_found++;
							
						} else {
							
							$ptnns_posted_value = sanitize_email($ptnns_posted_value);
						}
						
						//add sanitized value to array to save
						$ptnns_values_to_save['smtp_test_address'] = $ptnns_posted_value;
						
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
		

		if(!empty($_POST['ptnns-save-enhance-options'])) {
			
			//can't find out if nonce is checkd on register_setting, so let's check it "manually"
			if(!empty($_POST['ptnns-options-nonce']) && wp_verify_nonce($_POST['ptnns-options-nonce'], 'ptnns-options-nonce')) {
				
				//create an empty option first, otherwise register_setting acts twice
				update_option('_ptnns_enhance', '', false);
				
				//register settings
				$ptnns_register_enhance_options_args = array(
					'type' => 'string', 
					'sanitize_callback' => 'ptnns_sanitize_enhance_entries',
					);
					
				register_setting('enhance-section', '_ptnns_enhance', $ptnns_register_enhance_options_args); 
				
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
	
	add_action('admin_init', 'ptnns_register_enhance_settings_action');

} else {
	
	error_log('function: "ptnns_register_enhance_settings_action" already exists');
	
}