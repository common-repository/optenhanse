<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');


//build send headers
if(!function_exists('ptnns_splash_page_header')) {

    function ptnns_splash_page_header() {

        //go on only if user is not logged in and if ajax is not involved
        if(!wp_doing_ajax() && !wp_doing_cron() && !is_user_logged_in()) {

            //get enhance option
            global $ptnns_enhance_options_array;

            //display maintenance mode (header 503)
            if(!empty($ptnns_enhance_options_array['maintenance_mode'])) {

                $ptnns_maintenance_mode = $ptnns_enhance_options_array['maintenance_mode'];

                if($ptnns_maintenance_mode === '1' && !headers_sent()) {

                    header($_SERVER["SERVER_PROTOCOL"] . " 503 Service Temporarily Unavailable", true, 503);

                    //display retry after
                    if (!empty($ptnns_enhance_options_array['retry_after']) && is_numeric($ptnns_enhance_options_array['retry_after']) && $ptnns_enhance_options_array['retry_after'] !== '0') {

                        $ptnns_retry_after = $ptnns_enhance_options_array['retry_after'];
                        header('Retry-After: ' . $ptnns_retry_after);

                    }

                }

            }

        }
		
    }

    add_action('after_setup_theme', 'ptnns_splash_page_header');

} else {

    error_log('function: "ptnns_splash_page_header" already exists');

}

//public styles and scripts function
if(!function_exists('ptnns_register_splash_page_styles_and_scripts')){

	function ptnns_register_splash_page_styles_and_scripts() {

		wp_enqueue_style('optenhanse-splash-style', PTNNS_BASE_URL.'/public/css/splash-page.css');
		wp_enqueue_script('optenhanse-splash-script', PTNNS_BASE_URL.'/public/js/splash-page.js', array('jquery'), '', true );

		//ajax stuff
		wp_localize_script('optenhanse-splash-script', 'ptnns_ajax_object', array(
			'ptnns_ajaxurl' => admin_url('admin-ajax.php'),
			'ptnns_redirect_url' => admin_url(),
			'ptnns_loading_message' => __('Please wait','ptnnslang')
		));

	}

} else {

	error_log('function: "ptnns_register_splash_page_styles_and_scripts" already exists');

}


//build splash page content
if(!function_exists('ptnns_splash_page_content')) {

	function ptnns_splash_page_content() {

		//go on only if user is not logged in and if ajax is not involved
		if(!wp_doing_ajax() && !is_user_logged_in()) {

			//register splash styles and scripts
			add_action('wp_enqueue_scripts', 'ptnns_register_splash_page_styles_and_scripts');

			//get enhance option
			global $ptnns_enhance_options_array;

			//define if an image or a page content should be displayed
			if(!empty($ptnns_enhance_options_array['splash_type'])) {

				//display image
				if(esc_attr($ptnns_enhance_options_array['splash_type']) === 'splash_type_image') {

					$ptnns_splash_image_id = $ptnns_enhance_options_array['splash_image_id'];

					if(!empty($ptnns_splash_image_id) && is_numeric($ptnns_splash_image_id)) {

						//get media url by id
						$ptnns_splash_page_image_url = esc_url_raw(wp_get_attachment_url($ptnns_splash_image_id));

					}
				}

				//display page content
				elseif(esc_attr($ptnns_enhance_options_array['splash_type']) === 'splash_type_page') {

					$ptnns_splash_page_id = $ptnns_enhance_options_array['splash_page_id'];

					if(!empty($ptnns_splash_page_id) && is_numeric($ptnns_splash_page_id)) {

						//get post content
						$ptnns_splash_page_post_object = get_post($ptnns_splash_page_id);


					}

				}

			}

			?>
			<!DOCTYPE html>

			<html <?php language_attributes(); ?> >

				<head>
					
                    <meta charset="<?php bloginfo('charset'); ?>">
					<meta name="viewport" content="width=device-width, initial-scale=1">
					<link rel="profile" href="https://gmpg.org/xfn/11">

                    <?php
					//include jquery
					if(!function_exists('ptnns_add_jquery')) {

						function ptnns_add_jquery() {

							wp_enqueue_script('jquery');

						}

						add_action('wp_enqueue_scripts', 'ptnns_add_jquery');

					} else {

						error_log('function: "ptnns_add_jquery" already exists');

					}

					//call wp head functions
					wp_head();

					?>

				</head>

				<body>

					<div class="ptnns-form ptnns-login-form-container">

						<form method="post" id="ptnns-login-form" class="ptnns-login-form">

							<label for="ptnns-login-user-input"><?php echo __('Username or Email','ptnnslang'); ?>
								<br>
								<input type="text" value="" class="ptnns-input" id="ptnns-login-user-input" name="ptnns-login-user-input" placeholder="<?php echo __('Username or Email','ptnnslang'); ?>">
								<br>
							</label>

							<label for="ptnns-login-password-input"><?php echo __('Password','ptnnslang'); ?>
								<br>
								<input type="password" class="ptnns-input" id="ptnns-login-password-input" name="ptnns-login-password-input" placeholder="<?php echo __('Password','ptnnslang'); ?>">
								<br>
							</label>

							<input type="hidden" id="ptnns-login-form-nonce" name="ptnns-login-form-nonce" value="<?php echo wp_create_nonce('ptnns-login-form-nonce'); ?>">

							<input type="submit" name="ptnns-login-submit" value="<?php echo __('Login','ptnnslang'); ?>" class="button button-primary ptnns-login-button ptnns-input ptnns-button">

							<div id="ptnns-display-error" class="ptnns-display-error">

							</div>

						</form>

					</div>

					<div class="ptnns-login-form-expander ptnns-login-form-retired" id="ptnns-login-form-expander">

						<img src="<?php echo PTNNS_BASE_URL.'/public/images/login.png'; ?>" title="Optenhanse Login Icon" alt="Optenhanse Login Icon">

					</div>

					<?php


					if(!empty($ptnns_splash_page_post_object)) {

						$ptnns_splash_content_query = new WP_Query(array(

							//in order to include draft posts, don't use 'p' but 'post__in'
							'post__in' => array($ptnns_splash_page_post_object->ID),
							'posts_per_page' => 1,
							'post_type' => array('page'),
							'post_status' => 'any'

						));

						//if post is found, display content
						if ($ptnns_splash_content_query->have_posts()) {

							while ($ptnns_splash_content_query->have_posts()) {

								$ptnns_splash_content_query->the_post();
								the_content();

							}

						}


						wp_reset_postdata();

						}

					//call wp footer functions
					wp_footer();

					?>

					<style>
					<?php
					//get offline background image, if set
					if(!empty($ptnns_splash_page_image_url)) {
						?>
						body{background: url("<?php echo $ptnns_splash_page_image_url ?>") no-repeat center center fixed;
						-webkit-background-size: cover;
						-moz-background-size: cover;
						-o-background-size: cover;
						background-size: cover;
						min-height: 100vh;
						min-width: 100vw;
						overflow:hidden;
						padding:0;
						margin:0;
						}
						<?php
					}
					?>
					</style>

				</body>

			</html>

			<?php

			die();

		}
	}

	add_action('init', 'ptnns_splash_page_content');

} else {

	error_log('function: "ptnns_splash_page_content" already exists');

}