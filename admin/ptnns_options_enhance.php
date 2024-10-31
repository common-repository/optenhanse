<?php 
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

if(!empty($ptnns_optenhanse_options_array['optenhanse_pro'])) {
	
	$ptnns_pro_feature_class = '';
	
} else {
	
	$ptnns_pro_feature_class = ' ptnns-pro-feature';
	
}

add_settings_section(
'enhance_block_editor_section',
'<span class="dashicons dashicons-admin-plugins"></span>'.__('Block Editor','ptnnslang'),
'enhance_block_editor_section_comment',
'enhance-section'
);

if(!function_exists('enhance_block_editor_section_comment')) {
	
	function enhance_block_editor_section_comment(){
		echo '<span class="ptnns-section-comment">'.__('Deactivate block editor and switch back to classic editor', 'ptnnslang').'</span>';
	}
	
} else {
	
	error_log('function: "enhance_block_editor_section_comment" already exists');
	
}

add_settings_field(
'ptnns-block-editor',
__('Deactivate block editor','ptnnslang'),
'ptnns_deactivate_block_editor',
'enhance-section',
'enhance_block_editor_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-block-editor')
);

if(!function_exists('ptnns_deactivate_block_editor')) {

	function ptnns_deactivate_block_editor($ptnns_arguments){
		
		if(!empty($ptnns_arguments['ptnns_saved_options']['block_editor'])) {
			
			$ptnns_saved_option = $ptnns_arguments['ptnns_saved_options']['block_editor'];
			
		} else {
			
			$ptnns_saved_option = null;
			
		}
		
		if($ptnns_saved_option === '1') {
			
			$ptnns_block_editor_checked = 'checked';
			
		} else {
			
			$ptnns_block_editor_checked = null;
			
		}
		
		?>
		<input type="checkbox" name="_ptnns_enhance[block_editor]" class="ptnns-switch" id="ptnns-block-editor" value="1" <?php echo $ptnns_block_editor_checked; ?> />
		<label for="ptnns-block-editor">&nbsp;</label>
		<p><small><?php echo __('If switched on, classic editor will be displayed instead of block editor or Gutenberg','ptnnslang'); ?></small></p>
		<?php
		
	}

} else {
	
	error_log('function: "ptnns_deactivate_block_editor" already exists');
	
}


add_settings_section(
'enhance_admin_notices_section',
'<span class="dashicons dashicons-admin-plugins"></span>'.__('Dashboard Notices','ptnnslang'),
'enhance_admin_notices_section_comment',
'enhance-section'
);

if(!function_exists('enhance_admin_notices_section_comment')) {
	
	function enhance_admin_notices_section_comment(){
		echo '<span class="ptnns-section-comment">'.__('Prevent notices to be displayed into your admin dashboard', 'ptnnslang').'</span>';
	}
	
} else {
	
	error_log('function: "enhance_admin_notices_section_comment" already exists');
	
}

add_settings_field(
'ptnns-admin-notices',
__('Hide dashboard notices','ptnnslang'),
'ptnns_deactivate_admin_notices',
'enhance-section',
'enhance_admin_notices_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-admin-notices')
);

if(!function_exists('ptnns_deactivate_admin_notices')) {

	function ptnns_deactivate_admin_notices($ptnns_arguments){
		
		if(!empty($ptnns_arguments['ptnns_saved_options']['admin_notices'])) {
			
			$ptnns_saved_option = $ptnns_arguments['ptnns_saved_options']['admin_notices'];
			
		} else {
			
			$ptnns_saved_option = null;
			
		}
		
		if($ptnns_saved_option === '1') {
			
			$ptnns_admin_notices_checked = 'checked';
			
		} else {
			
			$ptnns_admin_notices_checked = null;
			
		}
		
		?>
		<input type="checkbox" name="_ptnns_enhance[admin_notices]" class="ptnns-switch" id="ptnns-admin-notices" value="1" <?php echo $ptnns_admin_notices_checked; ?> />
		<label for="ptnns-admin-notices">&nbsp;</label>
		<p><small><?php echo __('If switched on, no notice will be shown anymore (even important notices will be hidden)','ptnnslang'); ?></small></p>
		<?php
		
	}

} else {
	
	error_log('function: "ptnns_deactivate_admin_notices" already exists');
	
}


add_settings_section(
'enhance_splash_section',
'<span class="dashicons dashicons-admin-plugins"></span>'.__('Splash Page','ptnnslang'),
'ptnns_splash_section_comment',
'enhance-section'
);

if(!function_exists('ptnns_splash_section_comment')) {
	
	function ptnns_splash_section_comment(){
		echo '<span class="ptnns-section-comment">'.__('Hide your website to not logged users, display a full screen image or the content of a page (with no header and footer) and let users to authenticate through an overlaid ajax login form', 'ptnnslang').'</span>';
	}
	
} else {
	
	error_log('function: "ptnns_splash_section_comment" already exists');
	
}

add_settings_field(
'ptnns-splash-page',
__('Enable Splash Page','ptnnslang'),
'ptnns_splash_page',
'enhance-section',
'enhance_splash_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-splash-page')
);

if(!function_exists('ptnns_splash_page')) {

	function ptnns_splash_page($ptnns_arguments){
		
		if(!empty($ptnns_arguments['ptnns_saved_options']['splash_page'])) {
			
			$ptnns_saved_option = $ptnns_arguments['ptnns_saved_options']['splash_page'];
			
		} else {
			
			$ptnns_saved_option = null;
			
		}
		
		if($ptnns_saved_option === '1') {
			$ptnns_splash_page_checked = 'checked';
		} else {
			$ptnns_splash_page_checked = null;
		}
		?>
		<input type="checkbox" name="_ptnns_enhance[splash_page]" class="ptnns-switch" id="ptnns-splash-page" value="1" <?php echo $ptnns_splash_page_checked; ?> />
		<label for="ptnns-splash-page">&nbsp;</label>
		<p><small><?php echo __('If switched on, a splash page will be displayed instead of your website for maintenance purpose or just to hide your site to not logged users','ptnnslang'); ?></small></p>
		<?php
	}

} else {
	
	error_log('function: "ptnns_splash_page" already exists');
	
}

add_settings_field(
'ptnns-splash-type',
__('Choose what to display','ptnnslang'),
'ptnns_splash_type',
'enhance-section',
'enhance_splash_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-splash-type')
);

if(!function_exists('ptnns_splash_type')) {

	function ptnns_splash_type($ptnns_arguments){
		
		if(!empty($ptnns_arguments['ptnns_saved_options']['splash_type'])) {
			
			$ptnns_saved_option = $ptnns_arguments['ptnns_saved_options']['splash_type'];
			
		} else {
			
			$ptnns_saved_option = null;
			
		}
		
		if($ptnns_saved_option === 'splash_type_image' || empty($ptnns_saved_option)) {
			$splash_type_image_checked = 'checked';
			$splash_type_page_checked = null;
		} 
		
		else if($ptnns_saved_option === 'splash_type_page') {
			$splash_type_image_checked = null;
			$splash_type_page_checked = 'checked';
		}
		
		?>
		<input type="radio" id="ptnns-splash-type-image" name="_ptnns_enhance[splash_type]" value="splash_type_image" <?php echo $splash_type_image_checked; ?>>
		<label for="ptnns-splash-type-image"><?php echo __('a full screen image (cover)','ptnnslang') ?></label>
		
		<input type="radio" id="ptnns-splash-type-page" name="_ptnns_enhance[splash_type]" value="splash_type_page" <?php echo $splash_type_page_checked; ?>>
		<label for="ptnns-splash-type-page"><?php echo __('the content of a page (with no header and footer)','ptnnslang') ?></label>
		<?php
	}

} else {
	
	error_log('function: "ptnns_splash_type" already exists');
	
}
	
add_settings_field(
'ptnns-splash-image',  
__('Choose an image','ptnnslang'),
'ptnns_splash_image_id',
'enhance-section',
'enhance_splash_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-splash-image')
);

if(!function_exists('ptnns_splash_image_id')) {

	function ptnns_splash_image_id($ptnns_arguments){
					
		$ptnns_saved_option_url = null;
		$ptnns_saved_option_placeholder = null;
		
		if(!empty($ptnns_arguments['ptnns_saved_options']['splash_image_id'])) {
			
			//get media id
			$ptnns_saved_option = $ptnns_arguments['ptnns_saved_options']['splash_image_id'];
			//get media url by id
			$ptnns_saved_option_url = esc_url_raw(wp_get_attachment_url($ptnns_saved_option));
			
			//check if media url exists
			if($ptnns_saved_option !== '0' && !get_post_status($ptnns_saved_option)) {
			
				$ptnns_saved_option_placeholder = __('Image not found: press Save Settings to empty or choose another image','ptnnslang');
				$ptnns_saved_option = null;
			
			} 
						
		} else {
			
			$ptnns_saved_option = null;
			
		}	
		
		wp_enqueue_media();
		?>
		<input type="text" size="75" name="_ptnns_enhance[splash_image]" id="ptnns-splash-image" value="<?php echo $ptnns_saved_option_url; ?>" placeholder="<?php echo $ptnns_saved_option_placeholder; ?>" readonly />
		<input type="hidden" name="_ptnns_enhance[splash_image_id]" id="ptnns-splash-image-id" value="<?php echo $ptnns_saved_option; ?>" />
		<input type="button" id="ptnns-splash-image-button" class="button button-primary" value="<?php echo __('Choose form media library','ptnnslang'); ?>" />
		<input type="button" id="ptnns-splash-image-remove-button" class="button" value="<?php echo __('Remove','ptnnslang'); ?>" />
		<p><small><?php echo __('Select an image from the media gallery, leave blank for displaying an empty page with the login form only','ptnnslang'); ?></small></p>
		
		<?php
	}

} else {
	
	error_log('function: "ptnns_splash_image_id" already exists');
	
}

add_settings_field(
'ptnns-splash-id',  
__('Choose a page','ptnnslang'),
'ptnns_splash_page_id',
'enhance-section',
'enhance_splash_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-splash-page-id')
);

if(!function_exists('ptnns_splash_page_id')) {

	function ptnns_splash_page_id($ptnns_arguments){
					
		if(!empty($ptnns_arguments['ptnns_saved_options']['splash_page_id'])) {
			
			$ptnns_saved_option = $ptnns_arguments['ptnns_saved_options']['splash_page_id'];
			
		} else {
			
			$ptnns_saved_option = null;
			
		}	
		
		$ptnns_page_id_dropdown_args = array(
			'post_type'			=> 'page',
			'post_status'		=> ['publish', 'draft'],
			'name'				=> '_ptnns_enhance[splash_page_id]',
			'id'				=> 'ptnns-splash-page-id',
			'sort_column'		=> 'menu_order, post_title',
			'echo'				=> 1,
			'selected'			=> $ptnns_saved_option,
		);
		
		wp_dropdown_pages($ptnns_page_id_dropdown_args);
		?>

		<p><small><?php echo __('Select the page whose content, with no header or footer, will be shown with an overlaid ajax login form','ptnnslang'); ?>; <?php echo __('use a draft page to prevent to be browsed by logged users','ptnnslang'); ?></small></p>
		
		<?php
	}

} else {
	
	error_log('function: "ptnns_splash_page_id" already exists');
	
}

add_settings_field(
'ptnns-splash-login',
__('Hide WordPress login page','ptnnslang'),
'ptnns_splash_login',
'enhance-section',
'enhance_splash_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-splash-login')
);

if(!function_exists('ptnns_splash_login')) {

	function ptnns_splash_login($ptnns_arguments){
		
		if(!empty($ptnns_arguments['ptnns_saved_options']['splash_login'])) {
			
			$ptnns_saved_option = $ptnns_arguments['ptnns_saved_options']['splash_login'];
			
		} else {
			
			$ptnns_saved_option = null;
			
		}
		
		if($ptnns_saved_option === '1') {
			$ptnns_splash_login_checked = 'checked';
		} else {
			$ptnns_splash_login_checked = null;
		}
		?>
		<input type="checkbox" name="_ptnns_enhance[splash_login]" class="ptnns-switch" id="ptnns-splash-login" value="1" <?php echo $ptnns_splash_login_checked; ?> />
		<label for="ptnns-splash-login">&nbsp;</label>
		<p><small><?php echo __('If switched on, splash page will be also displayed intead of WordPress login page, so that users can authenticate only through the overlaid ajax login form','ptnnslang'); ?></small></p>
		<?php
	}

} else {
	
	error_log('function: "ptnns_splash_login" already exists');
	
}

add_settings_field(
    'ptnns-maintenance-mode',
    __('Maintenance Mode','ptnnslang'),
    'ptnns_maintenance_mode',
    'enhance-section',
    'enhance_splash_section',
    array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-splash-maintenance-mode')
);

if(!function_exists('ptnns_maintenance_mode')) {

    function ptnns_maintenance_mode($ptnns_arguments){

        if(!empty($ptnns_arguments['ptnns_saved_options']['maintenance_mode'])) {

            $ptnns_saved_option = $ptnns_arguments['ptnns_saved_options']['maintenance_mode'];

        } else {

            $ptnns_saved_option = null;

        }

        if($ptnns_saved_option === '1') {
            $ptnns_maintenance_mode_checked = 'checked';
        } else {
            $ptnns_maintenance_mode_checked = null;
        }
        ?>
        <input type="checkbox" name="_ptnns_enhance[maintenance_mode]" class="ptnns-switch" id="ptnns-splash-maintenance-mode" value="1" <?php echo $ptnns_maintenance_mode_checked; ?> />
        <label for="ptnns-splash-maintenance-mode">&nbsp;</label>
        <p><small><?php echo __('If switched on, an HTTP response','ptnnslang'); ?> "503 Service Temporarily Unavailable" <?php echo __('will be set, so that users and search engines will know that splash page is for maintenance purpose','ptnnslang'); ?>
        </small></p>

        <?php
    }

} else {

    error_log('function: "ptnns_maintenance_mode" already exists');

}


add_settings_field(
    'ptnns-retry-after',
    __('Maintenance expected duration','ptnnslang'),
    'ptnns_retry_after',
    'enhance-section',
    'enhance_splash_section',
    array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-splash-retry-after')
);

if(!function_exists('ptnns_retry_after')) {

    function ptnns_retry_after($ptnns_arguments){

        if(!empty($ptnns_arguments['ptnns_saved_options']['retry_after'])) {

            $ptnns_saved_option = $ptnns_arguments['ptnns_saved_options']['retry_after'];

        } else {

            $ptnns_saved_option = null;

        }


        ?>
        <select name="_ptnns_enhance[retry_after]" id="ptnns-splash-retry-after" />
            <option value="0" selected> <?php echo __('Undefined duration','ptnnslang'); ?></option>
        <?php

        //minutes loop
        $ptnns_minute_step = 10;
        while($ptnns_minute_step <= 59) {

            $ptnns_minute_value = __('minutes','ptnnslang');

            if((int)$ptnns_saved_option === ($ptnns_minute_step*60)) {
                ?>

                <option value="<?php echo ($ptnns_minute_step*60); ?>" selected><?php echo $ptnns_minute_step; ?> <?php echo $ptnns_minute_value; ?></option>

                <?php
            } else {
                ?>

                <option value="<?php echo ($ptnns_minute_step*60); ?>"><?php echo $ptnns_minute_step; ?> <?php echo $ptnns_minute_value; ?></option>

                <?php
            }

            $ptnns_minute_step = $ptnns_minute_step + 10;
        }

        //hours loop
        $ptnns_hour_step = 1;
        while($ptnns_hour_step <= 12) {

            if($ptnns_hour_step == 1) {

                $ptnns_hour_value = __('hour','ptnnslang');

            } else {

                $ptnns_hour_value = __('hours','ptnnslang');

            }

            if((int)$ptnns_saved_option === ($ptnns_hour_step*60*60)) {
                ?>

                <option value="<?php echo ($ptnns_hour_step*60*60); ?>" selected><?php echo $ptnns_hour_step; ?> <?php echo $ptnns_hour_value; ?></option>

                <?php
            } else {

                ?>

                <option value="<?php echo ($ptnns_hour_step*60*60); ?>"><?php echo $ptnns_hour_step; ?> <?php echo $ptnns_hour_value; ?></option>

                <?php
            }

            $ptnns_hour_step = $ptnns_hour_step + 1;
        }

        //days loop
        $ptnns_day_step = 1;
        while($ptnns_day_step <= 6) {

            if($ptnns_day_step == 1) {

                $ptnns_day_value = __('day','ptnnslang');

            } else {

                $ptnns_day_value = __('days','ptnnslang');

            }

            if((int)$ptnns_saved_option === ($ptnns_day_step*60*60*24)) {
                ?>

                <option value="<?php echo ($ptnns_day_step*60*60*24); ?>" selected><?php echo $ptnns_day_step; ?> <?php echo $ptnns_day_value; ?></option>

                <?php
            } else {
                ?>

                <option value="<?php echo ($ptnns_day_step*60*60*24); ?>"><?php echo $ptnns_day_step; ?> <?php echo $ptnns_day_value; ?></option>

                <?php
            }

            $ptnns_day_step = $ptnns_day_step + 1;
        }

        //weeks loop
        $ptnns_week_step = 1;
        while($ptnns_week_step <= 3) {

            if($ptnns_week_step == 1) {

                $ptnns_week_value = __('week','ptnnslang');

            } else {

                $ptnns_week_value = __('weeks','ptnnslang');

            }

            $ptnns_week_value_addendum = null;

            if((int)$ptnns_saved_option === ($ptnns_week_step*60*60*24*7)) {
                ?>

                <option value="<?php echo ($ptnns_week_step*60*60*24*7); ?>" selected><?php echo $ptnns_week_step; ?> <?php echo $ptnns_week_value; ?></option>

                <?php
            } else {

                ?>

                <option value="<?php echo ($ptnns_week_step*60*60*24*7); ?>"><?php echo $ptnns_week_step; ?> <?php echo $ptnns_week_value; ?></option>

                <?php
            }

            $ptnns_week_step = $ptnns_week_step + 1;
        }

        ?>
        </select>
        <p><small><?php echo __('The duration, if defined, will be used to set an HTTP response','ptnnslang'); ?> "Retry After", <?php echo __('so that users and search engines will know how long the maintenance mode will last','ptnnslang'); ?></small></p>
        <?php
    }

} else {

    error_log('function: "ptnns_retry_after" already exists');

}

add_settings_section(
'enhance_custom_404_section',
'<span class="dashicons dashicons-admin-plugins"></span>'.__('Custom 404 Page','ptnnslang'),
'ptnns_enhance_custom_404_section_comment',
'enhance-section'
);

if(!function_exists('ptnns_enhance_custom_404_section_comment')) {
	
	function ptnns_enhance_custom_404_section_comment(){
		echo '<span class="ptnns-section-comment">'.__('Redirect visitors to a custom 404 page, instead of displaying your theme 404 default page','ptnnslang').'</span>';
	}
	
} else {
	
	error_log('function: "ptnns_enhance_custom_404_section_comment" already exists');
	
}


add_settings_field(
'ptnns-404-custom',
__('Enable custom 404','ptnnslang'),
'ptnns_404_custom',
'enhance-section',
'enhance_custom_404_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-404-custom')
);

if(!function_exists('ptnns_404_custom')) {

	function ptnns_404_custom($ptnns_arguments){
		
		if(!empty($ptnns_arguments['ptnns_saved_options']['custom_404'])) {
			
			$ptnns_saved_option = $ptnns_arguments['ptnns_saved_options']['custom_404'];
			
		} else {
			
			$ptnns_saved_option = null;
			
		}
		
		if($ptnns_saved_option === '1') {
			$ptnns_404_custom_checked = 'checked';
		} else {
			$ptnns_404_custom_checked = null;
		}
		?>
		<input type="checkbox" name="_ptnns_enhance[custom_404]" class="ptnns-switch" id="ptnns-404-custom" value="1" <?php echo $ptnns_404_custom_checked; ?> />
		<label for="ptnns-404-custom">&nbsp;</label>
		<p><small><?php echo __('If switched on, visitors will be redirected to the below selected custom 404 page, instead of showing them the default 404 page provided by your theme','ptnnslang'); ?></small></p>
		<?php
	}

} else {
	
	error_log('function: "ptnns_404_custom" already exists');
	
}
	
add_settings_field(
'ptnns-custom-404-id',  
__('Choose a page','ptnnslang'),
'ptnns_custom_404_id',
'enhance-section',
'enhance_custom_404_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-custom-404-id')
);

if(!function_exists('ptnns_custom_404_id')) {

	function ptnns_custom_404_id($ptnns_arguments){
					
		if(!empty($ptnns_arguments['ptnns_saved_options']['custom_404_id'])) {
			
			$ptnns_saved_option = $ptnns_arguments['ptnns_saved_options']['custom_404_id'];
			
		} else {
			
			$ptnns_saved_option = null;
			
		}	
		
		$ptnns_page_id_dropdown_args = array(
			'post_type'        => 'page',
			'name'             => '_ptnns_enhance[custom_404_id]',
			'id'               => 'ptnns-custom-404-id',
			'sort_column'      => 'menu_order, post_title',
			'echo'             => 1,
			'selected' 		   => $ptnns_saved_option,
		);
		
		wp_dropdown_pages($ptnns_page_id_dropdown_args);
		?>

		<p><small><?php echo __('Define where to redirect visitors when the requested page does not exist','ptnnslang'); ?></small></p>
		
		<?php
	}

} else {
	
	error_log('function: "ptnns_custom_404_id" already exists');
	
}

add_settings_section(
'enhance_size_quality_section',
'<span class="dashicons dashicons-admin-plugins"></span>'.__('Image Resolution and JPEG Compression','ptnnslang'),
'ptnns_enhance_size_quality_section_comment',
'enhance-section'
);

if(!function_exists('ptnns_enhance_size_quality_section_comment')) {
	
	function ptnns_enhance_size_quality_section_comment(){
		echo '<span class="ptnns-section-comment">'.__('Set the image resolution and the JPEG quality compression in order to resize each image you will upload and to recompress JPEG images, so that you do not need to worry of image dimensions any more','ptnnslang').'</span>';
	}
	
} else {
	
	error_log('function: "ptnns_enhance_size_quality_section_comment" already exists');
	
}

add_settings_field(
'ptnns-image-treating',
__('Enable image resolution and JPEG Compression','ptnnslang'),
'ptnns_image_treating',
'enhance-section',
'enhance_size_quality_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-image-treating')
);

if(!function_exists('ptnns_image_treating')) {

	function ptnns_image_treating($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress/" target="_blank">NutsForPress Images and Media</a></p>
		<?php

	}

} else {
	
	error_log('function: "ptnns_image_treating" already exists');
	
}


add_settings_field(
'ptnns-image-size',  
__('Choose resolution','ptnnslang'),
'ptnns_image_size',
'enhance-section',
'enhance_size_quality_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-image-size')
);

if(!function_exists('ptnns_image_size')) {

	function ptnns_image_size($ptnns_arguments){
					
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress/" target="_blank">NutsForPress Images and Media</a></p>
		<?php
		
	}

} else {
	
	error_log('function: "ptnns_image_size" already exists');
	
}


add_settings_field(
'ptnns-skip-gif',
__('Skip GIF images from resizing','ptnnslang'),
'ptnns_skip_gif',
'enhance-section',
'enhance_size_quality_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-skip-gif')
);

if(!function_exists('ptnns_skip_gif')) {

	function ptnns_skip_gif($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress/" target="_blank">NutsForPress Images and Media</a></p>
		<?php
		
	}

} else {
	
	error_log('function: "ptnns_skip_gif" already exists');
	
}


add_settings_field(
'ptnns-jpeg-quality',  
__('Choose JPEG compression','ptnnslang'),
'ptnns_jpeg_quality',
'enhance-section',
'enhance_size_quality_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-jpeg-quality')
);

if(!function_exists('ptnns_jpeg_quality')) {

	function ptnns_jpeg_quality($ptnns_arguments){
					
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress/" target="_blank">NutsForPress Images and Media</a></p>
		<?php		
		
	}

} else {
	
	error_log('function: "ptnns_jpeg_quality" already exists');
	
}


add_settings_field(
'ptnns-rebuild-thumbnails',  
__('Bulk rebuild and compress','ptnnslang'),
'ptnns_rebuild_thumbnails',
'enhance-section',
'enhance_size_quality_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-rebuild-thumbnails'.$ptnns_pro_feature_class)
);

if(!function_exists('ptnns_rebuild_thumbnails')) {

	function ptnns_rebuild_thumbnails($ptnns_arguments){
	
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress/" target="_blank">NutsForPress Images and Media</a></p>
		<?php
		
	}

} else {
	
	error_log('function: "ptnns_rebuild_thumbnails" already exists');
	
}

add_settings_section(
'enhance_smtp_mail_section',
'<span class="dashicons dashicons-admin-plugins"></span>'.__('Send mail through SMTP','ptnnslang'),
'enhance_smtp_mail_size_section_comment',
'enhance-section'
);

if(!function_exists('enhance_smtp_mail_size_section_comment')) {
	
	function enhance_smtp_mail_size_section_comment(){
		echo '<span class="ptnns-section-comment">'.__('Use your SMTP to send email messages from your website, to prevent they can be forwarded to spam or junk mail','ptnnslang').'</span>';
	}
	
} else {
	
	error_log('function: "enhance_smtp_mail_size_section_comment" already exists');
	
}

add_settings_field(
'ptnns-smtp-mail',  
__('Enable SMTP server','ptnnslang'),
'ptnns_smtp_mail',
'enhance-section',
'enhance_smtp_mail_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-smtp-mail')
);

if(!function_exists('ptnns_smtp_mail')) {
	
	function ptnns_smtp_mail($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-smtp-mail/" target="_blank">NutsForPress SMTP Mail</a></p>
		<?php
		
	}	

	
} else {
	
	error_log('function: "ptnns_smtp_mail" already exists');
	
}

add_settings_field(
'ptnns-smtp-encryption',
__('Define encryption','ptnnslang'),
'ptnns_smtp_encryption',
'enhance-section',
'enhance_smtp_mail_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-smtp-encryption')
);

if(!function_exists('ptnns_smtp_encryption')) {

	function ptnns_smtp_encryption($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-smtp-mail/" target="_blank">NutsForPress SMTP Mail</a></p>
		<?php
		
	}

} else {
	
	error_log('function: "ptnns_smtp_encryption" already exists');
	
}


add_settings_field(
'ptnns-smtp-port',
__('Define port','ptnnslang'),
'ptnns_smtp_port',
'enhance-section',
'enhance_smtp_mail_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-smtp-port')
);

if(!function_exists('ptnns_smtp_port')) {

	function ptnns_smtp_port($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-smtp-mail/" target="_blank">NutsForPress SMTP Mail</a></p>
		<?php

	}

} else {
	
	error_log('function: "ptnns_smtp_port" already exists');
	
}


add_settings_field(
'ptnns-smtp-server',
__('Define server address','ptnnslang'),
'ptnns_smtp_server',
'enhance-section',
'enhance_smtp_mail_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-smtp-server')
);

if(!function_exists('ptnns_smtp_server')) {

	function ptnns_smtp_server($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-smtp-mail/" target="_blank">NutsForPress SMTP Mail</a></p>
		<?php

	}

} else {
	
	error_log('function: "ptnns_smtp_server" already exists');
	
}


add_settings_field(
'ptnns-smtp-from-address',
__('Define from address','ptnnslang'),
'ptnns_smtp_from_address',
'enhance-section',
'enhance_smtp_mail_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-smtp-from-address')
);

if(!function_exists('ptnns_smtp_from_address')) {

	function ptnns_smtp_from_address($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-smtp-mail/" target="_blank">NutsForPress SMTP Mail</a></p>
		<?php

	}

} else {
	
	error_log('function: "ptnns_smtp_from_address" already exists');
	
}


add_settings_field(
'ptnns-smtp-from-name',
__('Define from name','ptnnslang'),
'ptnns_smtp_from_name',
'enhance-section',
'enhance_smtp_mail_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-smtp-from-name')
);

if(!function_exists('ptnns_smtp_from_name')) {

	function ptnns_smtp_from_name($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-smtp-mail/" target="_blank">NutsForPress SMTP Mail</a></p>
		<?php

	}

} else {
	
	error_log('function: "ptnns_smtp_from_name" already exists');
	
}


add_settings_field(
'ptnns-smtp-authentication',
__('Define authentication','ptnnslang'),
'ptnns_smtp_authentication',
'enhance-section',
'enhance_smtp_mail_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-smtp-authentication')
);

if(!function_exists('ptnns_smtp_authentication')) {

	function ptnns_smtp_authentication($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-smtp-mail/" target="_blank">NutsForPress SMTP Mail</a></p>
		<?php
		
	}

} else {
	
	error_log('function: "ptnns_smtp_authentication" already exists');
	
}


add_settings_field(
'ptnns-smtp-authentication-address',
__('Define authentication address','ptnnslang'),
'ptnns_smtp_authentication_address',
'enhance-section',
'enhance_smtp_mail_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-smtp-authentication-address')
);

if(!function_exists('ptnns_smtp_authentication_address')) {

	function ptnns_smtp_authentication_address($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-smtp-mail/" target="_blank">NutsForPress SMTP Mail</a></p>
		<?php

	}

} else {
	
	error_log('function: "ptnns_smtp_authentication_address" already exists');
	
}

add_settings_field(
'ptnns-smtp-authentication-password',
__('Define authentication password','ptnnslang'),
'ptnns_smtp_authentication_password',
'enhance-section',
'enhance_smtp_mail_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-smtp-authentication-password')
);

if(!function_exists('ptnns_smtp_authentication_password')) {

	function ptnns_smtp_authentication_password($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-smtp-mail/" target="_blank">NutsForPress SMTP Mail</a></p>
		<?php

	}

} else {
	
	error_log('function: "ptnns_smtp_authentication_password" already exists');
	
}


add_settings_field(
'ptnns-smtp-test',  
__('SMTP test','ptnnslang'),
'ptnns_smtp_test',
'enhance-section',
'enhance_smtp_mail_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-smtp-test')
);

if(!function_exists('ptnns_smtp_test')) {

	function ptnns_smtp_test($ptnns_arguments){
	
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-smtp-mail/" target="_blank">NutsForPress SMTP Mail</a></p>
		<?php
		
	}

} else {
	
	error_log('function: "ptnns_smtp_test" already exists');
	
}

add_settings_field(
'ptnns-smtp-test-address',  
__('SMTP test recipient','ptnnslang'),
'ptnns_smtp_test_address',
'enhance-section',
'enhance_smtp_mail_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-smtp-test-address')
);

if(!function_exists('ptnns_smtp_test_address')) {

	function ptnns_smtp_test_address($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-smtp-mail/" target="_blank">NutsForPress SMTP Mail</a></p>
		<?php
		
	}

} else {
	
	error_log('function: "ptnns_smtp_test_address" already exists');
	
}


settings_fields("enhance-section");
do_settings_sections("enhance-section");

submit_button('Save Settings', 'primary', 'ptnns-save-enhance-options');
