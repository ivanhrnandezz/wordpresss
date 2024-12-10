<?php

class Wproulettewheel_Admin{

	function __construct() {
		// Only load scripts and styles in this specific admin page
		add_action( 'admin_enqueue_scripts', array($this, 'load_admin_resources') ); 
		// Registers settings
		add_action( 'admin_init', array( $this, 'wprw_settings_init' ) );
		// Renders settings 
		add_action( 'admin_menu', array( $this, 'wprw_settings_page' ) ); 
		// Unschedule cron job if setting changes
		add_action( 'update_option_wprw_resetspincounter_setting', array( $this, 'update_cronjob_time' ), 10, 2 ); 
	}

	function wprw_settings_page() {
		/* Admin Menu Settings */
		$parentslug = 'options-general.php';
		$page_title = 'WP Roulette Wheel';
		$menu_title = 'WP Roulette Wheel';
		$capability = 'manage_options';
		$slug = 'wproulettewheel';
		$callback = array( $this, 'wprw_settings_page_content' );
		$position = null;
		add_submenu_page( $parentslug, $page_title, $menu_title, $capability, $slug, $callback, $position );
		/* Add Action Links as Well (Settings Link in the Plugins Page) */

		// Build plugin file relative to plugins folder
		$absolutefilepath = dirname(plugins_url('', __FILE__),1);
		$pluginsurllength = strlen(plugins_url())+1;
		$relativepath = substr($absolutefilepath, $pluginsurllength);

		add_filter( 'plugin_action_links_'.$relativepath.'/wproulettewheel.php', array($this, 'wprw_action_links') );
	}
	

	function wprw_action_links( $links ) {
		// Build and escape the URL.
		$url = esc_url( add_query_arg(
			'page',
			'wproulettewheel',
			get_admin_url() . 'admin.php'
		) );
		// Create the link.
		$settings_link = "<a href='$url'>" . esc_html__( 'Settings', 'wproulettewheel' ) . '</a>';
		$upgrade_link = "<a href='https://1.envato.market/3KYgr'>" . esc_html__( 'Upgrade to PRO', 'wproulettewheel' ) . '</a>';
		// Adds the link to the end of the array.

		array_push(	$links,	$settings_link );
		array_push(	$links,	$upgrade_link );
		return $links;
	}

	function wprw_settings_init(){
		require_once ( WP_ROULETTE_DIR . 'admin/class-wproulettewheel-settings.php' );
		$settings = new Wproulettewheel_Settings;
		$settings->register_all_settings();
	}
	
	function wprw_settings_page_content() {
		require_once ( WP_ROULETTE_DIR . 'admin/class-wproulettewheel-settings.php' );
		$settings = new Wproulettewheel_Settings;
		$settings->render_settings_page_content();
	}
			
	function update_cronjob_time( $old_value, $new_value ) {
		// Unschedule Cron Job
		$timestamp = wp_next_scheduled( 'wprw_reset_spins_hook' );
		wp_unschedule_event( $timestamp, 'wprw_reset_spins_hook' );
	}
	
	function load_admin_resources($hook) {

		// Load only on this specific plugin admin
		if($hook != 'settings_page_wproulettewheel') {
			return;
		}
		
		wp_enqueue_script('jquery');

		wp_enqueue_script('semantic', plugins_url('../includes/assets/lib/semantic/semantic.min.js', __FILE__), $deps = array(), $ver = false, $in_footer =true);
		wp_enqueue_style( 'semanticcss', plugins_url('../includes/assets/lib/semantic/semantic.min.css', __FILE__));

		wp_enqueue_style( 'wprw_adminstyle', plugins_url('assets/css/adminstyle.css', __FILE__));
		wp_enqueue_script('wprw_admin_script', plugins_url('assets/js/admin.js', __FILE__), $deps = array(), $ver = false, $in_footer =true);
		wp_enqueue_style( 'wprw_style', plugins_url('../includes/assets/css/style.css', __FILE__)); // Needed for input style shortcode
		wp_enqueue_script('particlesjs', plugins_url('../includes/assets/lib/particles/particles.min.js', __FILE__), $deps = array(), $ver = false, $in_footer =true);

		wp_enqueue_style( 'nouislidercss', plugins_url('../includes/assets/lib/nouislider/nouislider.min.css', __FILE__));
		wp_enqueue_script('nouisliderjs', plugins_url('../includes/assets/lib/nouislider/nouislider.min.js', __FILE__), $deps = array(), $ver = false, $in_footer =true);
		
		wp_enqueue_style( 'plyr', plugins_url('../includes/assets/lib/plyr/plyr.css', __FILE__));
		wp_enqueue_script('plyr', plugins_url('../includes/assets/lib/plyr/plyr.js', __FILE__), $deps = array(), $ver = false, $in_footer =true);	

		wp_enqueue_style( 'wprw_wheel_style', plugins_url('../includes/assets/css/wheelstyle.css', __FILE__));
		wp_enqueue_script('wprw_wheel_spin', plugins_url('../includes/assets/js/wheelspin.js', __FILE__), $deps = array(), $ver = false, $in_footer =true);

		// Send settings to JS
		$datatoBePassed = array(
			'win_probability_setting' => get_option( 'wprw_win_probability_setting', 50 ),
			'active_tab_on_load' => get_option( 'wprw_current_tab_setting', 'first' ),
			'security'  => wp_create_nonce( 'wprw_adminsecurity_nonce' ),
			'plugins_url' => plugins_url('../', __FILE__),
			
		 );
		wp_localize_script( 'wprw_admin_script', 'wprw_admin_settings', $datatoBePassed );

		// Send translations to JS
		$datatoBePassedTranslation = array(
			'dont_have_any_coupons' => esc_html__('You don\'t have any coupons!','wproulettewheel'),
			'spins_reset_confirmation' => esc_html__('Are you sure you want to reset the spin counter for all users?','wproulettewheel'),
			'spins_successfully_reset' => esc_html__('Spins have been successfully reset for all users!', 'wproulettewheel'),
			'spins_reset_error' => esc_html__('There was some sort of error!','wproulettewheel'),
		);
		wp_localize_script( 'wprw_admin_script', 'wprw_admin_translation', $datatoBePassedTranslation );

	}
	
}
?>