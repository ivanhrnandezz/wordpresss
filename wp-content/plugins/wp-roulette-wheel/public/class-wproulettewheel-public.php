<?php

class Wproulettewheel_Public{


	function __construct() {
		// Register public styles and scripts, but enqueue only when the shortcode is used or popup is initialized
		add_action('wp_enqueue_scripts', array($this, 'register_public_resources'));
		 		
		$initialize = $this->wprw_initialization_check(); // either 'popup' or 'shortcode'
		if ($initialize === 'popup'){
			// Enqueue Resources Immediately
			add_action('wp_enqueue_scripts', array($this, 'enqueue_public_resources'));
			// Initialize Pop-Up
			add_action('wp_footer', array($this, 'wprw_popup_init'));
		} else if ($initialize === 'shortcode'){
			// Shortcodes only work if the pop-up is disabled
		}

	}

	// Checks and returns what should be initialized, if anything. Ensures things are not loaded unnecessarily
	function wprw_initialization_check(){
		// First check if the pop-up functionality is disabled in Advanced Settings
		$popup_disabled = intval(get_option( 'wprw_disable_popup_setting', 0 ));
		if($popup_disabled === 1){
			// Popup should not be loaded. Load Shortcodes
			return 'shortcode';
		} else {
			// Check if any of the triggers  are enabled
			$pageLoadTrigger = intval(get_option( 'wprw_display_onpageload_setting', 0 ));
			$timeSpentPageTrigger = intval(get_option( 'wprw_time_spent_onpage_setting', 0 ));
			if ( ( $pageLoadTrigger + $timeSpentPageTrigger ) > 0 ){
				// if enabled, initialize popup
				return 'popup';
			} else {
				return 'shortcode';
			}
		}
	}


	// Initialize the pop-up
	function wprw_popup_init(){

		include ( WP_ROULETTE_DIR . 'includes/templates/popup-display-template.php' );
	}
	
	function register_public_resources(){
		// Register styles
		wp_register_style('wprw_style', plugins_url('../includes/assets/css/style.css', __FILE__));
	    wp_register_style('wprw_wheel_style', plugins_url('../includes/assets/css/wheelstyle.css', __FILE__));
	    wp_register_style( 'semanticcss', plugins_url('../includes/assets/lib/semantic/semantic.min.css', __FILE__));

	    // Register scripts
	    wp_register_script('semantic', plugins_url('../includes/assets/lib/semantic/semantic.min.js', __FILE__), $deps = array(), $ver = false, $in_footer =true);
		wp_register_script('jquery_keyframes', plugins_url('../includes/assets/lib/jquerykeyframes/jquery.keyframes.js', __FILE__), $deps = array(), $ver = false, $in_footer =true);
		wp_register_script('wprw_wheel_spin', plugins_url('../includes/assets/js/wheelspin.js', __FILE__), $deps = array(), $ver = false, $in_footer =true);
		wp_register_script('wheelpopup', plugins_url('../includes/assets/js/wheelpopup.js', __FILE__), $deps = array(), $ver = false, $in_footer =true);
		wp_register_script('particlesjs', plugins_url('../includes/assets/lib/particles/particles.min.js', __FILE__), $deps = array(), $ver = false, $in_footer =true);
	}
	
	function enqueue_public_resources(){

		wp_enqueue_script('jquery'); // already registered by default in WP
		wp_enqueue_script('jquery_keyframes'); 

		wp_enqueue_style( 'semanticcss');
		wp_enqueue_script('semantic');
		
		wp_enqueue_style('wprw_style');
		wp_enqueue_style('wprw_wheel_style');
		wp_enqueue_script('wprw_wheel_spin');
		
		// Scripts necessary only for popups
    	$popup_disabled = intval(get_option( 'wprw_disable_popup_setting', 0 ));
    	if($popup_disabled === 0){
    		wp_enqueue_script('wheelpopup');
    		wp_enqueue_script('particlesjs');
    	}

    	// Send display settings to JS
    	$datatoBePassed = array(
    		'wprw_disable_popup_setting' => intval(get_option( 'wprw_disable_popup_setting', 0 )),
	        'wprw_display_onpageload_setting' =>  intval(get_option( 'wprw_display_onpageload_setting', 0 )),
	        'wprw_enable_custom_triggers_setting' => 0,
	      	'wprw_time_spent_onpage_setting' =>  intval(get_option( 'wprw_time_spent_onpage_setting', 0 )),
	      	'wprw_enable_sound_setting' =>  intval(get_option( 'wprw_enable_sound_setting', 1 )),
	      	'wprw_enable_coupons_setting' =>  0,
	      	'wprw_chosen_sound_setting' =>  intval(get_option( 'wprw_chosen_sound_setting', 1 )),
	      	'wprw_chosen_coupon_setting' =>  intval(get_option( 'wprw_chosen_coupon_setting', 1 )),
	      	'wprw_current_tab_setting' =>  get_option( 'wprw_current_tab_setting', 'first' ), // string
	      	'wprw_customcoupontext_setting' =>  get_option( 'wprw_customcoupontext_setting', 'WIN2020JKS2S' ), // string
	      	'wprw_existing_coupon_setting' =>  get_option( 'wprw_existing_coupon_setting' ), // string
			'wprw_time_spent_seconds_setting' =>  floatval(get_option( 'wprw_time_spent_seconds_setting', 15 )),
			'win_probability_setting' => get_option( 'wprw_win_probability_setting', 50 ),
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'security'  => wp_create_nonce( 'wprw_security_nonce' ),
			'plugins_url' => plugins_url('../', __FILE__),
			'chosen_animation' => get_option( 'wprw_chosen_animation_setting', 'none' ),
		);
		wp_localize_script( 'wprw_wheel_spin', 'wprw_display_settings', $datatoBePassed );

		// Send translations to JS
		$datatoBePassedTranslation = array(
			'winmessage' => esc_html(get_option('wprw_win_message_setting', __('You won! Your Prize is an Exclusive 25% Discount Coupon','wproulettewheel'))),
			'losemessage' => esc_html(get_option( 'wprw_lose_message_setting', __('You lost! Don\'t give up. Try again later!','wproulettewheel'))),
			'not_have_permission' => esc_html__('Sorry, you have already played too many times! Try again later.','wproulettewheel'),
			'your_coupon_is' => esc_html__('Your coupon code is:','wproulettewheel'),
			'you_won' => esc_html__('You Won!','wproulettewheel'),
			'you_lost' => esc_html__('You Lost!','wproulettewheel'),
			'dont_give_up' => esc_html__('Don\'t Give Up!', 'wproulettewheel'),

		);
		wp_localize_script( 'wprw_wheel_spin', 'wprw_display_translation', $datatoBePassedTranslation );
    }	

}

?>