<?php

/**
 * Fired during plugin activation
 *
 * @link      https://github.com/saqib59
 * @since      1.0.0
 *
 * @package    Track_Time
 * @subpackage Track_Time/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Track_Time
 * @subpackage Track_Time/includes
 * @author     Saqib Ali <saqibali80400@gmail.com>
 */
class Track_Time_Activator {

	/**
     * Create the custom table on plugin activation.
     *
     * @since    1.0.0
     */
	public static function activate() {
		global $wpdb;
        $table_name      = $wpdb->prefix . 'track_time';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            user_id bigint(20) NOT NULL,
            page_id bigint(20) NOT NULL,
            user_activity JSON NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		// Create or update the table
        dbDelta( $sql );
	}
}
