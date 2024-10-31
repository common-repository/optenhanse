<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//define minification content
if(!function_exists('ptnns_html_minification_content')) {

		function ptnns_html_minification_content($ptnns_output_buffer) {	
			
			//treat elements to exclude from minification
			preg_match_all('#<textarea.*?>.*?<\/textarea>#is', $ptnns_output_buffer, $ptnns_textarea_content);
			preg_match_all('#<pre.*?>.*?<\/pre>#is', $ptnns_output_buffer, $ptnns_pre_content);
			preg_match_all('#<script.*?>.*?<\/script>#is', $ptnns_output_buffer, $ptnns_script_content);

			//treat textaera to exclude from minification
			$ptnns_output_buffer = str_replace($ptnns_textarea_content[0], array_map(function($ptnns_element) {
				return '<textarea>' . $ptnns_element . '</textarea>';
			}, 
			array_keys($ptnns_textarea_content[0])), $ptnns_output_buffer);

			//treat pre to exclude from minification 
			$ptnns_output_buffer = str_replace($ptnns_pre_content[0], array_map(function($ptnns_element) {
				return '<pre>' . $ptnns_element . '</pre>';
			}, array_keys($ptnns_pre_content[0])), $ptnns_output_buffer);

			//treat script to exclude from minification
			$ptnns_output_buffer = str_replace($ptnns_script_content[0], array_map(function($ptnns_element) {
				return '<script>' . $ptnns_element . '</script>';
			}, 
			array_keys($ptnns_script_content[0])), $ptnns_output_buffer);

			//minification search
			$ptnns_string_to_search = array(
				'/[ \n\t]+/m',			//clean tab e new line
				'/\>[^\S ]+/s', 		//strip whitespaces after tags, except space
				'/[^\S ]+\</s', 		//strip whitespaces before tags, except space
				'/(\s)+/s',     		//shorten multiple whitespace sequences
				'/<!--[^#](.*?)-->/s'	//remove HTML comments
			);

			//minification replace
			$ptnns_string_to_replace = array(
				' ',
				'>',
				'<',
				' ',
				''
			);

			//output buffer cleaned
			$ptnns_output_buffer = preg_replace($ptnns_string_to_search, $ptnns_string_to_replace, $ptnns_output_buffer);

			//reinject excluded textarea
			$ptnns_output_buffer = str_replace(array_map(function($ptnns_element) {
				return '<textarea>' . $ptnns_element . '</textarea>';
			}, 
			array_keys($ptnns_textarea_content[0])), $ptnns_textarea_content[0], $ptnns_output_buffer);

			//reinject excluded pre
			$ptnns_output_buffer = str_replace(array_map(function($ptnns_element) {
				return '<pre>' . $ptnns_element . '</pre>';
			}, 
			array_keys($ptnns_pre_content[0])), $ptnns_pre_content[0], $ptnns_output_buffer);

			//reinject excluded script
			$ptnns_output_buffer = str_replace(array_map(function($ptnns_element) {
				return '<script>' . $ptnns_element . '</script>';
			}, 
			array_keys($ptnns_script_content[0])), $ptnns_script_content[0], $ptnns_output_buffer);
			
			//return minified text
			return $ptnns_output_buffer;
			
			//thanks to http://www.callstack.in/tech/question/how-to-minify-html-without-touching-javascript-code-using-php-142
			//thanks to https://rstopup.com/minifying-final-de-la-salida-de-html-usando-expresiones-regulares-con-codeigniter.html		
	
		}
				
} else {
	
	error_log('function: "ptnns_html_minification_content" already exists');
	
}


if(!function_exists('ptnns_html_minification')) {

	function ptnns_html_minification() {
		
		ob_start('ptnns_html_minification_content');
		
	}
	
	add_action('get_header', 'ptnns_html_minification');

} else {
	
	error_log('function: "ptnns_html_minification" already exists');
	
}