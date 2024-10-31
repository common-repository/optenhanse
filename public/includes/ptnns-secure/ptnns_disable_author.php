<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

if(!function_exists('ptnns_author_function')) {
	
	function ptnns_author_function() {
	
		//if is author page, redirect to home url
		if(is_author()){
			
			wp_safe_redirect(home_url());
			exit;

		}

	}
	
	add_action('template_redirect', 'ptnns_author_function');

} else {
	
	error_log('function: "ptnns_author_function" already exists');
	
}


if(!function_exists('ptnns_author_htaccess')) {
	
	function ptnns_author_htaccess($ptnns_htaccess_rules) {
		
		$ptnns_htaccess_author_rule = '
			# BEGIN Optenhanse AUTHOR ARCHIVE
			<IfModule mod_rewrite.c>
			RewriteEngine On
			RewriteBase /
			RewriteCond %{REQUEST_URI} ^/$
			RewriteCond %{QUERY_STRING} ^/?author=([0-9]*) [NC]
			RewriteRule ^(.*)$ http://%{HTTP_HOST}/? [L,R=301,NC]
			</IfModule>
			# END Optenhanse AUTHOR ARCHIVE'."\r\n";

		return $ptnns_htaccess_rules . $ptnns_htaccess_author_rule;

	}
	
} else {
	
	error_log('function: "ptnns_author_htaccess" already exists');
	
}


if(!function_exists('ptnns_author_htaccess_filter')) {
	
	function ptnns_author_htaccess_filter() {
		
		add_filter('mod_rewrite_rules', 'ptnns_author_htaccess');

	}

} else {
	
	error_log('function: "ptnns_author_htaccess_filter" already exists');
	
}
