<?php
/*
/**
 * Plugin Name:       WP Roulette Wheel
 * Plugin URI:        webwizards.dev/wp-roulette-wheel-demos
 * Description:       Boost visitor engagement and conversions! WP Roulette Wheel adds a fun game that collects users' data and offers powerful incentives such as auto-generated WooCommerce coupons.
 * Version:           1.0.1
 * Author:            WebWizards
 * Author URI:        webwizards.dev
 * Text Domain:       wproulettewheel
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'WP_ROULETTE_DIR', plugin_dir_path( __FILE__ ) );

function activate_wproulettewheel() {
	require_once WP_ROULETTE_DIR . 'includes/class-wproulettewheel-activator.php';
	Wproulettewheel_Activator::activate();
}
register_activation_hook( __FILE__, 'activate_wproulettewheel' );

function deactivate_wproulettewheel() {
	require_once WP_ROULETTE_DIR . 'includes/class-wproulettewheel-deactivator.php';
	Wproulettewheel_Deactivator::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_wproulettewheel' );

require WP_ROULETTE_DIR . 'includes/class-wproulettewheel.php';

// Load Plugin Language
add_action( 'init', 'wprw_load_language');
function wprw_load_language() {
   load_plugin_textdomain( 'wproulettewheel', FALSE, basename( dirname( __FILE__ ) ) . '/languages');
}

// Begins execution of the plugin.
function run_wproulettewheel() {
	$plugin = new Wproulettewheel();
}

run_wproulettewheel();

