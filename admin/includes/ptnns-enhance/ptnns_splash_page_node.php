<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

if(!function_exists('ptnns_splash_page_notice')) {
	
	function ptnns_splash_page_notice($ptnns_wp_admin_bar) {
		
		if (current_user_can('manage_options')) {
			
			$ptnns_splash_page_args = array(
				'id'    => 'ptnns-offline-notice',
				'title' => '"SplashPage" '.__('activated','ptnnslangh'),
				'href'  => site_url().'/wp-admin/admin.php?page=ptnns-setup&tab=enhance',
				'meta'  => array('class' => 'ptnns-offline-notice')
			);
			
			$ptnns_wp_admin_bar->add_node($ptnns_splash_page_args);
		}
		
	}
	
	add_action('admin_bar_menu', 'ptnns_splash_page_notice', 999);
		
} else {
	
	error_log('function: "ptnns_splash_page_notice" already exists');
	
}