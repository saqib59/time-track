<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://https://github.com/saqib59
 * @since      1.0.0
 *
 * @package    Track_Time
 * @subpackage Track_Time/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Track_Time
 * @subpackage Track_Time/includes
 * @author     Saqib Ali <saqibali80400@gmail.com>
 */
class Track_Time_Deactivator {

	/**
     * Drop the custom table on plugin deactivation.
	 *
	 * @since    1.0.0
     */
	public static function deactivate() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'track_time';
		$sql        = "DROP TABLE IF EXISTS $table_name;";
		$wpdb->query( $sql );
	}
}
