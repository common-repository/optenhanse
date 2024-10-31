jQuery(document).ready(function() {
	
	/*pro features*/	
	jQuery('.ptnns-pro-feature th').append('<a href="https://www.optenhanse.com/" target="_blank" style="cursor:pointer;" title="Optenhanse.com" alt="Optenhanse.com"><img src="'+optenhanse_script.ptnns_base_url+'/admin/images/optenhanse_pro_feature.png" title="Optenhanse Pro" alt="Optenhanse Pro"></a>');
	jQuery('.ptnns-pro-feature td input:checkbox').attr('readonly', true);
	jQuery('.ptnns-pro-feature td input:checkbox').val('');
	jQuery('.ptnns-pro-feature td input:text').attr('readonly', true);
	jQuery('.ptnns-pro-feature td input:text').val('');
	//jQuery('.ptnns-pro-feature td select').attr('disabled', true);
	jQuery('.ptnns-pro-feature td').on('click', function() {
		
		jQuery('.ptnns-pro-feature td select').attr('disabled', true);
		jQuery('.ptnns-pro-feature-container').fadeIn('fast');
		jQuery('.ptnns-pro-feature-popup').fadeIn('fast');
		event.preventDefault()
		
	});	
	
	
	//hide pro popoup
	
	jQuery('#ptnns-hide-pro-popup, #ptnns-link-to-website').on('click', function(){
		
		jQuery('.ptnns-pro-feature td select').attr('disabled', false);
		jQuery('.ptnns-pro-feature-container').css('display','none');
		jQuery('.ptnns-pro-feature-popup').css('display','none');
		
	})
	
	
	jQuery('#ptnns-settings-form').css('display','block');
	
	/*auothide optin messages*/
	var ptnnsSettingErrorHeight = jQuery('#setting-error-ptnns-message').height();
	var ptnnsSettingInfoHeight = jQuery('#setting-error-ptnns-info').height();
	
	if(ptnnsSettingErrorHeight > 0) {
		jQuery('#setting-error-ptnns-message').delay(2000).fadeTo( 100 , 0, function() {
			jQuery('#setting-error-ptnns-message').slideUp( ptnnsSettingErrorHeight, function() {
				jQuery('#setting-error-ptnns-message').remove();
			});
		});
	} 
	
	if(ptnnsSettingInfoHeight > 0) {
		/*jQuery('#setting-error-ptnns-info').delay(5000).fadeTo( 100 , 0, function() {
			jQuery('#setting-error-ptnns-info').slideUp( ptnnsSettingInfoHeight, function() {
				jQuery('#setting-error-ptnns-info').remove();
			});
		});*/
	} 
	
	/*prevent user to change page with unsaved changes*/
 	ptnnsFormChange = false; 
	window.onbeforeunload = function() {

		if (ptnnsFormChange) {
			return "Your unsaved data will be lost."; 
		};
		
	};
 
	jQuery("#ptnns-save-optenhanse-options").click(function() {
		ptnnsFormChange = false;
	});

	jQuery("#ptnns-save-optimize-options").click(function() {
		ptnnsFormChange = false;
	});
	
	jQuery("#ptnns-save-enhance-options").click(function() {
		ptnnsFormChange = false;
	});
	
	jQuery("#ptnns-save-secure-options").click(function() {
		ptnnsFormChange = false;
	});
 
	jQuery("#ptnns-settings-form").change(function() {
		ptnnsFormChange = true;
	});
	
		
	/*display type detail only if splash type is checked*/
	function checkPtnnsSplashType() {
		
		if (jQuery('#ptnns-splash-type-image').prop('checked') && jQuery('#ptnns-splash-page').prop('checked')) {
			jQuery('.ptnns-splash-image').css('display','table-row')
			jQuery('.ptnns-splash-image-button').css('display','table-row')
			jQuery('.ptnns-splash-page-id').css('display','none')
		} 
		
		if (jQuery('#ptnns-splash-type-page').prop('checked') && jQuery('#ptnns-splash-page').prop('checked')) {
			jQuery('.ptnns-splash-image').css('display','none')
			jQuery('.ptnns-splash-image-button').css('display','none')
			jQuery('.ptnns-splash-page-id').css('display','table-row')
		} 
		
		if (jQuery('#ptnns-splash-type-image').prop('checked') == false && jQuery('#ptnns-splash-type-page').prop('checked') == false) {
			jQuery('.ptnns-splash-image').css('display','none')
			jQuery('.ptnns-splash-image-button').css('display','none')
			jQuery('.ptnns-splash-page-id').css('display','none')
		} 
		
	}

	/*display retry after only if maintenance mode is checked*/
	function checkPtnnsRetryAfter() {

		if (jQuery('#ptnns-splash-maintenance-mode').prop('checked') && jQuery('#ptnns-splash-page').prop('checked')) {
			jQuery('.ptnns-splash-retry-after').css('display','table-row')

		}

		if (jQuery('#ptnns-splash-maintenance-mode').prop('checked') == false && jQuery('#ptnns-splash-type-page').prop('checked') == false) {
			jQuery('.ptnns-splash-retry-after').css('display','none')
		}

	}
	
	/*display splash details content if splash page is checked*/
	function checkPtnnsSplashEnable() {
		
		if (jQuery('#ptnns-splash-page').prop('checked')) {
			jQuery('.ptnns-splash-type').css('display','table-row')
			jQuery('.ptnns-splash-image').css('display','table-row')
			jQuery('.ptnns-splash-image-button').css('display','table-row')
			jQuery('.ptnns-splash-page-id').css('display','table-row')
			jQuery('.ptnns-splash-login').css('display','table-row')
			jQuery('.ptnns-splash-maintenance-mode').css('display','table-row')
			if(jQuery('#ptnns-splash-maintenance-mode').prop('checked')) {
				jQuery('.ptnns-splash-retry-after').css('display','table-row')
			} else {
				jQuery('.ptnns-splash-retry-after').css('display','none')
			}

		} else {
			jQuery('.ptnns-splash-type').css('display','none')
			jQuery('.ptnns-splash-image').css('display','none')
			jQuery('.ptnns-splash-image-button').css('display','none')
			jQuery('.ptnns-splash-page-id').css('display','none')
			jQuery('.ptnns-splash-login').css('display','none')
			jQuery('.ptnns-splash-maintenance-mode').css('display','none')
			jQuery('.ptnns-splash-retry-after').css('display','none')
		}
		
	}	
	
	checkPtnnsSplashEnable();
	checkPtnnsSplashType();
	
	jQuery('#ptnns-splash-page').click(function() {
		
		checkPtnnsSplashEnable();
		checkPtnnsSplashType();
		
	});
	
	
	jQuery('#ptnns-splash-type-image, #ptnns-splash-type-page').click(function() {
		
		checkPtnnsSplashType();
		
	});

	jQuery('#ptnns-splash-maintenance-mode').click(function() {

		checkPtnnsRetryAfter();

	});
	
	
	
	//remove button
	if(jQuery('#ptnns-splash-image').val()) {
		
		jQuery('#ptnns-splash-image-remove-button').css('display','inline-block')
		
	}
	
	if(jQuery('#ptnns-alternative-social-image').val()) {
		
		jQuery('#ptnns-alternative-social-image-remove-button').css('display','inline-block')
		
	}
	
	jQuery('#ptnns-splash-image-remove-button').on('click', function() {
		
		jQuery('#ptnns-splash-image-id').val('');
		jQuery('#ptnns-splash-image').val('');
		
	});
	
	jQuery('#ptnns-alternative-social-image-remove-button').on('click', function() {
		
		jQuery('#ptnns-alternative-social-image-id').val('');
		jQuery('#ptnns-alternative-social-image').val('');
		
	});
	
	
	/*display page selection only if custom 404 is checked*/
	function checkPtnns404Enable() {
		
		if (jQuery('#ptnns-404-custom').prop('checked')) {
			jQuery('.ptnns-custom-404-id').css('display','table-row')
		} else {
			jQuery('.ptnns-custom-404-id').css('display','none')
		}
		
	}	
	
	checkPtnns404Enable();
	
	jQuery('#ptnns-404-custom').click(function() {
		
		checkPtnns404Enable();
		
	});
	
	





	/*display page selection only if custom 404 is checked*/
	function checkPtnnsImageTreating() {
		
		if (jQuery('#ptnns-image-treating').prop('checked')) {
			jQuery('.ptnns-image-size').css('display','table-row')
			jQuery('.ptnns-skip-gif').css('display','table-row')
			jQuery('.ptnns-jpeg-quality').css('display','table-row')
			jQuery('.ptnns-rebuild-thumbnails').css('display','table-row')			
			
		} else {
			jQuery('.ptnns-image-size').css('display','none')
			jQuery('.ptnns-skip-gif').css('display','none')
			jQuery('.ptnns-jpeg-quality').css('display','none')
			jQuery('.ptnns-rebuild-thumbnails').css('display','none')			
		}
		
	}	
	
	checkPtnnsImageTreating();
	
	jQuery('#ptnns-image-treating').click(function() {
		
		checkPtnnsImageTreating();
		
	});










	

	
	/*display alternative image only if one facebook open graph or twitter card is checked*/
	function checkPtnnsSocialhEnable() {
		
		if (jQuery('#ptnns-facebook-share').prop('checked') || jQuery('#ptnns-twitter-share').prop('checked')) {
			jQuery('.ptnns-alternative-social-image').css('display','table-row')
		} else {
			jQuery('.ptnns-alternative-social-image').css('display','none')
		}
		
	}	
	
	checkPtnnsSocialhEnable();
	
	jQuery('#ptnns-facebook-share, #ptnns-twitter-share').click(function() {
		
		checkPtnnsSocialhEnable();
		
	});
		
	/*display smtp setup only if smtp mail is checked*/
	function checkPtnnsSmtpEnable() {
		
		if (jQuery('#ptnns-smtp-mail').prop('checked')) {
			jQuery('.ptnns-smtp-encryption').css('display','table-row')
			jQuery('.ptnns-smtp-port').css('display','table-row')
			jQuery('.ptnns-smtp-server').css('display','table-row')
			jQuery('.ptnns-smtp-from-name').css('display','table-row')
			jQuery('.ptnns-smtp-from-address').css('display','table-row')
			jQuery('.ptnns-smtp-authentication').css('display','table-row')
			jQuery('.ptnns-smtp-test').css('display','table-row')
			jQuery('.ptnns-smtp-test-address').css('display','table-row')
			jQuery('.ptnns-smtp-test-address').css('display','none')
			if(jQuery('#ptnns-smtp-authentication-enabled').prop('checked')) {
				jQuery('.ptnns-smtp-authentication-address').css('display','table-row')
				jQuery('.ptnns-smtp-authentication-password').css('display','table-row')
			}
		} else {
			jQuery('.ptnns-smtp-encryption').css('display','none')
			jQuery('.ptnns-smtp-port').css('display','none')
			jQuery('.ptnns-smtp-server').css('display','none')
			jQuery('.ptnns-smtp-from-name').css('display','none')
			jQuery('.ptnns-smtp-from-address').css('display','none')
			jQuery('.ptnns-smtp-authentication').css('display','none')
			jQuery('.ptnns-smtp-authentication-address').css('display','none')
			jQuery('.ptnns-smtp-authentication-password').css('display','none')
			jQuery('.ptnns-smtp-test').css('display','none')
			jQuery('#ptnns-smtp-test').prop('checked', false)
			jQuery('.ptnns-smtp-test-address').css('display','none')
			jQuery('.ptnns-smtp-authentication-address').css('display','none')
			jQuery('.ptnns-smtp-authentication-password').css('display','none')
		}
		
	}	
	
	checkPtnnsSmtpEnable();
	
	jQuery('#ptnns-smtp-mail').click(function() {
		
		checkPtnnsSmtpEnable();
		
	});
	
	
	/*display smtp address and password only if authentication is enabled*/
	function checkPtnnsSmtpAuthenticationEnable() {
		
		if (jQuery('#ptnns-smtp-authentication-enabled').prop('checked')) {
			jQuery('.ptnns-smtp-authentication-address').css('display','table-row')
			jQuery('.ptnns-smtp-authentication-password').css('display','table-row')
		} 
		else if (jQuery('#ptnns-smtp-authentication-disabled').prop('checked')) {
			jQuery('.ptnns-smtp-authentication-address').css('display','none')
			jQuery('.ptnns-smtp-authentication-password').css('display','none')

		}
		
	}	
	
	checkPtnnsSmtpAuthenticationEnable();
	
	jQuery('#ptnns-smtp-authentication-enabled, #ptnns-smtp-authentication-disabled').click(function() {
		
		checkPtnnsSmtpAuthenticationEnable();
		
	});
	

	/*display smtp test address only if smtp test is checked*/
	function checkPtnnsSmtpTestEnable() {
		
		if (jQuery('#ptnns-smtp-test').prop('checked')) {
			jQuery('.ptnns-smtp-test-address').css('display','table-row')

		} else {
			jQuery('.ptnns-smtp-test-address').css('display','none')

		}
		
	}	
	
	checkPtnnsSmtpTestEnable();
	
	jQuery('#ptnns-smtp-test').click(function() {
		
		checkPtnnsSmtpTestEnable();
		
	});
	
	
	/*display cach expiring only if cache is checked*/
	function checkPtnnsCacheEnable() {
		
		if (jQuery('#ptnns-browser-cache').prop('checked')) {
			jQuery('.ptnns-media-cache').css('display','table-row')
			jQuery('.ptnns-script-cache').css('display','table-row')
			jQuery('.ptnns-code-cache').css('display','table-row')

		} else {
			jQuery('.ptnns-media-cache').css('display','none')
			jQuery('.ptnns-script-cache').css('display','none')
			jQuery('.ptnns-code-cache').css('display','none')

		}
		
	}	
	
	checkPtnnsCacheEnable();
	
	jQuery('#ptnns-browser-cache').click(function() {
		
		checkPtnnsCacheEnable();
		
	});
	
	
	/*display login monitor settings only if login monitor is checked*/
	function checkPtnnsLoginMonitor() {
		
		if (jQuery('#ptnns-check-login').prop('checked')) {
			jQuery('.ptnns-login-attempts').css('display','table-row')
			jQuery('.ptnns-login-investigation').css('display','table-row')
			jQuery('.ptnns-login-lock').css('display','table-row')
			jQuery('.ptnns-login-warn').css('display','table-row')
			jQuery('.ptnns-lock-user-notification').css('display','table-row')
			jQuery('.ptnns-ban-user-notification').css('display','table-row')
			jQuery('.ptnns-lock-down-message').css('display','table-row')
			jQuery('.ptnns-login-ban').css('display','table-row')
			if(jQuery('#ptnns-login-ban').val() !== '0') {
				jQuery('.ptnns-ban-message').css('display','table-row')
			}
		} else {
			jQuery('.ptnns-login-attempts').css('display','none')
			jQuery('.ptnns-login-investigation').css('display','none')
			jQuery('.ptnns-login-lock').css('display','none')
			jQuery('.ptnns-login-warn').css('display','none')
			jQuery('.ptnns-lock-user-notification').css('display','none')
			jQuery('.ptnns-ban-user-notification').css('display','none')
			jQuery('.ptnns-lock-down-message').css('display','none')
			jQuery('.ptnns-login-ban').css('display','none')
			jQuery('.ptnns-ban-message').css('display','none')
			jQuery('#ptnns-lock-user-notification').prop('checked', false);
			jQuery('#ptnns-ban-user-notification').prop('checked', false);
		}
		
	}	
	
	checkPtnnsLoginMonitor();
	
	jQuery('#ptnns-check-login').click(function() {
		
		checkPtnnsLoginMonitor();
		
	});	
	
	
	/*display login monitor settings only if login monitor is checked*/
	function checkPtnnsLoginBan() {
		
		if (jQuery('#ptnns-login-ban').val() === '0') {
			jQuery('.ptnns-ban-user-notification').css('display','none')
			jQuery('.ptnns-ban-message').css('display','none')
			jQuery('#ptnns-ban-user-notification').prop('checked', false);
		} else {
			jQuery('.ptnns-ban-user-notification').css('display','table-row')
			jQuery('.ptnns-ban-message').css('display','table-row')
		}
		
	}	
	
	jQuery('#ptnns-login-ban').on('change',function() {
		
		checkPtnnsLoginBan();
		
	});		
		

    /*media uploader*/
	var ptnnsMediaUploader;
	
    jQuery('#ptnns-alternative-social-image-button, #ptnns-splash-image-button').click(function(e) {
		
        e.preventDefault();
		
		if (this.id == 'ptnns-alternative-social-image-button') {
			
			var idToSaveImageUrl = '#ptnns-alternative-social-image';
			var idToSaveImageId = '#ptnns-alternative-social-image-id';
		
		}
		
		else if (this.id == 'ptnns-splash-image-button') {
			
			var idToSaveImageUrl = '#ptnns-splash-image';
			var idToSaveImageId = '#ptnns-splash-image-id';
		
		}

 
 if (ptnnsMediaUploader) {
            ptnnsMediaUploader.open();
            return;
        }
		
        ptnnsMediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false,
        });
		

       ptnnsMediaUploader.on('select', function() {
			
            attachment = ptnnsMediaUploader.state().get('selection').first().toJSON();
            jQuery(idToSaveImageUrl).val(attachment.url);
			jQuery(idToSaveImageId).val(attachment.id);
			
        });

        ptnnsMediaUploader.open();
    });
 
});