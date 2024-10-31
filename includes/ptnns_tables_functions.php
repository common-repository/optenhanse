<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

if(!function_exists('ptnns_install_monitor_table')){

	function ptnns_install_monitor_table() {
		
		//echo '<script>console.log("installation launched")</script>';
		
		global $wpdb;
		$ptnns_install_monitor_table_name = $wpdb->prefix.'ptnns_failed_login_attempts';
		$ptnns_install_monitor_table_charset = $wpdb->get_charset_collate();
	
		$ptnns_install_monitor_table_sql = "CREATE TABLE IF NOT EXISTS $ptnns_install_monitor_table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			time datetime,
			ip varchar(50),
			username varchar(150),
			PRIMARY KEY  (id)
		) $ptnns_install_monitor_table_charset;";

		//require_once(ABSPATH.'wp-admin/includes/upgrade.php');
		//dbDelta($ptnns_install_monitor_table_sql);	
		$wpdb->query($ptnns_install_monitor_table_sql);

		
	}

} else {
	
	error_log('function: "ptnns_install_monitor_table" already exists');
	
}

if(!function_exists('ptnns_install_login_history_table')){

	function ptnns_install_login_history_table() {
		
		//echo '<script>console.log("installation launched")</script>';
		
		global $wpdb;
		$ptnns_install_login_history_table_name = $wpdb->prefix.'ptnns_failed_login_history';
		$ptnns_install_login_history_table_charset = $wpdb->get_charset_collate();
	
		$ptnns_install_login_history_table_sql = "CREATE TABLE IF NOT EXISTS $ptnns_install_login_history_table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			time datetime,
			ip varchar(50),
			username varchar(150),
			PRIMARY KEY  (id)
		) $ptnns_install_login_history_table_charset;";

		//require_once(ABSPATH.'wp-admin/includes/upgrade.php');
		//dbDelta($ptnns_install_login_history_table_sql);	
		$wpdb->query($ptnns_install_login_history_table_sql);

		
	}

} else {
	
	error_log('function: "ptnns_install_login_history_table" already exists');
	
}

if(!function_exists('ptnns_update_monitor_table')){

	function ptnns_update_monitor_table($ptnns_login_monitor_table_installed_version, $ptnns_login_monitor_table_current_version) {
		
		//echo '<script>console.log("update launched")</script>';
						
		global $wpdb;
		$ptnns_update_monitor_table_name = $wpdb->prefix.'ptnns_failed_login_attempts';
		$ptnns_update_monitor_table_charset = $wpdb->get_charset_collate();
		
		//variation form 1.0 and 1.1
		if($ptnns_login_monitor_table_installed_version === '1.0' && $ptnns_login_monitor_table_current_version == '1.1') {
			
			//echo '<script>console.log("variation form 1.0 to 1.1 found")</script>';

			//if table exists
			/*if($wpdb->get_var("SHOW TABLES LIKE '$ptnns_update_monitor_table_name'")) {
			
				//modifiy and uncomment to update table
				$ptnns_update_monitor_table_sql = "ALTER TABLE $ptnns_update_monitor_table_name
					ADD column_name varchar(150)
				;";
				
			}*/
			
		}
		
		//variation form 1.1 and 1.2
		elseif($ptnns_login_monitor_table_installed_version === '1.1' && $ptnns_login_monitor_table_current_version == '1.2') {
			
			//echo '<script>console.log("variation form 1.1 to 1.2 found")</script>';

			//if table exists
			/*if($wpdb->get_var("SHOW TABLES LIKE '$ptnns_update_monitor_table_name'")) {
			
				//modifiy and uncomment to update table
				$ptnns_update_monitor_table_sql = "ALTER TABLE $ptnns_update_monitor_table_name
					ADD column_name varchar(150)
				;";
				
			}*/
			
		}
		
		//variation form 1.0 and 1.2
		elseif($ptnns_login_monitor_table_installed_version === '1.0' && $ptnns_login_monitor_table_current_version == '1.2') {
			
			//echo '<script>console.log("variation form 1.0 to 1.2 found")</script>';

			//if table exists
			/*if($wpdb->get_var("SHOW TABLES LIKE '$ptnns_update_monitor_table_name'")) {
			
				//modifiy and uncomment to update table
				$ptnns_update_monitor_table_sql = "ALTER TABLE $ptnns_update_monitor_table_name
					ADD column_name varchar(150)
				;";
				
			}*/
			
			
		}				
		
		if($ptnns_update_monitor_table_sql) {
			
			//require_once(ABSPATH.'wp-admin/includes/upgrade.php');
			//dbDelta($ptnns_update_monitor_table_sql);
			$wpdb->query($ptnns_update_monitor_table_sql);			
			
		}
		
	}
				
} else {
	
	error_log('function: "ptnns_update_monitor_table" already exists');
	
}


if(!function_exists('ptnns_tables_functions')){

	function ptnns_tables_functions() {
				
		//get tables version option
		$ptnns_tables_version = get_option('_ptnns_tables_version');
		
		//list tables and their current versions
		$ptnns_login_monitor_table_current_version = '1.0';
		$ptnns_login_history_table_current_version = '1.0';
		
		//one or more tables are installed
		if(!empty($ptnns_tables_version)) {
			
			//get login monitor table version
			if(!empty($ptnns_tables_version['_ptnns_login_monitor_table_version'])) {
				
				$ptnns_login_monitor_table_installed_version = $ptnns_tables_version['_ptnns_login_monitor_table_version'];
							
				//login monitor table previously installed, check if we need to update it
				if($ptnns_login_monitor_table_installed_version !== $ptnns_login_monitor_table_current_version) {
					
					//echo '<script>console.log("tables found, previous version of monitor table found: updating it")</script>';
					
					//installed version is different than current version, we need to update it
					ptnns_update_monitor_table($ptnns_login_monitor_table_installed_version, $ptnns_login_monitor_table_current_version);
										
					//update tables version options
					$ptnns_tables_version['_ptnns_login_monitor_table_version'] = $ptnns_login_monitor_table_current_version;
					update_option('_ptnns_tables_version', $ptnns_tables_version, false);
				
				} else {
					
					//echo '<script>console.log("tables found, current version of monitor table found: do nothing")</script>';
					
				}				
					
			} else {
				
				//echo '<script>console.log("tables found, monitor table not found: installing it")</script>';
				
				//login monitor table previously uninstalled,we need to install it
				ptnns_install_monitor_table();

				//update tables version options
				$ptnns_tables_version['_ptnns_login_monitor_table_version'] = $ptnns_login_monitor_table_current_version;
				update_option('_ptnns_tables_version', $ptnns_tables_version, false);		

			}
			
			//get login history table version
			if(!empty($ptnns_tables_version['_ptnns_login_history_table_version'])) {
				
				$ptnns_login_history_table_installed_version = $ptnns_tables_version['_ptnns_login_history_table_version'];
							
				//login history table previously installed, check if we need to update it
				if($ptnns_login_history_table_installed_version !== $ptnns_login_history_table_current_version) {
					
					//echo '<script>console.log("tables found, previous version of history table found: updating it")</script>';
					
					//installed version is different than current version, we need to update it
					ptnns_update_history_table($ptnns_login_history_table_installed_version, $ptnns_login_history_table_current_version);
										
					//update tables version options
					$ptnns_tables_version['_ptnns_login_history_table_version'] = $ptnns_login_history_table_current_version;
					update_option('_ptnns_tables_version', $ptnns_tables_version, false);
				
				} else {
					
					//echo '<script>console.log("tables found, current version of history table found: do nothing")</script>';
					
				}				
					
			} else {
				
				//echo '<script>console.log("tables found, history table not found: installing it")</script>';
				
				//login history table previously uninstalled,we need to install it
				ptnns_install_login_history_table();

				//update tables version options
				$ptnns_tables_version['_ptnns_login_history_table_version'] = $ptnns_login_history_table_current_version;
				update_option('_ptnns_tables_version', $ptnns_tables_version, false);		

			}
					

		//no tables are installed
		} else {
			
			//echo '<script>console.log("no tables found: installing all of them")</script>';
			
			//no table found at all, need to install them all
			ptnns_install_monitor_table();
			ptnns_install_login_history_table();
			
			//update current tables versions
			$ptnns_tables_version['_ptnns_login_monitor_table_version'] = $ptnns_login_monitor_table_current_version;
			$ptnns_tables_version['_ptnns_login_history_table_version'] = $ptnns_login_history_table_current_version;
			
			//add tables version options
			add_option('_ptnns_tables_version', $ptnns_tables_version, false);			
			
		}

		
	}

} else {
	
	error_log('function: "ptnns_tables_functions" already exists');
	
}