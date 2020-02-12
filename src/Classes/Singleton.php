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

/**
 * Singleton trait.
 *
 * @since 1.0.0
 */
trait Singleton {
	/**
	 * Instance of this class.
	 *
	 * @since 1.0.0
	 * @var Singleton
	 */
	private static $instance;

	/**
	 * Protected class constructor to prevent direct object creation.
	 *
	 * @since 1.0.0
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
	 * @since 1.0.0
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
	 * Validate callback of action and filter hook.
	 *
	 * @since 1.0.0
	 * @throws \Exception When callback is not well formatted.
	 *
	 * @param string $callback Callback formatted like `className@methodName`.
	 * @return object
	 */
	private function validate_callback( string $callback ) {
		if ( false === strpos( $callback, '@' ) ) {
			throw new \Exception( __( 'Not a valid callback. Callback should be formatted like className@hookName', 'wppf' ) );
		}

		$callback = explode( '@', $callback );

		if ( count( $callback ) > 2 ) {
			throw new \Exception( __( 'Not a valid callback. Callback should be formatted like className@hookName', 'wppf' ) );
		}

		$hook   = $callback[0];
		$method = 'hook_' . $callback[1];

		// Check if method exists.
		if ( ! method_exists( $this, $method ) ) {
			throw new \Exception(
				sprintf(
					// Translators: 1: Name of method, 2: Name of action.
					__( 'Method %1$s does not exists for action %2$s', 'wppf' ),
					$method,
					$hook
				)
			);
		}

		return (object) array(
			'hook'   => $hook,
			'method' => $method,
		);
	}

	/**
	 * Register action in plugin.
	 *
	 * Loading action from this method will allow private methods to be
	 * called. All hooks function must be prefixed with `hook_`.
	 * This is to prevent calling of callback directly.
	 *
	 * @since 1.0.0
	 * @throws \Exception When callback is not well formatted.
	 *
	 * @param  string  $callback      Callback string.
	 * @param  integer $priority      Priority.
	 * @param  integer $accepted_args Accepted args.
	 * @return void
	 */
	public function add_action( $callback, $priority = 10, $accepted_args = 1 ) {
		$cb     = $this->validate_callback( $callback );
		$method = $cb->method;

		add_action(
			$cb->hook,
			function() use ( $method ) {
				call_user_func_array( array( $this, $method ), func_get_args() );
			},
			$priority,
			$accepted_args
		);
	}

	/**
	 * Register filter in plugin.
	 *
	 * Loading filter from this method will allow private methods to be
	 * called. All hooks function must be prefixed with `hook_`.
	 * This is to prevent calling of callback directly.
	 *
	 * @since 1.0.0
	 * @throws \Exception When callback is not well formatted.
	 *
	 * @param string  $callback      Callback string.
	 * @param integer $priority      Priority.
	 * @param integer $accepted_args Accepted args.
	 * @return void
	 */
	public function add_filter( $callback, $priority = 10, $accepted_args = 1 ) {
		$cb     = $this->validate_callback( $callback );
		$method = $cb->method;

		add_filter(
			$cb->hook,
			function() use ( $method ) {
				return call_user_func_array( array( $this, $method ), func_get_args() );
			},
			$priority,
			$accepted_args
		);
	}
}
