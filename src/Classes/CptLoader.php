<?php
/**
 * File defines `CptLoader` class.
 *
 * @since      1.0.0
 * @author     Rahul Arya <team@wordboot.com>
 * @package    WPPF
 * @subpackage classes
 */

namespace WPPF\Classes;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

use WPPF\Classes\Singleton;

/**
 * Class handle activation hook.
 *
 * @since 1.0.0
 */
class CptLoader {
	use Singleton;

	/**
	 * Directory from where cpts to load.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	private $dir;

	/**
	 * Method called on `\WPPF\Classes\CptLoader` initialization.
	 *
	 * @return void
	 */
	private function on_initialization() {
		$this->dir = WPPF_PLUGIN_DIR . 'cpt';
		$this->add_action( 'init@load_cpt' );
	}

	/**
	 * Load all custom post types from cpt directory.
	 * Method is called on `init` hook.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function hook_load_cpt() {
		$dir = WPPF_PLUGIN_DIR . 'cpt';

		if ( file_exists( $dir ) ) {
			$files = glob( $dir . '/*.php' );

			if ( ! empty( $files ) ) {
				foreach ( $files as $file ) {
					require_once $file;
				}
			}
		}
	}
}
