<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

if(!function_exists('ptnns_hide_notices')) {
	
	function ptnns_hide_notices() {
		
		  if(is_admin()){
			  
			  remove_all_actions('admin_notices');
			  remove_all_actions('all_admin_notices');
			   
		  }
		
	}
	
	add_action('in_admin_header', 'ptnns_hide_notices', 999);
		
} else {
	
	error_log('function: "ptnns_hide_notices" already exists');
	
}