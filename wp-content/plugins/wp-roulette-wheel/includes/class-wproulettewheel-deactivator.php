<?php


class Wproulettewheel_Deactivator {

	public static function deactivate() {
		//Unschedule Cron Jobs
		$timestamp = wp_next_scheduled( 'wprw_reset_spins_hook' );
		wp_unschedule_event( $timestamp, 'wprw_reset_spins_hook' );
	}


}
