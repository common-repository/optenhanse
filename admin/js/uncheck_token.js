jQuery(document).ready(function() {
	
	jQuery('#ptnns-deactivate-button').on('click', function(){
		
		//prevent user to leave deactivation process before ends
		window.onbeforeunload = function() {
			return "deactivation process is still running and will be ended if you leave this page."; 
		};
		
		//hide deactivation failed message if is shown
		jQuery('.ptnns-deactivation-failed-message').css('display','none');
	
		//show deactivation in progress message
		jQuery('.ptnns-deactivation-in-progress-message').css('display','block');
		
		//hide deactivation button
		jQuery('#ptnns-deactivate-button').prop('disabled', true);	
		
		setTimeout(function() {
			
			ptnnsCheckTokenAjax();
			
		}, 2500);
		
	})
	
	function ptnnsCheckTokenAjax() {

		//get token value
		var ptnnsTokenValue = jQuery('#ptnns-license-token').val();
		
		if(ptnnsTokenValue.length !== 23) {
			
			//show deactivation in progress message
			jQuery('.ptnns-deactivation-in-progress-message').css('display','none');
			
			jQuery('.ptnns-deactivation-failed-message').css('display','block');
			
			setTimeout(function() {
			
				jQuery('#ptnns-deactivate-button').prop('disabled', false);
			
			}, 2500);			

			return;			
			
		}
		
		
		setTimeout(function() {

			jQuery.ajax({
				type: 'POST',
				dataType: 'json',
				url: ptnns_uncheck_token_ajax_object.ptnns_uncheck_token_ajax_url,
				data: {
					'action': 'ptnns_uncheck_token',
					'ptnns_uncheck_token_nonce': ptnns_uncheck_token_ajax_object.ptnns_uncheck_token_nonce,
					'ptnns_token_to_deactivate': ptnnsTokenValue,
					'ptnns_uncheck_token_action': ptnns_uncheck_token_ajax_object.ptnns_uncheck_token_action,
				},
				
				//deal with success
				success:function(data){

					if(data === true) {
						
						//hide deactivation in progress message and display deactivation completed message
						jQuery('.ptnns-deactivation-in-progress-message').css('display','none');
						jQuery('.ptnns-deactivation-completed-message').css('display','block');
						jQuery('.ptnns-deactivation-warning').css('display','block');
					
					} else {
						
						//hide deactivation in progress message and display deactivation failed message
						jQuery('.ptnns-deactivation-in-progress-message').css('display','none');
						jQuery('.ptnns-deactivation-failed-message').css('display','block');
						
						setTimeout(function() {
						
							jQuery('#ptnns-deactivate-button').prop('disabled', false);
						
						}, 2500);
						
						console.log(data);
						
					}
					
											
				},
				
				error: function(errorThrown){
					
					console.log(errorThrown);
					
				}
			}); 

		}, 2500);
		
		
		//unset onbeforeunload
		window.onbeforeunload = null;

	
	}
              
});