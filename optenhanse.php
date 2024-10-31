<?php
/*
Plugin Name:		Optenhanse: Optimize, Enhance and Secure
Plugin URI:			https://optenhanse.com
Description:		A unique plugin to Optimize, Enhance and Secure your WordPress website.
Version:			1.3.4
Author:				Christian Gatti
Author URI:			https://profiles.wordpress.org/christian-gatti/
License:			GPL-2.0+
License URI:		http://www.gnu.org/licenses/gpl-2.0.txt
Text Domain:		ptnnslang
Domain Path:		/languages
*/
 
//if this file is called directly, abort.
if(!defined('ABSPATH')) die();

//define a constant to call script and style enqueue
define('PTNNS_BASE_URL',plugins_url().'/'.plugin_basename(dirname(__FILE__)));


//ACTIVATE, DEACTIVATE AND UNINSTALL

//plugin activation function
if(!function_exists('ptnns_plugin_activation')){

	function ptnns_plugin_activation() {
		
		//include page where functions are defined
		require_once plugin_dir_path( __FILE__ ) . 'includes/ptnns_base_functions.php';
		ptnns_activate();
		
	}
	
	//activation actions
	register_activation_hook( __FILE__ , 'ptnns_plugin_activation');

} else {
	
	error_log('function: "ptnns_plugin_activation" already exists');
	
}

//plugin deactivation function
if(!function_exists('ptnns_plugin_deactivation')){

	function ptnns_plugin_deactivation() {
		
		//include page where functions are defined
		require_once plugin_dir_path( __FILE__ ).'includes/ptnns_base_functions.php';
		ptnns_deactivate();

	}
	
	//deactivation actions
	register_deactivation_hook( __FILE__ , 'ptnns_plugin_deactivation');
	
} else {
	
	error_log('function: "ptnns_plugin_deactivation" already exists');
	
}

//plugin uninstall function
if(!function_exists('ptnns_plugin_uninstallation')){

	function ptnns_plugin_uninstallation() {
		
		//include page where functions are defined
		require_once plugin_dir_path( __FILE__ ).'includes/ptnns_base_functions.php';
		ptnns_uninstall();

	}
	
	//uninstall actions
	register_uninstall_hook( __FILE__ , 'ptnns_plugin_uninstallation' );
	
}  else {
	
	error_log('function: "ptnns_plugin_uninstallation" already exists');
	
}


//LOAD LANGUAGES

//load languages functions
if(!function_exists('ptnns_load_languages')){

	function ptnns_load_languages() {

		load_plugin_textdomain(
			'ptnnslang',
			false,
			dirname(plugin_basename( __FILE__ )).'/languages/'
			);

	}
	
	//load languages
	add_action('plugins_loaded', 'ptnns_load_languages');

} else {
	
	error_log('function: "ptnns_load_languages" already exists');
	
}


//STYLES AND SCRIPTS

//public styles and scripts function
if(!function_exists('ptnns_register_public_styles_and_scripts')){
	
	function ptnns_register_public_styles_and_scripts() {
		
		//wp_enqueue_style('optenhanse-style', PTNNS_BASE_URL .'/public/css/style.css');
		//wp_enqueue_script('optenhanse-script', PTNNS_BASE_URL .'/public/js/script.js', array('jquery'), '', true );	
		
	}
	
	//load public styles and scripts
	add_action('wp_enqueue_scripts', 'ptnns_register_public_styles_and_scripts');
	
} else {
	
	error_log('function: "ptnns_register_public_styles_and_scripts" already exists');
	
}

//admin styles
if(!function_exists('ptnns_register_admin_styles')){
	
	function ptnns_register_admin_styles() {
		
		wp_enqueue_style('optenhanse-style', PTNNS_BASE_URL .'/admin/css/style.css');	
		
	}
	
	//load admin styles
	add_action('admin_enqueue_scripts', 'ptnns_register_admin_styles');
	
} else {
	
	error_log('function: "ptnns_register_admin_styles" already exists');
	
}

//admin scripts loaded conditionally
if(!function_exists('ptnns_get_current_screen')){

	function ptnns_get_current_screen() {
		
		//return if is_admin is false, since we need this file only into administrative interface page
		if(!is_admin()) return;
		
		//define script to load
		if(!function_exists('ptnns_register_admin_scripts')){
			
			function ptnns_register_admin_scripts() {
					
				wp_enqueue_script('optenhanse-script',PTNNS_BASE_URL .'/admin/js/script.js', array('jquery'), '', true );
				wp_localize_script('optenhanse-script', 'optenhanse_script', array(
					'ptnns_base_url' => PTNNS_BASE_URL,
				));
				
			}
			
		} else {
			
			error_log('function: "ptnns_register_admin_scripts" already exists');
			
		}
			
		$ptnns_get_current_screen = get_current_screen();
		
		if($ptnns_get_current_screen->id === "toplevel_page_ptnns-setup") {

			//load admin styles and scripts
			add_action('admin_enqueue_scripts', 'ptnns_register_admin_scripts');
			
		}
		
	}
	
	add_action('current_screen', 'ptnns_get_current_screen');

} else {
	
	error_log('function: "ptnns_get_current_screen" already exists');
	
}


//LOAD PLUGIN OPTIONS AND SET THEM GLOBAL

//get all plugin options and store them in global variables, so that get_options query is made only once
if(!function_exists('ptnns_load_settings')){

	function ptnns_load_settings() {
			
		//set global option variabiles
		global $ptnns_optenhanse_options_array;
		global $ptnns_optimize_options_array;
		global $ptnns_enhance_options_array;
		global $ptnns_secure_options_array;	
		
		//get all options and store them
		$ptnns_optenhanse_options_array = get_option('_ptnns_optenhanse');
		$ptnns_optimize_options_array = get_option('_ptnns_optimize');
		$ptnns_enhance_options_array = get_option('_ptnns_enhance');
		$ptnns_secure_options_array = get_option('_ptnns_secure');
	
	}

	//load settings and store them in some global valibles
	add_action('plugins_loaded', 'ptnns_load_settings');

} else {
	
	error_log('function: "ptnns_load_settings" already exists');
	
}


//LOAD DEPENDENCIES BY SETTINGS

//load dependencies
if(!function_exists('ptnns_load_ptnns_dependencies_by_settings')){
	
	function ptnns_load_ptnns_dependencies_by_settings() {

		//include page where functions are defined
		require_once plugin_dir_path(__FILE__).'includes/ptnns_dependencies_by_settings.php';
		ptnns_dependencies_by_settings();
		
		//include renew date functions independently by settings
		require_once plugin_dir_path(__FILE__).'admin/includes/ptnns-optenhanse/ptnns_renew_date.php';
		
	}
	
	//load dependencies
	add_action('plugins_loaded', 'ptnns_load_ptnns_dependencies_by_settings');	
	
} else {
	
	error_log('function: "ptnns_load_ptnns_dependencies_by_settings" already exists');
	
}


//LOAD ADMIN DEPENDENCIES BY SETTINGS

//load admin dependencies
if(!function_exists('ptnns_load_admin_dependencies_by_setings')){
	
	function ptnns_load_admin_dependencies_by_setings() {
		
		//return if is_admin is false, since we need this file only into back end
		if(!is_admin()) return;

		//include page where functions are defined
		require_once plugin_dir_path(__FILE__).'includes/ptnns_admin_dependencies_by_settings.php';
		ptnns_admin_dependencies_by_settings();
		
	}
	
	//load admin dependencies
	add_action('admin_init', 'ptnns_load_admin_dependencies_by_setings');
	
} else {
	
	error_log('function: "ptnns_load_admin_dependencies_by_setings" already exists');
	
}


//LOAD PUBLIC DEPENDENCIES BY SETTINGS

//load public dependencies
if(!function_exists('ptnns_load_public_dependencies_by_settings')){
	
	function ptnns_load_public_dependencies_by_settings() {
			
		//return if is_admin is true, since we need this file only into front end
		if(is_admin()) return;
		
		//include page where dependencies are defined
		require_once plugin_dir_path(__FILE__).'includes/ptnns_public_dependencies_by_settings.php';
		ptnns_public_dependencies_by_settings();
		
	}
	
	//load public dependencies
	add_action('template_redirect', 'ptnns_load_public_dependencies_by_settings');
	
} else {
	
	error_log('function: "ptnns_load_public_dependencies_by_settings" already exists');
	
}

//LOAD PUBLIC CUSTOM ERRORS FILTER

//load plublic custom errors filter
if(!function_exists('ptnns_load_custom_errors_filter')){
	
	function ptnns_load_custom_errors_filter() {

		//return if is_admin is true, since we need this file only into front end
		if(is_admin()) return;
		
		//include page where functions are defined
		require_once plugin_dir_path(__FILE__).'public/includes/ptnns-secure/ptnns_custom_login_errors.php';
		
	}
	
	//load plublic custom errors filter
	add_action('init', 'ptnns_load_custom_errors_filter');
	
} else {
	
	error_log('function: "ptnns_load_custom_errors_filter" already exists');
	
}


//LOAD ADMIN AJAX

//load admin ajax
if(!function_exists('ptnns_load_admin_ajax')){
	
	function ptnns_load_admin_ajax() {
		
		//return if is_admin is false, since we need this file only into back end
		if(!is_admin()) return;
		
		//smtp test ajax
		//require_once plugin_dir_path(__FILE__).'admin/includes/ptnns-enhance/ptnns_smtp_test.php';
		
		//login ajax
		require_once plugin_dir_path(__FILE__).'admin/includes/ptnns-enhance/ptnns_login.php';
		
		//check token ajax
		require_once plugin_dir_path(__FILE__).'admin/includes/ptnns-optenhanse/ptnns_check_token.php';
		
		//uncheck token ajax
		require_once plugin_dir_path(__FILE__).'admin/includes/ptnns-optenhanse/ptnns_uncheck_token.php';

		//bulk thumbnails rebuild ajax
		//require_once plugin_dir_path(__FILE__).'admin/includes/ptnns-enhance/ptnns_rebuild_thumbnails.php';
		
		//bulk meta rebuild ajax
		//require_once plugin_dir_path(__FILE__).'admin/includes/ptnns-optimize/ptnns_bulk_rebuild_meta.php';
		
	}
	
	//load admin dependencies
	add_action('admin_init', 'ptnns_load_admin_ajax');
	
} else {
	
	error_log('function: "ptnns_load_admin_ajax" already exists');
	
}


//LOAD OPTIONS PAGES

//load options pages
if(!function_exists('ptnns_load_options')){
	
	function ptnns_load_options() {

		//return if is_admin is false, since we need this file only into administrative interface page
		if(!is_admin()) return;
		
		//include page where functions are defined
		require_once plugin_dir_path(__FILE__).'admin/ptnns_options.php';
		
	}
	
	//load options pages
	add_action('plugins_loaded', 'ptnns_load_options');
	
} else {
	
	error_log('function: "ptnns_load_options" already exists');
	
}


//TABLES FUNCTION PAGES

//load options pages
if(!function_exists('ptnns_load_tables_functions')){
	
	function ptnns_load_tables_functions() {

		//check installed tables and update them, if it is necessary
		require_once plugin_dir_path( __FILE__ ) . 'includes/ptnns_tables_functions.php';
		ptnns_tables_functions();
		
	}
	
	//load options pages
	add_action('init', 'ptnns_load_tables_functions');
	
} else {
	
	error_log('function: "ptnns_load_tables_functions" already exists');
	
}


//COMUMNS FUNCTIONS

//load options pages
if(!function_exists('ptnns_load_columns_functions')){
	
	function ptnns_load_columns_functions() {

		//check installed tables and update them, if it is necessary
		//require_once plugin_dir_path( __FILE__ ) . 'includes/ptnns_columns_functions.php';
		
	}
	
	//load options pages
	add_action('admin_init', 'ptnns_load_columns_functions');
	
} else {
	
	error_log('function: "ptnns_load_columns_functions" already exists');
	
}


//ADD SETTINGS LINK

//add settings link in plugin list page
if(!function_exists('ptnns_add_setting_link')){
	
	function ptnns_add_setting_link ($ptnns_setting_links) {
		
		global $ptnns_optenhanse_options_array;
		
		if(!empty($ptnns_optenhanse_options_array['optenhanse_pro'])) {
		
			$ptnns_links_to_add = array(
				'<a href="'.admin_url('admin.php?page=ptnns-setup').'" target="_blank" title="Optenhanse Settings" alt="Optenhanse Settings">'.__('Settings','ptnnslang').'</a>'
			,);
			
		} else {
			
			$ptnns_links_to_add = array(
				'<a href="'.admin_url('admin.php?page=ptnns-setup') . '">'.__('Settings','ptnnslang').'</a>',
				'<a href="https://www.optenhanse.com" target="_blank" title="Optenhanse PRO" alt="Optenhanse PRO"><span style="font-weight:bold;">'.__('PRO','ptnnslang').'</span></a>'
			,);		
			
		}
		
		return array_merge($ptnns_setting_links, $ptnns_links_to_add);
		
	}
		
	add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'ptnns_add_setting_link');

} else {
	
	error_log('function: "ptnns_add_setting_link" already exists');
	
}


//OLD PRO PLUGIN ALERT

//display an alert if user still has Optenhanse PRO installed
if(!function_exists('ptnnp_old_pro_plugin_alert')){
	
	function ptnnp_old_pro_plugin_alert(){
			
		if(defined('PTNNSP_BASE_URL')){
			
			?>
				<div class="notice notice-error">
					<p><?php echo __('Starting from Optenhanse 2.0, Optenhanse Pro plugin is no more needed','ptnnslang'); ?>. <?php echo __('Please deactivate it and delete it','ptnnslang'); ?>!</p>
				</div>
			<?php

		} 
		
	}
	
	add_action('admin_notices', 'ptnnp_old_pro_plugin_alert');	
	
} else {
	
	error_log('function: "ptnnp_old_pro_plugin_alert" already exists');
	
}

//FUNCTIONS DISMESSED ALERT

//if one fo the NutsForPress plugin is not active, throw an error
if(!function_exists('ptnns_functions_missing_notice')){
	
	function ptnns_functions_missing_notice(){
		
		if(!defined('NFPMGM_BASE_PATH') || !defined('NFPSMT_BASE_PATH') || !defined('NFPNDX_BASE_PATH')){
			
			?>
				<div class="notice notice-error">
					<p><?php echo __('Some essential Optenhanse functions are no more available, since they are migrated to a set of brand-new plugins named NutsForPress. Please download and install them all from the <a href="/wp-admin/plugin-install.php?s=nutsforpress&tab=search&type=term" title="NutsForPress" alt"NutsForPress">WordPress repository</a>','ptnnslang'); ?>.</p>
				</div>
			<?php

		}
		
	}
	
	add_action('admin_notices', 'ptnns_functions_missing_notice');	
	
} else {
	
	error_log('function: "ptnns_functions_missing_notice" already exists');
	
}