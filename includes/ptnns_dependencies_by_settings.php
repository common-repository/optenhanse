<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//LOAD DEPENDENCIES BY SETTINGS
if(!function_exists('ptnns_dependencies_by_settings')){

	function ptnns_dependencies_by_settings() {
	
		//get global option variabiles
		global $ptnns_optenhanse_options_array;
		global $ptnns_optimize_options_array;
		global $ptnns_enhance_options_array;
		global $ptnns_secure_options_array;	
		
		$ptnns_is_admin = false;
		if(is_admin() === true) {
			
			$ptnns_is_admin = true;
			
		}

		//load dependencies by optimize options
		if(!empty($ptnns_optimize_options_array['title_tag'])) {
			
			if(esc_attr($ptnns_optimize_options_array['title_tag']) === '1') {
						
				if($ptnns_is_admin){
					
					//include backend functions
					//require_once plugin_dir_path(__DIR__).'admin/includes/ptnns-optimize/ptnns_title_tag.php';
				
				} else {
					
					//include frontend functions
					//require_once plugin_dir_path(__DIR__).'public/includes/ptnns-optimize/ptnns_title_tag.php';
					
				}
				
			}
			
		}

		if(!empty($ptnns_optimize_options_array['description_tag'])) {
			
			if(esc_attr($ptnns_optimize_options_array['description_tag']) === '1') {
						
				if($ptnns_is_admin){
					
					//include backend functions
					//require_once plugin_dir_path(__DIR__).'admin/includes/ptnns-optimize/ptnns_description_tag.php';
				
				} else {
					
					//include frontend functions
					//require_once plugin_dir_path(__DIR__).'public/includes/ptnns-optimize/ptnns_description_tag.php';
					
				}
				
			}
			
		}
		
		if(!empty($ptnns_optimize_options_array['no_index'])) {
			
			if(esc_attr($ptnns_optimize_options_array['no_index']) === '1') {
						
				if($ptnns_is_admin){
					
					//include backend functions
					//require_once plugin_dir_path(__DIR__).'admin/includes/ptnns-optimize/ptnns_no_index.php';
				
				} else {
					
					//include frontend functions
					//require_once plugin_dir_path(__DIR__).'public/includes/ptnns-optimize/ptnns_no_index.php';
					
				}
				
			}
			
		}
		
		if((!empty($ptnns_optimize_options_array['facebook_share']) && esc_attr($ptnns_optimize_options_array['facebook_share']) === '1') || (!empty($ptnns_optimize_options_array['twitter_share']) && esc_attr($ptnns_optimize_options_array['twitter_share']) === '1')) {
						
			if(!$ptnns_is_admin){
				
				//include frontend functions
				//require_once plugin_dir_path(__DIR__).'public/includes/ptnns-optimize/ptnns_social_share.php';
				
			}
				
		}
			
		if(!empty($ptnns_optimize_options_array['sitemap'])) {
			
			if(esc_attr($ptnns_optimize_options_array['sitemap']) === '1') {
				
				if(!$ptnns_is_admin){
					
					//remove WP sitemap
					//add_filter('wp_sitemaps_enabled', '__return_false');
						
					//include frontend functions
					//require_once plugin_dir_path(__DIR__).'public/includes/ptnns-optimize/ptnns_sitemap.php';
					
				}

			}
			
		}
		
		if(!empty($ptnns_optimize_options_array['attachment_meta'])) {
			
			if(esc_attr($ptnns_optimize_options_array['attachment_meta']) === '1') {
				
				if($ptnns_is_admin){
				
					//include backend functions
					//require_once plugin_dir_path(__DIR__).'admin/includes/ptnns-optimize/ptnns_attachment_meta.php';
				
				}

			}
			
		}
		
		if(!empty($ptnns_optimize_options_array['browser_cache'])) {
			
			if(esc_attr($ptnns_optimize_options_array['browser_cache']) === '1') {
						
				//include backend functions
				require_once plugin_dir_path(__DIR__).'admin/includes/ptnns-optimize/ptnns_cache_rules.php';
				ptnns_cache_htaccess_filter();
					

			}
			
		}
		
		//load dependencies by enhance options
		if(!empty($ptnns_enhance_options_array['block_editor'])) {
			
			if(esc_attr($ptnns_enhance_options_array['block_editor']) === '1') {
				
				if($ptnns_is_admin){
				
					//include backend functions
					require_once plugin_dir_path(__DIR__).'admin/includes/ptnns-enhance/ptnns_block_editor.php';
				
				}
			}
			
		}	

		if(!empty($ptnns_enhance_options_array['admin_notices'])) {
			
			if(esc_attr($ptnns_enhance_options_array['admin_notices']) === '1') {
				
				if($ptnns_is_admin){
				
					//include backend functions
					require_once plugin_dir_path(__DIR__).'admin/includes/ptnns-enhance/ptnns_hide_notices.php';
				
				}
			}
			
		}			
		
		if(!empty($ptnns_enhance_options_array['splash_page'])) {	
			
			if(esc_attr($ptnns_enhance_options_array['splash_page']) === '1') {
				
				if($ptnns_is_admin){
					
					//include backend functions
					require_once plugin_dir_path(__DIR__).'admin/includes/ptnns-enhance/ptnns_splash_page_node.php';
				
				} else {
					
					//include if is not login page
					global $pagenow;
					if($pagenow !== 'wp-login.php') {
						
						//include frontend functions
						require_once plugin_dir_path(__DIR__).'public/includes/ptnns-enhance/ptnns_splash_page.php';
						
					//if is login page, check if include or not
					} else {
						
						//include only if splash_login is active
						if(!empty($ptnns_enhance_options_array['splash_login']) && esc_attr($ptnns_enhance_options_array['splash_login']) === '1') {
							
							//include frontend functions
							require_once plugin_dir_path(__DIR__).'public/includes/ptnns-enhance/ptnns_splash_page.php';
							
						}
						
					}
					
				}				
				
			}
			
		}
		
		if(!empty($ptnns_enhance_options_array['custom_404'])) {
			
			if(esc_attr($ptnns_enhance_options_array['custom_404']) === '1') {
				
				if(!$ptnns_is_admin){
				
					//include frontend functions
					require_once plugin_dir_path(__DIR__).'public/includes/ptnns-enhance/ptnns_custom_404.php';
				
				}
				
			}
			
		}

		
		if(!empty($ptnns_enhance_options_array['image_treating']) && esc_attr($ptnns_enhance_options_array['image_treating']) === '1' && !empty($ptnns_enhance_options_array['image_size'])) {		
			
			if($ptnns_is_admin){
			
				//include backend functions, with no condition (they will be managed by the included function)
				//require_once plugin_dir_path(__DIR__).'admin/includes/ptnns-enhance/ptnns_image_size.php';
				
			}
			
		}
		
		if(!empty($ptnns_enhance_options_array['image_treating']) && esc_attr($ptnns_enhance_options_array['image_treating']) === '1' && !empty($ptnns_enhance_options_array['jpeg_quality'])) {
			
			if($ptnns_is_admin){
						
				//include backend functions, with no condition (they will be managed by the included function)
				//require_once plugin_dir_path(__DIR__).'admin/includes/ptnns-enhance/ptnns_jpeg_quality.php';
				
			}
			
		}
		
		if(!empty($ptnns_enhance_options_array['smtp_mail'])) {
			
			if(esc_attr($ptnns_enhance_options_array['smtp_mail']) === '1') {
				
				//include functions for frontend and backend
				//require_once plugin_dir_path(__DIR__).'admin/includes/ptnns-enhance/ptnns_smtp_mail.php';
			
			}
			
		}
			
		//load dependencies by secure options
		if(!empty($ptnns_secure_options_array['check_login'])) {
			
			if(esc_attr($ptnns_secure_options_array['check_login']) === '1') {
						
				//include functions for frontend and backend
				//require_once plugin_dir_path(__DIR__).'public/includes/ptnns-secure/ptnns_check_login.php';
				
			}
			
		}		
		
		if(!empty($ptnns_secure_options_array['disable_xmlrpc'])) {
			
			if(esc_attr($ptnns_secure_options_array['disable_xmlrpc']) === '1') {
						
				//include functions for frontend and backend
				//require_once plugin_dir_path(__DIR__).'admin/includes/ptnns-secure/ptnns_disable_xmlrpc.php';
				//ptnns_xmlrpc_filter();
				//ptnns_xmlrpc_htaccess_filter();
				
			}
			
		}
			
		if(!empty($ptnns_secure_options_array['disable_author'])) {
			
			if(esc_attr($ptnns_secure_options_array['disable_author']) === '1') {
						
				//include frontend functions
				//require_once plugin_dir_path(__DIR__).'public/includes/ptnns-secure/ptnns_disable_author.php';
				//ptnns_author_htaccess_filter();
					

			}
			
		}
		
		if(!empty($ptnns_secure_options_array['disable_users_rest'])) {
			
			if(esc_attr($ptnns_secure_options_array['disable_users_rest']) === '1') {
						
				//include functions for frontend and backend
				//require_once plugin_dir_path(__DIR__).'public/includes/ptnns-secure/ptnns_disable_users_rest.php';
				
			}
			
		}	
		
		if(!empty($ptnns_secure_options_array['success_login_notification'])) {
			
			if(esc_attr($ptnns_secure_options_array['success_login_notification']) === '1') {
				
				if($ptnns_is_admin){
				
					//include backend functions
					//require_once plugin_dir_path(__DIR__).'admin/includes/ptnns-secure/ptnns_success_login_notification.php';
				
				}
				
			}
			
		}
		
		if(!empty($ptnns_secure_options_array['change_role_notification'])) {
			
			if(esc_attr($ptnns_secure_options_array['change_role_notification']) === '1') {
				
				if($ptnns_is_admin){
				
					//include backend functions
					//require_once plugin_dir_path(__DIR__).'admin/includes/ptnns-secure/ptnns_change_role_notification.php';
				
				}
				
			}
			
		}
		
		if(!empty($ptnns_secure_options_array['delete_user_notification'])) {
			
			if(esc_attr($ptnns_secure_options_array['delete_user_notification']) === '1') {
				
				if($ptnns_is_admin){
				
					//include backend functions
					//require_once plugin_dir_path(__DIR__).'admin/includes/ptnns-secure/ptnns_delete_user_notification.php';
				
				}
				
			}
			
		}
		
		if(!empty($ptnns_secure_options_array['register_user_notification'])) {
			
			if(esc_attr($ptnns_secure_options_array['register_user_notification']) === '1') {
				
				if($ptnns_is_admin){
				
					//include backend functions
					//require_once plugin_dir_path(__DIR__).'admin/includes/ptnns-secure/ptnns_register_user_notification.php';
				
				}
				
			}
			
		}
	
	}
	
} else {
	
	error_log('function: "ptnns_dependencies_by_settings" already exists');
	
}