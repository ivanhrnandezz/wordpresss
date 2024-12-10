<?php

/**
*
* PHP File that handles Settings management
*
*/

class Wproulettewheel_Settings {

	public function register_all_settings() {

		/*
		* 1.1
		* Tab: Pop-Up Designer Tab (first)
		* Section: Pop-Up Text Settings
		*/ 

		add_settings_section('rouletteoptions_popuptextsettings', '', '', 'wproulettewheel');
		// Play Button Text
		register_setting( 'wproulettewheel', 'wprw_play_button_text_setting');
		add_settings_field('wprw_play_button_text_setting', esc_html__('Play Button Text:', 'wproulettewheel'), array($this,'wprw_play_button_text_setting_content'), 'wproulettewheel', 'rouletteoptions_popuptextsettings');
		// Pop-Up Header ('Spin to Win a Prize')
		register_setting( 'wproulettewheel', 'wprw_popup_header_text_setting');
		add_settings_field('wprw_popup_header_text_setting', esc_html__('Header Text:', 'wproulettewheel'), array($this,'wprw_popup_header_text_setting_content'), 'wproulettewheel', 'rouletteoptions_popuptextsettings');
		// Current Tab Setting - Misc setting, hidden, only saves the last opened menu tab
		register_setting( 'wproulettewheel', 'wprw_current_tab_setting');
		add_settings_field('wprw_current_tab_setting', '', array($this, 'wprw_current_tab_setting_content'), 'wproulettewheel', 'rouletteoptions_popuptextsettings');

		/*
		* 1.2
		* Tab: Pop-Up Designer Tab (first)
		* Section: Custom Style Left & Custom Style Right
		*/ 

		add_settings_section('rouletteoptions_customstyleleft', '',	'',	'wproulettewheel');
		add_settings_section('rouletteoptions_customstyleright', '', '','wproulettewheel');
		// Pop-Up Background Gradient Start
		register_setting( 'wproulettewheel', 'wprw_popup_background_gradient_start_setting');
		add_settings_field('wprw_popup_background_gradient_start_setting', esc_html__('Background Gradient Start:','wproulettewheel'), array($this,'wprw_popup_background_gradient_start_setting_content'), 'wproulettewheel', 'rouletteoptions_customstyleleft');
		// Pop-Up Background Gradient End
		register_setting( 'wproulettewheel', 'wprw_popup_background_gradient_end_setting');
		add_settings_field('wprw_popup_background_gradient_end_setting', esc_html__('Background Gradient End:','wproulettewheel'), array($this,'wprw_popup_background_gradient_end_setting_content'), 'wproulettewheel', 'rouletteoptions_customstyleleft');
		// Pop-Up Border Color
		register_setting( 'wproulettewheel', 'wprw_popup_border_color_setting');
		add_settings_field('wprw_popup_border_color_setting', esc_html__('Pop-Up Border Color:','wproulettewheel'), array($this,'wprw_popup_border_color_setting_content'), 'wproulettewheel', 'rouletteoptions_customstyleleft');
		// Pop-Up Text Color Setting
		register_setting( 'wproulettewheel', 'wprw_popup_text_color_setting');
		add_settings_field('wprw_popup_text_color_setting', esc_html__('Pop-Up Text Color:','wproulettewheel'), array($this,'wprw_popup_text_color_setting_content'), 'wproulettewheel', 'rouletteoptions_customstyleright');
		// Popup Submit Button Background Color
		register_setting( 'wproulettewheel', 'wprw_popup_submit_background_color_setting');
		add_settings_field('wprw_popup_submit_background_color_setting', esc_html__('Submit Button Background Color','wproulettewheel'), array($this,'wprw_popup_submit_background_color_setting_content'), 'wproulettewheel', 'rouletteoptions_customstyleright');
		// Popup Submit Button Background Hover Color
		register_setting( 'wproulettewheel', 'wprw_popup_submit_background_hover_color_setting');
		add_settings_field('wprw_popup_submit_background_hover_color_setting', esc_html__('Submit Button Background Hover Color','wproulettewheel'), array($this,'wprw_popup_submit_background_hover_color_setting_content'), 'wproulettewheel', 'rouletteoptions_customstyleright');
		// Popup Submit Button Text Color
		register_setting( 'wproulettewheel', 'wprw_popup_submit_text_color_setting');
		add_settings_field('wprw_popup_submit_text_color_setting', esc_html__('Submit Button Text Color:','wproulettewheel'), array($this,'wprw_popup_submit_text_color_setting_content'), 'wproulettewheel', 'rouletteoptions_customstyleright');

		// Popup style preset setting
		register_setting('wproulettewheel', 'wprw_popup_preset_setting');
		// Popup chosen animation setting
		register_setting( 'wproulettewheel', 'wprw_chosen_animation_setting');
		
		/*
		* 2.1
		* Tab: Win & Lose Tab 
		* Section: Main Win & Lose Section
		*/ 

		add_settings_section('rouletteoptions_winlose', '',	'',	'wproulettewheel');
		// Win Probability Setting (Slider)
		register_setting( 'wproulettewheel', 'wprw_win_probability_setting');
		add_settings_field('wprw_win_probability_setting', esc_html__('Set Win Probability','wproulettewheel'), array($this,'wprw_win_probability_setting_content'), 'wproulettewheel', 'rouletteoptions_winlose');
		// Win Message
		register_setting( 'wproulettewheel', 'wprw_win_message_setting');
		add_settings_field('wprw_win_message_setting', esc_html__('Message shown to user (win):','wproulettewheel'), array($this,'wprw_win_message_setting_content'), 'wproulettewheel', 'rouletteoptions_winlose');
		// Lose Message
		register_setting( 'wproulettewheel', 'wprw_lose_message_setting');
		add_settings_field('wprw_lose_message_setting', esc_html__('Message shown to user (lose):','wproulettewheel'), array($this,'wprw_lose_message_setting_content'), 'wproulettewheel', 'rouletteoptions_winlose');

		/*
		* 2.2
		* Tab: Win & Lose Tab 
		* Section: Coupon Settings Section
		*/ 

		add_settings_section('rouletteoptions_coupons', '',	'',	'wproulettewheel');
		// Enable Coupons Setting
		register_setting( 'wproulettewheel', 'wprw_enable_coupons_setting');
		add_settings_field('wprw_enable_coupons_setting', esc_html__('Offer a Coupon to Winners','wproulettewheel'), array($this,'wprw_enable_coupons_setting_content'), 'wproulettewheel', 'rouletteoptions_coupons');
		// Chosen Coupon Setting
		register_setting( 'wproulettewheel', 'wprw_chosen_coupon_setting');
		add_settings_field('wprw_chosen_coupon_setting', esc_html__('Choose Coupon:','wproulettewheel'), array($this,'wprw_chosen_coupon_setting_content'), 'wproulettewheel', 'rouletteoptions_coupons');
		// Custom Coupon Text Setting
		register_setting( 'wproulettewheel', 'wprw_customcoupontext_setting');
		// Existing Coupon Setting
		register_setting( 'wproulettewheel', 'wprw_existing_coupon_setting');
		// Choose GeneratedCoupon Type
		register_setting( 'wproulettewheel', 'wprw_generatedcoupontype_setting');
		// Choose Generated Coupon Amount
		register_setting( 'wproulettewheel', 'wprw_generatedcouponamount_setting');
		// Choose Generated Coupon Expiry
		register_setting( 'wproulettewheel', 'wprw_generatedcouponexpiry_setting');

		/*
		* 2.3
		* Tab: Win & Lose Tab 
		* Section: Mailing Settings Section
		*/ 

		add_settings_section('rouletteoptions_mailing', '',	'',	'wproulettewheel');
		// Send Coupon Email on Win
		register_setting( 'wproulettewheel', 'wprw_send_email_onwin_setting');
		add_settings_field('wprw_send_email_onwin_setting', esc_html__('Send Coupon Email on Win','wproulettewheel'), array($this,'wprw_send_email_onwin_setting_content'), 'wproulettewheel', 'rouletteoptions_mailing');
		// Email Subject
		register_setting( 'wproulettewheel', 'wprw_emailsubject_setting');
		add_settings_field('wprw_emailsubject_setting', esc_html__('Email Subject','wproulettewheel'), array($this,'wprw_emailsubject_setting_content'), 'wproulettewheel', 'rouletteoptions_mailing');
		// Email Message
		register_setting( 'wproulettewheel', 'wprw_emailmessage_setting');
		add_settings_field('wprw_emailmessage_setting', esc_html__('Email Message','wproulettewheel'), array($this,'wprw_emailmessage_setting_content'), 'wproulettewheel', 'rouletteoptions_mailing');
		// Custom Name
		register_setting( 'wproulettewheel', 'wprw_customname_setting');
		add_settings_field('wprw_customname_setting', esc_html__('Custom Name from which emails are sent','wproulettewheel'), array($this,'wprw_customname_setting_content'), 'wproulettewheel', 'rouletteoptions_mailing');
		// Custom Email 
		register_setting( 'wproulettewheel', 'wprw_customemail_setting');
		add_settings_field('wprw_customemail_setting', esc_html__('Custom Email Address from which emails are sent
','wproulettewheel'), array($this,'wprw_customemail_setting_content'), 'wproulettewheel', 'rouletteoptions_mailing');
		
		/*
		* 3.1
		* Tab: Data Collection Tab 
		* Section: Main Data Collection Section
		*/ 

		add_settings_section('rouletteoptions_datacollection', '',	'',  'wproulettewheel');
		//Email Setting
		register_setting( 'wproulettewheel', 'wprw_collect_email_setting');
		add_settings_field('wprw_collect_email_setting', esc_html__('Collect Email','wproulettewheel'), array($this,'wprw_collect_email_setting_content'), 'wproulettewheel', 'rouletteoptions_datacollection');
		//First Name Setting
		register_setting( 'wproulettewheel', 'wprw_collect_firstname_setting');
		add_settings_field('wprw_collect_firstname_setting', esc_html__('Collect First Name','wproulettewheel'), array($this,'wprw_collect_firstname_setting_content'), 'wproulettewheel', 'rouletteoptions_datacollection');
		//Last Name Setting
		register_setting( 'wproulettewheel', 'wprw_collect_lastname_setting');
		add_settings_field('wprw_collect_lastname_setting', esc_html__('Collect Last Name','wproulettewheel'), array($this,'wprw_collect_lastname_setting_content'), 'wproulettewheel', 'rouletteoptions_datacollection');
		//Phone Number Setting
		register_setting( 'wproulettewheel', 'wprw_collect_phonenumber_setting');
		add_settings_field('wprw_collect_phonenumber_setting', esc_html__('Collect Phone Number','wproulettewheel'), array($this,'wprw_collect_phonenumber_setting_content'), 'wproulettewheel', 'rouletteoptions_datacollection');
		//Require user to accept rules Setting
		register_setting( 'wproulettewheel', 'wprw_user_rules_setting');
		add_settings_field('wprw_user_rules_setting', esc_html__('Terms & Conditions','wproulettewheel'), array($this,'wprw_user_rules_setting_content'), 'wproulettewheel', 'rouletteoptions_datacollection');

		/*
		* 3.2
		* Tab: Data Collection Tab 
		* Section: MailChimp Settings Section
		*/ 

		add_settings_section('rouletteoptions_mailchimp', '',	'',	'wproulettewheel');
		// Enable MailChimp Setting
		register_setting( 'wproulettewheel', 'wprw_enable_mailchimp_setting');
		add_settings_field('wprw_enable_mailchimp_setting', esc_html__('Enable MailChimp','wproulettewheel'), array($this,'wprw_enable_mailchimp_setting_content'), 'wproulettewheel', 'rouletteoptions_mailchimp');
		// MailChimp API KEY Setting
		register_setting( 'wproulettewheel', 'wprw_mailchimp_api_key_setting');
		add_settings_field('wprw_mailchimp_api_key_setting', esc_html__('MailChimp API Key:','wproulettewheel'), array($this,'wprw_mailchimp_api_key_setting_content'), 'wproulettewheel', 'rouletteoptions_mailchimp');
		// Chosen List Setting
		register_setting( 'wproulettewheel', 'wprw_mailchimpchosenlist_setting');
		// Optin Status Setting (Single or Double Optin)
		register_setting('wproulettewheel', 'wprw_mailchimp_optin_status_setting');
		add_settings_field('wprw_mailchimp_optin_status_setting', esc_html__('Optin Status:','wproulettewheel'), array($this,'wprw_mailchimp_optin_status_setting_content'), 'wproulettewheel', 'rouletteoptions_mailchimp');

		/*
		* 4.1
		* Tab: Display Triggers Tab
		* Section: Main Display Triggers Section
		*/ 

		add_settings_section('rouletteoptions_displaytriggers', '',	'',	'wproulettewheel');
		// Display on Page Load Setting
		register_setting( 'wproulettewheel', 'wprw_display_onpageload_setting');
		add_settings_field('wprw_display_onpageload_setting', esc_html__('Display on Page Load','wproulettewheel'), array($this,'wprw_display_onpageload_setting_content'), 'wproulettewheel', 'rouletteoptions_displaytriggers');
		// Display on Time Spent on Page Setting
		register_setting( 'wproulettewheel', 'wprw_time_spent_onpage_setting');
		add_settings_field('wprw_time_spent_onpage_setting', esc_html__('Time Spent on Page','wproulettewheel'), array($this,'wprw_time_spent_onpage_setting_content'), 'wproulettewheel', 'rouletteoptions_displaytriggers');
		// Time Spent in seconds
		register_setting( 'wproulettewheel', 'wprw_time_spent_seconds_setting');
		add_settings_field('wprw_time_spent_seconds_setting', esc_html__('Time Spent in Seconds','wproulettewheel'), array($this,'wprw_time_spent_seconds_setting_content'), 'wproulettewheel', 'rouletteoptions_displaytriggers');

		/*
		* 4.2
		* Tab: Display Triggers Tab
		* Section: WooCommerce Triggers Section
		*/ 
		add_settings_section('rouletteoptions_woocommercetriggers', '',	'',	'wproulettewheel');
		// Display After Successful Purchase
		register_setting( 'wproulettewheel', 'wprw_display_after_woocommerce_purchase_setting');
		add_settings_field('wprw_display_after_woocommerce_purchase_setting', esc_html__('Display on Successful Purchase','wproulettewheel'), array($this,'wprw_display_after_woocommerce_purchase_setting_content'), 'wproulettewheel', 'rouletteoptions_woocommercetriggers');

		/*
		* 4.3
		* Tab: Display Triggers Tab
		* Section: Custom Triggers Section
		*/ 

		add_settings_section('rouletteoptions_customtriggers', '',	'',	'wproulettewheel');
		// Enable Custom Triggers
		register_setting( 'wproulettewheel', 'wprw_enable_custom_triggers_setting');
		add_settings_field('wprw_enable_custom_triggers_setting', esc_html__('Enable Custom Triggers','wproulettewheel'), array($this,'wprw_enable_custom_triggers_setting_content'), 'wproulettewheel', 'rouletteoptions_customtriggers');


		/*
		* 5.1
		* Tab: Sound Tab
		* Section: Sound Settings Section
		*/ 

		add_settings_section('rouletteoptions_soundsettings', '', '', 'wproulettewheel');
		// Enable Sound Setting
		register_setting( 'wproulettewheel', 'wprw_enable_sound_setting');
		add_settings_field('wprw_enable_sound_setting', esc_html__('Enable Sound','wproulettewheel'), array($this,'wprw_enable_sound_setting_content'), 'wproulettewheel', 'rouletteoptions_soundsettings');
		// Chosen Sound Setting
		register_setting( 'wproulettewheel', 'wprw_chosen_sound_setting');
		add_settings_field('wprw_chosen_sound_setting', esc_html__('Choose Sound','wproulettewheel'), array($this,'wprw_chosen_sound_setting_content'), 'wproulettewheel', 'rouletteoptions_soundsettings');

		/*
		* 6.1
		* Tab: Advanced Tab
		* Section: Spin Limits Section
		*/ 

		add_settings_section('rouletteoptions_spinlimits', '',	'',	'wproulettewheel');
		// Limit Spins by Email
		register_setting( 'wproulettewheel', 'wprw_limitspinsemail_setting');
		add_settings_field('wprw_limitspinsemail_setting', esc_html__('Limit Spins by Email','wproulettewheel'), array($this,'wprw_limitspinsemail_setting_content'), 'wproulettewheel', 'rouletteoptions_spinlimits');
		// Limit Spins by Cookie
		register_setting( 'wproulettewheel', 'wprw_limitspinscookie_setting');
		add_settings_field('wprw_limitspinscookie_setting', esc_html__('Limit Spins by Cookie','wproulettewheel'), array($this,'wprw_limitspinscookie_setting_content'), 'wproulettewheel', 'rouletteoptions_spinlimits');
		// Limit Spins by IP
		register_setting( 'wproulettewheel', 'wprw_limitspinsip_setting');
		add_settings_field('wprw_limitspinsip_setting', esc_html__('Limit Spins by IP','wproulettewheel'), array($this,'wprw_limitspinsip_setting_content'), 'wproulettewheel', 'rouletteoptions_spinlimits');
		// Max Spins per User
		register_setting( 'wproulettewheel', 'wprw_maximum_spins_peruser_setting');
		add_settings_field('wprw_maximum_spins_peruser_setting', esc_html__('Maximum Spins per User','wproulettewheel'), array($this,'wprw_maximum_spins_peruser_setting_content'), 'wproulettewheel', 'rouletteoptions_spinlimits');
		// Reset Spin Counter Setting
		register_setting( 'wproulettewheel', 'wprw_resetspincounter_setting');
		add_settings_field('wprw_resetspincounter_setting', esc_html__('Reset spins every X hours','wproulettewheel'), array($this,'wprw_resetspincounter_setting_content'), 'wproulettewheel', 'rouletteoptions_spinlimits');

		/*
		* 6.2
		* Tab: Advanced Tab
		* Section: Uninstall Section
		*/ 

		add_settings_section('rouletteoptions_uninstall', '', '',	'wproulettewheel');
		// Keep Data and Settings on Uninstall
		register_setting( 'wproulettewheel', 'wprw_keepdata_setting');
		add_settings_field('wprw_keepdata_setting', esc_html__('Keep Data and Settings after Uninstall','wproulettewheel'), array($this,'wprw_keepdata_setting_content'), 'wproulettewheel', 'rouletteoptions_uninstall');
		
		/*
		* 6.3
		* Tab: Advanced Tab
		* Section: Disable Popup Section (Website Integration SubSection)
		*/ 

		// Disable Pop-Up functionality
		add_settings_section('rouletteoptions_disablepopup', '', '', 'wproulettewheel');
		register_setting( 'wproulettewheel', 'wprw_disable_popup_setting');
		add_settings_field('wprw_disable_popup_setting', esc_html__('Disable Pop-Up Display','wproulettewheel'), array($this,'wprw_disable_popup_setting_content'), 'wproulettewheel', 'rouletteoptions_disablepopup');

		/*
		* 6.4
		* Tab: Advanced Tab
		* Section: Wheel Design Section
		*/ 

		add_settings_section('rouletteoptions_wheeldesign', '', '', 'wproulettewheel');
		// Wheel Size Setting
		register_setting('wproulettewheel', 'wprw_wheel_size_setting');
		add_settings_field('wprw_wheel_size_setting', esc_html__('','wproulettewheel'), array($this,'wprw_wheel_size_setting_content'), 'wproulettewheel', 'rouletteoptions_wheeldesign');


		/*
		* 6.5
		* Tab: Advanced Tab
		* Section: Input Shortcode Design Section
		*/ 

		add_settings_section('rouletteoptions_inputshortcode', '',	'',	'wproulettewheel');
		// Input Background Color
		register_setting( 'wproulettewheel', 'wprw_input_background_setting');
		add_settings_field('wprw_input_background_setting', esc_html__('Background Color Picker:','wproulettewheel'), array($this,'wprw_input_background_setting_content'), 'wproulettewheel', 'rouletteoptions_inputshortcode');
		// Input Label Color
		register_setting( 'wproulettewheel', 'wprw_input_label_setting');
		add_settings_field('wprw_input_label_setting', esc_html__('Label Text Color Picker:','wproulettewheel'), array($this,'wprw_input_label_setting_content'), 'wproulettewheel', 'rouletteoptions_inputshortcode');
		// Submit Button Background Color
		register_setting( 'wproulettewheel', 'wprw_submit_background_setting');
		add_settings_field('wprw_submit_background_setting', esc_html__('Submit Button Color Picker:','wproulettewheel'), array($this,'wprw_submit_background_setting_content'), 'wproulettewheel', 'rouletteoptions_inputshortcode');
		// Submit Button Background Color Hover
		register_setting( 'wproulettewheel', 'wprw_submit_background_hover_setting');
		add_settings_field('wprw_submit_background_hover_setting', esc_html__('Submit Button Hover Color Picker:','wproulettewheel'), array($this,'wprw_submit_background_hover_setting_content'), 'wproulettewheel', 'rouletteoptions_inputshortcode');
		// Submit Button Text Color
		register_setting( 'wproulettewheel', 'wprw_submit_text_setting');
		add_settings_field('wprw_submit_text_setting', esc_html__('Submit Text Color Picker:','wproulettewheel'), array($this,'wprw_submit_text_setting_content'), 'wproulettewheel', 'rouletteoptions_inputshortcode');
	}

	/*
	* 1.1
	* Tab: Pop-Up Designer Tab (first)
	* Section: Pop-Up Text Settings
	*/ 

	// Play Button Text Setting 
	function wprw_play_button_text_setting_content(){
		echo '
		<div class="ui form">
			<div class="field">
				<input type="text" name="wprw_play_button_text_setting" maxlength="22" class="wprw_minwidth150" value="'.esc_attr(get_option('wprw_play_button_text_setting', __('Spin the Wheel!','wproulettewheel'))).'">
			</div>
		</div>
		';
	}

	// Pop-Up Header Text Setting 
	function wprw_popup_header_text_setting_content(){
		echo '
		<div class="ui form">
			<div class="field">
				<input type="text" name="wprw_popup_header_text_setting" maxlength="20" class="wprw_minwidth150" value="'.esc_attr(get_option('wprw_popup_header_text_setting', __('Spin to Win a Prize','wproulettewheel'))).'">
			</div>
		</div>
		';
	}
	
	// This function remembers the current tab as a hidden input setting. When the page loads, it goes to the saved tab
	function wprw_current_tab_setting_content(){
		echo '
			  <input type="hidden" id="wprw_current_tab_setting_input" name="wprw_current_tab_setting" value="'.esc_attr(get_option( 'wprw_current_tab_setting', 'first' )).'">
		';
	}

	/*
	* 1.2
	* Tab: Pop-Up Designer Tab (first)
	* Section: Custom Style Left & Custom Style Right
	*/ 

	function wprw_popup_background_gradient_start_setting_content(){
		echo ' <input id="wprw_popup_background_gradient_start_setting_picker" class="wprw_popup_custom_styling" type="color" name="wprw_popup_background_gradient_start_setting" value="'.esc_attr(get_option('wprw_popup_background_gradient_start_setting', '#111111')).'">';
	}

	function wprw_popup_background_gradient_end_setting_content(){
		echo ' <input id="wprw_popup_background_gradient_end_setting_picker" class="wprw_popup_custom_styling" type="color" name="wprw_popup_background_gradient_end_setting" value="'.esc_attr(get_option('wprw_popup_background_gradient_end_setting', '#cccccc')).'">';
	}

	function wprw_popup_border_color_setting_content(){
		echo ' <input id="wprw_popup_border_color_setting_picker" class="wprw_popup_custom_styling" type="color" name="wprw_popup_border_color_setting" value="'.esc_attr(get_option('wprw_popup_border_color_setting', '#111111')).'">';
	}

	function wprw_popup_text_color_setting_content(){
		echo ' <input id="wprw_popup_text_color_setting_picker" class="wprw_popup_custom_styling" type="color" name="wprw_popup_text_color_setting" value="'.esc_attr(get_option('wprw_popup_text_color_setting', '#ffffff')).'">';
	}

	function wprw_popup_submit_background_color_setting_content(){
		echo ' <input id="wprw_popup_submit_background_color_setting_picker" class="wprw_popup_custom_styling" type="color" name="wprw_popup_submit_background_color_setting" value="#fec522">';
	}
	function wprw_popup_submit_background_hover_color_setting_content(){
		echo ' <input id="wprw_popup_submit_background_hover_color_setting_picker" class="wprw_popup_custom_styling" type="color" name="wprw_popup_submit_background_hover_color_setting" value="'.esc_attr(get_option('wprw_popup_submit_background_hover_color_setting', '#d7aa29')).'">';
	}
	function wprw_popup_submit_text_color_setting_content(){
		echo ' <input id="wprw_popup_submit_text_color_setting_picker" class="wprw_popup_custom_styling" type="color" name="wprw_popup_submit_text_color_setting" value="'.esc_attr(get_option('wprw_popup_submit_text_color_setting', '#2e2e2e')).'">';
	}

	/*
	* 2.1
	* Tab: Win & Lose Tab 
	* Section: Main Win & Lose Section
	*/ 

	function wprw_win_probability_setting_content(){
		echo '<div class="ui slider" id="wprw_win_probability_setting_slider"></div>';
		echo '<br><br><input id="wprw_win_probability_setting_input" type="number" min="0" max="100" name="wprw_win_probability_setting" step="1" value="'.esc_attr(get_option( 'wprw_win_probability_setting', 50 )).'">';
	}
	function wprw_win_message_setting_content(){
		echo '
		<div class="ui form">
		   <div class="field">
			<label>'.esc_html__('Win Message','wproulettewheel').'</label>
			<textarea rows="2" name="wprw_win_message_setting">'.esc_textarea(get_option('wprw_win_message_setting', __('You won! Your Prize is an Exclusive 25% Discount Coupon','wproulettewheel'))).'</textarea>
		  </div>
		</div>
		';
	}
	function wprw_lose_message_setting_content(){
		echo '
		<div class="ui form">
		   <div class="field">
			<label>'.esc_html__('Lose Message','wproulettewheel').'</label>
			<textarea rows="2" name="wprw_lose_message_setting">'.esc_textarea(get_option( 'wprw_lose_message_setting', __('You lost! Don\'t give up. Try again later!','wproulettewheel'))).'</textarea>
		  </div>
		</div>
		';
	}

	/*
	* 2.2
	* Tab: Win & Lose Tab 
	* Section: Coupon Settings Section
	*/ 

	function wprw_enable_coupons_setting_content(){
		echo '
		<div class="ui toggle checkbox">
		  <input type="hidden" name="wprw_enable_coupons_setting" value="1" >
		</div>
		<a href="https://1.envato.market/3KYgr"><button class="ui teal button" type="button">Upgrade for This Feature!</button></a>
		';
	}
	function wprw_chosen_coupon_setting_content(){
		// Get list of all WooCommerce coupons
		$woo_coupon_posts = get_posts( array(
			'posts_per_page'   => -1,
			'orderby'          => 'title',
			'order'            => 'asc',
			'post_type'        => 'shop_coupon',
			'post_status'      => 'publish',
		));

		$woo_coupon_names=array();
		foreach ( $woo_coupon_posts as $coupon ) {
			// Get the name for each coupon post
			$coupon_name = $coupon->post_title;
			array_push( $woo_coupon_names, $coupon_name );
		}
		$disabledempty = '';
		if (empty($woo_coupon_names)) {$disabledempty = ' disabled="true"';}
		
		echo '

		<div class="grouped fields">
			<div class="field">
				<div class="ui checkbox wprw_padding5">
					<input type="radio" name="wprw_chosen_coupon_setting" class="wprw_coupon_group" value="1" disabled="true">
					<label>'.esc_html__('Auto Generate Unique WooCommerce Coupon','wproulettewheel').'</label>
				</div>
				<br>
				<div id="wprw_generatecoupon_card" class="ui card">
					<div class="content">
						<label>'.esc_html__('Choose Coupon Type:','wproulettewheel').'</label>
						<select class="ui fluid dropdown wprw_coupon_group_select disabled" name="wprw_generatedcoupontype_setting" >
						   <option value="percent" '.selected(get_option('wprw_generatedcoupontype_setting', 'percent'),'percent', false).'>'.esc_html__('Percentage Discount','wproulettewheel').'</option>
						   <option value="fixed_cart" '.selected(get_option('wprw_generatedcoupontype_setting', 'percent'),'fixed_cart', false).'>'.esc_html__('Fixed Cart Discount','wproulettewheel').'</option>
					   </select>
					   <br>
					   <div class="ui form">
							<div class="field">
								<label>'.esc_html__('Choose Coupon Amount','wproulettewheel').'</label>
								<input type="text" class="wprw_coupon_group" name="wprw_generatedcouponamount_setting" value="" disabled="true">
							</div>
						</div>
						<br>
						<div class="ui form">
							<div class="field">
								<label>'.esc_html__('Choose Coupon Expiry Date (in days):','wproulettewheel').'</label>
								<input type="text" class="wprw_coupon_group" name="wprw_generatedcouponexpiry_setting" value="" disabled="true">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="field">
				<div class="ui checkbox wprw_margintop20">
					<input type="radio" name="wprw_chosen_coupon_setting" class="wprw_coupon_group" value="2" '.checked(intval(get_option( 'wprw_chosen_coupon_setting', 1 )), 2, false).' '.disabled(intval(get_option( 'wprw_enable_coupons_setting', 0 )), 0, false).' '.$disabledempty.'>
					<label>'.esc_html__('Choose Existing WooCommerce Coupon:','wproulettewheel').'</label>
				</div>
			</div>
			<select class="ui fluid dropdown wprw_margintop5 wprw_coupon_group_select '.disabled(intval(get_option( 'wprw_enable_coupons_setting', 0 )), 0, false).'" name="wprw_existing_coupon_setting" '.$disabledempty.'>
					  ';
						if (empty($woo_coupon_names)){
							echo '<option>'.esc_html__('You don\'t have any coupons!','wproulettewheel').'</option>';
						}
						foreach($woo_coupon_names as $coupon_name){
							$selected = '';
							if (get_option('wprw_existing_coupon_setting') === $coupon_name){$selected = 'selected';}
							echo '<option value="'.esc_attr($coupon_name).'" '.$selected.'>'.esc_html($coupon_name).'</option>';
						}
						echo'
			</select>
			<div class="field">
				<div class="ui checkbox wprw_margintop20">
					<input type="radio" name="wprw_chosen_coupon_setting" class="wprw_coupon_group" value="3" disabled="true">
					<label>'.esc_html__('Custom Coupon Text','wproulettewheel').'</label>
				</div>
				<div class="ui form wprw_margintop5">
					<div class="field">
						<input type="text" class="wprw_coupon_group" name="wprw_customcoupontext_setting" value="" disabled="true">
					</div>
				</div>
			</div>
		</div>

	';
	}


	/*
	* 2.3
	* Tab: Win & Lose Tab 
	* Section: Mailing Settings Section
	*/ 

	function wprw_send_email_onwin_setting_content(){
		echo '
		<div class="ui toggle checkbox">
		  <input type="hidden" name="wprw_send_email_onwin_setting" value="1">
		</div>
		<a href="https://1.envato.market/3KYgr"><button class="ui teal button" type="button">Upgrade for This Feature!</button></a>
		';
	}
	function wprw_emailsubject_setting_content(){
		echo '
		<div class="ui form">
			<div class="field">
				<label>'.esc_html__('Email Subject','wproulettewheel').'</label>
				<input type="text" class="wprw_mail_input_group" name="wprw_emailsubject_setting" placeholder="'.esc_attr__('Email Subject', 'wproulettewheel').'" value="" disabled="true">
			</div>
		</div>
		';
	}
	function wprw_emailmessage_setting_content(){
		echo '
		<div class="ui form">
			<div class="field">
				<label>'.esc_html__('Email Message','wproulettewheel').'</label>
					<textarea rows="8" class="wprw_mail_input_group" name="wprw_emailmessage_setting" disabled="true">'.esc_textarea(get_option('wprw_emailmessage_setting', __('Hello {firstname} {lastname}. We\'re delighted to tell you that you won the following coupon: {couponcode} granting you a 25 percent discount. Enjoy, The Coupon Company','wproulettewheel'))).'
					</textarea>
				<label>'.esc_html__('You can use the following tags: {firstname}, {lastname}, {email}, {phone}, {couponcode}','wproulettewheel').'</label>
			</div>
		</div>
		';
	}
	function wprw_customname_setting_content(){
		echo '
		<div class="ui form">
			<div class="field">
				<label>'.esc_html__('Custom Name','wproulettewheel').'</label>
				<input type="text" class="wprw_mail_input_group" name="wprw_customname_setting" placeholder="'.esc_attr__('Custom Name', 'wproulettewheel').'" value="" disabled="true">
			</div>
		</div>
		';
	}
	function wprw_customemail_setting_content(){
		echo '
		<div class="ui form">
			<div class="field">
				<label>'.esc_html__('Custom Email','wproulettewheel').'</label>
				<input type="text" class="wprw_mail_input_group" name="wprw_customemail_setting" placeholder="'.esc_attr__('Custom Email', 'wproulettewheel').'" value="" disabled="true">
			</div>
		</div>
		';
	}

	/*
	* 3.1
	* Tab: Data Collection Tab 
	* Section: Main Data Collection Section
	*/ 

	function wprw_collect_email_setting_content(){
		echo '
		<div class="ui toggle checkbox">
		  <input type="checkbox" name="wprw_collect_email_setting" value="1" '.checked(1,get_option( 'wprw_collect_email_setting', 1 ), false).'">
		  <label>&nbsp;</label>
		</div>
		';
	}
	function wprw_collect_firstname_setting_content(){
		echo '
		<div class="ui toggle checkbox">
		  <input type="checkbox" name="wprw_collect_firstname_setting" value="1" '.checked(1,get_option( 'wprw_collect_firstname_setting', 1 ), false).'">
		  <label>&nbsp;</label>
		</div>
		';
	}
	function wprw_collect_lastname_setting_content(){
		echo '
		<div class="ui toggle checkbox">
		  <input type="checkbox" name="wprw_collect_lastname_setting" value="1" '.checked(1,get_option( 'wprw_collect_lastname_setting', 0 ), false).'">
		  <label>&nbsp;</label>
		</div>
		';
	}
	function wprw_collect_phonenumber_setting_content(){
		echo '
		<div class="ui toggle checkbox">
		  <input type="checkbox" name="wprw_collect_phonenumber_setting" value="1" '.checked(1,get_option( 'wprw_collect_phonenumber_setting', 0 ), false).'">
		  <label>&nbsp;</label>
		</div>
		';
	}
	function wprw_user_rules_setting_content(){
		echo '
		<div class="ui toggle checkbox">
		  <input type="checkbox" name="wprw_user_rules_setting" value="1" '.checked(1,get_option( 'wprw_user_rules_setting', 0 ), false).'">
		  <label>'.esc_html__('Mandatory Agreement','wproulettewheel').'</label>
		</div>
		';
	}

	/*
	* 3.2
	* Tab: Data Collection Tab 
	* Section: MailChimp Settings Section
	*/ 

	function wprw_enable_mailchimp_setting_content(){
		echo '
		<div class="ui toggle checkbox">
			<input type="hidden" name="wprw_enable_mailchimp_setting" value="1">
		</div>
		<a href="https://1.envato.market/3KYgr"><button class="ui teal button" type="button">Upgrade for This Feature!</button></a>
		';
	}
	function wprw_mailchimp_api_key_setting_content(){
		echo '
		<div class="ui form">
		<div class="two fields">
			<div class="field">
				<input type="text" name="wprw_mailchimp_api_key_setting" value="" disabled="true">
			</div>
			<div class="field">
				<input type="submit" class="ui primary disabled button" value="'.esc_attr__('Connect with MailChimp','wproulettewheel').'">
			</div>
		</div>
			
		<label>'.esc_html__('Your MailChimp Lists:','wproulettewheel').'</label>
		<select class="ui fluid dropdown" name="wprw_mailchimpchosenlist_setting" disabled="true">
		';
		if (get_option('wprw_mailchimp_api_key_setting', '') != '') {
			// Get MailChimp Lists
			require_once ( WP_ROULETTE_DIR . 'includes/class-wproulettewheel-database.php' );
			$listsarray = Wproulettewheel_Database::mailchimp_lists();
			foreach ($listsarray as $listname){
				$listnameid = explode('RWSCONNECTOR', $listname);
				// $listnameid[0] will display list name, while $listnameid[1] will display list id
				echo '<option value='.esc_attr($listname).' '.selected(get_option('wprw_mailchimpchosenlist_setting', $listname)).'>'.esc_html($listnameid[0]).'</option>';
			}
			// If No List Found
			if (empty($listsarray)){
				echo '
				<option>'.esc_html__('No List Found!','wproulettewheel').'</option>
				';
			}
		} else {
			echo '
			<option>'.esc_html__('Upgrade for This Feature!','wproulettewheel').'</option>
			';
		}
		echo '</select></div>';
		
	}
	function wprw_mailchimp_optin_status_setting_content(){
		
		echo '
		<div class="grouped fields">
			<div class="field">
				<div class="ui checkbox">
					<input type="radio" name="wprw_mailchimp_optin_status_setting" value="subscribed" disabled="true">
					<label>'.esc_html__('Single Optin (User is automatically subscribed)','wproulettewheel').'</label>
				</div>
			</div>
			<div class="field wprw_margintop10">
				<div class="ui checkbox">
					<input type="radio" name="wprw_mailchimp_optin_status_setting" value="pending" disabled="true">
					<label>'.esc_html__('Double Optin (User is sent confirmation email)','wproulettewheel').'</label>
				</div>
			</div>
		</div>
		';

	}

	/*
	* 4.1
	* Tab: Display Triggers Tab
	* Section: Main Display Triggers Section
	*/ 

	function wprw_display_onpageload_setting_content(){
		echo '
		<div class="ui toggle checkbox">
		  <input type="checkbox" name="wprw_display_onpageload_setting" value="1" '.checked(1,get_option( 'wprw_display_onpageload_setting', 0 ), false).'">
		  <label>'.esc_html__('Display pop-up when the page loads','wproulettewheel').'</label>
		</div>
		';
	}
	function wprw_time_spent_onpage_setting_content(){
		echo '
		<div class="ui toggle checkbox">
		  <input type="checkbox" name="wprw_time_spent_onpage_setting" value="1" '.checked(1,get_option( 'wprw_time_spent_onpage_setting', 0 ), false).'">
		  <label>'.esc_html__('Display pop-up after X seconds','wproulettewheel').'</label>
		</div>
		';
	}
	function wprw_time_spent_seconds_setting_content(){
		echo '<div class="ui slider" id="wprw_time_spent_seconds_slider"></div>';
		echo '
			<br><br>
			<input id="wprw_time_spent_input" type="number" min="1" max="30" name="wprw_time_spent_seconds_setting" step="0.5" value="'.esc_attr(get_option( 'wprw_time_spent_seconds_setting', 15 )).'">
		';
	}

	/*
	* 4.2
	* Tab: Display Triggers Tab
	* Section: WooCommerce Triggers Section
	*/ 
	
	function wprw_display_after_woocommerce_purchase_setting_content(){
		echo '
		<div class="ui toggle checkbox">
		  <input type="hidden" name="wprw_display_after_woocommerce_purchase_setting" value="1" ">
		</div>
		<a href="https://1.envato.market/3KYgr"><button class="ui teal button" type="button">Upgrade for This Feature!</button></a>
		';
	}

	/*
	* 4.3
	* Tab: Display Triggers Tab
	* Section: Custom Triggers Section
	*/ 

	function wprw_enable_custom_triggers_setting_content(){
		echo '
		<div class="ui toggle checkbox">
		  <input type="hidden" name="wprw_enable_custom_triggers_setting" value="1" ">
		</div>
		<a href="https://1.envato.market/3KYgr"><button class="ui teal button" type="button">Upgrade for This Feature!</button></a>
		';
	}

	/*
	* 5.1
	* Tab: Sound Tab
	* Section: Sound Settings Section
	*/ 

	function wprw_enable_sound_setting_content(){
		echo '
		<div class="ui toggle checkbox">
		  <input type="checkbox" name="wprw_enable_sound_setting" value="1" '.checked(1,get_option( 'wprw_enable_sound_setting', 1 ), false).'">
		  <label>&nbsp;</label>
		</div>
		';
	}
	function wprw_chosen_sound_setting_content(){
		echo '
		<div class="grouped fields">
			<div class="field">
				<div class="ui checkbox">
					<input type="radio" name="wprw_chosen_sound_setting" value="1" '.checked(intval(get_option( 'wprw_chosen_sound_setting', 1 )), 1, false).' '.disabled(intval(get_option( 'wprw_enable_sound_setting', 1 )), 0, false).'>
					<label>'.esc_html__('Default Sound (Recommended)','wproulettewheel').'</label>
					<audio id="wprw_plyrsound1" controls>
						<source src="'.plugins_url('../includes/assets/sounds/RouletteWheel1.mp3', __FILE__).'" type="audio/mp3" />
					</audio>
				</div>
			</div>
			<div class="field">
				<div class="ui checkbox">
					<input type="radio" name="wprw_chosen_sound_setting" value="2" '.checked(intval(get_option( 'wprw_chosen_sound_setting', 1 )), 2, false).' '.disabled(intval(get_option( 'wprw_enable_sound_setting', 1 )), 0, false).'>
					<label>'.esc_html__('Roulette Sound 2','wproulettewheel').'</label>
					<audio id="wprw_plyrsound2" controls>
						<source src="'.plugins_url('../includes/assets/sounds/RouletteWheel2.wav', __FILE__).'" type="audio/wav" />
					</audio>
				</div>
			</div>
		</div>
		';
	}

	/*
	* 6.1
	* Tab: Advanced Tab
	* Section: Spin Limits Section
	*/ 

	function wprw_limitspinsemail_setting_content(){
		echo '
		<div class="ui toggle checkbox">
			<input type="checkbox" name="wprw_limitspinsemail_setting" value="1" '.checked(get_option( 'wprw_limitspinsemail_setting', 1 ),1, false).'">
			<label>&nbsp;</label>
		</div>
		';
	}
	function wprw_limitspinscookie_setting_content(){
		echo '
		<div class="ui toggle checkbox">
			<input type="checkbox" name="wprw_limitspinscookie_setting" value="1" '.checked(get_option( 'wprw_limitspinscookie_setting', 1 ),1, false).'">
			<label>&nbsp;</label>
		</div>
		';
	}
	function wprw_limitspinsip_setting_content(){
		echo '
		<div class="ui toggle checkbox">
			<input type="checkbox" name="wprw_limitspinsip_setting" value="1" '.checked(get_option( 'wprw_limitspinsip_setting', 0 ),1, false).'">
			<label>'.esc_html__('(Warning! This setting can pose issues for people using the same connection)','wproulettewheel').'</label>
		</div>
		';
	}
	function wprw_maximum_spins_peruser_setting_content(){
		echo '
		<div class="ui form">
			<div class="field">
				<label>'.esc_html__('How many times a user can spin','wproulettewheel').'</label>
				<input type="number" name="wprw_maximum_spins_peruser_setting" placeholder="'.esc_attr__('Chances to play per user', 'wproulettewheel').'" value="'.esc_attr(get_option('wprw_maximum_spins_peruser_setting', 1)).'">
			</div>
		</div>
		';
	}
	function wprw_resetspincounter_setting_content(){
		echo '
		<div class="ui form">
			<div class="field">
				<label>'.esc_html__('Reset spin counter after how many hours','wproulettewheel').'</label>
				<input type="number" name="wprw_resetspincounter_setting" placeholder="'.esc_attr__('Reset chances after X hours', 'wproulettewheel').'" value="'.esc_attr(get_option('wprw_resetspincounter_setting', 24)).'" min="1">
			</div>
			<button id="wprw_reset_spin_counter_button" class="ui orange button" type="button">'.esc_html__('Manual Spin Counter Reset','wproulettewheel').'
			</button>
		</div>
		';
	}


	/*
	* 6.2
	* Tab: Advanced Tab
	* Section: Uninstall Section
	*/ 

	function wprw_keepdata_setting_content(){
		echo '
		<div class="ui toggle checkbox">
			<input type="checkbox" name="wprw_keepdata_setting" value="1" '.checked(1,get_option( 'wprw_keepdata_setting', 0 ), false).'">
			<label>'.esc_html__('Keep collected user data and remember plugin settings after uninstall','wproulettewheel').'</label>
		</div>
		';
	}
	
	/*
	* 6.3
	* Tab: Advanced Tab
	* Section: Disable Popup Section (Website Integration SubSection)
	*/ 

	function wprw_disable_popup_setting_content(){
		echo '
		<div class="ui toggle checkbox">
			<input type="checkbox" name="wprw_disable_popup_setting" value="1" '.checked(intval(get_option( 'wprw_disable_popup_setting', 0 )), 1 , false).'">
			<label>&nbsp;</label>
		</div>
		';
	}

	/*
	* 6.4
	* Tab: Advanced Tab
	* Section: Wheel Design Section
	*/ 

	function wprw_wheel_size_setting_content(){
		echo '<div class="ui slider wprwhidden" id="wprw_wheel_size_setting_slider" disabled="true"></div>';
		echo '<input id="wprw_wheel_size_setting_input" class="wprwhidden" type="number" min="1" max="10" name="wprw_wheel_size_setting" step="0.01" value="6" disabled="true"><br>';
	}

	/*
	* 6.5
	* Tab: Advanced Tab
	* Section: Input Shortcode Design Section
	*/ 

	function wprw_input_background_setting_content(){
		echo '<input id="wprw_shortcode_background_color_picker" class="wprw_inputpicker_group" type="color" name="wprw_input_background_setting" value="#156baa" disabled="true">';
	}
	//Input Label Color
	function wprw_input_label_setting_content(){
		echo '<input id="wprw_shortcode_label_text_color_picker" class="wprw_inputpicker_group" type="color" name="wprw_input_label_setting" value="#156baa" disabled="true">';
	}
	//Submit Button Background Color
	function wprw_submit_background_setting_content(){
		echo '<input id="wprw_shortcode_submit_button_background_color_picker" class="wprw_inputpicker_group" type="color" name="wprw_submit_background_setting" value="#156baa" disabled="true">';
	}
	//Submit Button Background Hover Color
	function wprw_submit_background_hover_setting_content(){
		echo '<input id="wprw_shortcode_submit_button_background_hover_color_picker" class="wprw_inputpicker_group" type="color" name="wprw_submit_background_hover_setting" value="#156baa" disabled="true">';
	}
	//Submit Button Text Color
	function wprw_submit_text_setting_content(){
		echo '<input id="wprw_shortcode_submit_button_text_color_picker" class="wprw_inputpicker_group" type="color" name="wprw_submit_text_setting" value="#156baa" disabled="true">';
	}

	public function render_settings_page_content() {

			// Admin Menu Page Content 
			echo '<form id="wprw_admin_form" method="POST" action="options.php">';
			settings_fields('wproulettewheel');

			// Output Admin Menu Tabs
			echo '
			<div id="wprw_admin_menu" class="ui labeled icon stackable menu tabular attached">
				<a id="wprw_popup_designer_menu_tab" class="teal item '.$this->wprw_isactivetab('first').'" data-tab="first">
					<i class="paint brush icon"></i>
					'.esc_html__('Pop-Up Designer','wproulettewheel').'
				</a>
				<a class="red item '.$this->wprw_isactivetab('winlose').'" data-tab="winlose">
					<i class="gift icon"></i>
					'.esc_html__('Win & Lose','wproulettewheel').'
				</a>
				<a class="green item '.$this->wprw_isactivetab('datacollection').'" data-tab="datacollection">
					<i class="address book icon"></i>
					'.esc_html__('Data Collection','wproulettewheel').'
				</a>
				<a class="brown item '.$this->wprw_isactivetab('displaytriggers').'" data-tab="displaytriggers">
					<i class="stopwatch icon"></i>
					'.esc_html__('Display Triggers','wproulettewheel').'
				</a>
				<a class="pink item '.$this->wprw_isactivetab('sound').'" data-tab="sound">
					<i class="headphones icon"></i>
					'.esc_html__('Sound','wproulettewheel').'
				</a>
				<a class="blue item '.$this->wprw_isactivetab('advanced').'" data-tab="advanced">
					<i class="cogs icon"></i>
					'.esc_html__('Advanced','wproulettewheel').'
				</a>
				<a class="orange item '.$this->wprw_isactivetab('proversion').'" style="color: #f2711c!important;font-weight:700" data-tab="proversion">
					<i class="rocket icon"></i>
					'.esc_html__('Upgrade to PRO!','wproulettewheel').'
				</a>
			</div>
			';
			
			// Output Admin Menu Tabs Content	

			echo '<div class="ui bottom attached tab segment '.$this->wprw_isactivetab('first').'" data-tab="first">';

			// Pop-Up Designer (first) Content
			echo '<div class="ui stackable grid">';
			echo '<div id="wprw_admin_styles_column" class="six wide computer sixteen wide tablet column">'; // Left Side Column
			echo '
			<h3 class="ui block header">
				<i class="paint brush icon"></i>'.esc_html__('Pop-Up Styles and Design','wproulettewheel').'
			</h3>'
			;

			// Output Style Presets
			echo '
			<div class="grouped fields">
				<div id="wprw_styles_container">

					<div class="wprw_stylepreset wprw_midnight_blue">
						<div class="field wprw_style_label">
							<div class="ui checkbox">
								<input type="radio" name="wprw_popup_preset_setting" value="wprw_midnight_blue" '.checked(get_option( 'wprw_popup_preset_setting', 'wprw_night_sky' ), 'wprw_midnight_blue', false).'>
								<label class="wprw_style_label_container">Midnight Blue</label>
							</div>
						</div>
					</div>

					<div class="wprw_stylepreset wprw_rose_gold">
						<div class="field wprw_style_label">
							<div class="ui checkbox">
								<input type="radio" name="wprw_popup_preset_setting" value="wprw_rose_gold" '.checked(get_option( 'wprw_popup_preset_setting', 'wprw_night_sky' ), 'wprw_rose_gold', false).'>
								<label class="wprw_style_label_container">Rose Gold</label>
							</div>
						</div>
					</div>

					<div class="wprw_stylepreset wprw_cobalt_blue">
						<div class="field wprw_style_label">
							<div class="ui checkbox">
								<input type="radio" name="wprw_popup_preset_setting" value="wprw_cobalt_blue" '.checked(get_option( 'wprw_popup_preset_setting', 'wprw_night_sky' ), 'wprw_cobalt_blue', false).'>
								<label class="wprw_style_label_container">Cobalt Blue</label>
							</div>
						</div>
					</div>

					<div class="wprw_stylepreset wprw_underwater_blue">
						<div class="field wprw_style_label">
							<div class="ui checkbox">
								<input type="radio" name="wprw_popup_preset_setting" value="wprw_underwater_blue" '.checked(get_option( 'wprw_popup_preset_setting', 'wprw_night_sky' ), 'wprw_underwater_blue', false).'>
								<label class="wprw_style_label_container">Underwater Blue</label>
							</div>
						</div>
					</div>

					<div class="wprw_stylepreset wprw_morning_blue">
						<div class="field wprw_style_label">
							<div class="ui checkbox">
								<input type="radio" name="wprw_popup_preset_setting" value="wprw_morning_blue" '.checked(get_option( 'wprw_popup_preset_setting', 'wprw_night_sky' ), 'wprw_morning_blue', false).'>
								<label class="wprw_style_label_container">Morning Blue</label>
							</div>
						</div>
					</div>

					<div class="wprw_stylepreset wprw_purple_waters">
						<div class="field wprw_style_label">
							<div class="ui checkbox">
								<input type="radio" name="wprw_popup_preset_setting" value="wprw_purple_waters" '.checked(get_option( 'wprw_popup_preset_setting', 'wprw_night_sky' ), 'wprw_purple_waters', false).'>
								<label class="wprw_style_label_container">Purple Waters</label>
							</div>
						</div>
					</div>

					<div class="wprw_stylepreset wprw_night_sky">
						<div class="field wprw_style_label">
							<div class="ui checkbox">
								<input type="radio" name="wprw_popup_preset_setting" value="wprw_night_sky" '.checked(get_option( 'wprw_popup_preset_setting', 'wprw_night_sky' ), 'wprw_night_sky', false).'>
								<label class="wprw_style_label_container">Night Sky</label>
							</div>
						</div>
					</div>

					<div class="wprw_stylepreset wprw_casino_purple">
						<div class="field wprw_style_label">
							<div class="ui checkbox">
								<input type="radio" name="wprw_popup_preset_setting" value="wprw_casino_purple" '.checked(get_option( 'wprw_popup_preset_setting', 'wprw_night_sky' ), 'wprw_casino_purple', false).'>
								<label class="wprw_style_label_container">Casino Purple</label>
							</div>
						</div>
					</div>

					<div class="wprw_stylepreset wprw_winter_night">
						<div class="field wprw_style_label">
							<div class="ui checkbox">
								<input type="radio" name="wprw_popup_preset_setting" value="wprw_winter_night" '.checked(get_option( 'wprw_popup_preset_setting', 'wprw_night_sky' ), 'wprw_winter_night', false).'>
								<label class="wprw_style_label_container">Winter Night</label>
							</div>
						</div>
					</div>

					<div class="wprw_stylepreset wprw_cherry_flowers">
						<div class="field wprw_style_label">
							<div class="ui checkbox">
								<input type="radio" name="wprw_popup_preset_setting" value="wprw_cherry_flowers" '.checked(get_option( 'wprw_popup_preset_setting', 'wprw_night_sky' ), 'wprw_cherry_flowers', false).'>
								<label class="wprw_style_label_container">Cherry Flowers</label>
							</div>
						</div>
					</div>

					<div class="wprw_stylepreset wprw_snow_blanket">
						<div class="field wprw_style_label">
							<div class="ui checkbox">
								<input type="radio" name="wprw_popup_preset_setting" value="wprw_snow_blanket" '.checked(get_option( 'wprw_popup_preset_setting', 'wprw_night_sky' ), 'wprw_snow_blanket', false).'>
								<label class="wprw_style_label_container">Snow Blanket</label>
							</div>
						</div>
					</div>

					<div class="wprw_stylepreset wprw_custom_style">
						<div class="field wprw_style_label">
							<div class="ui checkbox">
								<input type="radio" name="wprw_popup_preset_setting" value="wprw_custom_style" '.checked(get_option( 'wprw_popup_preset_setting', 'wprw_night_sky' ), 'wprw_custom_style', false).'>
								<label class="wprw_style_label_container">'.esc_html__('Custom Style','wproulettewheel').'</label>
								<i class="wprw_custom_style_icon pencil alternate icon"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<h3 class="ui block header">
				<i class="magic icon"></i>
				'.esc_html__('Animation Picker','wproulettewheel').'
			</h3>
			<div class="wprw_animations_container">

				<div class="field">
					<div class="ui checkbox">
						<input type="radio" name="wprw_chosen_animation_setting" value="none" '.checked(get_option( 'wprw_chosen_animation_setting', 'starfall' ), 'none', false).'>
						<label>'.esc_html__('None','wproulettewheel').'</label>
					</div>
				</div>
				<div class="field">
					<div class="ui checkbox">
						<input type="radio" name="wprw_chosen_animation_setting" value="snowfall" '.checked(get_option( 'wprw_chosen_animation_setting', 'starfall' ), 'snowfall', false).'>
						<label><i class="snowflake outline icon"></i>'.esc_html__('Soft Snow','wproulettewheel').'</label>
					</div>
				</div>
					<div class="field">
						<div class="ui checkbox">
							<input type="radio" name="wprw_chosen_animation_setting" value="starfall" '.checked(get_option( 'wprw_chosen_animation_setting', 'starfall' ), 'starfall', false).'>
							<label><i class="star icon"></i>'.esc_html__('Falling Stars','wproulettewheel').'</label>
						</div>
					</div>
				</div>
				<br>
				<a class="wprw_flexjustifycenter" href="https://1.envato.market/3KYgr"><button class="ui teal button" type="button">This Feature is Only Available in Preview! Upgrade!</button></a>
			</div>


			<div class="ten wide computer sixteen wide tablet column"> <!-- Right Side Colum -->
				<h3 class="ui block header">
					<i class="play circle icon"></i>
					'.esc_html__('Pop-Up Preview','wproulettewheel').'
				</h3>
				<div id="wprw_popup_preview">
					<div id="particlesContainerPreview"></div>
					<div id="wprw_popup_preview_left">
						<div class="ui grid wprw_width100">
							<div id="wprw_previewcenter" class="nine wide column">
								<div id="wprw_wheel_preview"></div>
							</div>
							<div class="seven wide column"> 	
								<div id="wprw_main_popup_form" class="ui large form">
									<h2 class="ui header">
										<i id="wprw_popup_header_icon" class="gift icon"></i>
										<div id="wprw_popup_header" class="content">
										'.esc_html(get_option('wprw_popup_header_text_setting', __('Spin to Win a Prize', 'wproulettewheel'))).'
										</div>
									</h2>
									<div class="field">
										<label>'.esc_html__('First Name','wproulettewheel').'</label>
										<input type="text" name="first-name" placeholder="'.esc_attr__('First Name','wproulettewheel').'" >
									</div>
									<div class="field">
										<label>'.esc_html__('Email','wproulettewheel').'</label>
										<input type="email" name="email" placeholder="'.esc_attr__('Email Address','wproulettewheel').'" >
									</div>
									<div class="field">
										<label>'.esc_html__('Phone Number','wproulettewheel').'</label>
										<input type="tel" name="phone-number" placeholder="'.esc_attr__('Phone Number','wproulettewheel').'" >
									</div>
									<div class="field">
										<div class="ui checkbox">
										  <input type="checkbox" tabindex="0" >
										  <label>'.esc_html__('I agree to the Terms and Conditions','wproulettewheel').'</label>
									   </div>
									</div>
									<div class="field">
										<label>'.esc_html__('Choose Lucky Number','wproulettewheel').'</label>
										<input id="wprw-chosenFieldPreview" type="number" min="0" max="36">
									</div>
									<button id="wprw-btnSpinPreview" class="ui button" type="button">
										<i class="play icon"></i>
										'.esc_html(get_option('wprw_play_button_text_setting', __('Spin the Wheel!','wproulettewheel'))).'
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- SECOND ROW HERE -->

		<div class="ui stackable grid">
			<div class="six wide column"> 
				<h3 class="ui block header">
					<i class="newspaper icon"></i>
					'.esc_html__('Pop-Up Text Settings','wproulettewheel').'
				</h3>
				<table class="form-table">
				';
				do_settings_fields( 'wproulettewheel', 'rouletteoptions_popuptextsettings' );
				echo '
				</table>
			</div>
			<div class="ten wide column"> 
				<h3 class="ui block header">
					<i class="pencil alternate icon"></i>
					'.esc_html__('Custom Style Design','wproulettewheel').'
				</h3>
				<div id="wprw_generatecoupon_card" class="ui card">
				  	<div class="content">
						<div class="ui grid">
							<div class="eight wide column"> 
							';
							echo '<table class="form-table">'; 
							do_settings_fields( 'wproulettewheel', 'rouletteoptions_customstyleleft' );
							echo '</table>';

							echo '
							</div>
							<div class="eight wide column"> 
							';

							echo '<table class="form-table">'; 
							do_settings_fields( 'wproulettewheel', 'rouletteoptions_customstyleright' );
							echo '</table>';

							echo '
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>';

// FIRST TAB SETTINGS END

echo '
	<div class="ui bottom attached tab segment '.$this->wprw_isactivetab('winlose').'" data-tab="winlose">
		<h2 class="ui block header">
			<i class="gift icon"></i>
			<div class="content">
				'.esc_html__('Win & Lose','wproulettewheel').'
				<div class="sub header">
					'.esc_html__('Win probability, messages, coupons and mailing','wproulettewheel').'
				</div>
			</div>
		</h2>
	';

		echo '<table class="form-table">'; 
		do_settings_fields( 'wproulettewheel', 'rouletteoptions_winlose' );
		echo '</table>';

		echo '
		<h3 class="ui block header">
			<i class="shopping basket icon"></i>
			'.esc_html__('Coupon Settings','wproulettewheel').'					  
		</h3>
		';

		echo '<table class="form-table">'; 
		do_settings_fields( 'wproulettewheel', 'rouletteoptions_coupons' );
		echo '</table>';

	   echo '
		<h3 class="ui block header">
			<i class="envelope open  icon"></i>					  
			'.esc_html__('Mailing Settings','wproulettewheel').'	
		</h3>
		';

		echo '<table class="form-table">'; 
		do_settings_fields( 'wproulettewheel', 'rouletteoptions_mailing' );
		echo '</table>';

echo '
	</div>
	<div class="ui bottom attached tab segment '.$this->wprw_isactivetab('datacollection').'" data-tab="datacollection">
		<h2 class="ui block header">
			<i class="id badge outline icon"></i>
			<div class="content">
				'.esc_html__('Data Collection Settings','wproulettewheel').'
				<div class="sub header">
					'.esc_html__('Collect user data. Integrate 3rd parties.','wproulettewheel').'
				</div>
			</div>
		</h2>
	';
		echo '<table class="form-table">'; 
		do_settings_fields( 'wproulettewheel', 'rouletteoptions_datacollection' );
		echo '</table>';
								
		echo '
		<br>
		<div id="wprw_download_users_button" class="ui labeled button" tabindex="0">
			<div class="ui teal button">
				<i class="address book icon"></i> 
				'.esc_html__('Download Users','wproulettewheel').'
			</div>
			<a class="ui basic green left pointing label">';
				// Get current number of users in database
				require_once ( WP_ROULETTE_DIR . 'includes/class-wproulettewheel-database.php' );
				echo Wproulettewheel_Database::usersnumber();
			echo'
			</a>
		</div>
		<button id="wprw_download_emails_button" class="ui teal basic button" type="button">
			<i class="download icon"></i>
			'.esc_html__('Download Email List Only','wproulettewheel').'
		</button>
		<br>
		<h3 class="ui block header">
			<i class="linkify icon"></i>
			'.esc_html__('Connect with MailChimp','wproulettewheel').'
		</h3>
		';

		echo '<table class="form-table">'; 
		do_settings_fields( 'wproulettewheel', 'rouletteoptions_mailchimp' );
		echo '</table>';
		
		echo'
	</div>
	
	<div class="ui bottom attached tab segment '.$this->wprw_isactivetab('displaytriggers').'" data-tab="displaytriggers">';
	echo '
		<h2 class="ui block header">
			<i class="hourglass half icon"></i>
			<div class="content">
				'.esc_html__('Pop-Up Display Settings','wproulettewheel').'
				<div class="sub header">
					'.esc_html__('Display triggers and timing settings','wproulettewheel').'
				</div>
			</div>
		</h2>
		';

		echo '<table class="form-table">'; 
		do_settings_fields( 'wproulettewheel', 'rouletteoptions_displaytriggers' );
		echo '</table>';

		echo '
		<h3 class="ui block header">
			<i class="wordpress icon"></i>
			'.esc_html__('WooCommerce Triggers','wproulettewheel').'
		</h3>';

		echo '<table class="form-table">'; 
		do_settings_fields( 'wproulettewheel', 'rouletteoptions_woocommercetriggers' );
		echo '</table>';

		echo '
		<h3 class="ui block header">
			<i class="code icon"></i>
			'.esc_html__('Custom Triggers','wproulettewheel').'
		</h3>';

		echo '<table class="form-table">'; 
		do_settings_fields( 'wproulettewheel', 'rouletteoptions_customtriggers' );
		echo '</table>';
		
		echo '
	</div>

	<div class="ui bottom attached tab segment '.$this->wprw_isactivetab('sound').'" data-tab="sound">
		<h3 class="ui block header">
			<i class="bell outline icon"></i>
			'.esc_html__('Sound Settings','wproulettewheel').'
		</h3>
		';
		
		echo '<table class="form-table">'; 
		do_settings_fields( 'wproulettewheel', 'rouletteoptions_soundsettings' );
		echo '</table>';
								
		echo '
	</div>

	<div class="ui bottom attached tab segment '.$this->wprw_isactivetab('advanced').'" data-tab="advanced">
		<h2 class="ui block header">
			<i class="settings icon"></i>
			<div class="content">
				'.esc_html__('Advanced Settings','wproulettewheel').'
				<div class="sub header">
					'.esc_html__('Advanced Settings and Developer Options','wproulettewheel').'
				</div>
			</div>
		</h2>
		';
		
		echo '
		<h3 class="ui block header">
			<i class="sliders horizontal icon"></i>
			'.esc_html__('Spin Limits','wproulettewheel').'
		</h3>';

		echo '<table class="form-table">'; 
		do_settings_fields( 'wproulettewheel', 'rouletteoptions_spinlimits' );
		echo '</table>';

		echo '
		<h3 class="ui block header">
			<i class="trash alternate outline icon"></i>
			'.esc_html__('Uninstall','wproulettewheel').'
		</h3>';

		echo '<table class="form-table">'; 
		do_settings_fields( 'wproulettewheel', 'rouletteoptions_uninstall' );
		echo '</table>';
	echo '
		<h2 class="ui block header">
			<i class="object group outline icon"></i>
			<div class="content">
				'.esc_html__('Website Integration','wproulettewheel').'
				<div class="sub header">
					'.esc_html__('Integrate the wheel in your website page(s)','wproulettewheel').'
				</div>
			</div>
		</h2>
		';

		echo '
		<div class="ui stackable grid">
			<div class="eight wide middle aligned column">
				<a class="wprw_flexjustifycenter" href="https://1.envato.market/3KYgr"><button class="ui teal button" type="button">Upgrade for This Feature!</button></a>
				
				<div class="ui large celled ordered list">

				</div>
			</div>
		<div class="eight wide column wprw_flexjustifycenter">
			<img src="'.plugins_url('assets/images/website-example.png', __FILE__).'" width="400" height="250"/> 
		</div>
	</div>
	';
	
	//Notice message
	echo '
	<div class="ui warning message wprw_width100">
		<i class="close icon"></i>
		<div class="header">
			Notice!
		</div>
		<br>
		'.esc_html__('Changes made below only affect the output of ','wproulettewheel').'<strong>'.esc_html__('shortcodes','wproulettewheel').'</strong>'.esc_html__(', to help you integrate the wheel in a website page. Changes below have ','wproulettewheel').'<strong>'.esc_html__('no effect on pop-up','wproulettewheel').'</strong> '.esc_html__('wheel or input design.','wproulettewheel').'
	</div>
	';
	echo '
	<div class="ui stackable grid">
		<div class="eight wide column"> <!-- LEFT SIDE COLUMN -->
			<h3 class="ui block header">
				<i class="paint brush icon"></i>
				'.esc_html__('Wheel Design (Shortcode)','wproulettewheel').'
			</h3>
			<a class="wprw_flexjustifycenter middle aligned" href="https://1.envato.market/3KYgr"><button class="ui teal button" type="button">Upgrade for This Feature!</button></a>
			';
			echo '<table class="form-table">'; 
			do_settings_fields( 'wproulettewheel', 'rouletteoptions_wheeldesign' );
			echo '</table>
		</div>
		<div id="wprw_livewheelpreview" class="eight wide column"> <!-- RIGHT SIDE COLUMN -->
			<h3 class="ui block header">
				<i class="play circle icon"></i>
				'.esc_html__('Live Wheel Preview (Shortcode)','wproulettewheel').'
			</h3>';

			echo Wproulettewheel::wprw_wheelContent();
		echo '
		</div>
	</div>
	<div class="ui stackable grid">
		<div class="eight wide column"> <!-- LEFT SIDE COLUMN -->
			<h3 class="ui block header">
				<i class="paint brush icon"></i>
				'.esc_html__('Input Design (Shortcode)','wproulettewheel').'
			</h3>
			<a class="wprw_flexjustifycenter" href="https://1.envato.market/3KYgr"><button class="ui teal button" type="button">Upgrade for This Feature!</button></a>';
			echo '<table class="form-table">'; 
			do_settings_fields( 'wproulettewheel', 'rouletteoptions_inputshortcode' );
			echo '</table>
		</div>
		<div class="eight wide column"> <!-- RIGHT SIDE COLUMN -->
			<h3 class="ui block header">
				<i class="play circle icon"></i>
				'.esc_html__('Input Preview (Shortcode)','wproulettewheel').'
			</h3>
			';
			echo Wproulettewheel::wprw_wheelInput('admin');
			echo '
		</div>
	</div>
</div>
<div class="ui bottom attached tab segment '.$this->wprw_isactivetab('proversion').'" data-tab="proversion">
	<h2 class="ui block header">
		<i class="rocket icon"></i>
		<div class="content">
			'.esc_html__('Upgrade to PRO Version','wproulettewheel').'
			<div class="sub header">
				'.esc_html__('Unlock all features! Boost your Conversions and Income!','wproulettewheel').'
			</div>
		</div>
	</h2>
	<a class="wprw_flexjustifycenter" href="https://1.envato.market/3KYgr"><button class="ui teal large button" type="button">Upgrade to PRO Version!</button></a>
	<div class="ui icon message">
		<i class="gift icon"></i>
		<div class="content">
			<div class="header">
				Unlock Coupons
			</div>
			<p>Incentivize users to come back for repeat business and purchases</p>
	  	</div>
	</div>
	<div class="ui icon message">
		<i class="envelope icon"></i>
		<div class="content">
			<div class="header">
				Unlock Mailing
			</div>
			<p>Immediately contact users, send coupons by mail and maximize engagement</p>
	  	</div>
	</div>
	<div class="ui icon message">
		<i class="magic icon"></i>
		<div class="content">
			<div class="header">
				Unlock Animations
			</div>
			<p>Stunning effects that captivate and impress your audience</p>
	  	</div>
	</div>
	<div class="ui icon message">
		<i class="linkify icon"></i>
		<div class="content">
			<div class="header">
				Unlock MailChimp Integration
			</div>
			<p>Send users straight to your MailChimp lists. Build a powerful and relevant email newsletter list.</p>
	  	</div>
	</div>
	<div class="ui icon message">
		<i class="wordpress icon"></i>
		<div class="content">
			<div class="header">
				Powerful WooCommerce Triggers
			</div>
			<p>Maximize repeat business with WooCommerce-specific display triggers</p>
	  	</div>
	</div>
	<div class="ui icon message">
		<i class="code icon"></i>
		<div class="content">
			<div class="header">
				Custom Triggers
			</div>
			<p>Display pop-ups wherever you want with custom triggers</p>
	  	</div>
	</div>
	<div class="ui icon message">
		<i class="object group outline icon"></i>
		<div class="content">
			<div class="header">
				Website Integration
			</div>
			<p>Integrate the Roulette Wheel as a static / standalone game in your website pages</p>
	  	</div>
	</div>
	<div class="ui icon message">
		<i class="paint brush icon"></i>
		<div class="content">
			<div class="header">
				Unlock Shortcode Designer
			</div>
			<p>Unlock shortcodes and the powerful shortcode designer</p>
	  	</div>
	</div>
	<a class="wprw_flexjustifycenter" href="https://1.envato.market/3KYgr"><button class="ui teal large button" type="button">Upgrade to PRO Version!</button></a>
</div>
<br>
<input type="submit" name="submit" id="submit" class="ui primary button" value="Save Settings">
</form>';

	}

	function wprw_isactivetab($tab){
		$gototab = get_option( 'wprw_current_tab_setting', 'first' );
		if ($tab === $gototab){
			return 'active';
		} 
	}

}