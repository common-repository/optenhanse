<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

if(!function_exists('ptnns_author_htaccess_rest')) {

	function ptnns_author_htaccess_rest($ptnns_rest_endpoints){
		
		if (!empty($ptnns_rest_endpoints['/wp/v2/users']) && !is_user_logged_in()) {
			
			unset($ptnns_rest_endpoints['/wp/v2/users']);
			
		}
		
		if (!empty($ptnns_rest_endpoints['/wp/v2/users/(?P<id>[\d]+)']) && !is_user_logged_in()){
			
			unset($ptnns_rest_endpoints['/wp/v2/users/(?P<id>[\d]+)']);
			
		}
		
		return $ptnns_rest_endpoints;
	}

	add_filter('rest_endpoints', 'ptnns_author_htaccess_rest');
	
}

else {
	
	error_log('function: "ptnns_author_htaccess_rest" already exists');
	
}