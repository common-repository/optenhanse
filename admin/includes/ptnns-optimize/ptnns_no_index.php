<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//add no index metabox to post, page and public custom post types
if(!function_exists('ptnns_no_index_meta_box')) {
	
	function ptnns_no_index_meta_box() {
					
		//show post meta for all kinds of post
		$ptnns_all_post_types = get_post_types(array('public' => true));
		
		add_meta_box( 
		'ptnns-no-index', 
		__('No Index','ptnnslang'), 
		'ptnns_no_index_meta_box_content', 
		$ptnns_all_post_types,
		'side',
		'high'
		);
		
	}
	
	add_action('add_meta_boxes', 'ptnns_no_index_meta_box');
	
} else {
	
	error_log('function: "ptnns_no_index_meta_box" already exists');
	
}

//custom metabox callback
if(!function_exists('ptnns_no_index_meta_box_content')) {
	
	function ptnns_no_index_meta_box_content($ptnns_post_object) {
		
		if(!get_the_ID()) return;
		
		$ptnns_no_index = esc_attr(get_post_meta(get_the_ID(), '_ptnns_no_index', true));
		
		if(!empty($ptnns_no_index) && $ptnns_no_index === '1') {
			
			$ptnns_no_index_checked = 'checked';
			
		} else {
			
			$ptnns_no_index_checked = null;
		}
		
		?>
		
		<?php echo __('Flag this checkbox if you want that add "noindex" meta to this page','ptnnslang'); ?><br><br>
		
		<input type="checkbox" name="ptnns-no-index" class="ptnns-switch" id="ptnns-no-index-checkbox" value="1" <?php echo $ptnns_no_index_checked; ?> />
		<label for="ptnns-no-index-checkbox">&nbsp;</label>
		<input type="hidden" value="<?php echo wp_create_nonce('ptnns-no-index-tag-nonce'); ?>" id="ptnns-no-index-tag-nonce" name="ptnns-no-index-tag-nonce">

		<?php
	}

} else {
	
	error_log('function: "ptnns_no_index_meta_box_content" already exists');
	
}

//custom metabox save
if(!function_exists('ptnns_save_no_index_meta_box')) {
	
	function ptnns_save_no_index_meta_box($ptnns_post_id_to_save) {
			
		if(!empty($_POST['ptnns-no-index-tag-nonce']) && wp_verify_nonce($_POST['ptnns-no-index-tag-nonce'], 'ptnns-no-index-tag-nonce')) {
		
			if((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || (defined('DOING_AJAX') && DOING_AJAX) || (!current_user_can('edit_post', get_the_ID())) || (wp_is_post_revision( get_the_ID()) !== false)) return;
			
			if(!empty($_POST['ptnns-no-index']) && $_POST['ptnns-no-index'] === '1') {
				
				$ptnns_no_index_meta_box = sanitize_text_field($_POST['ptnns-no-index']);
				update_post_meta($ptnns_post_id_to_save, '_ptnns_no_index', $ptnns_no_index_meta_box);
				
			} else {
				
				update_post_meta($ptnns_post_id_to_save, '_ptnns_no_index', '0');
				
			}
		
		}
			
	}
	
	add_action('save_post', 'ptnns_save_no_index_meta_box', 10, 3);
	
} else {
	
	error_log('function: "ptnns_save_no_index_meta_box" already exists');
	
}