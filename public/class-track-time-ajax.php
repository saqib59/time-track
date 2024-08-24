<?php

/**
 * The public-facing ajax functionality of the plugin.
 *
 * @link       https://https://github.com/saqib59
 * @since      1.0.0
 *
 * @package    Track_Time
 * @subpackage Track_Time/public
 */

/**
 * The public-facing ajax functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Track_Time
 * @subpackage Track_Time/public
 * @author     Saqib Ali <saqibali80400@gmail.com>
 */
class Track_Time_Ajax {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}


	/**
	 * Handles the AJAX request for tracking user activity on a specific page.
	 */
    public function handle_track_user_activity() {
        // Check for valid nonce
		if ( ! isset( $_POST['security'] ) || ! wp_verify_nonce( $_POST['security'], 'track_time_nonce' ) ) {
            error_log( 'Invalid nonce' );
			wp_die();
		}

		// Get and sanitize the input data
		$user_email    = isset( $_POST['user_email'] ) ? sanitize_email( $_POST['user_email'] ) : '';
		$page_id       = isset( $_POST['page_id'] ) ? intval( $_POST['page_id'] ) : 0;
		$user_activity = isset( $_POST['user_activity'] ) ? wp_unslash( $_POST['user_activity'] ) : '';

		// Validate the data
		if ( empty( $user_email ) || ! is_email( $user_email ) ) {
            error_log( 'Invalid email address' );
			wp_die();
		}

		if ( empty( $page_id ) || empty( $user_activity ) ) {
            error_log( 'Missing required data' );
			wp_die();
		}

		// Decode the JSON object
		$user_activity_data = json_decode( $user_activity, true );

		if ( ! is_array( $user_activity_data ) || ! isset( $user_activity_data['time_spent'] ) || ! isset( $user_activity_data['date_visited'] ) ) {
            error_log( 'Invalid user activity data' );
			wp_die();
		}

		global $wpdb;
		$table_name = $wpdb->prefix . 'track_time';

		// Prepare data for insertion
		$user_email         = $wpdb->esc_like( $user_email ); // Escape user email for safe use in SQL queries
		$user_activity_json = wp_json_encode( $user_activity_data );
		$created_at         = current_time( 'mysql' ); // Get the current time in MySQL format
		$updated_at         = $created_at;

	 	// Check if a record exists for this user_email and page_id
		$existing_record = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM $table_name WHERE user_email = %s AND page_id = %d",
				$user_email,
				$page_id
			)
		);

		if ( $existing_record ) {
			// Record exists, update the existing record
			$existing_activity_data = json_decode( $existing_record->user_activity, true );
			$existing_time_spent    = isset( $existing_activity_data['time_spent'] ) ? intval( $existing_activity_data['time_spent'] ) : 0;
			$new_time_spent         = $existing_time_spent + intval( $user_activity_data['time_spent'] );

			$wpdb->update(
				$table_name,
				[
					'user_activity' => wp_json_encode( array_merge( $existing_activity_data, [ 'time_spent' => $new_time_spent ] ) ),
					'updated_at'    => $updated_at,
				],
				[
					'id' => $existing_record->id,
				],
				[
					'%s',
					'%s',
				],
				[
					'%d',
				]
			);
		} else {
			// Record does not exist, insert a new record
			$wpdb->insert(
                $table_name,
                [
					'user_email'    => $user_email,
					'page_id'       => $page_id,
					'user_activity' => $user_activity_json,
					'created_at'    => $created_at,
					'updated_at'    => $updated_at,
                ],
                [
					'%s',
					'%d',
					'%s',
					'%s',
					'%s',
                ]
            );
		}
			// Check if the insert/update was successful
		if ( $wpdb->last_error ) {
			error_log( 'Database error: ' . $wpdb->last_error );
			wp_die();
		}

		wp_die();
    }
}
