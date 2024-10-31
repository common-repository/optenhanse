<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

if(!empty($ptnns_optenhanse_options_array)) {
	
	$ptnns_image_to_show = PTNNS_BASE_URL .'/admin/images/logo_optenhanse_pro.png';
	
} else {
	
	$ptnns_image_to_show = PTNNS_BASE_URL .'/admin/images/logo_optenhanse.png';
	
}

?>

<div class="ptnns-optenhanse-logo">
<img src="<?php echo $ptnns_image_to_show; ?>" title="Optenhanse logo" alt="Optenhanse logo"></img>


	<?php
	
	if(empty($ptnns_optenhanse_options_array['optenhanse_pro'])) {
		
		?>
		
		<div>
		<a href="https://optenhanse.com/optenhanse-plugin-for-wordpress/optenhanse-pro-single-website/" title="<?php echo __('Get Optenhanse PRO','ptnnslang'); ?>" alt="<?php echo __('Get Optenhanse PRO','ptnnslang'); ?>" class="button button-primary ptnns-homepage-pro-button" target="_blank"><span class="ptnns-homepage-pro-button-text"><?php echo __('Get Optenhanse PRO','ptnnslang'); ?></span></a>
		</div>
		
		<?php		
		
		
	}
	
	?>

</div>


<?php

add_settings_section(
'optenhanse-license-section',
'<span class="dashicons dashicons-lock"></span>'.__('Optenhanse PRO','ptnnslang'),
'ptnns_license_comment',
'optenhanse-section'
);


if(!function_exists('ptnns_license_comment')) {

	function ptnns_license_comment(){
		
		global $ptnns_optenhanse_options_array;
		
		if(!empty($ptnns_optenhanse_options_array['optenhanse_pro'])) {
			
			echo __('PRO features are activated', 'ptnnslang').'!';
			
		} else {
			
			echo __('In order to activate PRO features, fill in the license token provided when you bought Optenhanse PRO and press "Activate" button', 'ptnnslang');
		
		}
		
	}

} else {
	
	error_log('function: "ptnns_license_comment" already exists');
	
}

add_settings_field(
'ptnns-license-token',
__('Optenhanse PRO license token','ptnnslang'),
'ptnns_license_token',
'optenhanse-section',
'optenhanse-license-section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-license-token')
//array('class' => 'ptnns-license-token')
);

if(!function_exists('ptnns_license_token')) {

	function ptnns_license_token($ptnns_arguments){
		
		$ptnns_license_token_saved = null;
		
		if(!empty($ptnns_arguments['ptnns_saved_options']['optenhanse_pro'])) {
		
			$ptnns_license_token = base64_decode($ptnns_arguments['ptnns_saved_options']['optenhanse_pro']);
			
			if(!empty($ptnns_license_token)) {
				
				$ptnns_license_token_saved = sanitize_text_field($ptnns_license_token);
				
			}
		
		}	

		if(!empty($ptnns_arguments['ptnns_saved_options']['optenhanse_pro'])) {
			
			$ptnns_license_token_filed_type = 'hidden';

		} else {
			
			$ptnns_license_token_filed_type = 'text';
		}
		
		?>

		<input type="<?php echo $ptnns_license_token_filed_type; ?>" size="75" name="_ptnns_optenhanse[license_token]" id="ptnns-license-token" value="<?php echo $ptnns_license_token_saved; ?>" placeholder="<?php echo __('Enter your token','ptnnslang'); ?>" />
		
		<?php			
	
		if(is_null($ptnns_license_token_saved)) {
			
			?>
			<input type="button" id="ptnns-activate-button" class="button button-primary" value="<?php echo __('Activate','ptnnslang'); ?>" />	
			<p><small><?php echo __('Enter Optenhanse PRO token and press "Activate" button','ptnnslang'); ?></small></p>
			<span class="ptnns-activation-in-progress-message" style="margin-top:15px"><strong><?php echo '<span class="dashicons dashicons-editor-help" style="color:#0073AA;"></span>'.__('Activation in progress, please wait','ptnnslang'); ?>...</strong></span>
			<span class="ptnns-activation-completed-message" style="margin-top:15px"><strong><?php echo '<span class="dashicons dashicons-yes-alt" style="color:#0073AA;"></span>'.__('Activation completed successfully','ptnnslang'); ?>!</strong></span>
			<span class="ptnns-activation-failed-message" style="margin-top:15px"><strong><?php echo '<span class="dashicons dashicons-warning" style="color:#0073AA;"></span>'.__('Activation failed, check token','ptnnslang'); ?>!</strong></span>
			<?php
			
		} else {
			?>
			
			<input type="button" id="ptnns-deactivate-button" class="button" value="<?php echo __('Deactivate','ptnnslang'); ?>" />
			<p><small><?php echo __('In order to use your Optenhanse PRO license in another website, press "Deactivate" button','ptnnslang'); ?></small></p>
			<span class="ptnns-deactivation-in-progress-message" style="margin-top:15px"><strong><?php echo '<span class="dashicons dashicons-editor-help" style="color:#0073AA;"></span>'.__('Deactivation in progress, please wait','ptnnslang'); ?>...</strong></span>
			<span class="ptnns-deactivation-completed-message" style="margin-top:15px"><strong><?php echo '<span class="dashicons dashicons-yes-alt" style="color:#0073AA;"></span>'.__('Deactivation completed successfully','ptnnslang'); ?>!</strong></span>
			<span class="ptnns-deactivation-failed-message" style="margin-top:15px"><strong><?php echo '<span class="dashicons dashicons-warning" style="color:#0073AA;"></span>'.__('Deactivation failed, check token','ptnnslang'); ?>!</strong></span>
			
			<?php
		}
		?>			

		<?php
	
	}

}  else {
	
	error_log('function: "ptnns_license_token" already exists');
	
}

settings_fields("optenhanse-section");
do_settings_sections("optenhanse-section");