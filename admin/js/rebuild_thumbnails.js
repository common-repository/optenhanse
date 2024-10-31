jQuery(document).ready(function() {
	
	//show calculating message
	jQuery('.ptnns-rebuild-calculating-message').css('display','inline');
	
    //function to call for ids array
	jQuery.ajax({
		type: 'POST',
		dataType: 'json',
        url: ptnns_rebuild_thumbnails_ajax_object.ptnns_rebuild_thumbnails_ajax_url,
		data: {
			'action': 'ptnns_rebuild_and_resize_images',
			'ptnns_rebuild_thumbnails_compression': ptnns_rebuild_thumbnails_ajax_object.ptnns_current_jpeg_quality,
			'ptnns_rebuild_thumbnails_nonce': ptnns_rebuild_thumbnails_ajax_object.ptnns_rebuild_thumbnails_nonce
		},
        
		//deal with success
		success:function(data){		
					
			//hide rebuild checkbox and display image
			jQuery('#ptnns-rebuild-thumbnails').attr('disabled', true);
			
			//prevent user to leave thumbnails rebuild process before ends//
			window.onbeforeunload = function() {
				return "Thumbnails rebuilding process is still running and will be ended if you leave this page."; 
			};			
			
			var ptnnsImagesToWorkWidth = data[0];
			var ptnnsImagesResizeWidth = data[1];
			var ptnnsImagesResizeHeight = data[2];
			var ptnnsImagesOrientation = data[3];
			
			var ptnnsImagesToWorkWidthLenght = ptnnsImagesToWorkWidth.length;
			
			//console.log(data)
			console.log(ptnnsImagesToWorkWidthLenght+' images to work with')
			
			//treat no image case
			if(ptnnsImagesToWorkWidthLenght == 0) {
				
				//display no thumbnails message
				jQuery('.ptnns-rebuild-no-entry-message').css('display','inline');					
				//hide other messages
				jQuery('.ptnns-rebuild-in-progress-message').css('display','none');
				jQuery('.ptnns-rebuild-calculating-message').css('display','none');
				//reactivate checkbox
				jQuery('#ptnns-rebuild-thumbnails').attr('disabled', false);
				//unset onbeforeunload
				window.onbeforeunload = null;
				
			} else {
				
				//define a viariable to count lopps
				var ptnnsImagesRebuilt = 0;				
				var ptnnsInvolvedImageId = ptnnsImagesToWorkWidth[ptnnsImagesRebuilt];
				var ptnnsInvolvedImageOrientation = ptnnsImagesOrientation[ptnnsImagesRebuilt];
				
				function ptnnsRebuildThumbnail(ptnnsInvolvedImageId,ptnnsImagesResizeWidth,ptnnsImagesResizeHeight,ptnnsInvolvedImageOrientation,ptnnsImagesOrientation,ptnnsImagesRebuilt,ptnnsImagesToWorkWidth) {
								
					//console.log('orientation: '+ptnnsInvolvedImageOrientation)
								
					jQuery.ajax({
						type: 'POST',
						dataType: 'json',
						url: ptnns_rebuild_thumbnails_ajax_object.ptnns_rebuild_thumbnails_ajax_url,
						data: {
							'action': 'ptnns_rebuild_and_resize_images',
							'ptnns_rebuild_thumbnails_id': ptnnsInvolvedImageId,
							'ptnns_rebuild_thumbnails_compression': ptnns_rebuild_thumbnails_ajax_object.ptnns_current_jpeg_quality,							
							'ptnns_rebuild_thumbnails_width': ptnnsImagesResizeWidth,
							'ptnns_rebuild_thumbnails_height': ptnnsImagesResizeHeight,
							'ptnns_rebuild_thumbnails_orientation': ptnnsInvolvedImageOrientation,
							'ptnns_rebuild_thumbnails_nonce': ptnns_rebuild_thumbnails_ajax_object.ptnns_rebuild_thumbnails_nonce
						},
						
						//deal with success
						success:function(data) {
														
							ptnnsImagesRebuilt++;
							
							console.log(ptnnsImagesRebuilt+') '+data)
							
							//check if job is complete
							if(ptnnsImagesRebuilt == ptnnsImagesToWorkWidthLenght) {
								
								//display message of completed job
								jQuery('.ptnns-rebuild-completed-message').css('display','inline');
								//hide other messages
								jQuery('.ptnns-rebuild-in-progress-message').css('display','none');
								jQuery('.ptnns-rebuild-in-progress-step').css('display','none');
								jQuery('.ptnns-rebuild-calculating-message').css('display','none');
								//reactivate checkbox
								jQuery('#ptnns-rebuild-thumbnails').attr('disabled', false);
								//unset onbeforeunload
								window.onbeforeunload = null;
								
							} else {
								
								//display message of current conversion
								//console.log(data)
								
								jQuery('.ptnns-rebuild-in-progress-message').css('display','inline');
								jQuery('.ptnns-rebuild-in-progress-step').css('display','inline');
								//display step
								jQuery('.ptnns-rebuild-in-progress-step').html(' '+ptnnsImagesRebuilt+' ('+ptnnsImagesToWorkWidthLenght+')');
								//hide other messages
								jQuery('.ptnns-rebuild-calculating-message').css('display','none');
								
								if(ptnnsImagesRebuilt < ptnnsImagesToWorkWidthLenght) {
									ptnnsInvolvedImageId = ptnnsImagesToWorkWidth[ptnnsImagesRebuilt];
									ptnnsInvolvedImageOrientation = ptnnsImagesOrientation[ptnnsImagesRebuilt];
									
									setTimeout(function() {
										ptnnsRebuildThumbnail(ptnnsInvolvedImageId,ptnnsImagesResizeWidth,ptnnsImagesResizeHeight,ptnnsInvolvedImageOrientation,ptnnsImagesOrientation,ptnnsImagesRebuilt,ptnnsImagesToWorkWidth);
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
									
				ptnnsRebuildThumbnail(ptnnsInvolvedImageId,ptnnsImagesResizeWidth,ptnnsImagesResizeHeight,ptnnsInvolvedImageOrientation,ptnnsImagesOrientation,ptnnsImagesRebuilt,ptnnsImagesToWorkWidth);
				
			}
        							
		},
		
        error: function(errorThrown){
            console.log(errorThrown);
        }
		
    });  
              
});