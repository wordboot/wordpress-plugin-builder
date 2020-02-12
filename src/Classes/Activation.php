<?php
/**
 * File defines activation class.
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
class Activation {
	use Singleton;

	/**
	 * Method called on `\WPPF\Classes\Activation` initialization.
	 *
	 * @return void
	 */
	private function on_initialization() {
		$this->load_plugin_activation();
	}

	/**
	 * Load activation.php file if present in root directory.
	 *
	 * @return void
	 */
	private function load_plugin_activation() {
		$file = WPPF_PLUGIN_DIR . 'activation.php';

		if ( file_exists( $file ) ) {
			require_once $file;
		}
	}
}
