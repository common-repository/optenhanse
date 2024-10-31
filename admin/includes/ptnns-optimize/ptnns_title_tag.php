<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//add title metabox to post, page and public custom post types
if(!function_exists('ptnns_title_meta_box')) {
	
	function ptnns_title_meta_box() {
					
		//show post meta for all kinds of post
		$ptnns_all_post_types = get_post_types(array('public' => true));
		
		add_meta_box( 
		'ptnns-title', 
		__('Title','ptnnslang'), 
		'ptnns_title_meta_box_content', 
		$ptnns_all_post_types,
		'side',
		'high'
		);
		
	}
	
	add_action('add_meta_boxes', 'ptnns_title_meta_box');
	
} else {
	
	error_log('function: "ptnns_title_meta_box" already exists');
	
}

//custom metabox callback
if(!function_exists('ptnns_title_meta_box_content')) {
	
	function ptnns_title_meta_box_content($ptnns_post_object) {
		
		if(!get_the_ID()) return;
		
		$ptnns_title = esc_attr(get_post_meta(get_the_ID(), '_ptnns_meta_title', true));
		$ptnns_title_blogname = esc_attr(get_post_meta(get_the_ID(), '_ptnns_meta_title_blogname', true));
		
		if(isset($ptnns_title_blogname) && $ptnns_title_blogname === '0') {
			
			$ptnns_title_blogname_checked = null;
			
		} else {
			
			$ptnns_title_blogname_checked = 'checked';
			
		}		
		
		$ptnns_blog_name = get_bloginfo('name');
		
		?>

		<label for="ptnns-title"><?php echo __('These 70 chars represent the content of your title tag','ptnnslang'); ?><br><br>
		<textarea id="ptnns-title" name="ptnns-title" class="ptnns-title" rows="3" maxlength="70"><?php echo $ptnns_title; ?></textarea>
		</label>
		
		<?php
		if(!empty($ptnns_blog_name)) {
			?>
			<br><br>
			<?php echo __('Add','ptnnslang'); ?>  <?php echo '"<strong>'.$ptnns_blog_name.'</strong>"'; ?> <?php echo __('to the title','ptnnslang'); ?> <?php echo __('so that your page title becames','ptnnslang'); ?>: <em>"<?php echo __('your title','ptnnslang'); ?></em> | <em><?php echo __('your sitename','ptnnslang'); ?>"</em> <br><br>
			<input type="checkbox" name="ptnns-title-blogname" class="ptnns-switch" id="ptnns-title-blogname-checkbox" value="1" <?php echo $ptnns_title_blogname_checked; ?> />
			<label for="ptnns-title-blogname-checkbox">&nbsp;</label>			
			
			<?php
		}
		?>

		<input type="hidden" value="<?php echo wp_create_nonce('ptnns-title-tag-nonce'); ?>" id="ptnns-title-tag-nonce" name="ptnns-title-tag-nonce">

		<?php
	}

} else {
	
	error_log('function: "ptnns_title_meta_box_content" already exists');
	
}

//custom metabox save
if(!function_exists('ptnns_save_title_meta_box')) {
		
	function ptnns_save_title_meta_box($ptnns_post_id_to_save) {
				
		if(!empty($_POST['ptnns-title-tag-nonce']) && wp_verify_nonce($_POST['ptnns-title-tag-nonce'], 'ptnns-title-tag-nonce')) {
		
			if((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || (defined('DOING_AJAX') && DOING_AJAX) || (!current_user_can('edit_post', get_the_ID())) || (wp_is_post_revision( get_the_ID()) !== false)) return;	
			
			if(!empty($_POST['ptnns-title'])) {
						
				$ptnns_title_meta_box = sanitize_text_field($_POST['ptnns-title']);
				update_post_meta($ptnns_post_id_to_save, '_ptnns_meta_title', $ptnns_title_meta_box);
				
			} else {
				
				delete_post_meta($ptnns_post_id_to_save, '_ptnns_meta_title');
				
			}
			
			if(!empty($_POST['ptnns-title-blogname'])) {
			
				update_post_meta($ptnns_post_id_to_save, '_ptnns_meta_title_blogname', '1');
				
			} else {
				
				update_post_meta($ptnns_post_id_to_save, '_ptnns_meta_title_blogname', '0');
			}
			
		}
			
	}
	
	add_action('save_post', 'ptnns_save_title_meta_box', 10, 3);
	
} else {
	
	error_log('function: "ptnns_save_title_meta_box" already exists');
	
}


 /*
//add custom column to every post type
if(!function_exists('ptnns_decription_post_column_header')) {
	
	function ptnns_decription_post_column_header($ptnns_default_wp_columns) {
		
		//keep this condition to hide column only on some post types
		$ptnns_excluded_post_types = array('elementor_library');
		global $current_screen;
		
		if(!in_array($current_screen->post_type,$ptnns_excluded_post_types)) {
			
			$ptnns_default_wp_columns['pttns_has_title'] = __('Meta title','ptnnslang');
			
		}
		
		return $ptnns_default_wp_columns;
		
	}
	
	add_filter('manage_posts_columns', 'ptnns_decription_post_column_header');
	
} else {
	
	error_log('function: "ptnns_decription_post_column_header" already exists');
	
}

//add custom column to page
if(!function_exists('ptnns_decription_page_column_header')) {
	
	function ptnns_decription_page_column_header($ptnns_default_wp_columns) {
		
		$ptnns_decription_page_column_header = array(
			'pttns_has_title' => __('Meta title','ptnnslang')
		);
		$ptnns_all_page_columns = array_merge($ptnns_default_wp_columns, $ptnns_decription_page_column_header);

		return $ptnns_all_page_columns;
		
	}
	
	add_filter('manage_pages_columns', 'ptnns_decription_page_column_header');

} else {
	
	error_log('function: "ptnns_decription_page_column_header" already exists');
	
}


//deal with custom column content
if(!function_exists('ptnns_decription_postand_page_column_content')) {
	
function ptnns_decription_postand_page_column_content($column_name, $post_ID) {
	
		if ($column_name === 'pttns_has_title') {
			
			$ptnns_title = esc_attr(get_post_meta($post_ID, '_ptnns_meta_title', true));
			
			//backward compatibility with previous version of Optenhance plugin
			if(empty($ptnns_title)) {
				
				$ptnns_title = esc_html(get_post_meta(get_the_ID(), '_optenhance_title', true));
			}	
			
			if(!empty($ptnns_title)) {
				
				echo $ptnns_title;
				
			}

		}
		
	}
	
	add_action('manage_posts_custom_column', 'ptnns_decription_postand_page_column_content', 10, 2);
	add_action('manage_pages_custom_column', 'ptnns_decription_postand_page_column_content', 10, 2);

} else {
	
	error_log('function: "ptnns_decription_postand_page_column_content" already exists');
	
}
*/