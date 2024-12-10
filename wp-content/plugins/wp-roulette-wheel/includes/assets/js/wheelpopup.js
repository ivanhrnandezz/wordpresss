/**
*
* JavaScript file that defines pop-up functions and handles pop-up triggers
*
*/

(function($){

	"use strict";

	$( document ).ready(function() {
		// First get if user has permission to spin. If not, don't display the pop-up. 

		// Create Permission Request
		let dataform = 'action=handlepermissionrequest';
		dataform += '&security='+wprw_display_settings.security;  // Add nonce security to request

		// Run Request to See if User Has Permission to Spin
		$.post(wprw_display_settings.ajaxurl, dataform, function(response){
			response = $.trim(response);
			// If user has permission, run triggers
			if (response === 'yes'){
				if (parseInt(wprw_display_settings.wprw_disable_popup_setting) === 0){
						// Preload Wheel Background Image
						$('<img/>').attr('src', wprw_display_settings.plugins_url + 'includes/assets/images/wheelbackgroundfinal.png').on('load', function() {
						$(this).remove(); // prevent memory leaks 
						$('.wprw-spinner').css('background-image','url('+wprw_display_settings.plugins_url + 'includes/assets/images/wheelbackgroundfinal.png'+')');
						runPopupTriggers();
					});
				}
			} else if (response === 'no'){
				// Do nothing
			}
		});


		function runPopupTriggers(){

			/**
			* Pop-Up Display Triggers
			*/

			// Checks if Page Load Trigger for Pop-Up is activated in Settings
		    const pageLoadTrigger = parseInt(wprw_display_settings.wprw_display_onpageload_setting);
		    if (pageLoadTrigger === 1){
		    	setTimeout(function(){
		    		wprwShowPopUp();
		 	   	}, 500);
		    }
		 
			// Check if Time Spent on Page Trigger (Timed PopUp)  is activated in Settings
			// Get User-specified Time Setting
			const timeSpentTrigger = parseInt(wprw_display_settings.wprw_time_spent_onpage_setting);
		    const timeSpentSetting = parseFloat(wprw_display_settings.wprw_time_spent_seconds_setting);
		    if (timeSpentTrigger === 1){
		    	setTimeout(function(){
		    		wprwShowPopUp();
		    	}, timeSpentSetting*1000);
		    }

		}


		/**
		* Hide the pop-up 
		*/

		// Hide directly when the user clicks the close button
		$('#wprw_close_button').on('click', function() {
	  		wprwHidePopUp();
	  	});
		// Confirm first, and then hide when the user clicks outside the pop-up area
		$('#wprw-popUpBg').on('click', function() {
			var close = confirm("Close?");
			if (close === true){
	  			wprwHidePopUp();
	  		}
		});
		// Prevent pop-up closing when the user clicks PopUpBg, but inside the pop-up area
		$('#wprw-popUpContent').on('click', function(event){
	        event.stopPropagation();
	    });
		
	});

})(jQuery);


/**
*
* Declare global functions
* These are global in order to facillitate user access and easy plugin extension
*
*/

(function($) {

	"use strict";

	// Brings in Pop-Up
	let wprwShowPopUp = function(){
		// Get Chosen Animation Setting and Display Animation if Enabled
	    let chosenAnimation = 'none'

	    // Set pop visibility to visible
	    $('#wprw-popUpBg').css('display','block');
		$('#wprw-popUpContent').css('visibility','visible');

		// Enable Smooth CSS transitions
		$('#wprw-popUpBg').css('transition','all 0.5s ease 0s');
		$('#wprw-popUpContent').css('transition','all 0.5s ease 0s');

		// Do the actual pop-up transition
		setTimeout(function(){
			$('#wprw-popUpContent').css('transform','translateX(100vw)');
			$('#wprw-popUpBg').css('background-color','rgba(0,0,0,0.83)');
		},200);
		
		// Disable CSS transition. The reason for this is to avoid a bad-looking effect when the window is resized.
		setTimeout(function(){ 
			$('#wprw-popUpBg').css('transition','');
			$('#wprw-popUpContent').css('transition','');
		}, 700);
	};

	// Hides Pop-Up
	let wprwHidePopUp = function(){
		
		// Enable Smooth CSS transitions
		$('#wprw-popUpBg').css('transition','all 0.5s ease 0s');
		$('#wprw-popUpContent').css('transition','all 0.5s ease 0s');

		setTimeout(function(){
			wprwDestroyParticlesAnimation();
			$('#wprw-popUpContent').css('transform','');
			$('#wprw-popUpBg').css('background-color','rgba(0,0,0,0)');
		},200);

		setTimeout(function(){ 
			$('#wprw-popUpBg').css('display','none');
			$('#wprw-popUpContent').css('visibility','hidden'); 
			$('#wprw-popUpBg').css('overflow','hidden');
			$('#wprw-popUpContent').css('overflow','hidden');
			$('#wprw-popUpBg').css('transition','');
			$('#wprw-popUpContent').css('transition','');
		}, 700);
	};

	// Destroys Particles.js Animation (Snow, Falling Stars)
	let wprwDestroyParticlesAnimation = function(){
		// If Particles exists, destroy it
		if(window.pJSDom !== null && typeof window.pJSDom !== "undefined"){
			if(typeof window.pJSDom[0] !== "undefined"){
				window.pJSDom[0].pJS.fn.vendors.destroypJS();
				window.pJSDom = [];
			}
		}
		$('#particlesContainer').css('display','none');
	};

	// Make functions global
	window.wprwShowPopUp = wprwShowPopUp;
	window.wprwHidePopUp = wprwHidePopUp;
	window.wprwDestroyParticlesAnimation = wprwDestroyParticlesAnimation;

})(jQuery);


