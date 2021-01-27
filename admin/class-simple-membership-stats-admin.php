<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Simple_Membership_Stats
 * @subpackage Simple_Membership_Stats/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Simple_Membership_Stats
 * @subpackage Simple_Membership_Stats/admin
 * @author     Your Name <email@example.com>
 */
class Simple_Membership_Stats_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	public function add_admin_menus() {
		add_submenu_page(
			'simple_wp_membership',
			'Member Statistics',
			'Member Statistics',
			'manage_options',
			$this->plugin_name,
			array(
				$this,
				'show_admin_page',
			)
		);
	}

	public static function show_admin_page() {
		if ( is_file( plugin_dir_path( __FILE__ ) . 'partials/admin-stats.php' ) ) {
			include_once plugin_dir_path( __FILE__ ) . 'partials/admin-stats.php';
		}
	}

	public function member_statistics_widget() {
		wp_add_dashboard_widget(
			'member-stats-analytics',
			'Simple Membership Analytics',
			array( $this, 'show_member_stats_widget' )
		);
	}

	public static function show_member_stats_widget() {
		if ( is_file( plugin_dir_path( __FILE__ ) . 'partials/admin-widget.php' ) ) {
			include_once plugin_dir_path( __FILE__ ) . 'partials/admin-widget.php';
		}
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
		 * defined in Simple_Membership_Stats_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_Membership_Stats_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/simple-membership-stats-admin.css', array(), $this->version, 'all' );

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
		 * defined in Simple_Membership_Stats_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_Membership_Stats_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/simple-membership-stats-admin.js', array( 'jquery' ), $this->version, false );

	}

}
