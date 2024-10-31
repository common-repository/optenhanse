<?php 
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

if(!empty($ptnns_optenhanse_options_array['optenhanse_pro'])) {
	
	$ptnns_pro_feature_class = '';
	
} else {
	
	$ptnns_pro_feature_class = ' ptnns-pro-feature';
	
}


add_settings_section(
'optimize-title-section',
'<span class="dashicons dashicons-admin-tools"></span>'.__('Title Tag','ptnnslang'),
'ptnns_title_tag_comment',
'optimize-section'
);


if(!function_exists('ptnns_title_tag_comment')) {

	function ptnns_title_tag_comment(){
		echo __('Add a title field to pages and posts editor to replace title tag content and to take control of the title displayed by Search Engines', 'ptnnslang');
	}

} else {
	
	error_log('function: "ptnns_title_tag_comment" already exists');
	
}

add_settings_field(
'ptnns-title-tag',
__('Enable title','ptnnslang'),
'ptnns_title_tag',
'optimize-section',
'optimize-title-section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-title-tag')
);

if(!function_exists('ptnns_title_tag')) {

	function ptnns_title_tag($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-indexing-and-seo/" target="_blank">NutsForPress Indexing and SEO</a></p>
		<?php
		
	}

}  else {
	
	error_log('function: "ptnns_title_tag" already exists');
	
}


add_settings_section(
'optimize-description-section',
'<span class="dashicons dashicons-admin-tools"></span>'.__('Description Meta Tag','ptnnslang'),
'ptnns_description_tag_comment',
'optimize-section'
);


if(!function_exists('ptnns_description_tag_comment')) {

	function ptnns_description_tag_comment(){
		echo __('Add a description field to pages and posts editor and add a description meta tag to HTML code, to take control of the excerpt that Search Engines display in search results', 'ptnnslang');
	}

} else {
	
	error_log('function: "ptnns_description_tag_comment" already exists');
	
}

add_settings_field(
'ptnns-description-tag',
__('Enable description','ptnnslang'),
'ptnns_description_tag',
'optimize-section',
'optimize-description-section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-description-tag')
);

if(!function_exists('ptnns_description_tag')) {

	function ptnns_description_tag($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-indexing-and-seo/" target="_blank">NutsForPress Indexing and SEO</a></p>
		<?php

	}

}  else {
	
	error_log('function: "ptnns_description_tag" already exists');
	
}
	

add_settings_section(
'optimize-no-index-section',
'<span class="dashicons dashicons-admin-tools"></span>'.__('Allow No Index','ptnnslang'),
'ptnns_no_index_tag_comment',
'optimize-section'
);


if(!function_exists('ptnns_no_index_tag_comment')) {

	function ptnns_no_index_tag_comment(){
		echo __('Add a checkbox to pages and posts editor, add a "noindex" meta to page or post header where the checkbox is flagged and define content that should not be indexed by Search Engines', 'ptnnslang');
	}

} else {
	
	error_log('function: "ptnns_no_index_tag_comment" already exists');
	
}

add_settings_field(
'ptnns-no-index-tag',
__('Enable no index','ptnnslang'),
'ptnns_no_index_tag',
'optimize-section',
'optimize-no-index-section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-no-index-tag')
);

if(!function_exists('ptnns_no_index_tag')) {

	function ptnns_no_index_tag($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-indexing-and-seo/" target="_blank">NutsForPress Indexing and SEO</a></p>
		<?php		
		
	}

}  else {
	
	error_log('function: "ptnns_no_index_tag" already exists');
	
}	

add_settings_section(
'optimize_social_section',
'<span class="dashicons dashicons-admin-tools"></span>'.__('Social Media Sharing','ptnnslang'),
'ptnns_social_section_comment',
'optimize-section'
);

if(!function_exists('ptnns_social_section_comment')) {
	
	function ptnns_social_section_comment(){
		echo '<span class="ptnns-section-comment">'.__('When someone shares contents of your website, the correct title, description and image will be shown, thanks to the proper meta tags automatically added to HTML code', 'ptnnslang').'</span>';
	}
	
} else {
	
	error_log('function: "ptnns_social_section_comment" already exists');
	
}

add_settings_field(
'ptnns-facebook-share',
__('Facebook Opengraph','ptnnslang'),
'ptnns_facebook_share',
'optimize-section',
'optimize_social_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-facebook-share')
);

if(!function_exists('ptnns_facebook_share')) {

	function ptnns_facebook_share($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-indexing-and-seo/" target="_blank">NutsForPress Indexing and SEO</a></p>
		<?php
		
	}

} else {
	
	error_log('function: "ptnns_facebook_share" already exists');
	
}

add_settings_field(
'ptnns-twitter-share',  
__('Twitter Card','ptnnslang'),
'ptnns_twitter_share',
'optimize-section',
'optimize_social_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-twitter-share')
);

if(!function_exists('ptnns_twitter_share')) {

	function ptnns_twitter_share($ptnns_arguments){
					
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-indexing-and-seo/" target="_blank">NutsForPress Indexing and SEO</a></p>
		<?php

	}

} else {
	
	error_log('function: "ptnns_twitter_share" already exists');
	
}
		
add_settings_field(
'ptnns-alternative-social-image',  
__('Alternative Social Image','ptnnslang'),
'ptnns_alternative_social_image_id',
'optimize-section',
'optimize_social_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-alternative-social-image')
);

if(!function_exists('ptnns_alternative_social_image_id')) {

	function ptnns_alternative_social_image_id($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-indexing-and-seo/" target="_blank">NutsForPress Indexing and SEO</a></p>
		<?php

	}

} else {
	
	error_log('function: "ptnns_alternative_social_image_id" already exists');
	
}

add_settings_section(
'optimize_sitemap_section',
'<span class="dashicons dashicons-admin-tools"></span>'.__('Build Sitemap','ptnnslang'),
'ptnns_optimize_sitemap_section_comment',
'optimize-section'
);

if(!function_exists('ptnns_optimize_sitemap_section_comment')) {
	
	function ptnns_optimize_sitemap_section_comment(){
		echo '<span class="ptnns-section-comment">'.__('Build a virtual sitemap.xml file, including pages, posts and custom post types set to public', 'ptnnslang'),'</span>';
	}
	
} else {
	
	error_log('function: "ptnns_optimize_sitemap_section_comment" already exists');
	
}


add_settings_field(
'ptnns-sitemap',
__('Enable sitemap.xml','ptnnslang'),
'ptnns_sitemap',
'optimize-section',
'optimize_sitemap_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-sitemap')
);

if(!function_exists('ptnns_sitemap')) {

	function ptnns_sitemap($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress-indexing-and-seo/" target="_blank">NutsForPress Indexing and SEO</a></p>
		<?php

	}

} else {
	
	error_log('function: "ptnns_sitemap" already exists');
	
}


add_settings_section(
'optimize_attachment_meta_section',
'<span class="dashicons dashicons-admin-tools"></span>'.__('Automatically Fill Out Attachment Meta','ptnnslang'),
'ptnns_optimize_attachment_meta_section_comment',
'optimize-section'
);

if(!function_exists('ptnns_optimize_attachment_meta_section_comment')) {
	
	function ptnns_optimize_attachment_meta_section_comment(){
		echo '<span class="ptnns-section-comment">'.__('Automatically fill out "description", "caption" and "alt title" every time you upload a media file, preventing the lack of tag "alt" and increasing substantially your SEO', 'ptnnslang').'</span>';
	}
	
} else {
	
	error_log('function: "ptnns_optimize_attachment_meta_section_comment" already exists');
	
}


add_settings_field(
'ptnns-attachment-meta',
__('Enable automatic meta','ptnnslang'),
'ptnns_attachment_meta',
'optimize-section',
'optimize_attachment_meta_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-attachment-meta')
);

if(!function_exists('ptnns_attachment_meta')) {

	function ptnns_attachment_meta($ptnns_arguments){
		
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress/" target="_blank">NutsForPress Images and Media</a></p>
		<?php

	}

} else {
	
	error_log('function: "ptnns_attachment_meta" already exists');
	
}


add_settings_field(
'ptnns-rebuild-meta',  
__('Bulk meta rebuild','ptnnslang'),
'ptnns_rebuild_meta',
'optimize-section',
'optimize_attachment_meta_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-rebuild-meta'.$ptnns_pro_feature_class)
);

if(!function_exists('ptnns_rebuild_meta')) {

	function ptnns_rebuild_meta($ptnns_arguments){
	
		?>
		<p><?php echo __('This function is no more available, please download and install our new plugin','ptnnslang'); ?> <a href="https://it.wordpress.org/plugins/nutsforpress/" target="_blank">NutsForPress Images and Media</a></p>
		<?php
		
	}

} else {
	
	error_log('function: "ptnns_rebuild_meta" already exists');
	
}


add_settings_section(
'optimize_minification_section',
'<span class="dashicons dashicons-admin-tools"></span>'.__('Minify HTML Code','ptnnslang'),
'ptnns_optimize_minification_section_comment',
'optimize-section'
);

if(!function_exists('ptnns_optimize_minification_section_comment')) {
	
	function ptnns_optimize_minification_section_comment(){
		echo '<span class="ptnns-section-comment">'.__('Minify HTML code on the fly', 'ptnnslang').'</span>';
	}
	
} else {
	
	error_log('function: "ptnns_optimize_minification_section_comment" already exists');
	
}


add_settings_field(
'ptnns-html-minification',
__('Enable HTML minification','ptnnslang'),
'ptnns_html_minification',
'optimize-section',
'optimize_minification_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-html-minification')
);

if(!function_exists('ptnns_html_minification')) {

	function ptnns_html_minification($ptnns_arguments){
		
		if(!empty($ptnns_arguments['ptnns_saved_options']['html_minification'])) {
			
			$ptnns_saved_option = $ptnns_arguments['ptnns_saved_options']['html_minification'];
			
		} else {
			
			$ptnns_saved_option = null;
			
		}
		
		if($ptnns_saved_option === '1') {
			$ptnns_html_minification_checked = 'checked';
		} else {
			$ptnns_html_minification_checked = null;
		}
		?>
		<input type="checkbox" name="_ptnns_optimize[html_minification]" class="ptnns-switch" id="ptnns-html-minification" value="1" <?php echo $ptnns_html_minification_checked; ?> />
		<label for="ptnns-html-minification">&nbsp;</label>
		<p><small><?php echo __('If switched on, all your website HTML code will be minificated on the fly', 'ptnnslang'); ?></small></p>
		<?php
	}

} else {
	
	error_log('function: "ptnns_html_minification" already exists');
	
}



add_settings_section(
'optimize_cache_section',
'<span class="dashicons dashicons-admin-tools"></span>'.__('Browser Cache','ptnnslang'),
'ptnns_optimize_cache_section_comment',
'optimize-section'
);

if(!function_exists('ptnns_optimize_cache_section_comment')) {
	
	function ptnns_optimize_cache_section_comment(){
		echo '<span class="ptnns-section-comment">'.__('Add browser cache rules via htaccess', 'ptnnslang').'</span>';
	}
	
} else {
	
	error_log('function: "ptnns_optimize_cache_section_comment" already exists');
	
}


add_settings_field(
'ptnns-browser-cache',
__('Enable browser cache','ptnnslang'),
'ptnns_browser_cache',
'optimize-section',
'optimize_cache_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-browser-cache')
);

if(!function_exists('ptnns_browser_cache')) {

	function ptnns_browser_cache($ptnns_arguments){
		
		if(!empty($ptnns_arguments['ptnns_saved_options']['browser_cache'])) {
			
			$ptnns_saved_option = $ptnns_arguments['ptnns_saved_options']['browser_cache'];
			
		} else {
			
			$ptnns_saved_option = null;
			
		}
		
		if($ptnns_saved_option === '1') {
			$ptnns_browser_cache_checked = 'checked';
		} else {
			$ptnns_browser_cache_checked = null;
		}
		?>
		<input type="checkbox" name="_ptnns_optimize[browser_cache]" class="ptnns-switch" id="ptnns-browser-cache" value="1" <?php echo $ptnns_browser_cache_checked; ?> />
		<label for="ptnns-browser-cache">&nbsp;</label>
		<p><small><?php echo __('If switched on, browser cache rules will be added to htaccess (it works only on Apache with mod_headers module installed)', 'ptnnslang'); ?></small></p>
		<?php
	}

} else {
	
	error_log('function: "ptnns_browser_cache" already exists');
	
}


add_settings_field(
'ptnns-media-cache',  
__('Media cache duration','ptnnslang'),
'ptnns_media_cache',
'optimize-section',
'optimize_cache_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-media-cache')
);

if(!function_exists('ptnns_media_cache')) {

	function ptnns_media_cache($ptnns_arguments){
					
		if(!empty($ptnns_arguments['ptnns_saved_options']['media_cache'])) {
			
			$ptnns_saved_option = $ptnns_arguments['ptnns_saved_options']['media_cache'];
			
		} else {
			
			$ptnns_saved_option = null;
			
		}	
		

		?>
		<select name="_ptnns_optimize[media_cache]" id="ptnns-media-cache" />
		<?php
		
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
			
			if($ptnns_week_step*60*60*24*7 === 1209600) {
				
				$ptnns_week_value_addendum = ' ('.__('recommended','ptnnslang').')';
				
			}			
			
			if((int)$ptnns_saved_option === ($ptnns_week_step*60*60*24*7)) {
				?>
				
				<option value="<?php echo ($ptnns_week_step*60*60*24*7); ?>" selected><?php echo $ptnns_week_step; ?> <?php echo $ptnns_week_value; ?><?php echo $ptnns_week_value_addendum; ?></option>
				
				<?php		
			} else {
				
				?>
				
				<option value="<?php echo ($ptnns_week_step*60*60*24*7); ?>"><?php echo $ptnns_week_step; ?> <?php echo $ptnns_week_value; ?><?php echo $ptnns_week_value_addendum; ?></option>
				
				<?php
			}		
			
			$ptnns_week_step = $ptnns_week_step + 1;
		}

		//months loop
		$ptnns_month_step = 1;
		while($ptnns_month_step <= 6) {
			
			if($ptnns_month_step == 1) {
				
				$ptnns_month_value = __('month','ptnnslang');
				
			} else {
				
				$ptnns_month_value = __('months','ptnnslang');
				
			}
			
			if((int)$ptnns_saved_option === ($ptnns_month_step*60*60*24*30)) {
				?>
				
				<option value="<?php echo ($ptnns_month_step*60*60*24*30); ?>" selected><?php echo $ptnns_month_step; ?> <?php echo $ptnns_month_value; ?></option>
				
				<?php		
			} else {
				?>
				
				<option value="<?php echo ($ptnns_month_step*60*60*24*30); ?>"><?php echo $ptnns_month_step; ?> <?php echo $ptnns_month_value; ?></option>
				
				<?php
			}		
			
			$ptnns_month_step = $ptnns_month_step + 1;
		}			
		
		?>
		</select>
		<p><small><?php echo __('The defined duration will be used to cache media files','ptnnslang'); ?> (ico, pdf, flv, jpg, jpeg, png, gif, swf, mp3, mp4)</small></p>
		<?php
	}

} else {
	
	error_log('function: "ptnns_media_cache" already exists');
	
}


add_settings_field(
'ptnns-script-cache',  
__('Script cache duration','ptnnslang'),
'ptnns_script_cache',
'optimize-section',
'optimize_cache_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-script-cache')
);

if(!function_exists('ptnns_script_cache')) {

	function ptnns_script_cache($ptnns_arguments){
					
		if(!empty($ptnns_arguments['ptnns_saved_options']['script_cache'])) {
			
			$ptnns_saved_option = $ptnns_arguments['ptnns_saved_options']['script_cache'];
			
		} else {
			
			$ptnns_saved_option = null;
			
		}	
		

		?>
		<select name="_ptnns_optimize[script_cache]" id="ptnns-script-cache" />
		<?php
		
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
			
			if($ptnns_week_step*60*60*24*7 === 1209600) {
				
				$ptnns_week_value_addendum = ' ('.__('recommended','ptnnslang').')';
				
			}			
			
			if((int)$ptnns_saved_option === ($ptnns_week_step*60*60*24*7)) {
				?>
				
				<option value="<?php echo ($ptnns_week_step*60*60*24*7); ?>" selected><?php echo $ptnns_week_step; ?> <?php echo $ptnns_week_value; ?><?php echo $ptnns_week_value_addendum; ?></option>
				
				<?php		
			} else {
			
				?>
				
				<option value="<?php echo ($ptnns_week_step*60*60*24*7); ?>"><?php echo $ptnns_week_step; ?> <?php echo $ptnns_week_value; ?><?php echo $ptnns_week_value_addendum; ?></option>
				
				<?php
			}		
			
			$ptnns_week_step = $ptnns_week_step + 1;
		}

		//months loop
		$ptnns_month_step = 1;
		while($ptnns_month_step <= 6) {
			
			if($ptnns_month_step == 1) {
				
				$ptnns_month_value = __('month','ptnnslang');
				
			} else {
				
				$ptnns_month_value = __('months','ptnnslang');
				
			}
			
			if((int)$ptnns_saved_option === ($ptnns_month_step*60*60*24*30)) {
				?>
				
				<option value="<?php echo ($ptnns_month_step*60*60*24*30); ?>" selected><?php echo $ptnns_month_step; ?> <?php echo $ptnns_month_value; ?></option>
				
				<?php		
			} else {
				?>
				
				<option value="<?php echo ($ptnns_month_step*60*60*24*30); ?>"><?php echo $ptnns_month_step; ?> <?php echo $ptnns_month_value; ?></option>
				
				<?php
			}		
			
			$ptnns_month_step = $ptnns_month_step + 1;
		}			
		
		?>
		</select>
		<p><small><?php echo __('The defined duration will be used to cache script files','ptnnslang'); ?> (js, css)</small></p>
		<?php
	}

} else {
	
	error_log('function: "ptnns_script_cache" already exists');
	
}



add_settings_field(
'ptnns-code-cache',  
__('Code cache duration','ptnnslang'),
'ptnns_code_cache',
'optimize-section',
'optimize_cache_section',
array('ptnns_saved_options' => $ptnns_saved_options, 'class' => 'ptnns-code-cache')
);

if(!function_exists('ptnns_code_cache')) {

	function ptnns_code_cache($ptnns_arguments){
					
		if(!empty($ptnns_arguments['ptnns_saved_options']['code_cache'])) {
			
			$ptnns_saved_option = $ptnns_arguments['ptnns_saved_options']['code_cache'];
			
		} else {
			
			$ptnns_saved_option = null;
			
		}	
		

		?>
		<select name="_ptnns_optimize[code_cache]" id="ptnns-code-cache" />
		<?php
		
		//hours loop
		$ptnns_hour_step = 1;
		while($ptnns_hour_step <= 12) {
			
			if($ptnns_hour_step == 1) {
				
				$ptnns_hour_value = __('hour','ptnnslang');
				
			} else {
				
				$ptnns_hour_value = __('hours','ptnnslang');
				
			}
			
			$ptnns_hour_value_addendum = null;
			
			if($ptnns_hour_step*60*60 === 7200) {
				
				$ptnns_hour_value_addendum = ' ('.__('recommended','ptnnslang').')';
				
			}	
			
			if((int)$ptnns_saved_option === ($ptnns_hour_step*60*60)) {
				?>
				
				<option value="<?php echo ($ptnns_hour_step*60*60); ?>" selected><?php echo $ptnns_hour_step; ?> <?php echo $ptnns_hour_value; ?><?php echo $ptnns_hour_value_addendum; ?></option>
				
				<?php		
			} else {
				?>
				
				<option value="<?php echo ($ptnns_hour_step*60*60); ?>"><?php echo $ptnns_hour_step; ?> <?php echo $ptnns_hour_value; ?><?php echo $ptnns_hour_value_addendum; ?></option>
				
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

		//months loop
		$ptnns_month_step = 1;
		while($ptnns_month_step <= 6) {
			
			if($ptnns_month_step == 1) {
				
				$ptnns_month_value = __('month','ptnnslang');
				
			} else {
				
				$ptnns_month_value = __('months','ptnnslang');
				
			}
			
			if((int)$ptnns_saved_option === ($ptnns_month_step*60*60*24*30)) {
				?>
				
				<option value="<?php echo ($ptnns_month_step*60*60*24*30); ?>" selected><?php echo $ptnns_month_step; ?> <?php echo $ptnns_month_value; ?></option>
				
				<?php		
			} else {
				?>
				
				<option value="<?php echo ($ptnns_month_step*60*60*24*30); ?>"><?php echo $ptnns_month_step; ?> <?php echo $ptnns_month_value; ?></option>
				
				<?php
			}		
			
			$ptnns_month_step = $ptnns_month_step + 1;
		}			
		
		?>
		</select>
		<p><small><?php echo __('The defined duration will be used to cache code files','ptnnslang'); ?> (html, htm, xml, txt, xsl)</small></p>
		<?php
	}

} else {
	
	error_log('function: "ptnns_code_cache" already exists');
	
}


settings_fields("optimize-section");
do_settings_sections("optimize-section");

submit_button('Save Settings', 'primary', 'ptnns-save-optimize-options');