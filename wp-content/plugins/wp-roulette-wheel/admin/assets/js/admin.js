/**
*
* JavaScript file that controls all Admin Menu JavaScript: Sliders, Dynamic Disabling, as well as the Pop-up and Input Designers
* This file is ordered as follows: General Functions, Pop-Up Designer, Win & Lose, Data Collection, Display Triggers, Sound, Advanced Settings
*
*/

(function($){

	"use strict";

	$( document ).ready(function() {

		/**
		* General Functions
		*/

		// Initialize SemanticUI Menu Functions
		$(".menu .item").tab();
		$('.ui.dropdown').dropdown();
		$('.message .close').on('click', function() {
		    $(this).closest('.message').transition('fade');
		});


		// On Form Submit (Save Settings), remove disabled attribute (to prevent issues with correctly storing settings in the database)
		$('#wprw_admin_form').on('submit', function() {
			const toEnable = [...chosenSoundCheckboxes];
			toEnable.forEach( 
			  function(currentValue, currentIndex, listObj) { 
			    currentValue.removeAttribute('disabled');
			  }
			);
		    return true; 
		});
		
		//On Submit (Save Settings), Get Current Tab and Pass The Tab as a Setting. 
		$('#wprw_admin_form').on('submit', function() {
			let tabInput = document.querySelector('#wprw_current_tab_setting_input');
		    tabInput.value = document.querySelector('.active').dataset.tab;
		    return true; 
		});

		/**
		*
		* Pop-Up Designer Tab
		*
		*/

		/**
		* Popup Preview Style Actions
		*/

		//On Page Load Set Pop-Up Preview Style
		const styleOnLoad = $('input[name="wprw_popup_preset_setting"]:checked').val();
		setPreviewStyleTo(styleOnLoad);

		//On Preview Style Change, Set Style
		$('input[name="wprw_popup_preset_setting"]').on('change', function (){
			//Set Style to Selected Preset
			setPreviewStyleTo(this.value);
		});

		//When custom styling changes
		$('.wprw_popup_custom_styling').on('change',function(){
			// If custom style is selected
			let selectedStyle = $('input[name="wprw_popup_preset_setting"]:checked').val();
			if (selectedStyle === 'wprw_custom_style' ){
				setPreviewStyleToCustom();
			}
		});

		// On Popup text settings change
		$('input[name="wprw_play_button_text_setting"]').on('input',function(){
			$('#wprw-btnSpinPreview').html('<i class="play icon"></i>'+$(this).val());
		});

		// On Popup Header Text Change
		$('input[name="wprw_popup_header_text_setting"]').on('input',function(){
			$('#wprw_popup_header').html($(this).val());
		});
		
		// Sets Preview Window Style
		function setPreviewStyleTo(style){
			clearPreviewStyle();
			if (style === 'wprw_custom_style'){
				setPreviewStyleToCustom();
			} else {
				$('#wprw_popup_preview_left').addClass(style);
			}
		}

		// Sets Preview Windows Style to Custom Style
		function setPreviewStyleToCustom(){
			let background_gradient_start = $('#wprw_popup_background_gradient_start_setting_picker').val();
			let background_gradient_end = $('#wprw_popup_background_gradient_end_setting_picker').val();
			let linear_gradient = 'linear-gradient(' + background_gradient_start + ', ' + background_gradient_end +')';
			let popup_border_setting = $('#wprw_popup_border_color_setting_picker').val();
			let popup_border_right = '3px solid ' + popup_border_setting;
			let text_color_setting = $('#wprw_popup_text_color_setting_picker').val();
			let submit_background_color_setting = $('#wprw_popup_submit_background_color_setting_picker').val();
			let submit_text_color_setting = $('#wprw_popup_submit_text_color_setting_picker').val();
			$('#wprw_popup_preview_left').css('background', linear_gradient);
			$('#wprw_popup_preview_left').css('border-right', popup_border_right);
			$('#wprw_popup_preview_left label, #wprw_popup_header, #wprw_popup_header_icon').css('color', text_color_setting);
			$('#wprw_popup_preview_left button').css('background-color', submit_background_color_setting);
			$('#wprw_popup_preview_left button').css('color', submit_text_color_setting);
			setPopupSubmitButtonBackgroundHover();
		}

		// Sets Submit Button Background Hover Effect
		function setPopupSubmitButtonBackgroundHover(){
			$("#wprw-btnSpinPreview").on('mouseenter', function() {
			  $(this).css("background-color",$('#wprw_popup_submit_background_hover_color_setting_picker').val());
			}).on('mouseleave', function() {
			  $(this).css("background-color",$('#wprw_popup_submit_background_color_setting_picker').val());
			}); 
		}

		// Clears Preview Windows Style
		function clearPreviewStyle(){
			$('#wprw_popup_preview_left').removeClass();
			$('#wprw_popup_preview_left, #wprw_popup_preview_left label, #wprw_popup_header, #wprw_popup_header_icon, #wprw_popup_preview_left button').removeAttr('style');
			$('#wprw-btnSpinPreview').unbind('mouseenter mouseleave');
		}

		/**
		* Animation Actions
		*/

		//On load Set Animation
		setParticlesAnimation();

		// On Animation Change, Set Animation to New Value
		$('input[name="wprw_chosen_animation_setting"]').on('change', function (){
			setParticlesAnimation();
		});

		// Sets Particles.js Animation (Snowfall / Starfall)
		function setParticlesAnimation(){
			// Destroys current animation, if Any
			destroyParticlesAnimation();
			//get which animation is selected
			let selectedAnimation = $('input[name="wprw_chosen_animation_setting"]:checked').val();
			if (selectedAnimation === 'none'){
				// Do Nothing
			} else {
				let href = wprw_admin_settings.plugins_url + 'includes/assets/lib/particles/'+selectedAnimation+'.json';
				particlesJS.load('particlesContainerPreview', href);
			}
		}
		
		function destroyParticlesAnimation(){
			// If Particles exists, destroy it
			if(window.pJSDom !== null && typeof window.pJSDom !== "undefined"){
				if(typeof window.pJSDom[0] !== "undefined"){
					window.pJSDom[0].pJS.fn.vendors.destroypJS();
					window.pJSDom = [];
				}
			}
		}

		// Bug Fix Workaround - If ParticlesContainer is out of view, it will not load. If the active tab on load is not the pop-up designer
		// then the animation will not initially load. Solution is to check the active tab setting and fire a one-time trigger when 
		// going to the pop-up designer tab for the first time

		$('#wprw_popup_designer_menu_tab').on('click', function (event){
			// If the tab on load was not the pop-up designer tab
			if (wprw_admin_settings.active_tab_on_load !== 'first'){
				// Set the animation
				setParticlesAnimation();
				// Remove this trigger 
				$('#wprw_popup_designer_menu_tab').off(event);
			}
		});

		/**
		*
		* Win & Lose Tab
		*
		*/

		// Initialize Win Probability Slider
		const winProbabilitySlider = document.getElementById('wprw_win_probability_setting_slider');

		noUiSlider.create(winProbabilitySlider, {
			start: wprw_admin_settings.win_probability_setting,
			connect: 'lower',
			tooltips: [true],
			step: 1 	,
			range: {
				'min': 0,
				'max': 100
			},
			pips: {
				mode: 'count',
				values: 5,
			},
			format: {
			    from: Number,
			    to: function(value) {
			        return (parseInt(value)+" %");
			    }
			}
		});

		// Connect Win Probability Slider with Win Probability Input (hidden input, which controls the actual setting)
		const winProbabilityInput = document.querySelector('input[name="wprw_win_probability_setting"]');
		winProbabilitySlider.noUiSlider.on('update', function (values, handle) {
			winProbabilityInput.innerHTML = values[handle].slice(0,-2);
	    	winProbabilityInput.value = values[handle].slice(0,-2);
		});


		/**
		*
		* Data Collection Tab
		*
		*/
		
		// On click "Download Users" button and "Download Emails" button, download lists
		$('#wprw_download_users_button').on('click', function() {
		    window.location = ajaxurl + '?action=handledownloadrequest&requests=users&security=' + wprw_admin_settings.security;
	    });
		$('#wprw_download_emails_button').on('click', function() {
	        window.location = ajaxurl + '?action=handledownloadrequest&requests=emails&security=' + wprw_admin_settings.security;
		});

		/**
		*
		* Display Triggers Settings Tab
		*
		*/

		// Initialize Time Spent Seconds Slider
		const timeSpentSecondsSlider = document.getElementById('wprw_time_spent_seconds_slider');

		noUiSlider.create(timeSpentSecondsSlider, {
			start: document.querySelector('input[name="wprw_time_spent_seconds_setting"]').value,
			connect: 'lower',
			tooltips: [true],
			step: 0.5 	,
			range: {
				'min': 0,
				'max': 30
			},
			pips: {
				mode: 'count',
				values: 5,
				density: 2

			}
		});

		// Connect Slider with Hidden Input which controls the actual setting
		const timeSpentInput = document.querySelector('input[name="wprw_time_spent_seconds_setting"]');
		timeSpentSecondsSlider.noUiSlider.on('update', function (values, handle) {
	    	timeSpentInput.innerHTML = values[handle];
	    	timeSpentInput.value = values[handle];
		});
		
		//On Load, Disable Slider if Timed PopUp Setting Disabled
		const timedPopupCheckbox = document.querySelector('input[name="wprw_time_spent_onpage_setting"]');
		if (!timedPopupCheckbox.checked){
			timeSpentSecondsSlider.setAttribute('disabled', true);
		}

		function toggleTimedPopup(element) {
		    if (!timedPopupCheckbox.checked) {
		        element.setAttribute('disabled', true);
		    } else {
		        element.removeAttribute('disabled');
		    }
		}
		
		// On clicking "Enable Timed Popup" toggle Slider Disabled state
		timedPopupCheckbox.addEventListener('click', function () {
		    toggleTimedPopup.call(this, timeSpentSecondsSlider);
		});
		


		/**
		*
		* Sound Tab
		*
		*/

		// Initialize Plyr Sounds
		const plyrSound1 = new Plyr('#wprw_plyrsound1');
		const plyrSound2 = new Plyr('#wprw_plyrsound2');

		// Toggle Disabled States for Sound Checkboxes
		function toggleSound(element) {
		    if (!enableSoundCheckbox.checked) {
		        element.setAttribute('disabled', true);
		    } else {
		        element.removeAttribute('disabled');
		    }
		}

		const enableSoundCheckbox = document.querySelector('input[name="wprw_enable_sound_setting"]');
		const chosenSoundCheckboxes = document.querySelectorAll('input[name="wprw_chosen_sound_setting"]');

		// On clicking the "Enable Sound" Checkbox, Run Toggle functions 
		enableSoundCheckbox.addEventListener('click', function () {
			chosenSoundCheckboxes.forEach( 
			  function(currentValue, currentIndex, listObj) {
			    toggleSound(currentValue);
			  }
			);
		});
		

		/**
		*
		* Advanced Settings Tab
		*
		*/

		// Initialize Wheel Size Slider
		const wheelSizeSlider = document.getElementById('wprw_wheel_size_setting_slider');
		noUiSlider.create(wheelSizeSlider, {
			start: document.querySelector('input[name="wprw_wheel_size_setting"]').value,
			connect: 'lower',
			tooltips: [true],
			range: {
				'min': 1,
				'max': 10
			}
		});
		const wheelSizeInput = document.querySelector('input[name="wprw_wheel_size_setting"]');

		// Connect Slider with Hidden Input (which controls the actual setting)
		wheelSizeSlider.noUiSlider.on('update', function (values, handle) {
			wheelSizeInput.innerHTML = values[handle];
			wheelSizeInput.value = values[handle];
		});
		// Wheel Preview Size Change. To limit performance issues, it changes on change, not update
		wheelSizeSlider.noUiSlider.on('change', function (values, handle) {
			document.querySelector('.wprw-spinner').style.fontSize = 'calc(2px*'+values[handle]+')';
		});

		//On Click "Manual Spin Counter Reset" run Ajax request and Reset "Spins Left" in the Database
		$('#wprw_reset_spin_counter_button').on('click', function() {
			if (confirm (wprw_admin_translation.spins_reset_confirmation)){
		        let datavar = 'action=resetspinsrequest';
		        datavar += '&security='+wprw_admin_settings.security;
				$.post(ajaxurl, datavar, function(response){
					if ($.trim(response) === 'success'){
			            $('#wprw_reset_spin_counter_button').html(wprw_admin_translation.spins_successfully_reset);
			            $('#wprw_reset_spin_counter_button').removeClass('ui orange button').addClass('ui green button');
			        } else {
			        	$('#wprw_reset_spin_counter_button').html(wprw_admin_translation.spins_reset_error);
			            $('#wprw_reset_spin_counter_button').removeClass('ui orange button').addClass('ui red button');
			        }
		        });
			}
		});

		/**
		* Shortcode Preview Style Actions
		*/

		// On Load, set Shortcode styles
		setShortcodeInputStyle();

		// Change the shortcode preview for changes in each of the Color Inputs under (Input Design - Shortcode)
		$('.wprw_inputpicker_group').on('change',function(){
			setShortcodeInputStyle();
		});

		// Set the Shortcode Input Style
		function setShortcodeInputStyle(){
			$('#wprw_input_form').css('background-color', $('#wprw_shortcode_background_color_picker').val());
			$('#wprw_input_form label').css('color', $('#wprw_shortcode_label_text_color_picker').val());
			$('#wprw-btnSpin').css('background-color', $('#wprw_shortcode_submit_button_background_color_picker').val());
			$('#wprw-btnSpin').css('color', $('#wprw_shortcode_submit_button_text_color_picker').val());
			setShortcodeSubmitButtonBackgroundHover();
		}
		
		function setShortcodeSubmitButtonBackgroundHover(){
			$("#wprw-btnSpin").on('mouseenter', function() {
			  $(this).css("background-color",$('#wprw_shortcode_submit_button_background_hover_color_picker').val());
			}).on('mouseleave', function() {
			  $(this).css("background-color",$('#wprw_shortcode_submit_button_background_color_picker').val());
			}); 
		}

	});

})(jQuery);
