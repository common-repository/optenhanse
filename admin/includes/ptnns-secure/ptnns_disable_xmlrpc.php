<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

if(!function_exists('ptnns_xmlrpc_filter')) {
	
	function ptnns_xmlrpc_filter() {
	
		add_filter('xmlrpc_enabled', '__return_false');

	}

} else {
	
	error_log('function: "ptnns_xmlrpc_filter" already exists');
	
}

if(!function_exists('ptnns_xmlrpc_htaccess')) {
	
	function ptnns_xmlrpc_htaccess($ptnns_htaccess_rules) {
		
		$ptnns_htaccess_xmlrpc_rule = '
			# BEGIN Optenhanse XMLRPC
			<Files xmlrpc.php>
			order deny,allow
			deny from all
			</Files>
			# END Optenhanse XMLRPC'."\r\n";

		return $ptnns_htaccess_rules . $ptnns_htaccess_xmlrpc_rule;

	}
	
} else {
	
	error_log('function: "ptnns_xmlrpc_htaccess" already exists');
	
}

if(!function_exists('ptnns_xmlrpc_htaccess_filter')) {
	
	function ptnns_xmlrpc_htaccess_filter() {
		
		add_filter('mod_rewrite_rules', 'ptnns_xmlrpc_htaccess');

	}
	
} else {
	
	error_log('function: "ptnns_xmlrpc_htaccess_filter" already exists');
	
}