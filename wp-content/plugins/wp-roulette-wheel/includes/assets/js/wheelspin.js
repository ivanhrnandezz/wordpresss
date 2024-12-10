/**
*
* JavaScript file that controls wheel spinning as well as associated actions and logic for: showing / hiding the popup / modals
* Also manages Ajax requests (get user's permission to spin, send the user to the Database, generate a coupon, etc.)
*
*/

(function($){

	"use strict";

	$( document ).ready(function() {

		// Create Wheel and Get Numbers' Location
		const numbersLocation = createWheel();
		// Load Audio if not in Admin
		if (typeof wprw_display_settings !== 'undefined'){
			var audio;
			preloadAudio();
		}

		/**
		*
		* On Form Submit (either via Popup or via Shortcode Input), Spin the Wheel!
		*
		*/

		$("#wprw_input_form").on('submit',function(e){

			// Prevent actually submitting the form
			e.preventDefault();
			startWheelSequence('website');

		});

		$("#wprw_main_popup_form").on('submit',function(e){

			//Prevent actually submitting the form
			e.preventDefault();
			startWheelSequence('popup');

			/* iOS Sound Play Workaround  
			* iOS will not play sound unless directly triggered by a click. While our sound is truly triggered by the
			* click, there is a wait period in which the plugin gets the user's spin permission via AJAX request.
			* The solution below is to play the sound, immediately pause it, and then continue playing after all AJAX checks have been completed
			*/
			audio.volume=0;
			audio.play();
			audio.pause();

		});

		function startWheelSequence(integration){

			// Disable Submit Button to prevent Submitting the Form Twice
			$('#wprw-btnSpin').attr('disabled','true');

			// Create Permission Request
			let dataform = '';
			if (integration === 'popup'){
				dataform += $("#wprw_main_popup_form").serialize();
			} else if (integration === 'website') {
				dataform += $("#wprw_input_form").serialize();
			}
			dataform += '&action=handlepermissionrequest';
			dataform += '&security='+wprw_display_settings.security;  // Add nonce security to request

			// Run Request to See if User Has Permission to Spin
			$.post(wprw_display_settings.ajaxurl, dataform, function(response){
				response = $.trim(response);
				if (response === 'yes'){
					// If user has Permission, begin spinning the wheel
					beginWheelSpin(integration); 
				} else if (response === 'no'){
					noPermission(integration); 
				}
			});
		}

		function noPermission(integration){
			alert(wprw_display_translation.not_have_permission);
			if(integration === 'popup'){
				wprwHidePopUp();
			}
		}

		function beginWheelSpin(integration){
			// Set browser cookie
			if (getCookie('wprw_roulettewheel_cookie') === null) {
				setCookie('wprw_roulettewheel_cookie', Math.random().toString(36).substring(3), 3);
			}
			
			setTimeout(function(){
				// Get User Number
				const userChosenNumber = parseInt($("#wprw-chosenField").val());
				// Check against Win Probability
				if ( (Math.random()*100) < parseInt(wprw_display_settings.win_probability_setting) ){
					// If Win, Winning Number is User's Chosen Number
					spinTo(userChosenNumber);
					winFunction(integration);
				} else {
					// If Lose, Winning Number is random number from 0-36, but remove User's Number from possibilities 
					let numbersArray = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36];
					numbersArray.splice(userChosenNumber, 1);
					let randomNumber = numbersArray[Math.floor(Math.random()*numbersArray.length)];
					spinTo(randomNumber);
					loseFunction(integration);
				}
			}, 500);

			// Remove Form if integration is Pop-up
			if (integration === 'popup'){
				$("#wprw_main_popup_form, #wprw_popup_header_container ").css('opacity', 0);
				setTimeout(function(){
					$("#wprw_main_popup_form, #wprw_popup_header_container").css('display','none');
					//Bring wheel to center, if wheel is sideways (width > 768 );
					if ( $(window).width() > 768 ) {
						$("#wprw_popup_wheel_container_right").css('display','none');
						$(".wprw-spinner").css('transform', 'translateX(30%)');
						setTimeout(function (){
							// Move Back the wheel when the animation ends
							moveWheelBack();
						}, 10000);
					}
				}, 500);
			}
		} 

		function winFunction(integration) {
			// If coupons are enabled in Settings, make a coupon request
			if (parseInt(wprw_display_settings.wprw_enable_coupons_setting) === 1){

				// Create request data from form
				let datavar;
				if (integration === 'popup'){
					datavar = $("#wprw_main_popup_form").serialize(); // Include the form as well because we need this data to send winning emails
				} else if (integration === 'website'){
					datavar = $("#wprw_input_form").serialize();
				}
				datavar += '&action=handlecouponrequest';
				datavar += '&security=' + wprw_display_settings.security;
				
				//Make Coupon Request
				$.post(wprw_display_settings.ajaxurl, datavar, function(response){
					let coupon = response;
					sendUserToDatabase(coupon, integration);
					displayWinMessage(coupon, integration);
				});
			} else {
				// User wins but coupon setting is not enabled
				sendUserToDatabase('nocoupon', integration);
				displayWinMessage('couponnotenabled', integration);
			}
		}

		function displayWinMessage(coupon, integration){
			if (integration === 'popup'){
				if (coupon === 'couponnotenabled'){
					setTimeout(function(){
						$("#wprw_popup_wheel_container_right").append('<div id="wprw_winlosediv">'+wprw_display_translation.winmessage+'</div>');
						$("#wprw_winlosediv").css('display', 'block');
						setTimeout(function(){
							$("#wprw_winlosediv").css('opacity', 1);
						}, 200);
						// Re-enable submit button
						$('#wprw-btnSpin').removeAttr('disabled');
					}, 10500);
				} else {
					// If coupons enabled
					setTimeout(function(){
						$("#wprw_popup_wheel_container_right").append('<div id="wprw_winlosediv">'+wprw_display_translation.winmessage+'</div>');
						if (parseInt(wprw_display_settings.wprw_enable_coupons_setting) === 1){
							$("#wprw_popup_wheel_container_right").append('<div id="wprw_wincoupon_container"><i class="gift icon"></i>'+coupon+'</div>');  
							$("#wprw_wincoupon_container").css('display', 'block');
							setTimeout(function(){
								$("#wprw_wincoupon_container").css('opacity', 1);
							}, 200);
						}
						$("#wprw_winlosediv").css('display', 'block');
						setTimeout(function(){
							$("#wprw_winlosediv").css('opacity', 1);
						}, 200);
						$('#wprw-btnSpin').removeAttr('disabled');
					}, 10500);
				}
			} else if (integration === 'website'){
				if (coupon === 'couponnotenabled'){
					setModal('win', 'couponnotenabled');
				} else {
					setModal('win', coupon);
				}
				setTimeout(function(){
					showModal();
					$('#wprw-btnSpin').removeAttr('disabled');
				}, 10500);
			}
		}

		function loseFunction(integration) {
			sendUserToDatabase("nocoupon", integration);
			if (integration === 'popup'){
				setTimeout(function(){
					$("#wprw_popup_wheel_container_right").append('<div id="wprw_winlosediv">'+wprw_display_translation.losemessage+'</div>');  
					$("#wprw_winlosediv").css('display', 'block');
					setTimeout(function(){
						$("#wprw_winlosediv").css('opacity', 1);
					}, 200);
					$('#wprw-btnSpin').removeAttr('disabled');
				}, 10500);
			} else {
				setTimeout(function(){
					setModal('lose');
					showModal();
					$('#wprw-btnSpin').removeAttr('disabled');
				}, 10500);
			}
		}

		// Inserts or Updates User Data in the Database
		function sendUserToDatabase (coupon, integration){
			let datavaruser;
			if (integration === 'popup'){
				datavaruser = $("#wprw_main_popup_form").serialize();
			} else if (integration === 'website'){
				datavaruser = $("#wprw_input_form").serialize();
			}
			datavaruser += '&action=handleinsertrequest';
			datavaruser += '&security=' + wprw_display_settings.security;
			datavaruser += '&coupon=' + coupon;

			//Do AJAX request for Sending User Data to Database
			$.post(wprw_display_settings.ajaxurl, datavaruser); 
		}

		// Sets the Win / Lose Modal Content, before displaying the modal (only for website integration mode, not popup)
		function setModal(win, coupon = 'no'){
			if(win === 'win'){
				$('#wprw_modaltop').html('Congratulations!');
				$('#wprw_modalContentTop').html(wprw_display_translation.you_won);
				if(coupon !== 'couponnotenabled'){
					$('#wprw_modalMessage').html(wprw_display_translation.winmessage+'<Br><div class="ui success message"><div class="header">'+wprw_display_translation.your_coupon_is+' '+coupon+'</div></div>');
				} else {
					$('#wprw_modalMessage').html(wprw_display_translation.winmessage);
				}
			} else if (win === 'lose'){
				$('#wprw_modaltop').html(wprw_display_translation.you_lost);
				$('#wprw_modalContentTop').html(wprw_display_translation.dont_give_up);
				$('#wprw_modalMessage').html('<div class="ui negative message"><div class="header">'+wprw_display_translation.losemessage+'</div></div>');
				$('#wprw_modalIcon').removeClass('trophy icon').addClass('frown icon');
			}
		}

		// Displays Win / Lose Modal
		function showModal(){
			$('.tiny.modal').modal('show');
		}

		function moveWheelBack(){
			// if wheel was previously moved, move it back
			setTimeout(function(){
				$(".wprw-spinner").css('transform', '');
				setTimeout(function(){
					$("#wprw_popup_wheel_container_right").css('display','flex');
					$(".wprw-spinner").removeAttr('style');
				},500);
			},500);
		}

		function preloadAudio(){
			let enableSoundSetting = parseInt(wprw_display_settings.wprw_enable_sound_setting);
			let chosenSoundSetting = parseInt(wprw_display_settings.wprw_chosen_sound_setting);
			if (enableSoundSetting === 1){
				if(chosenSoundSetting === 1){
					audio = new Audio(wprw_display_settings.plugins_url + 'includes/assets/sounds/RouletteWheel1.mp3');
				} else if (chosenSoundSetting === 2){
					audio = new Audio(wprw_display_settings.plugins_url + 'includes/assets/sounds/RouletteWheel2.wav');
				}
			} else {
				// Sound Setting Not Enabled, Do Nothing
			}

		}
		function playSound() {
			let enableSoundSetting = parseInt(wprw_display_settings.wprw_enable_sound_setting);
			if (enableSoundSetting === 1){
				audio.volume=0.6;
				audio.play();
			}
		}

		// Functions that check if the cookie is already present and set the cookie
		function setCookie(name, value, days) {
			let expires = "";
			if (days) {
				let date = new Date();
				date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
				expires = "; expires=" + date.toUTCString();
			}
			document.cookie = name + "=" + (value || "") + expires + "; path=/";
		}
		function getCookie(name) {
			let nameEQ = name + "=";
			let ca = document.cookie.split(';');
			for (let i = 0; i < ca.length; i++) {
				let c = ca[i];
				while (c.charAt(0) == ' ') c = c.substring(1, c.length);
				if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
			}
			return null;
		}

		// Creates the inner wheel elements
		function createWheel() {
			const numbersLocation = [];
			const numorder = [0,32,15,19,4,21,2,25,17,34,6,27,13,36,11,30,8,23,10,5,24,16,33,1,20,14,31,9,22,18,29,7,28,12,35, 3, 26];
			const numred = [32,19,21,25,34,27,36,30,23,5,16,1,14,9,18,7,12,3];
			const numblack = [15,4,2,17,6,13,11,8,10,24,33,20,31,22,29,28,35,26];
			const numgreen = [0];

			let temparc = 360 / numorder.length;
			for (let i = 0; i < numorder.length; i++) {
				numbersLocation[numorder[i]] = [];
				numbersLocation[numorder[i]][0] = i * temparc;
				numbersLocation[numorder[i]][1] = i * temparc + temparc;

				let newSlice = document.createElement("div");
				$(newSlice).addClass("wprw-hold");
				let newHold = document.createElement("div");
				$(newHold).addClass("wprw-pie");
				let newNumber = document.createElement("div");
				$(newNumber).addClass("wprw-num");

				newNumber.innerHTML = numorder[i];
				$(newSlice).attr("id", "rSlice" + i);
				$(newSlice).css("transform","rotate(" + numbersLocation[numorder[i]][0] + "deg)");

				$(newHold).css("transform", "rotate(9.73deg)");
				$(newHold).css("-webkit-transform", "rotate(9.73deg)");

				if ($.inArray(numorder[i], numgreen) > -1) {
					$(newHold).addClass("wprw-greenbg");
				} else if ($.inArray(numorder[i], numred) > -1) {
					$(newHold).addClass("wprw-redbg");
				} else if ($.inArray(numorder[i], numblack) > -1) {
					$(newHold).addClass("wprw-greybg");
				}

				$(newNumber).appendTo(newSlice);
				$(newHold).appendTo(newSlice);

				const rinner = $("#wprw-rcircle");
				$(newSlice).appendTo(rinner);
			}
			return numbersLocation;
		}

		// Resets the animation to its default state
		function resetAnimation() {
			let animationPlayState = "animation-play-state";
			let playStateRunning = "running";

			const pfx = $.keyframe.getVendorPrefix();
			$(".wprw-ball").css(pfx + animationPlayState, playStateRunning).css(pfx + "animation", "none");
			$(".wprw-pieContainer").css(pfx + animationPlayState, playStateRunning).css(pfx + "animation", "none");
			$("#wprw-toppart").css(pfx + animationPlayState, playStateRunning).css(pfx + "animation", "none");

			$("#rotate2").html("");
			$("#rotate").html("");
		}

		// Begins spinning the wheel to the num $argument
		function spinTo(num) {
		  //get location
		  let temp = numbersLocation[num][0] + 4;
		  //randomize
		  let randomSpace = Math.floor(Math.random() * 360 + 1);

		  resetAnimation();
		  setTimeout(function() {
			bgRotateTo(randomSpace);
			ballRotateTo(randomSpace + temp);
			setTimeout(playSound(),500);
		  }, 500);
		}

		// The animation that rotates and translates the ball inward
		function ballRotateTo(deg) {
			const ballSpinTime = 4;
			const rotationsTime = 8;
			let destination = -360 * ballSpinTime - (360 - deg);
			$.keyframe.define({
				name: "rotate2",
				from: {
					'transform': "rotate(0deg) translateY(0em)"
				},
				to: {
					'transform': "rotate(" + destination + "deg) translateY(5em)"
				}
			});

			$.keyframe.define({
				name: "rotateBallStart",
				from: {
					transform: "rotate(0deg) translate(0px, 0px)"
				},
				to: {
					transform: "rotate(-2880deg) translate(0px, 0px)"
				}
			});

			$.keyframe.define({
				name: "rotateBallEnd",
				from: {
					transform: "rotate(" + destination + "deg) translateY(5em)"
				},
				to: {
					transform: "rotate(" + (destination + 700) + "deg) translateY(5em)"
				}
			});

			const ballbg = $(".wprw-ball");
			
			$(ballbg).playKeyframe({
					name: "rotateBallStart", 
					duration: '4s', 
					timingFunction: "cubic-bezier(0.15,0,1,1)", 
				});
			setTimeout(function(){
				$(ballbg).playKeyframe({
					name: "rotate2", 
					duration: (rotationsTime - 4) + 's', 
					timingFunction: "ease-out", 
				});
			}, 4000);
			setTimeout(function(){
				$(ballbg).playKeyframe({
					name: "rotateBallEnd", 
					duration: '7s', 
					timingFunction: "ease-out",
				});
			}, 8000);
		}

		// The animation that rotates the inner wheel / red & black numbers
		// Multiple keyframes and setTimeouts control the wheel rotation at every stage
		function bgRotateTo(deg) {
			const numbg = $(".wprw-pieContainer");
			const toppart = $("#wprw-toppart");
			const wheelSpinTime = 2;
			const rotationsTime = 8;
			let destination = 360 * wheelSpinTime + deg;
			let temptime = (rotationsTime * 1000) / 1000 + 's';

			$.keyframe.define({
				name: "rotate",
				from: {
					transform: "rotate(0deg)"
				},
				to: {
					transform: "rotate(" + destination + "deg)"
				}
			});

			$.keyframe.define({
				name: "rotateEnd",
				from: {
					transform: "rotate(" + destination + "deg)"
				},
				to: {
					transform: "rotate(" + (destination + 700) + "deg)"
				}
			});
			$(numbg).playKeyframe({
				name: "rotate", 
				duration: temptime, 
				timingFunction: "ease-in",
			});

			$(toppart).playKeyframe({
				name: "rotate", 
				duration: temptime, 
				timingFunction: "ease-in",
			});

			
			setTimeout(function(){
				$(numbg).playKeyframe({
					name: "rotateEnd", 
					duration: '7s', 
					timingFunction: "ease-out",
				});
				$(toppart).playKeyframe({
					name: "rotateEnd", 
					duration: '7s', 
					timingFunction: "ease-out",
				});
			}, 8000);
			
		}

	});

})(jQuery);
