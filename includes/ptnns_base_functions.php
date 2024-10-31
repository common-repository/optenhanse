<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//activation
if(!function_exists('ptnns_activate')){
	
	function ptnns_activate(){
				
		//we need to rewrite htaccess only in case of a previuos deactivation
		$ptnns_secure_options_array = get_option('_ptnns_secure');
		$ptnns_optimize_options_array = get_option('_ptnns_optimize');
		
		$ptnns_save_rules = false;
		
		//rewrite htaccess only if a disable_author was set to true 
		if(!empty($ptnns_optimize_options_array['browser_cache'])) {
			
			if(esc_attr($ptnns_optimize_options_array['browser_cache']) === '1') {
				
				require_once plugin_dir_path(__DIR__).'admin/includes/ptnns-optimize/ptnns_cache_rules.php';
				ptnns_cache_htaccess_filter();
				$ptnns_save_rules = true;
				
			}
			
		}
		
		//rewrite htaccess only if a disable_xmlrpc was set to true 
		if(!empty($ptnns_secure_options_array['disable_xmlrpc'])) {
			
			if(esc_attr($ptnns_secure_options_array['disable_xmlrpc']) === '1') {
				
				require_once plugin_dir_path(__DIR__).'admin/includes/ptnns-secure/ptnns_disable_xmlrpc.php';
				ptnns_xmlrpc_htaccess_filter();
				$ptnns_save_rules = true;
			}
			
		}

		//rewrite htaccess only if a disable_author was set to true 
		if(!empty($ptnns_secure_options_array['disable_author'])) {
			
			if(esc_attr($ptnns_secure_options_array['disable_author']) === '1') {
				
				require_once plugin_dir_path(__DIR__).'public/includes/ptnns-secure/ptnns_disable_author.php';
				ptnns_author_htaccess_filter();
				$ptnns_save_rules = true;
				
			}
			
		}

		if($ptnns_save_rules === true) {
			
			save_mod_rewrite_rules();
			
		}
			
	}

} else {
	
	error_log('function: "ptnns_activate" already exists');
	
}

//deactivation
if(!function_exists('ptnns_deactivate')){
	
	function ptnns_deactivate(){
		
		//rewrite xmlpc rules from htaccess
		remove_filter('mod_rewrite_rules', 'ptnns_xmlrpc_htaccess');
		//rewrite author rules from htaccess
		remove_filter('mod_rewrite_rules', 'ptnns_author_htaccess');
		//rewrite cache rules from htaccess
		remove_filter('mod_rewrite_rules', 'ptnns_cache_htaccess');
		//rewrite rules
		flush_rewrite_rules();

		//unregister scheduled event
		if(!empty(wp_next_scheduled('ptnnsp_renew_date_hook'))){
			
			wp_clear_scheduled_hook('ptnnsp_renew_date_hook');
			
		}
		
		if(!empty(wp_next_scheduled('ptnns_renew_date_hook'))){
			
			wp_clear_scheduled_hook('ptnns_renew_date_hook');
			
		}
				
	}

} else {
	
	error_log('function: "ptnns_deactivate" already exists');
	
}

//uninstallation
if(!function_exists('ptnns_uninstall')){
	
	function ptnns_uninstall(){
				
		//delete post meta
		delete_post_meta_by_key('_ptnns_meta_title');
		delete_post_meta_by_key('_ptnns_meta_title_blogname');
		delete_post_meta_by_key('_ptnns_meta_description');
		delete_post_meta_by_key('_ptnns_no_index');
		delete_post_meta_by_key('_ptnns_current_jpeg_quality');
		delete_post_meta_by_key('_ptnnsp_current_jpeg_quality');
		
		//delete all options
		delete_option('_ptnns_optenhanse');
		delete_option('_ptnns_optimize');
		delete_option('_ptnns_enhance');
		delete_option('_ptnns_secure');
		delete_option('_ptnns_tables_version');
		
		//delete tables
		global $wpdb;
		
		$ptnns_delete_monitor_table_name = $wpdb->prefix.'ptnns_failed_login_attempts';
		$ptnns_delete_monitor_table_sql = "DROP TABLE IF EXISTS $ptnns_delete_monitor_table_name";
		$wpdb->query($ptnns_delete_monitor_table_sql);	

		$ptnns_delete_ban_table_name = $wpdb->prefix.'ptnns_failed_login_history';
		$ptnns_delete_ban_table_sql = "DROP TABLE IF EXISTS $ptnns_delete_ban_table_name";
		$wpdb->query($ptnns_delete_ban_table_sql);			
		
		//rebuild htaccess file
		save_mod_rewrite_rules();
			
	}

} else {
	
	error_log('function: "ptnns_uninstall" already exists');
	
}