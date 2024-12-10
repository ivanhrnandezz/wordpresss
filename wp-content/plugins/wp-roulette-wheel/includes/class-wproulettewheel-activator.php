<?php


class Wproulettewheel_Activator {

	public static function activate() {
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();
		$tableprefix = $wpdb->prefix;
		$table_name = $tableprefix.'wprw_roulettewheel';

		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  first_name tinytext,
		  last_name tinytext,
		  email_address tinytext,
		  phone_number tinytext,
		  coupon_code text,
		  spinsleft mediumint(9),
		  ip tinytext,
		  cookie tinytext,
		  PRIMARY KEY  (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}


}
