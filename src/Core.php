<?php
/**
 * The file defines the main class of the framework.
 *
 * @link      https://wordboot.com/wp-plugin-framework/
 * @since     1.0.0
 * @author    Rahul Arya <rah12@live.com>
 * @license   GPL-3.0+
 * @package   WPPF
 */

namespace WPPF;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

use WPPF\Classes\I18n;
use WPPF\Classes\Singleton;

/**
 * Framework class.
 *
 * @since      1.0.0
 * @package    WPPF
 * @author     Rahul Arya <team@wordboot.com>
 */
class Core {
	use Singleton;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version = '1.0.0';

	/**
	 * Framework locale.
	 *
	 * @var Classes\I18n
	 */
	public $i18n;

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function on_initialization() {
		$this->set_locale();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {
		$this->i18n = I18n::get_instance();
	}

	/**
	 * Load all addons of framework.
	 *
	 * @param string $property Name of the property requested.
	 *
	 * @return mixed|void
	 */
	public function __get( $property ) {
		if ( property_exists( $this, $property ) ) {
			return $this->$property;
		}

		$namespace = "WPPF\\Addons\\$property\\Loader";

		if ( class_exists( $namespace ) ) {
			$this->$property = $namespace::get_instance();
			return $this->$property;
		}
	}

	/**
	 * Prevent setting property.
	 *
	 * @throws \Exception Throws exception.
	 * @param string $name  Name of the property.
	 * @param mixed  $value Value to set.
	 */
	public function __set( $name, $value ) {
		throw new \Exception( "Cannot add new property \$$name to instance of " . __CLASS__ );
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}
