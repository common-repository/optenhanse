jQuery(document).ready(function() {
	
	//prevent user to leave smtp test process before ends
	window.onbeforeunload = function() {
		return "meta rebuilding process is still running and will be ended if you leave this page."; 
	};
	
	//lock smtp test switch
	jQuery('#ptnns-smtp-test').attr('disabled', true);
	
	//show progress message
	jQuery('.ptnns-test-in-progress-message').css('display','inline');

    jQuery.ajax({
		type: 'POST',
		dataType: 'json',
        url: ptnns_smtp_test_ajax_object.ptnns_smtp_test_ajax_url,
		data: {
			'action': 'ptnns_smtp_do_test',
			'ptnns_smtp_test_nonce': ptnns_smtp_test_ajax_object.ptnns_smtp_test_nonce
		},
        
		//deal with success
		success:function(data){
			
			//console.log(data)
			
			if(data === true) {

				//display positive results messages
				jQuery('.ptnns-test-in-progress-message').css('display','none');
				jQuery('.ptnns-test-completed-message').css('display','inline');											
				
			}
			
			else if(data === false) {

				//display negative results messages
				jQuery('.ptnns-test-in-progress-message').css('display','none');
				jQuery('.ptnns-test-failed-message').css('display','inline');					
				
				
			}
				

			//unset onbeforeunload
			window.onbeforeunload = null;
			
			//unlock
			jQuery('#ptnns-smtp-test').attr('disabled', false);	
        							
		},
		
        error: function(errorThrown){
			
            console.log(errorThrown);
			
        },
		
		//deal with complete
		complete: function() {},
		//one hour timeout
		timeout: 360000,
	}); 
		              
});