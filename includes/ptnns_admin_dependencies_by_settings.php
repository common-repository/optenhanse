<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die;
		
if(!function_exists('ptnns_admin_dependencies_by_settings')){
	
	function ptnns_admin_dependencies_by_settings() {
		
		//get temporary options
		$ptnns_secure_options_updated = get_option('ptnns_secure_options_updated');
		$ptnns_optimize_options_updated = get_option('ptnns_optimize_options_updated');
		
		if((!empty($ptnns_secure_options_updated) && $ptnns_secure_options_updated === '1') || (!empty($ptnns_optimize_options_updated) && $ptnns_optimize_options_updated === '1')) {
	
			//delete temporay options
			delete_option('ptnns_secure_options_updated');
			delete_option('ptnns_optimize_options_updated');
			
			//rewrite rules
			save_mod_rewrite_rules();
			
		} 	
		
		//get temporary option
		$ptnns_smtp_test = get_option('_ptnns_smtp_test');
		
		if(!empty($ptnns_smtp_test) && $ptnns_smtp_test === '1') {
			
			//delete temporay option
			delete_option('_ptnns_smtp_test');

			if(!function_exists('ptnns_register_smtp_test_ajax_script')){
					
				//ajax script
				function ptnns_register_smtp_test_ajax_script() {
								
					wp_enqueue_script('ptnns-smtp-test-ajax-script', PTNNS_BASE_URL.'/admin/js/smtp_test.js', array('jquery'), '', true );
					wp_localize_script('ptnns-smtp-test-ajax-script', 'ptnns_smtp_test_ajax_object', array( 
						'ptnns_smtp_test_ajax_url' => admin_url('admin-ajax.php'),
						'ptnns_smtp_test_nonce' => wp_create_nonce('ptnns-smtp-test-nonce')
					));
					
				}
				
				//ajax script
				//add_action('admin_enqueue_scripts', 'ptnns_register_smtp_test_ajax_script');
				
			} else {
	
				error_log('function: "ptnns_register_smtp_test_ajax_script" already exists');
				
			}
				
		}
		

		//get temporary option
		$ptnns_rebuild_thumbnails = get_option('_ptnns_rebuild_thumbnails');

		//get global option variabiles
		global $ptnns_enhance_options_array;
		
		if(!empty($ptnns_enhance_options_array['image_treating']) && esc_attr($ptnns_enhance_options_array['image_treating']) === '1' && !empty($ptnns_rebuild_thumbnails) && $ptnns_rebuild_thumbnails === '1') {
			
			//delete temporay option
			delete_option('_ptnns_rebuild_thumbnails');
			
			if(!function_exists('ptnns_register_rebuild_thumbnails_ajax_script')){
						
				//ajax script
				function ptnns_register_rebuild_thumbnails_ajax_script() {
					
					//get enhance options
					$ptnns_current_jpeg_quality = $ptnns_enhance_options_array['jpeg_quality'];

					if(is_numeric($ptnns_current_jpeg_quality)){
							
						wp_enqueue_script('ptnns-rebuild-thumbnails-ajax-script', PTNNS_BASE_URL.'/admin/js/rebuild_thumbnails.js', array('jquery'), '', true );
						wp_localize_script('ptnns-rebuild-thumbnails-ajax-script', 'ptnns_rebuild_thumbnails_ajax_object', array( 
							'ptnns_rebuild_thumbnails_ajax_url' => admin_url('admin-ajax.php'),
							'ptnns_current_jpeg_quality' => $ptnns_current_jpeg_quality,
							'ptnns_rebuild_thumbnails_nonce' => wp_create_nonce('ptnns-rebuild-thumbnails-nonce')
						));
						
					}
					
				}
			
				//ajax script
				//add_action('admin_enqueue_scripts', 'ptnns_register_rebuild_thumbnails_ajax_script');
				
			} else {
	
				error_log('function: "ptnns_register_rebuild_thumbnails_ajax_script" already exists');
				
			}
		
		}
		
		//get temporary option
		$ptnns_rebuild_meta = get_option('_ptnns_rebuild_meta');
		
		if(!empty($ptnns_rebuild_meta) && $ptnns_rebuild_meta === '1') {
			
			//delete temporay option
			delete_option('_ptnns_rebuild_meta');

			if(!function_exists('ptnns_register_rebuild_meta_ajax_script')){
					
				//ajax script
				function ptnns_register_rebuild_meta_ajax_script() {
								
					wp_enqueue_script('ptnns-rebuild-meta-ajax-script', PTNNS_BASE_URL.'/admin/js/rebuild_meta.js', array('jquery'), '', true );
					wp_localize_script('ptnns-rebuild-meta-ajax-script', 'ptnns_rebuild_meta_ajax_object', array( 
						'ptnns_rebuild_meta_ajax_url' => admin_url('admin-ajax.php'),
						'ptnns_rebuild_meta_nonce' => wp_create_nonce('ptnns-rebuild-meta-nonce')
					));
					
				}
				
				//ajax script
				//add_action('admin_enqueue_scripts', 'ptnns_register_rebuild_meta_ajax_script');
				
			} else {
	
				error_log('function: "ptnns_register_rebuild_meta_ajax_script" already exists');
				
			}
				
		}
		
		if(!function_exists('ptnns_check_token_ajax_script')){
					
			//ajax script
			function ptnns_check_token_ajax_script() {
						
				wp_enqueue_script('ptnns-check-token-ajax-script', PTNNS_BASE_URL.'/admin/js/check_token.js', array('jquery'), '', true );
				wp_localize_script('ptnns-check-token-ajax-script', 'ptnns_check_token_ajax_object', array( 
					'ptnns_check_token_ajax_url' => admin_url('admin-ajax.php'),
					'ptnns_check_token_nonce' => wp_create_nonce('ptnns-check-token-nonce'),
					'ptnns_check_token_action' => 'activate'
				));
				
			}
		
			//ajax script
			add_action('admin_enqueue_scripts', 'ptnns_check_token_ajax_script');
			
		} else {

			error_log('function: "ptnns_check_token_ajax_script" already exists');
			
		}
		
		if(!function_exists('ptnns_uncheck_token_ajax_script')){
					
			//ajax script
			function ptnns_uncheck_token_ajax_script() {
						
				wp_enqueue_script('ptnns-uncheck-token-ajax-script', PTNNS_BASE_URL.'/admin/js/uncheck_token.js', array('jquery'), '', true );
				wp_localize_script('ptnns-uncheck-token-ajax-script', 'ptnns_uncheck_token_ajax_object', array( 
					'ptnns_uncheck_token_ajax_url' => admin_url('admin-ajax.php'),
					'ptnns_uncheck_token_nonce' => wp_create_nonce('ptnns-uncheck-token-nonce'),
					'ptnns_uncheck_token_action' => 'deactivate'
				));
				
			}
		
			//ajax script
			add_action('admin_enqueue_scripts', 'ptnns_uncheck_token_ajax_script');
			
		} else {

			error_log('function: "ptnns_uncheck_token_ajax_script" already exists');
			
		}		
		
				
	}
	
} else {
	
		error_log('function: "ptnns_admin_dependencies_by_settings" already exists');
}