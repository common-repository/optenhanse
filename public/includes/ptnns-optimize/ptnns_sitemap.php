<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//build sitemap
if(!function_exists('ptnns_build_sitemap')) {
	
	function ptnns_build_sitemap() {
		
		global $ptnns_is_sitemap;
		global $ptnns_is_404;
		
		if($ptnns_is_404 === true && $ptnns_is_sitemap === true) {
			
			//change headers status
			status_header(200);
			
			//$ptnns_offset = get_option('gmt_offset');
	
			//print headers
			ob_clean();
			header("Content-type: text/xml");
			echo '<?xml version="1.0" encoding="UTF-8"?>'."\r\n";
			echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\r\n";				

			//deal with homepage
			$ptnns_site_url = get_home_url();
			//get last post modified
			$ptnns_modified = get_post_modified_time('Y-m-d\TH:i:sP', false, get_option('page_on_front'), false);

			//if WPML is installed and activated
			if(function_exists('icl_get_languages')) {
				
				$ptnns_get_languages = icl_get_languages('skip_missing=0');
				 
				//loop into languages
				foreach($ptnns_get_languages as $ptnns_language) {
				 
					//change language
					do_action('wpml_switch_language', $ptnns_language['code']); 
										
					//get site url by language
					$ptnns_site_url = apply_filters('wpml_home_url', $ptnns_site_url);

					//get front page id
					$ptnns_get_frontpage_id = get_option('page_on_front');
					//get blog page id
					$ptnns_get_blog_id = get_option('page_for_posts');		
					
					//include homepage
					echo '  <url>'."\r\n";
					echo '    <loc>'.$ptnns_site_url.'</loc>'."\r\n";
					//echo '    <lastmod>'.ptnns_modify_formatted($ptnns_modified,$ptnns_offset).'</lastmod>'."\r\n";
					echo '		<lastmod>'.$ptnns_modified.'</lastmod>'."\r\n";
					echo '    <changefreq>monthly</changefreq>'."\r\n";
					echo '    <priority>1</priority>'."\r\n";
					echo '  </url>'."\r\n";						
					 
					//deal with pages and exclude homepages (front page and blog)
					$ptnns_pages_arguments = array(
						 'posts_per_page' => -1,
						 'post_status' => 'publish',
						 'sort_column' => 'post_title',
						 'sort_order' => 'ASC',
						 'exclude' => $ptnns_get_frontpage_id, $ptnns_get_blog_id
					);
					
					$ptnns_pages = get_pages($ptnns_pages_arguments); 
					
					//deal with pages to print
					if($ptnns_pages) {
						
						foreach($ptnns_pages as $ptnns_page) {
							
							$ptnns_modified = get_post_modified_time('Y-m-d\TH:i:sP', false, $ptnns_page->ID, false);
							
							if(has_filter('wpml_post_language_details') !== false){
								
								$ptnns_current_post_lang_informations = apply_filters('wpml_post_language_details', NULL, $ptnns_page->ID);
								
								if(!empty($ptnns_current_post_lang_informations)) {
									
									$ptnns_current_post_lang_code = $ptnns_current_post_lang_informations['language_code'];
									do_action('wpml_switch_language', $ptnns_current_post_lang_code);
									
								}
								
							}					
							
							$ptnns_url_complete = get_permalink($ptnns_page->ID);
							
							echo '	<url>'."\r\n";
							echo '		<loc>'.$ptnns_url_complete.'</loc>'."\r\n";
							//echo '		<lastmod>'.ptnns_modify_formatted($ptnns_modified,$ptnns_offset).'</lastmod>'."\r\n";
							echo '		<lastmod>'.$ptnns_modified.'</lastmod>'."\r\n";
							echo '		<changefreq>monthly</changefreq>'."\r\n";
							echo '		<priority>0.5</priority>'."\r\n";
							echo '	</url>'."\r\n";
					
						}
						
					}	
					
					
				}
				
			//if WPML is not installed and activated
			} else {
				
				//get front page id
				$ptnns_get_frontpage_id = get_option('page_on_front');
				//get blog page id
				$ptnns_get_blog_id = get_option('page_for_posts');		

				//include homepage
				echo '  <url>'."\r\n";
				echo '    <loc>'.$ptnns_site_url.'/</loc>'."\r\n";
				//echo '    <lastmod>'.ptnns_modify_formatted($ptnns_modified,$ptnns_offset).'</lastmod>'."\r\n";
				echo '		<lastmod>'.$ptnns_modified.'</lastmod>'."\r\n";
				echo '    <changefreq>monthly</changefreq>'."\r\n";
				echo '    <priority>1</priority>'."\r\n";
				echo '  </url>'."\r\n";		
				
				//deal with pages and exclude homepages (front page and blog)
				$ptnns_pages_arguments = array(
					 'posts_per_page' => -1,
					 'post_status' => 'publish',
					 'sort_column' => 'post_title',
					 'sort_order' => 'ASC',
					 'exclude' => $ptnns_get_frontpage_id, $ptnns_get_blog_id
				);
				
				$ptnns_pages = get_pages($ptnns_pages_arguments); 		

				//deal with pages to print
				if($ptnns_pages) {
					
					foreach($ptnns_pages as $ptnns_page) {

						$ptnns_modified = get_post_modified_time('Y-m-d\TH:i:sP', false, $ptnns_page->ID, false);
						
						if(has_filter('wpml_post_language_details') !== false){
							
							$ptnns_current_post_lang_informations = apply_filters('wpml_post_language_details', NULL, $ptnns_page->ID);
							
							if(!empty($ptnns_current_post_lang_informations)) {
								
								$ptnns_current_post_lang_code = $ptnns_current_post_lang_informations['language_code'];
								do_action('wpml_switch_language', $ptnns_current_post_lang_code);
								
							}
							
						}					
						
						$ptnns_url_complete = get_permalink($ptnns_page->ID);
						
						echo '	<url>'."\r\n";
						echo '		<loc>'.$ptnns_url_complete.'</loc>'."\r\n";
						//echo '		<lastmod>'.ptnns_modify_formatted($ptnns_modified,$ptnns_offset).'</lastmod>'."\r\n";
						echo '		<lastmod>'.$ptnns_modified.'</lastmod>'."\r\n";
						echo '		<changefreq>monthly</changefreq>'."\r\n";
						echo '		<priority>0.5</priority>'."\r\n";
						echo '	</url>'."\r\n";
				
					}
					
				}					
				
			}


			//deal with posts
			$ptnns_posts_arguments = array(
				'posts_per_page' => -1,
				'post_status' => 'publish',
			);
			
			$ptnns_posts = get_posts($ptnns_posts_arguments); 

			//deal with custom posts
			$ptnns_custom_posts_arguments = array(
				'public'   => true,
				'_builtin' => false
			);
			
			$ptnns_all_custom_post_types = get_post_types($ptnns_custom_posts_arguments); 
			$ptnns_excluded_post_types = array('elementor_library');
			
			$ptnns_custom_post_types = array_diff($ptnns_all_custom_post_types, $ptnns_excluded_post_types);

			//deal with posts to print	
			if($ptnns_posts) {
				
				foreach($ptnns_posts as $ptnns_post) {
					
					$ptnns_modified = get_post_modified_time('Y-m-d\TH:i:sP', false, $ptnns_page->ID, false);
					
					//if WPML is installed and activated
					if(has_filter('wpml_post_language_details') !== false){
						
						$ptnns_current_post_lang_informations = apply_filters('wpml_post_language_details', NULL, $ptnns_post->ID);
						
						if(!empty($ptnns_current_post_lang_informations)) {
							
							$ptnns_current_post_lang_code = $ptnns_current_post_lang_informations['language_code'];
							do_action('wpml_switch_language', $ptnns_current_post_lang_code);
							
						}
						
					}					
					
					$ptnns_url_complete = get_permalink($ptnns_post->ID);
					
					echo '  <url>'."\r\n";
					echo '		<loc>'.$ptnns_url_complete.'</loc>'."\r\n";
					//echo '		<lastmod>'.ptnns_modify_formatted($ptnns_modified,$ptnns_offset).'</lastmod>'."\r\n";
					echo '		<lastmod>'.$ptnns_modified.'</lastmod>'."\r\n";
					echo '		<changefreq>weekly</changefreq>'."\r\n";
					echo '		<priority>0.5</priority>'."\r\n";
					echo '  </url>'."\r\n";
				
				}
				
			}

			//deal with custom posts to print
			if($ptnns_custom_post_types) {
				
				foreach($ptnns_custom_post_types  as $ptnns_custom_post_type) {
					
					$ptnns_custom_posts_arguments = array(
						'post_type' => $ptnns_custom_post_type,
						'posts_per_page' => -1,
						'post_status' => 'publish',
					);
					
					$ptnns_custom_posts = get_posts($ptnns_custom_posts_arguments);
					foreach ($ptnns_custom_posts as $ptnns_custom_post) {

						$ptnns_modified = get_post_modified_time('Y-m-d\TH:i:sP', false, $ptnns_page->ID, false);
											
						//if WPML is installed and activated
						if(has_filter('wpml_post_language_details') !== false){
							
							$ptnns_current_post_lang_informations = apply_filters('wpml_post_language_details', NULL, $ptnns_custom_post->ID);
							
							if(!empty($ptnns_current_post_lang_informations)) {
								
								$ptnns_current_post_lang_code = $ptnns_current_post_lang_informations['language_code'];
								do_action('wpml_switch_language', $ptnns_current_post_lang_code);
								
							}
							
						}

						$ptnns_url_complete = get_permalink($ptnns_custom_post->ID);
							
						echo '  <url>'."\r\n";
						echo '		<loc>'.$ptnns_url_complete.'</loc>'."\r\n";
						//echo '		<lastmod>'.ptnns_modify_formatted($ptnns_modified,$ptnns_offset).'</lastmod>'."\r\n";
						echo '		<lastmod>'.$ptnns_modified.'</lastmod>'."\r\n";
						echo '		<changefreq>weekly</changefreq>'."\r\n";
						echo '		<priority>0.5</priority>'."\r\n";
						echo '	</url>'."\r\n";	
		
					}
					
				}
				
			}

			//print closing tag
			echo '</urlset>';
			die;
			
		}
	
	}
	
	add_action('template_redirect', 'ptnns_build_sitemap');
	
} else {
	
	error_log('function: "ptnns_build_sitemap" already exists');
	
}




//add sitemap link to robots.txt
if(!function_exists('ptnns_add_sitemap_to_robot')) {

	function ptnns_add_sitemap_to_robot($ptnns_current_robots_content) {
		
		$ptnns_current_robots_content .= "\r\n"."sitemap: ".site_url()."/sitemap.xml";
		return $ptnns_current_robots_content;
		
		}
		
	add_filter('robots_txt', 'ptnns_add_sitemap_to_robot');
		
} else {
	
	error_log('function: "ptnns_add_sitemap_to_robot" already exists');
	
}