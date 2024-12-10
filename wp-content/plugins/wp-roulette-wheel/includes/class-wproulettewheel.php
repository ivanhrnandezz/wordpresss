<?php

class Wproulettewheel {

	function __construct() {
		// Handle Ajax Requests
		if ( wp_doing_ajax() ){
			add_action( 'wp_ajax_handleinsertrequest', array($this, 'handleinsertrequest') );
    		add_action( 'wp_ajax_nopriv_handleinsertrequest', array($this, 'handleinsertrequest') );
    		add_action( 'wp_ajax_handlecouponrequest', array($this, 'handlecouponrequest') );
    		add_action( 'wp_ajax_nopriv_handlecouponrequest', array($this, 'handlecouponrequest') );
    		add_action( 'wp_ajax_handlepermissionrequest', array($this, 'handlepermissionrequest') );
    		add_action( 'wp_ajax_nopriv_handlepermissionrequest', array($this, 'handlepermissionrequest') );
    		add_action( 'wp_ajax_handledownloadrequest', array($this, 'handledownloadrequest') ); 
    		add_action( 'wp_ajax_resetspinsrequest', array($this, 'resetspinsrequest') ); 
		}

		// Run Cron Jobs
		require_once ( WP_ROULETTE_DIR . 'includes/class-wproulettewheel-database.php' );
		Wproulettewheel_Database::cronjob_reset_spins_counter();

		// Run Admin/Public code 
		if ( is_admin() ) { 
			require_once WP_ROULETTE_DIR . '/admin/class-wproulettewheel-admin.php';
			$admin = new Wproulettewheel_Admin();
		} else if ( !$this->wprw_is_login_page() ) {
			require_once WP_ROULETTE_DIR . '/public/class-wproulettewheel-public.php';
			$public = new Wproulettewheel_Public();
		}
		
	}

	// Helps prevent public code from running on login / register pages, where is_admin() returns false
	function wprw_is_login_page() {
	    return in_array(
	      $GLOBALS['pagenow'],
	      array( 'wp-login.php', 'wp-register.php' ),
	      true
	    );
	}
	
	// Displays Roulette Wheel
	public static function wprw_wheelContent($ispopup = 'no') {

    	include ( WP_ROULETTE_DIR . 'includes/templates/wheel-display-template.php' );

    }

    // Displays Roulette Wheel Input
    public static function wprw_wheelInput($isadmin = 'no') {

    	include ( WP_ROULETTE_DIR . 'includes/templates/input-display-template.php' );

    }

    // Handles AJAX insert / update request
    function handleinsertrequest(){
    	
    	// Check security nonce. 
		if ( ! check_ajax_referer( 'wprw_security_nonce', 'security' ) ) {
		  	wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}
		
		// If nonce verification didn't fail, run the code
		require_once ( WP_ROULETTE_DIR . 'includes/class-wproulettewheel-database.php' );

		$user_is_new = Wproulettewheel_Database::user_is_new();

		if ($user_is_new === 'yes') {
			Wproulettewheel_Database::insert();
		} else if ($user_is_new === 'no'){
			// Check if user can Spin. Has been checked already, but we need to recheck server-side to be sure user is not trying to cheat by directly running the JavaScript
			$permission = Wproulettewheel_Database::user_can_spin();
			if ($permission === 'yes'){
				Wproulettewheel_Database::update();
			} else if ($permission === 'no'){
				// DO NOTHING
			}
		}

	}

	// Handles AJAX Permission Request
	function handlepermissionrequest(){

    	// Check security nonce. 
		if ( ! check_ajax_referer( 'wprw_security_nonce', 'security' ) ) {
		  	wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}
		
		// If nonce verification didn't fail, run further
		require_once ( WP_ROULETTE_DIR . 'includes/class-wproulettewheel-database.php' );
		//Check if user can Spin
		$permission = Wproulettewheel_Database::user_can_spin(); //permission is 'yes' or 'no' string

		//Return permission check result to JavaScript wheel spin file
		echo $permission;

		exit();

	}

	// Handles AJAX Download requests, enabling the download of emails and users in the Admin panel
	function handledownloadrequest(){

    	// Check security nonce. 
		if ( ! check_ajax_referer( 'wprw_adminsecurity_nonce', 'security' ) ) {
		  	wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		} 
		
		// If nonce verification didn't fail, run further
		require_once ( WP_ROULETTE_DIR . 'includes/class-wproulettewheel-database.php' );
		if ($_REQUEST['requests'] === 'users'){
			Wproulettewheel_Database::download('users');
		}
		if ($_REQUEST['requests'] === 'emails'){
			Wproulettewheel_Database::download('emails');
		}
	}

	// Handles AJAX Coupon request
	function handlecouponrequest(){

    	// Check security nonce. 
    	if ( ! check_ajax_referer( 'wprw_security_nonce', 'security' ) ) {
		  	wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		} 
		
		// If nonce verification didn't fail, run further
		require_once ( WP_ROULETTE_DIR . 'includes/class-wproulettewheel-database.php' );

		/**
		* Check if user can Spin. Has been checked already, but we need to recheck server-side to be sure user is not trying to cheat by directly running the JavaScript
		*/
		$permission = Wproulettewheel_Database::user_can_spin();

		if ($permission === 'yes'){

			// Check what kind of coupon setting is enabled (auto generated, existing coupon or custom)
			$coupontype = intval(get_option( 'wprw_chosen_coupon_setting', 1 ));
			// if Auto Generated coupon
			if ($coupontype === 1){
				$sendtype = get_option( 'wprw_generatedcoupontype_setting', 'percent' );
				$sendamount = get_option( 'wprw_generatedcouponamount_setting', '25' );
				$sendexpiry = get_option( 'wprw_generatedcouponexpiry_setting', '30' );
				$usercoupon = trim(Wproulettewheel_Database::generate_coupon($sendtype, $sendamount, $sendexpiry));
			// if Existing coupon
			} else if ($coupontype === 2){
				$usercoupon = get_option( 'wprw_existing_coupon_setting');
			// if Custom coupon
			} else if ($coupontype === 3){
				$usercoupon = get_option( 'wprw_customcoupontext_setting');
			}
			
			// IF "Send Email on Win Setting" enabled-> send the generated coupon via email
			if (intval(get_option('wprw_send_email_onwin_setting', 0)) === 1){
				if (intval(get_option('wprw_collect_email_setting', 1)) === 1){ // If there is a collected user email to send the coupon to
					Wproulettewheel_Database::send_coupon_email($usercoupon);
				}
			}
			echo $usercoupon;
			exit();
		} else if ($permission === 'no'){
			// If user tries to cheat via Javascript, display this
			echo 'https://www.youtube.com/watch?v=msX4oAXpvUE'; 
			exit();
		}
	}

	// Handles AJAX reset spins request, manually resetting spins in the admin panel 
	function resetspinsrequest(){

		// Check security nonce. 
   		if ( ! check_ajax_referer( 'wprw_adminsecurity_nonce', 'security' ) ) {
		  	wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		} 
		
		// If nonce verification didn't fail, run further
		require_once ( WP_ROULETTE_DIR . 'includes/class-wproulettewheel-database.php' );
		$response = Wproulettewheel_Database::reset_spins();
		echo $response;
		exit();
	}
	
}
?>
