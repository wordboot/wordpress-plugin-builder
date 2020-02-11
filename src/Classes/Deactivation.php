<?php
/**
 * File defines deactivation class.
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
 * Class handle deactivation hook.
 *
 * @since 1.0.0
 */
class Deactivation {
	use Singleton;

	/**
	 * Method called on `\WPPF\Classes\Deactivation` initialization.
	 *
	 * @return void
	 */
	private function on_initialization() {
		$this->load_plugin_deactivation();
	}

	/**
	 * Load activation.php file if present in root directory.
	 *
	 * @return void
	 */
	private function load_plugin_deactivation() {
		$file = WPPF_PLUGIN_DIR . 'deactivation.php';

		if ( file_exists( $file ) ) {
			require_once $file;
		}
	}
}
