<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//define option page parameters
if(!function_exists('ptnns_option_page_parameters')){
	
	function ptnns_option_page_parameters() {
		
		global $ptnns_optenhanse_options_array;
		
		if(!empty($ptnns_optenhanse_options_array['optenhanse_pro'])) {
			
			$ptnns_menu_title = 'Optenhanse PRO';
			
		} else {
			
			$ptnns_menu_title = 'Optenhanse';
			
		}
		
		add_menu_page(
			$ptnns_menu_title,			//page title
			$ptnns_menu_title,			//menu title
			'manage_options',			//capability
			'ptnns-setup',				//menu slug
			'ptnns_setup',				//function
			'dashicons-chart-bar'	 	//icon 
		);
		
	}
	
	//option page
	add_action('admin_menu', 'ptnns_option_page_parameters');
	
} else {
	
	error_log('function: "ptnns_option_page_parameters" already exists');
	
}


//setup page content
if(!function_exists('ptnns_setup')){
	
	function ptnns_setup() {
		
		global $ptnns_optenhanse_options_array;
		
		if(!empty($ptnns_optenhanse_options_array['optenhanse_pro'])) {
			
			$ptnns_menu_title = 'Optenhanse PRO';
			
		} else {
			
			$ptnns_menu_title = 'Optenhanse';
			
		}
		
		//get plugin options
		global $ptnns_optenhanse_options_array;
		global $ptnns_optimize_options_array;
		global $ptnns_enhance_options_array;
		global $ptnns_secure_options_array;			
		
		//check capabilty
		if(!current_user_can('activate_plugins')) return;
		?>
		
		<div class="wrap">
			<h1 style="margin-bottom:15px; margin-top:5px;"><?php echo $ptnns_menu_title.' '.__("Setup","ptnnslang"); ?></h1>		
			<?php
			
			//get current tab
			if(!empty($_GET['tab'])) {
				
				$ptnns_get_selected_tab = sanitize_key($_GET['tab']);
				$ptnns_selected_tab_admitted_values = array('optimize', 'enhance', 'secure', 'optenanche');
				
				if(in_array($ptnns_get_selected_tab, $ptnns_selected_tab_admitted_values)) {
					
					$ptnns_selected_tab = $ptnns_get_selected_tab;
					
				} else {
					
					$ptnns_selected_tab = null;
					
				}
				
			} else {
				
				$ptnns_selected_tab = null;
				
			}
			
			
			//define varibles for each tab
			switch($ptnns_selected_tab) {

				case 'optimize':
				
					$ptnns_current_tab = 'optimize';
					$ptnns_settings_page = 'ptnns_options_optimize.php';
					$ptnns_saved_options = $ptnns_optimize_options_array;
					break;
					
				case 'enhance':
				
					$ptnns_current_tab = 'enhance';
					$ptnns_settings_page = 'ptnns_options_enhance.php';
					$ptnns_saved_options = $ptnns_enhance_options_array;
					break;
					
				case 'secure':
				
					$ptnns_current_tab = 'secure';
					$ptnns_settings_page = 'ptnns_options_secure.php';
					$ptnns_saved_options = $ptnns_secure_options_array;
					break;
					
				default:
				
					$ptnns_current_tab = 'optenhanse';
					$ptnns_settings_page = 'ptnns_options_optenhanse.php';
					$ptnns_saved_options = $ptnns_optenhanse_options_array;
							
			}
			
			
			//initialize custom setting errors
			settings_errors('ptnns-message', true, false);
			settings_errors('ptnns-info', true, false);
			
			?>
			<h2 class="nav-tab-wrapper">
			<a href="?page=ptnns-setup" class="nav-tab <?php if($ptnns_current_tab === 'optenhanse'){echo 'nav-tab-active';} ?>">Optenhanse</a>
			<a href="?page=ptnns-setup&tab=optimize" class="nav-tab <?php if($ptnns_current_tab === 'optimize'){echo 'nav-tab-active';} ?>"><?php echo __('Optimize','ptnnslang'); ?></a>
			<a href="?page=ptnns-setup&tab=enhance" class="nav-tab <?php if($ptnns_current_tab === 'enhance'){echo 'nav-tab-active';} ?>"><?php echo __('Enhance','ptnnslang'); ?></a>
			<a href="?page=ptnns-setup&tab=secure" class="nav-tab <?php if($ptnns_current_tab === 'secure'){echo 'nav-tab-active';} ?>"><?php echo __('Secure','ptnnslang'); ?></a>
			</h2>
			
			<form id="ptnns-settings-form" method="post" action="options.php" autocomplete="off">
			<?php
			
			//load form content from the involved page
			require_once plugin_dir_path(__FILE__).$ptnns_settings_page;
			
			//can't find out if nonce is checked on register_setting, so let's check it "manually"
			$ptnns_options_nonce = wp_create_nonce('ptnns-options-nonce');
			echo '<input type="hidden" name="ptnns-options-nonce" value='.$ptnns_options_nonce.'>';
			
			?>
			</form>
			
			<?php
			//pro feature popup, only if PRO plugin is not installed
			if(empty($ptnns_optenhanse_options_array['optenhanse_pro'])) {
				?>

				<div class="ptnns-pro-feature-container"></div>
				<div class="ptnns-pro-feature-popup">
				
					<img src="<?php echo PTNNS_BASE_URL .'/admin/images/logo_optenhanse_pro.png'; ?>" title="Optenhanse PRO logo" alt="Optenhanse PRO logo"></img>
					<h2>Get this feature and all the Optenhanse <span style="color:#016087">PRO</span> features now!</h2>
					<button id="ptnns-hide-pro-popup" class="button button">No Thanks</button>&nbsp;&nbsp;<a href="https://optenhanse.com/optenhanse-plugin-for-wordpress/optenhanse-pro-single-website/" target="_blank" id="ptnns-link-to-website" class="button button-primary">More Info</a>
				
				</div>
			
			<?php
			}
			?>
				
		</div>
		<?php
				
	}
	
} else {
	
	error_log('function: "ptnns_setup" already exists');
	
}

//include page with sanitize and save functions
if(!function_exists('ptnns_register_settings')){

	function ptnns_register_settings() {

		if(!empty($_POST['ptnns-save-optenhanse-options'])) {
			require_once plugin_dir_path(__FILE__).'ptnns_save_optenhanse_options.php';
		} 
		
		elseif(!empty($_POST['ptnns-save-optimize-options'])) {
			require_once plugin_dir_path(__FILE__).'ptnns_save_optimize_options.php';
		} 
		
		elseif(!empty($_POST['ptnns-save-enhance-options'])) {
			require_once plugin_dir_path(__FILE__).'ptnns_save_enhance_options.php';
		} 
		
		elseif(!empty($_POST['ptnns-save-secure-options'])) {
			require_once plugin_dir_path(__FILE__).'ptnns_save_secure_options.php';
		} 
		
	}
	
	add_action('admin_menu', 'ptnns_register_settings');
	
} else {
	
	error_log('function: "ptnns_register_settings" already exists');
	
}