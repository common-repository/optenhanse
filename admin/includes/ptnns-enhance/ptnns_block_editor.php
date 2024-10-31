<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//disable block editor
if(!function_exists('ptnns_disable_block_editor')) {
	
	function ptnns_disable_block_editor($ptnns_wp_admin_bar) {
		
		//add filter by WordPress version
		if(version_compare($GLOBALS['wp_version'], '5.0-beta', '>')) {

			add_filter('use_block_editor_for_post_type', '__return_false');
			
		} else {

			add_filter('gutenberg_can_edit_post_type', '__return_false');
			
		}
		
	}
	
	add_action('admin_init', 'ptnns_disable_block_editor');
		
} else {
	
	error_log('function: "ptnns_disable_block_editor" already exists');
	
}