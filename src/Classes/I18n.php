<?php
/**
 * File defines i18n class.
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
 * Class handle i18n initialization and loading.
 *
 * @since 1.0.0
 */
class I18n {
	use Singleton;

	/**
	 * Method called on singleton initialization.
	 *
	 * @return void
	 */
	private function on_initialization() {
		$this->add_action( 'plugins_loaded@load_framework_translations' );

		// Load plugin translation if constant defied.
		if ( defined( 'WPPF_PLUGIN_TEXTDOMAIN' ) ) {
			$this->add_action( 'plugins_loaded@load_translations' );
		}
	}

	/**
	 * Load translations of the framework.
	 *
	 * @return void
	 */
	private function hook_load_framework_translations() {
		load_plugin_textdomain(
			'wppf',
			false,
			WPPF_DIR . 'languages/'
		);
	}

	/**
	 * Load plugin translation.
	 *
	 * @return void
	 */
	private function hook_load_translations() {
		load_plugin_textdomain(
			WPPF_PLUGIN_TEXTDOMAIN,
			false,
			WPPF_PLUGIN_DIR . 'languages/'
		);
	}
}
