<?php

/**
 * Fired when the plugin is uninstalled.
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Check if Keep Data and Settings on Uninstall option is activated. If activated, do not erase data and settings
$keep_data_setting = boolval(get_option( 'wprw_keepdata_setting', 0 ));

// If "keep data" option is NOT activated
if (!$keep_data_setting) {

	// List all options
	$optionlist = array('wprw_submit_text_setting','wprw_submit_background_hover_setting','wprw_submit_background_setting','wprw_input_label_setting','wprw_input_background_setting','wprw_wheel_size_setting','wprw_disable_popup_setting','wprw_keepdata_setting','wprw_resetspincounter_setting','wprw_maximum_spins_peruser_setting','wprw_limitspinsip_setting','wprw_limitspinscookie_setting','wprw_limitspinsemail_setting','wprw_chosen_sound_setting','wprw_enable_sound_setting','wprw_enable_custom_triggers_setting','wprw_display_after_woocommerce_purchase_setting','wprw_time_spent_seconds_setting','wprw_time_spent_onpage_setting','wprw_display_onpageload_setting','wprw_mailchimp_optin_status_setting','wprw_mailchimpchosenlist_setting','wprw_mailchimp_api_key_setting','wprw_enable_mailchimp_setting','wprw_user_rules_setting','wprw_collect_phonenumber_setting','wprw_collect_lastname_setting','wprw_collect_firstname_setting','wprw_collect_email_setting','wprw_customemail_setting','wprw_customname_setting','wprw_emailmessage_setting','wprw_emailsubject_setting','wprw_send_email_onwin_setting','wprw_generatedcouponexpiry_setting','wprw_generatedcouponamount_setting','wprw_generatedcoupontype_setting','wprw_existing_coupon_setting','wprw_customcoupontext_setting','wprw_chosen_coupon_setting','wprw_enable_coupons_setting','wprw_lose_message_setting','wprw_win_message_setting','wprw_win_probability_setting','wprw_chosen_animation_setting','wprw_popup_preset_setting','wprw_popup_submit_text_color_setting','wprw_popup_submit_background_hover_color_setting','wprw_popup_submit_background_color_setting','wprw_popup_text_color_setting','wprw_popup_border_color_setting','wprw_popup_background_gradient_end_setting','wprw_popup_background_gradient_start_setting','wprw_current_tab_setting','wprw_play_button_text_setting'); 

	// Delete all options
	foreach ($optionlist as $option_name){ 
		delete_option($option_name);
	} 
	  
	// Drop a custom database table
	global $wpdb;
	$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}wprw_roulettewheel");
}