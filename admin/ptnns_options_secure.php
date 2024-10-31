<?php 
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

if(!empty($ptnns_optenhanse_options_array['optenhanse_pro'])) {
	
	$ptnns_pro_feature_class = '';
	
} else {
	
	$ptnns_pro_feature_class = ' ptnns-pro-feature';
	
}


add_settings_section(
'check-login-section',
'<span class="dashicons dashicons-admin-network"></span>'.__('Login Attempts Monitor','ptnnslang'),
'ptnns_check_login_comment',
'secure-section'
);


if(!function_exists('ptnns_check_login_comment')) {

	function ptnns_check_login_comment(){
		echo __('Check login attempts and block failed login attempts exceeding the limits defined in this section', 'ptnnslang');
	}

} else {
	
	error_log('function: "ptnns_check_login_comment" already exists');
	
}


add_settings_field(
'ptnns-check-login',
__('Enable login attempts monitor','ptnnslang'),
'ptnns_check_login',
'secure-section',
'check-login-section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-check-login')
);

if(!function_exists('ptnns_check_login')) {

	function ptnns_check_login($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-login-watchdog/" target="_blank">NutsForPress Login Watchdog</a></p>
		<?php
		
	}

} else {
	
	error_log('function: "ptnns_check_login" already exists');
	
}

add_settings_field(
'ptnns-login-attempts',  
__('Failed login attempts conceded','ptnnslang'),
'ptnns_login_attempts',
'secure-section',
'check-login-section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-login-attempts'.$ptnns_pro_feature_class)
);

if(!function_exists('ptnns_login_attempts')) {

	function ptnns_login_attempts($ptnns_arguments){
					
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-login-watchdog/" target="_blank">NutsForPress Login Watchdog</a></p>
		<?php

	}

} else {
	
	error_log('function: "ptnns_login_attempts" already exists');
	
}

add_settings_field(
'ptnns-login-investigation',  
__('Failed login investigation period','ptnnslang'),
'ptnns_login_investigation',
'secure-section',
'check-login-section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-login-investigation')
);

if(!function_exists('ptnns_login_investigation')) {

	function ptnns_login_investigation($ptnns_arguments){
					
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-login-watchdog/" target="_blank">NutsForPress Login Watchdog</a></p>
		<?php

	}

} else {
	
	error_log('function: "ptnns_login_investigation" already exists');
	
}


add_settings_field(
'ptnns-login-warn',
__('Warn user about login attempts left','ptnnslang'),
'ptnns_login_warn',
'secure-section',
'check-login-section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-login-warn')
);

if(!function_exists('ptnns_login_warn')) {

	function ptnns_login_warn($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-login-watchdog/" target="_blank">NutsForPress Login Watchdog</a></p>
		<?php
		
	}

} else {
	
	error_log('function: "ptnns_login_warn" already exists');
	
}

add_settings_field(
'ptnns-login-lock',  
__('User lock down duration','ptnnslang'),
'ptnns_login_lock',
'secure-section',
'check-login-section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-login-lock'.$ptnns_pro_feature_class)
);

if(!function_exists('ptnns_login_lock')) {

	function ptnns_login_lock($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-login-watchdog/" target="_blank">NutsForPress Login Watchdog</a></p>
		<?php		

	}

} else {
	
	error_log('function: "ptnns_login_lock" already exists');
	
}

add_settings_field(
'ptnns-lock-down-message',
__('Lock down message','ptnnslang'),
'ptnns_lock_down_message',
'secure-section',
'check-login-section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-lock-down-message')
);

if(!function_exists('ptnns_lock_down_message')) {

	function ptnns_lock_down_message($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-login-watchdog/" target="_blank">NutsForPress Login Watchdog</a></p>
		<?php
		
	}

} else {
	
	error_log('function: "ptnns_lock_down_message" already exists');
	
}


add_settings_field(
'ptnns-login-ban',  
__('Permanently ban after','ptnnslang'),
'ptnns_login_ban',
'secure-section',
'check-login-section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-login-ban')
);

if(!function_exists('ptnns_login_ban')) {

	function ptnns_login_ban($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-login-watchdog/" target="_blank">NutsForPress Login Watchdog</a></p>
		<?php		

	}

} else {
	
	error_log('function: "ptnns_login_ban" already exists');
	
}


add_settings_field(
'ptnns-ban-message',
__('Permanently ban message','ptnnslang'),
'ptnns_ban_message',
'secure-section',
'check-login-section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-ban-message')
);

if(!function_exists('ptnns_ban_message')) {

	function ptnns_ban_message($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-login-watchdog/" target="_blank">NutsForPress Login Watchdog</a></p>
		<?php

	}

} else {
	
	error_log('function: "ptnns_ban_message" already exists');
	
}


add_settings_section(
'secure-xmlrpc-section',
'<span class="dashicons dashicons-admin-network"></span>'.__('XML-RPC','ptnnslang'),
'ptnns_xmlrpc_comment',
'secure-section'
);


if(!function_exists('ptnns_xmlrpc_comment')) {

	function ptnns_xmlrpc_comment(){
		echo __('WordPress provides a default feature, based on XML-RPC protocol, that can be used for brute force attacks on your site: if you do not need it, it is better to disable it', 'ptnnslang');
	}

} else {
	
	error_log('function: "ptnns_xmlrpc_comment" already exists');
	
}

add_settings_field(
'ptnns-disable-xmlrpc',
__('Disable XML-RPC','ptnnslang'),
'ptnns_disable_xmlrpc',
'secure-section',
'secure-xmlrpc-section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-disable-xmlrpc')
);

if(!function_exists('ptnns_disable_xmlrpc')) {

	function ptnns_disable_xmlrpc($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-login-watchdog/" target="_blank">NutsForPress Login Watchdog</a></p>
		<?php
		
	}

} else {
	
	error_log('function: "ptnns_disable_xmlrpc" already exists');
	
}


add_settings_section(
'secure-author-section',
'<span class="dashicons dashicons-admin-network"></span>'.__('Author and Users REST API','ptnnslang'),
'ptnns_author_page_comment',
'secure-section'
);


//section author
if(!function_exists('ptnns_author_page_comment')) {

	function ptnns_author_page_comment(){
		printf(__('WordPress author page and WordPress %s publicly expose usernames of all registered user, including site owner or administrator which is normally', 'ptnnslang'), '<a href="'.site_url().'/wp-json/wp/v2/users" target="_blank" title="REST API" alt="REST API">users REST API</a>');
		echo ' <a href="'.site_url().'/?author=1" target="_blank" title="'.site_url().'/?author=1" alt="'.site_url().'/?author=1">'.__('the first to be registered','ptnnslang').'</a>. ';
		echo __('If you do not hide these informations, hackers will have got half of the information needed to get administrative access to your website, since they only have to guess a password','ptnnslang').'.';
	}

} else {
	
	error_log('function: "ptnns_author_page_comment" already exists');
	
}

add_settings_field(
'ptnns-disable-author',
__('Disable archive author page','ptnnslang'),
'ptnns_disable_author',
'secure-section',
'secure-author-section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-disable-author')
);

if(!function_exists('ptnns_disable_author')) {

	function ptnns_disable_author($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-login-watchdog/" target="_blank">NutsForPress Login Watchdog</a></p>
		<?php
		
	}

} else {
	
	error_log('function: "ptnns_disable_author" already exists');
	
}

add_settings_field(
'ptnns-disable-users-rest',
__('Hide users in REST API','ptnnslang'),
'ptnns_disable_users_rest',
'secure-section',
'secure-author-section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-disable-users-rest')
);

if(!function_exists('ptnns_disable_users_rest')) {

	function ptnns_disable_users_rest($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-login-watchdog/" target="_blank">NutsForPress Login Watchdog</a></p>
		<?php
		
	}

} else {
	
	error_log('function: "ptnns_disable_users_rest" already exists');
	
}


add_settings_section(
'secure_login_errors_section',
'<span class="dashicons dashicons-admin-network"></span>'.__('Custom Login Errors','ptnnslang'),
'secure_login_errors_section_comment',
'secure-section'
);

if(!function_exists('secure_login_errors_section_comment')) {
	
	function secure_login_errors_section_comment(){
		echo '<span class="ptnns-section-comment">'.__('Hiding WordPress default login error messages and displaying yours it is an important security care', 'ptnnslang').'</span>';
	}
	
} else {
	
	error_log('function: "secure_login_errors_section_comment" already exists');
	
}

add_settings_field(
'ptnns-invalid-username-login-errors',
__('Invalid username message','ptnnslang'),
'ptnns_invalid_username_login_errors',
'secure-section',
'secure_login_errors_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-invalid-username-login-errors')
);

if(!function_exists('ptnns_invalid_username_login_errors')) {

	function ptnns_invalid_username_login_errors($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-login-watchdog/" target="_blank">NutsForPress Login Watchdog</a></p>
		<?php
		
	}

} else {
	
	error_log('function: "ptnns_invalid_username_login_errors" already exists');
	
}

add_settings_field(
'ptnns-invalid-email-login-errors',
__('Invalid email message','ptnnslang'),
'ptnns_invalid_email_login_errors',
'secure-section',
'secure_login_errors_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-invalid-email-login-errors')
);

if(!function_exists('ptnns_invalid_email_login_errors')) {

	function ptnns_invalid_email_login_errors($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-login-watchdog/" target="_blank">NutsForPress Login Watchdog</a></p>
		<?php
		
	}

} else {
	
	error_log('function: "ptnns_invalid_email_login_errors" already exists');
	
}

add_settings_field(
'ptnns-incorrect-password-login-errors',
__('Incorrect password message','ptnnslang'),
'ptnns_incorrect_password_login_errors',
'secure-section',
'secure_login_errors_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-incorrect-password-login-errors')
);

if(!function_exists('ptnns_incorrect_password_login_errors')) {

	function ptnns_incorrect_password_login_errors($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-login-watchdog/" target="_blank">NutsForPress Login Watchdog</a></p>
		<?php
		
	}

} else {
	
	error_log('function: "ptnns_incorrect_password_login_errors" already exists');
	
}

add_settings_field(
'ptnns-empty-username-login-errors',
__('Empty username message','ptnnslang'),
'ptnns_empty_username_login_errors',
'secure-section',
'secure_login_errors_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-empty-username-login-errors')
);

if(!function_exists('ptnns_empty_username_login_errors')) {

	function ptnns_empty_username_login_errors($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-login-watchdog/" target="_blank">NutsForPress Login Watchdog</a></p>
		<?php
		
	}

} else {
	
	error_log('function: "ptnns_empty_username_login_errors" already exists');
	
}

add_settings_field(
'ptnns-empty-password-login-errors',
__('Empty password message','ptnnslang'),
'ptnns_empty_password_login_errors',
'secure-section',
'secure_login_errors_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-empty-password-login-errors')
);

if(!function_exists('ptnns_empty_password_login_errors')) {

	function ptnns_empty_password_login_errors($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-login-watchdog/" target="_blank">NutsForPress Login Watchdog</a></p>
		<?php
		
	}

} else {
	
	error_log('function: "ptnns_empty_password_login_errors" already exists');
	
}


add_settings_section(
'secure_notification_section',
'<span class="dashicons dashicons-admin-network"></span>'.__('Notification','ptnnslang'),
'secure_notification_section_comment',
'secure-section'
);

if(!function_exists('secure_notification_section_comment')) {
	
	function secure_notification_section_comment(){
		echo '<span class="ptnns-section-comment">'.__('Get an email notification when the below events will occur', 'ptnnslang').'</span>';
	}
	
} else {
	
	error_log('function: "secure_notification_section_comment" already exists');
	
}


add_settings_field(
'ptnns-success-login-notification',
__('Notify success login','ptnnslang'),
'ptnns_success_login_notification',
'secure-section',
'secure_notification_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-success-login-notification')
);

if(!function_exists('ptnns_success_login_notification')) {

	function ptnns_success_login_notification($ptnns_arguments){
			
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-login-watchdog/" target="_blank">NutsForPress Login Watchdog</a></p>
		<?php
		
	}

} else {
	
	error_log('function: "ptnns_success_login_notification" already exists');
	
}


add_settings_field(
'ptnns-change-role-notification',
__('Notify change role','ptnnslang'),
'ptnns_change_role_notification',
'secure-section',
'secure_notification_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-change-role-notification')
);

if(!function_exists('ptnns_change_role_notification')) {

	function ptnns_change_role_notification($ptnns_arguments){
				
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-login-watchdog/" target="_blank">NutsForPress Login Watchdog</a></p>
		<?php
		
	}

} else {
	
	error_log('function: "ptnns_change_role_notification" already exists');
	
}

add_settings_field(
'ptnns-delete-user-notification',
__('Notify delete user','ptnnslang'),
'ptnns_delete_user_notification',
'secure-section',
'secure_notification_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-delete-user-notification')
);

if(!function_exists('ptnns_delete_user_notification')) {

	function ptnns_delete_user_notification($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-login-watchdog/" target="_blank">NutsForPress Login Watchdog</a></p>
		<?php
		
	}

} else {
	
	error_log('function: "ptnns_delete_user_notification" already exists');
	
}


add_settings_field(
'ptnns-register-user-notification',
__('Notify register user','ptnnslang'),
'ptnns_register_user_notification',
'secure-section',
'secure_notification_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-register-user-notification')
);

if(!function_exists('ptnns_register_user_notification')) {

	function ptnns_register_user_notification($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-login-watchdog/" target="_blank">NutsForPress Login Watchdog</a></p>
		<?php
		
	}

} else {
	
	error_log('function: "ptnns_register_user_notification" already exists');
	
}

add_settings_field(
'ptnns-lock-user-notification',
__('Notify locked down user','ptnnslang'),
'ptnns_lock_user_notification',
'secure-section',
'secure_notification_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-lock-user-notification'.$ptnns_pro_feature_class)
);

if(!function_exists('ptnns_lock_user_notification')) {

	function ptnns_lock_user_notification($ptnns_arguments){
			
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-login-watchdog/" target="_blank">NutsForPress Login Watchdog</a></p>
		<?php
		
	}

} else {
	
	error_log('function: "ptnns_lock_user_notification" already exists');
	
}


add_settings_field(
'ptnns-ban-user-notification',
__('Notify baned user','ptnnslang'),
'ptnns_ban_user_notification',
'secure-section',
'secure_notification_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-ban-user-notification'.$ptnns_pro_feature_class)
);

if(!function_exists('ptnns_ban_user_notification')) {

	function ptnns_ban_user_notification($ptnns_arguments){
			
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-login-watchdog/" target="_blank">NutsForPress Login Watchdog</a></p>
		<?php

	}

} else {
	
	error_log('function: "ptnns_ban_user_notification" already exists');
	
}


add_settings_field(
'ptnns-nofification-address',  
__('Notification address','ptnnslang'),
'ptnns_notification_address',
'secure-section',
'secure_notification_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-nofification-address')
);

if(!function_exists('ptnns_notification_address')) {

	function ptnns_notification_address($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-login-watchdog/" target="_blank">NutsForPress Login Watchdog</a></p>
		<?php
		
	}

} else {
	
	error_log('function: "ptnns_notification_address" already exists');
	
}


settings_fields("secure-section");
do_settings_sections("secure-section");

submit_button('Save Settings', 'primary', 'ptnns-save-secure-options');