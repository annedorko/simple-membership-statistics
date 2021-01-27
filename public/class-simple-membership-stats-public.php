<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Simple_Membership_Stats
 * @subpackage Simple_Membership_Stats/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Simple_Membership_Stats
 * @subpackage Simple_Membership_Stats/public
 * @author     Your Name <email@example.com>
 */
class Simple_Membership_Stats_Public {

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
	 * Container for Analytics Class
	 * @var Class
	 */
	private $analytics;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	public function load_analytics() {
		$this->analytics = new Simple_Membership_Stats_Analytics();
	}

	public function register_shortcodes() {

		add_shortcode(
			'swpm_income',
			array( $this, 'show_monthly_income' )
		);

		add_shortcode(
			'swpm_members',
			array( $this, 'show_total_active_members' )
		);

		add_shortcode(
			'swpm_popular',
			array( $this, 'show_most_popular_level' )
		);

		add_shortcode(
			'swpm_goal',
			array( $this, 'show_goal_bar' )
		);

	}

	public function show_monthly_income( $atts ) {
		return $this->analytics->total_monthly_income();
	}

	public function show_total_active_members( $atts ) {
		return $this->analytics->total_active_members();
	}

	public function show_most_popular_level( $atts ) {
		return $this->analytics->most_popular_level();
	}

	public function show_goal_bar( $atts ) {
		$a = shortcode_atts(
			array(
				'goal'       => 1,
				'type'       => 'income',
				'progress'   => '#FFF',
				'background' => '#000',
			),
			$atts
		);

		$width = 0;

		if ( 'income' === $a['type'] ) {
			$width = ( $this->analytics->total_monthly_income_int() * 100 ) / $a['goal'];
		} else {
			$width = ( $this->analytics->total_active_members() * 100 ) / $a['goal'];
		}

		if ( $width > 100 ) {
			$width = 100;
		}

		$show_html = sprintf(
			'<div class="progress" style="background: %s">
		  <div class="progress-value" style="width: %d%%; background: %s;"></div>
		</div>',
			$a['background'],
			$width,
			$a['progress'],
		);
		return $show_html;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/goal-bar.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/simple-membership-stats-public.js', array( 'jquery' ), $this->version, false );

	}

}
