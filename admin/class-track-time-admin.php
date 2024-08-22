<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://github.com/saqib59
 * @since      1.0.0
 *
 * @package    Track_Time
 * @subpackage Track_Time/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Track_Time
 * @subpackage Track_Time/admin
 * @author     Saqib Ali <saqibali80400@gmail.com>
 */
class Track_Time_Admin {

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
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Track_Time_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Track_Time_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/track-time-admin.css', [], $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Track_Time_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Track_Time_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/track-time-admin.js', [ 'jquery' ], $this->version, false );
	}

   	/**
     * Register the admin menu for the plugin.
     *
     * @since    1.0.0
     */
	public function register_admin_menu() {
		add_menu_page(
			__( 'Track Time Settings', 'track-time' ),
			__( 'Track Time', 'track-time' ),
			'manage_options',
			'track-time-settings',
			[ $this, 'display_settings_page' ],
			'dashicons-admin-generic',
			81
		);
	}


	/**
     * Display the settings page.
     *
     * @since    1.0.0
     */
    public function display_settings_page() {
        // Include the template file for the settings page
        include plugin_dir_path( __FILE__ ) . '/templates/track-time-settings.php';
    }

	/**
	 * Register settings to save selected pages.
	 *
     * @since    1.0.0
	 */
	function track_time_register_settings() {
		register_setting(
			'track_time_settings_group',
			'track_time_selected_pages',
			array(
				'sanitize_callback' => function($input) {
					// If the input is an empty string, return an empty array
					if (empty($input)) {
						return array();
					}
					// Otherwise, return the input as is (assuming it's already an array)
					return $input;
				}
			)
		);
	}
}
