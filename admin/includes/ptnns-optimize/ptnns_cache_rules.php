<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');


if(!function_exists('ptnns_cache_htaccess')) {
	
	function ptnns_cache_htaccess($ptnns_htaccess_rules) {
		
		$ptnns_optimize_options_array = get_option('_ptnns_optimize');
		$ptnns_media_cache_expiration = $ptnns_optimize_options_array['media_cache'];
		$ptnns_script_cache_expiration = $ptnns_optimize_options_array['script_cache'];
		$ptnns_code_cache_expiration = $ptnns_optimize_options_array['code_cache'];
			
		$ptnns_htaccess_cache_rule = '
			# BEGIN Optenhanse CACHE
			
				<IfModule mod_deflate.c>
					AddOutputFilterByType DEFLATE application/javascript
					AddOutputFilterByType DEFLATE application/rss+xml
					AddOutputFilterByType DEFLATE application/vnd.ms-fontobject
					AddOutputFilterByType DEFLATE application/x-font
					AddOutputFilterByType DEFLATE application/x-font-opentype
					AddOutputFilterByType DEFLATE application/x-font-otf
					AddOutputFilterByType DEFLATE application/x-font-truetype
					AddOutputFilterByType DEFLATE application/x-font-ttf
					AddOutputFilterByType DEFLATE application/x-javascript
					AddOutputFilterByType DEFLATE application/xhtml+xml
					AddOutputFilterByType DEFLATE application/xml
					AddOutputFilterByType DEFLATE font/opentype
					AddOutputFilterByType DEFLATE font/otf
					AddOutputFilterByType DEFLATE font/ttf
					AddOutputFilterByType DEFLATE image/svg+xml
					AddOutputFilterByType DEFLATE image/x-icon
					AddOutputFilterByType DEFLATE text/css
					AddOutputFilterByType DEFLATE text/html
					AddOutputFilterByType DEFLATE text/javascript
					AddOutputFilterByType DEFLATE text/plain
					AddOutputFilterByType DEFLATE text/xml
				</IfModule>
				
				<IfModule mod_expires.c>
					ExpiresActive On
					ExpiresDefault A3600		
					<FilesMatch "\.(ico|flv|jpg|jpeg|png|gif|svg|tif|tiff|bmp|webp|swf|mp3|mp4|m4v|mov|avi|wmv|wav|ogg|webm|aac)$">
						ExpiresDefault A'.$ptnns_media_cache_expiration.'
					</FilesMatch>
					<FilesMatch "\.(js|css|woff|woff2|ttf|otf|eot)$">
						ExpiresDefault A'.$ptnns_script_cache_expiration.'
					</FilesMatch>
					<FilesMatch "\.(html|htm|xml|txt|xsl|pdf|ppt|doc)$">
						ExpiresDefault A'.$ptnns_code_cache_expiration.'
					</FilesMatch>
				</IfModule>
			
				<IfModule mod_headers.c>
					Header set Cache-Control "max-age=3600, public, no-transform, must-revalidate"
					<FilesMatch "\.(ico|flv|jpg|jpeg|png|gif|svg|tif|tiff|bmp|webp|swf|mp3|mp4|m4v|mov|avi|wmv|wav|ogg|webm|aac)$">
						Header set Cache-Control "max-age='.$ptnns_media_cache_expiration.', public"
					</FilesMatch>
					<FilesMatch "\.(js|css|woff|woff2|ttf|otf|eot)$">
						Header set Cache-Control "max-age='.$ptnns_script_cache_expiration.', public"
					</FilesMatch>	
					<FilesMatch "\.(html|htm|xml|txt|xsl|pdf|ppt|doc)$">
						Header set Cache-Control "max-age='.$ptnns_code_cache_expiration.', public"
					</FilesMatch>					
				</IfModule>
			
			# END Optenhanse CACHE'."\r\n";

		return $ptnns_htaccess_rules . $ptnns_htaccess_cache_rule;

	}
	
} else {
	
	error_log('function: "ptnns_cache_htaccess" already exists');
	
}

if(!function_exists('ptnns_cache_htaccess_filter')) {
	
	function ptnns_cache_htaccess_filter() {
		
		add_filter('mod_rewrite_rules', 'ptnns_cache_htaccess');

	}
	
} else {
	
	error_log('function: "ptnns_cache_htaccess_filter" already exists');
	
}