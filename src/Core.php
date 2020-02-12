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

use WPPF\Classes\CptLoader;
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
	 * @since    1.0.0
	 *
	 * @var Classes\I18n
	 */
	public $i18n;

	/**
	 * Framework custom post types.
	 *
	 * @since 1.0.0
	 *
	 * @var Classes\CptLoader
	 */
	public $cpt;

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function on_initialization() {
		$this->check_constants();

		// Register activation hook.
		register_activation_hook(
			WPPF_PLUGIN_FILE,
			array( 'WPPF\Classes\Activation', 'get_instance' )
		);

		// Register activation hook.
		register_deactivation_hook(
			WPPF_PLUGIN_FILE,
			array( 'WPPF\Classes\Deactivation', 'get_instance' )
		);

		$this->set_locale();
	}

	/**
	 * Check for required constants are defined or not.
	 *
	 * @since 1.0.0
	 * @throws \Exception Throws when constants are not defined.
	 * @return void
	 */
	private function check_constants() {
		$constants = array( 'WPPF_PLUGIN_FILE', 'WPPF_PLUGIN_DIR' );

		foreach ( $constants as $c ) {
			if ( ! defined( $c ) ) {
				throw new \Exception(
					sprintf(
						// translators: %s is the name of constant.
						__( 'Constant %s is not defined. Please define it before calling wppf()', 'wppf' ),
						$c
					)
				);
			}
		}
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {
		$this->i18n = I18n::get_instance();
		$this->cpt  = CptLoader::get_instance();
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
