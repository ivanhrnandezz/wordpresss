<?php

/**
*
* PHP File that contains all functions that deal with Database interaction and manipulation
*
*/


class Wproulettewheel_Database {

	// Inserts new user into the database
	public static function insert() {
		
		global $wpdb;

		$tableprefix = $wpdb->prefix;
		$table_name = $tableprefix.'wprw_roulettewheel';

		$maxspins = get_option('wprw_maximum_spins_peruser_setting', 1);
		$spinsleft = $maxspins - 1;
		$userip = self::get_user_ip();
		$usercookie = $_COOKIE['wprw_roulettewheel_cookie'];

		if (trim($_POST['coupon']) === 'nocoupon'){
			$coupon = null;
		} else {
			$coupon = trim($_POST['coupon']);
		}

		$sanitized_cookie = sanitize_text_field($usercookie);
		$sanitized_first_name = sanitize_text_field($_POST['first-name']);
		$sanitized_last_name = sanitize_text_field($_POST['last-name']);
		$sanitized_email = sanitize_email($_POST['email']);
		$sanitized_phone_number = sanitize_text_field($_POST['phone-number']);
		$sanitized_coupon = sanitize_text_field($coupon);

		$data = array( 
				'first_name' => $sanitized_first_name, 
				'last_name' => $sanitized_last_name,
				'email_address' => $sanitized_email,
				'phone_number' => $sanitized_phone_number,
				'coupon_code' => $sanitized_coupon,
				'spinsleft' => $spinsleft,
				'ip' => $userip,
				'cookie' => $sanitized_cookie,
		);
		
		$wpdb->insert( $table_name, $data);

	}

	// Updates an existing user ( updates coupon list and number of allowed spins )
	public static function update(){
		global $wpdb;

		$tableprefix = $wpdb->prefix;
		$table_name = $tableprefix.'wprw_roulettewheel';

		// As the user will be identified by either email, IP, or cookie depending on user setting, we first get the user identifier through user_is_new('yes')
		$userdata = self::user_is_new('yes'); //array with 'type' and 'data' 

		// Get current number of spins
		$currentspins = $wpdb->get_var( $wpdb->prepare( 
			"
				SELECT spinsleft 
				FROM {$table_name} 
				WHERE {$userdata['type']} = %s
			", 
			$userdata['data']
		) );

		// Set new spins number
		$spinsleft = $currentspins-1;

		// Get current coupon(s)
		$currentcoupon = trim($wpdb->get_var( $wpdb->prepare( 
			"
				SELECT coupon_code 
				FROM {$table_name}
				WHERE {$userdata['type']} = %s
			", 
			$userdata['data']
		) ) );

		// Set new coupon(s) value
		if (trim($_POST['coupon']) !== 'nocoupon'){
		$newcoupon = $currentcoupon . ' AND ' . trim($_POST['coupon']);
		} else {
		$newcoupon = $currentcoupon;
		}

		// Build Data to be Updated
		$data = array( 
			'coupon_code' => sanitize_text_field(trim($newcoupon)),
			'spinsleft' => $spinsleft,
		);
		$where = array(
			$userdata['type'] => $userdata['data'],
		);

		$wpdb->update( $table_name, $data, $where); 

	}
	
	// Checks a user's status and returns whether he's new
	// $return_user_data enables the return of a user's unique identifier to be used by other functions
	public static function user_is_new($return_user_data = 'no'){
		
		global $wpdb;

		$tableprefix = $wpdb->prefix;
		$table_name = $tableprefix.'wprw_roulettewheel';

		// See if there is an email to check AND check by email is enabled
		if ((intval(get_option( 'wprw_collect_email_setting', 1 )) === 1)&&(intval(get_option( 'wprw_limitspinsemail_setting', 1 )) === 1)){

			$email = trim($_POST['email']);
	 		$sanitizedemail = sanitize_email($email);
			$emailexists = $wpdb->get_var( $wpdb->prepare( 
				"
					SELECT email_address 
					FROM $table_name 
					WHERE email_address = %s
				", 
				$sanitizedemail
			) );
			if ($emailexists !== NULL) { // Email does exist in the database
				if ($return_user_data === 'yes') {
					return array('type'=>'email_address', 'data' => $sanitizedemail);
				}
				return 'no'; 
			} 
		}

		if (intval(get_option( 'wprw_limitspinsip_setting', 0 )) === 1){
			$userip = self::get_user_ip();
			$ipexists = $wpdb->get_var( $wpdb->prepare( 
				"
					SELECT ip 
					FROM $table_name 
					WHERE ip = %s
				", 
				$userip
			) );
			if ($ipexists !== NULL) { // Ip does exist in the database
				if ($return_user_data === 'yes') {
					return array('type'=>'ip', 'data' => $userip);
				}
				return 'no'; 
			} 
		}

		if (intval(get_option( 'wprw_limitspinscookie_setting', 1 )) === 1){
			$usercookie = sanitize_text_field($_COOKIE['wprw_roulettewheel_cookie']);
			$cookieexists = $wpdb->get_var( $wpdb->prepare( 
				"
					SELECT cookie 
					FROM $table_name 
					WHERE cookie = %s
				", 
				$usercookie
			) );
			if ($cookieexists !== NULL) { // Cookie DOES EXIST IN THE DATABASE
				if ($return_user_data === 'yes') {
					return array('type'=>'cookie', 'data' => $usercookie);
				}
				return 'no'; 
			} 
		}
		
		return 'yes';

	}

	// Returns whether a user has permission to spin again
	public static function user_can_spin(){
		
		global $wpdb;
		$tableprefix = $wpdb->prefix;
		$table_name = $tableprefix.'wprw_roulettewheel';
		$userdata = self::user_is_new('yes'); //array with 'type' and 'data' or string 'yes' if user is new

		//if user is new, can spin
		if ($userdata === 'yes') {
			return 'yes';
		}

		// Get `spinsleft` var from database
		$spinsleft = $wpdb->get_var( $wpdb->prepare( 
			"
				SELECT spinsleft 
				FROM {$table_name} 
				WHERE {$userdata['type']} = %s
			", 
			$userdata['data']
		) );
		if ( $spinsleft < 1 ) {
			return 'no';
		} else {
			return 'yes';
		}
	
	}

	// Downloads a file with users / emails from the database depending on what is requested in the $requested argument
	public static function download($requested) {
		
		global $wpdb;

		$tableprefix = $wpdb->prefix;
		$table_name = $tableprefix.'wprw_roulettewheel';

		if ($requested === 'users'){
			$queryresult = $wpdb->get_results( 
				"
			    SELECT `id`, `first_name`, `last_name`, `email_address`, `phone_number`, `coupon_code`, `spinsleft`, `ip`, `cookie` FROM $table_name
				"
			, ARRAY_A);
			header("Content-type: text/csv");
			header("Content-Disposition: attachment; filename=wproulette_users.csv");
			header("Pragma: no-cache");
			header("Expires: 0");

			function outputCSV($data) {
				$output = fopen("php://output", "wb");
				$headerrow = array("User ID", "First Name", "Last Name", "Email Address", "Phone Number", "Coupon Code", "Spins Left", "IP", "User Cookie");
				fputcsv($output, $headerrow);
				foreach ($data as $row){
					$trimmed_array = array_map('trim', $row);
					fputcsv($output, $trimmed_array); 
				}
				fclose($output);
			}

			outputCSV($queryresult);

		} else if ($requested === 'emails'){
			$queryresult = $wpdb->get_col( 
				"
			    SELECT `email_address` FROM `wp_wprw_roulettewheel` WHERE `email_address` IS NOT NULL
				"
			);
			header("Content-type: text/plain");
			header("Content-Disposition: attachment; filename=wproulette_users.txt");
			header("Pragma: no-cache");
			header("Expires: 0");

			$output = fopen("php://output", "wb");
			$txtcontent = '';
			foreach ($queryresult as $email_address){
				$txtcontent.= $email_address.", ";
			}

			// Remove comma and space at the end of the list
			$txtcontent = rtrim($txtcontent,', '); 
			echo $txtcontent;
			fclose($output);
		}
		
		wp_die();
	}

	// Returns how many users are in the table
	public static function usersnumber() {
		
		global $wpdb;

		$tableprefix = $wpdb->prefix;
		$table_name = $tableprefix.'wprw_roulettewheel';

		$numberofusers= $wpdb->query( 
			$wpdb->prepare( 
				"
		         SELECT id FROM $table_name
				"
			,''
		    )
		);

		return $numberofusers;
		wp_die();
	}

	// Generates a WooCommerce coupon based on arguments given
	public static function generate_coupon($giventype, $givenamount, $givenexpiry ) {
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$coupon_code = '';
		for ($i = 0; $i < 6; $i++)
		$coupon_code .= $characters[mt_rand(0, 61)];

		$expirydate = date('Y-m-d', strtotime("+{$givenexpiry} days"));
        $amount = $givenamount;
        $discount_type = $giventype; // Type: fixed_cart, percent, fixed_product, percent_product

        $coupon = array(
			'post_title' => $coupon_code,
			'post_content' => '',
			'post_status' => 'publish',
			'post_author' => 1,
			'post_type'     => 'shop_coupon'
		);

		$new_coupon_id = wp_insert_post( $coupon );

		// Add meta
		update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
		update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
		update_post_meta( $new_coupon_id, 'individual_use', 'no' );
		update_post_meta( $new_coupon_id, 'product_ids', '' );
		update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
		update_post_meta( $new_coupon_id, 'usage_limit', '' );
		update_post_meta( $new_coupon_id, 'expiry_date', $expirydate );
		update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
		update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
		
		return $coupon_code;

	}

	// Sends the user an email with the coupon provided in argument
	public static function send_coupon_email($couponcode){

		$email_subject = get_option('wprw_emailsubject_setting', __('You won a coupon!','wproulettewheel'));
		$email_message = get_option('wprw_emailmessage_setting', __('Hello {firstname} {lastname}. We\'re delighted to tell you that you won the following coupon: {couponcode} granting you a 25 percent discount. Enjoy, The Coupon Company','wproulettewheel'));
		$custom_name = get_option('wprw_customname_setting', 'The Coupon Company');
		$custom_email = get_option('wprw_customemail_setting', 'prizes@yourwebsite.com');
		$sanitized_email = sanitize_email($_POST['email']);
		$sanitized_first_name = sanitize_text_field($_POST['first-name']);
		$sanitized_last_name = sanitize_text_field($_POST['last-name']);
		$sanitized_phone_number = sanitize_text_field($_POST['phone-number']);

		if (empty($sanitized_first_name)) {
			$sanitized_first_name = '';
		}
		if (empty($sanitized_last_name)) {
			$sanitized_last_name = '';
		}
		if (empty($sanitized_phone_number)) {
			$sanitized_phone_number = '';
		}

		$email_message = str_replace("{couponcode}",$couponcode,$email_message);
		$email_message = str_replace("{firstname}",$sanitized_first_name,$email_message);
		$email_message = str_replace("{lastname}",$sanitized_last_name,$email_message);
		$email_message = str_replace("{phone}",$sanitized_phone_number,$email_message);
		$email_message = str_replace("{email}",$sanitized_email,$email_message);

		$headers = 'From: "'.$custom_name.'"<' . $custom_email . '>' . "\r\n";
		wp_mail($sanitized_email, $email_subject, $email_message, $headers);

	}

	// Returns the user's IP address
	function get_user_ip() {
	    $ipaddress = '';
	    if (isset($_SERVER['HTTP_CLIENT_IP']))
	        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED']))
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
	        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_FORWARDED']))
	        $ipaddress = $_SERVER['HTTP_FORWARDED'];
	    else if(isset($_SERVER['REMOTE_ADDR']))
	        $ipaddress = $_SERVER['REMOTE_ADDR'];
	    else
	        $ipaddress = 'UNKNOWN';
	    return $ipaddress;
	}

	// Resets the Spins Counter
	public static function reset_spins(){

		global $wpdb;
		$tableprefix = $wpdb->prefix;
		$table_name = $tableprefix.'wprw_roulettewheel';
		$spinssetting = intval(get_option('wprw_maximum_spins_peruser_setting', 1));
		$wpdb->query( 
		    $wpdb->prepare( 
		        "UPDATE $table_name
		         SET `spinsleft` = %d",
		         $spinssetting
		    )
		);
		return 'success';
	}
	
	/**
	*
	* CRON JOBS
	*
	*/

	// Runs the reset_spins() function as a cronjob to periodically reset spins
	public static function cronjob_reset_spins_counter(){
		
		// First Set User-defined Custom Interval
		add_filter( 'cron_schedules', 'userdefinedinterval' );

		function userdefinedinterval( $schedules ) {
		    $schedules['user_defined_interval'] = array(
		        'interval' => 3600 * get_option('wprw_resetspincounter_setting', 24),
		        'display'  => esc_html__( 'User Defined Interval', 'wproulettewheel'),
		    );
		 
		    return $schedules;
		}
		
		add_action( 'wprw_reset_spins_hook', __CLASS__.'::reset_spins');
		if ( ! wp_next_scheduled( 'wprw_reset_spins_hook' ) ) {
		    wp_schedule_event( time(), 'user_defined_interval', 'wprw_reset_spins_hook' );
		}
				
	}

}
