jQuery(document).ready(function() {
	
	//show calculating message
	jQuery('.ptnns-rebuild-calculating-message').css('display','inline');
	
    jQuery.ajax({
		type: 'POST',
		dataType: 'json',
        url: ptnns_rebuild_meta_ajax_object.ptnns_rebuild_meta_ajax_url,
        //data: 'action=ptnns_rebuild_attachment_meta',
		data: {
			'action': 'ptnns_rebuild_attachment_meta',
			'ptnns_rebuild_meta_nonce': ptnns_rebuild_meta_ajax_object.ptnns_rebuild_meta_nonce
		},
        
		//deal with success
		success:function(data){
							
			//hide rebuild checkbox and display image
			jQuery('#ptnns-rebuild-meta').attr('disabled', true);
			
			//prevent user to leave meta rebuild process before ends//
			window.onbeforeunload = function() {
				return "meta rebuilding process is still running and will be ended if you leave this page."; 
			};

			//count involvedmeta
			var ptnnsInvolvedMeta = data;
			
			//count involvedmeta
			var ptnnsInvolvedMetaLength = (ptnnsInvolvedMeta.length);
			
			console.log(ptnnsInvolvedMetaLength+' images to work with')
			
			//treat no image case
			if(ptnnsInvolvedMetaLength == 0) {
				
				//display no meta message
				jQuery('.ptnns-rebuild-no-entry-message').css('display','inline');					
				//hide other messages
				jQuery('.ptnns-rebuild-in-progress-message').css('display','none');
				jQuery('.ptnns-rebuild-calculating-message').css('display','none');
				//reactivate checkbox
				jQuery('#ptnns-rebuild-meta').attr('disabled', false);
				//unset onbeforeunload
				window.onbeforeunload = null;
				
			} else {
				
				//define a viariable to count lopps
				var ptnnsMetaRebuilt = 0;
				var ptnnsInvolvedMetaId = ptnnsInvolvedMeta[ptnnsMetaRebuilt];

				function ptnnsRebuildmeta(ptnnsInvolvedMetaId) {
																		
					jQuery.ajax({
						type: 'POST',
						dataType: 'json',
						url: ptnns_rebuild_meta_ajax_object.ptnns_rebuild_meta_ajax_url,
						//data: 'action=ptnns_rebuild_attachment_meta&id='+ptnnsInvolvedMetaId,
						data: {
							'action': 'ptnns_rebuild_attachment_meta',
							'ptnns_rebuild_meta_id': ptnnsInvolvedMetaId,
							'ptnns_rebuild_meta_nonce': ptnns_rebuild_meta_ajax_object.ptnns_rebuild_meta_nonce
						},
						
						//deal with success
						success:function(data) {
										
							//register new rebuid completed
							ptnnsMetaRebuilt++;
							
							console.log(ptnnsMetaRebuilt+') '+data)
							
							//check if job is complete
							if(ptnnsMetaRebuilt == ptnnsInvolvedMetaLength) {
								
								//display message of completed job
								jQuery('.ptnns-rebuild-completed-message').css('display','inline');
								//hide other messages
								jQuery('.ptnns-rebuild-in-progress-message').css('display','none');
								jQuery('.ptnns-rebuild-in-progress-step').css('display','none');
								jQuery('.ptnns-rebuild-calculating-message').css('display','none');
								//reactivate checkbox
								jQuery('#ptnns-rebuild-meta').attr('disabled', false);
								//unset onbeforeunload
								window.onbeforeunload = null;
								
							} else {
								
								//display message of current conversion
								//console.log(data)
								jQuery('.ptnns-rebuild-in-progress-message').css('display','inline');
								jQuery('.ptnns-rebuild-in-progress-step').css('display','inline');
								//display step
								jQuery('.ptnns-rebuild-in-progress-step').html(' '+ptnnsMetaRebuilt+' ('+ptnnsInvolvedMetaLength+')');
								//hide other messages
								jQuery('.ptnns-rebuild-calculating-message').css('display','none');
								
								if(ptnnsMetaRebuilt < ptnnsInvolvedMetaLength) {
									ptnnsInvolvedMetaId = ptnnsInvolvedMeta[ptnnsMetaRebuilt];
									
									setTimeout(function() {
										ptnnsRebuildmeta(ptnnsInvolvedMetaId);
									}, 250);									
								
								}
								
								
							}

						},
						
						//deal with errors
						error: function(errorThrown){
							console.log(errorThrown);
						},
						
						//deal with complete
						complete: function() {},
						//one hour timeout
						timeout: 360000,
					}); 
				
				};
					
				ptnnsRebuildmeta(ptnnsInvolvedMetaId);
					
				
			}
        							
		},
		
        error: function(errorThrown){
            console.log(errorThrown);
        }
    });  
              
});