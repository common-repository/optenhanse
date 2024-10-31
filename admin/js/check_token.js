jQuery(document).ready(function() {
	
	jQuery('#ptnns-activate-button').on('click', function(){
		
		//prevent user to leave activation process before ends
		window.onbeforeunload = function() {
			return "activation process is still running and will be ended if you leave this page."; 
		};
		
		//hide activation failed message if is shown
		jQuery('.ptnns-activation-failed-message').css('display','none');
	
		//show activation in progress message
		jQuery('.ptnns-activation-in-progress-message').css('display','block');
		
		//hide activation button
		jQuery('#ptnns-activate-button').prop('disabled', true);	
		
		setTimeout(function() {
			
			ptnnsCheckTokenAjax();
			
		}, 2500);
		
	})
	
	function ptnnsCheckTokenAjax() {

		//get token value
		var ptnnsTokenValue = jQuery('#ptnns-license-token').val();
		
		if(ptnnsTokenValue.length !== 23) {
			
			//show activation in progress message
			jQuery('.ptnns-activation-in-progress-message').css('display','none');
			
			jQuery('.ptnns-activation-failed-message').css('display','block');
			
			setTimeout(function() {
			
				jQuery('#ptnns-activate-button').prop('disabled', false);
			
			}, 2500);			

			return;			
			
		}
		
		
		setTimeout(function() {

			jQuery.ajax({
				type: 'POST',
				dataType: 'json',
				url: ptnns_check_token_ajax_object.ptnns_check_token_ajax_url,
				data: {
					'action': 'ptnns_check_token',
					'ptnns_check_token_nonce': ptnns_check_token_ajax_object.ptnns_check_token_nonce,
					'ptnns_token_to_activate': ptnnsTokenValue,
					'ptnns_check_token_action': ptnns_check_token_ajax_object.ptnns_check_token_action,
				},
				
				//deal with success
				success:function(data){

					if(data === true) {
											
						//hide activation in progress message and display activation completed message
						jQuery('.ptnns-activation-in-progress-message').css('display','none');
						jQuery('.ptnns-activation-completed-message').css('display','block');
						jQuery('.ptnns-activation-warning').css('display','none');
					
					} else {
						
						//hide activation in progress message and display activation failed message
						jQuery('.ptnns-activation-in-progress-message').css('display','none');
						jQuery('.ptnns-activation-failed-message').css('display','block');
						
						setTimeout(function() {
						
							jQuery('#ptnns-activate-button').prop('disabled', false);
						
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