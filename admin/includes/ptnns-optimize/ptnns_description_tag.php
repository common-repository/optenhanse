<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//add description metabox to post, page and public custom post types
if(!function_exists('ptnns_description_meta_box')) {
	
	function ptnns_description_meta_box() {
					
		//show post meta for all kinds of post
		$ptnns_all_post_types = get_post_types(array('public' => true));
		
		add_meta_box( 
		'ptnns-description', 
		__('Description Content','ptnnslang'), 
		'ptnns_description_meta_box_content', 
		$ptnns_all_post_types,
		'side',
		'high'
		);
		
	}
	
	add_action('add_meta_boxes', 'ptnns_description_meta_box');
	
} else {
	
	error_log('function: "ptnns_description_meta_box" already exists');
	
}

//custom metabox callback
if(!function_exists('ptnns_description_meta_box_content')) {
	
	function ptnns_description_meta_box_content($ptnns_post_object) {
		
		if(!get_the_ID()) return;
		
		$ptnns_description = esc_attr(get_post_meta(get_the_ID(), '_ptnns_meta_description', true));
		
		//backward compatibility with previous version of Optenhance plugin
		if(empty($ptnns_description)) {
			
			$ptnns_description = esc_html(get_post_meta(get_the_ID(), '_optenhance_description', true));
		}		
		
		?>

		<label for="ptnns-description"><?php echo __('These 160 chars represent the content of your meta description tag','ptnnslang'); ?><br><br>
		<textarea id="ptnns-description" name="ptnns-description" class="ptnns-description" rows="5" maxlength="160"><?php echo $ptnns_description; ?></textarea>
		</label>
		<input type="hidden" value="<?php echo wp_create_nonce('ptnns-description-tag-nonce'); ?>" id="ptnns-description-tag-nonce" name="ptnns-description-tag-nonce">

		<?php
	}

} else {
	
	error_log('function: "ptnns_description_meta_box_content" already exists');
	
}

//custom metabox save
if(!function_exists('ptnns_save_description_meta_box')) {
	
	function ptnns_save_description_meta_box($ptnns_post_id_to_save) {
			
		if(!empty($_POST['ptnns-description-tag-nonce']) && wp_verify_nonce($_POST['ptnns-description-tag-nonce'], 'ptnns-description-tag-nonce')) {
		
			if((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || (defined('DOING_AJAX') && DOING_AJAX) || (!current_user_can('edit_post', get_the_ID())) || (wp_is_post_revision( get_the_ID()) !== false)) return;
			
			if(!empty($_POST['ptnns-description'])) {
				
				$ptnns_description_meta_box = sanitize_text_field($_POST['ptnns-description']);
				update_post_meta($ptnns_post_id_to_save, '_ptnns_meta_description', $ptnns_description_meta_box);
				
			}
		
		}
			
	}
	
	add_action('save_post', 'ptnns_save_description_meta_box', 10, 3);
	
} else {
	
	error_log('function: "ptnns_save_description_meta_box" already exists');
	
}