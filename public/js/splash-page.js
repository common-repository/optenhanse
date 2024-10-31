jQuery(document).ready(function() {
	
	jQuery("#ptnns-login-form-expander").on("click", function() {
		
		if(jQuery("#ptnns-login-form-expander").hasClass("ptnns-login-form-expanded")) {
			
			jQuery("#ptnns-login-form-expander").removeClass("ptnns-login-form-expanded");
			jQuery("#ptnns-login-form-expander").addClass("ptnns-login-form-retired");
		
			jQuery(function () {
				
				jQuery(".ptnns-login-form-expander").animate({left: "-=250px"}, { duration: 400, queue: false } );
				jQuery(".ptnns-login-form-container").animate({left: "-=250px"}, { duration: 400, queue: false } );
				
			});
				
		} else {
				
			jQuery("#ptnns-login-form-expander").removeClass("ptnns-login-form-retired");
			jQuery("#ptnns-login-form-expander").addClass("ptnns-login-form-expanded");
				
			jQuery(function () {
					
				jQuery(".ptnns-login-form-expander").animate({left: "+=250px"}, { duration: 400, queue: false } );
				jQuery(".ptnns-login-form-container").animate({left: "+=250px"}, { duration: 400, queue: false } );
				
			});	
				
		}
			
	});
	
    jQuery('form#ptnns-login-form').on('submit', function(e){
		
		//display login error, if hidden
		jQuery(".ptnns-display-error").css('display','block');
		
		//hide errors after five seconds
		jQuery(".ptnns-display-error").delay(5000).fadeOut(500);
		
		//display courtesy message
        jQuery('.ptnns-display-error').text(ptnns_ajax_object.ptnns_loading_message);
				
		jQuery.ajax({
			
            type: 'POST',
            dataType: 'json',
            url: ptnns_ajax_object.ptnns_ajaxurl,
            data: { 
                'action': 'ptnns_login_ajax',
                'ptnns-login-user-input': jQuery('form#ptnns-login-form #ptnns-login-user-input').val(), 
                'ptnns-login-password-input': jQuery('form#ptnns-login-form #ptnns-login-password-input').val(), 
                'ptnns_login_form_nonce': jQuery('form#ptnns-login-form #ptnns-login-form-nonce').val() 
				},
            success: function(data){
                jQuery('.ptnns-display-error').html(data.ptnns_login_message);
                if (data.ptnns_login_result == true){
                    document.location.href = ptnns_ajax_object.ptnns_redirect_url;
                }
            }
			
        });

        e.preventDefault();
    });		
		
});