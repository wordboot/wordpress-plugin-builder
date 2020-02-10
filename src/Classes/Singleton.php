<?php
/**
 * File defines singleton trait.
 *
 * @package    WPPF
 * @subpackage core
 * @since      1.0.0
 * @author     Rahul Arya <team@wordboot.com>
 */

namespace WPPF\Classes;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

trait Singleton {
	/**
	 * Instance of this class.
	 *
	 * @var Singleton
	 */
	private static $instance;

	/**
	 * Protected class constructor to prevent direct object creation.
	 */
	private function __construct() {

	}

	/**
	 * Cloning is forbidden.
	 *
	 * @access public
	 * @since 1.0.0
	 */
	final public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'wppf' ), '1.0.0' ); // phpcs:ignore
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @access public
	 * @since 1.0.0
	 */
	final public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'wppf' ), '1.0.0' ); // phpcs:ignore
	}

	/**
	 * To return new or existing Singleton instance of the class from which it is called.
	 * As it sets to final it can't be overridden.
	 *
	 * @return object Singleton instance of the class.
	 */
	final public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();

			if ( method_exists( self::$instance, 'on_initialization' ) ) {
				self::$instance->on_initialization();
			}
		}

		return self::$instance;
	}

	/**
	 * Register action in plugin.
	 *
	 * Loading action from this method will allow private methods to be
	 * called. All hooks function must be prefixed with `hook_`.
	 * This is to prevent calling of callback directly.
	 *
	 * @param string  $hook          Name of hook.
	 * @param string  $callback      Callback function.
	 * @param integer $priority      Priority.
	 * @param integer $accepted_args Accepted args.
	 * @return void
	 */
	public function add_action( $hook, $callback, $priority = 10, $accepted_args = 1 ) {

		if ( is_string( $callback )
			&& false !== strpos( $callback, 'hook_' )
			&& method_exists( $this, $callback ) ) {
				add_action(
					$hook,
					function() use ( $callback ) {
						call_user_func_array( array( $this, $callback ), func_get_args() );
					},
					$priority,
					$accepted_args
				);
		}
	}

	/**
	 * Register filter in plugin.
	 *
	 * Loading filter from this method will allow private methods to be
	 * called. All hooks function must be prefixed with `hook_`.
	 * This is to prevent calling of callback directly.
	 *
	 * @param string  $hook          Name of hook.
	 * @param string  $callback      Callback function.
	 * @param integer $priority      Priority.
	 * @param integer $accepted_args Accepted args.
	 * @return void
	 */
	public function add_filter( $hook, $callback, $priority = 10, $accepted_args = 1 ) {
		if ( is_string( $callback )
			&& false !== strpos( $callback, 'hook_' )
			&& method_exists( $this, $callback ) ) {
				add_filter(
					$hook,
					function() use ( $callback ) {
						return call_user_func_array( array( $this, $callback ), func_get_args() );
					},
					$priority,
					$accepted_args
				);
		}
	}
}
