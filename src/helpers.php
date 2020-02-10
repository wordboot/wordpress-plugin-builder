<?php
/**
 * This file defines helper functions for WordPress.
 *
 * @since      1.0.0
 * @package    WPPF
 * @subpackage helpers
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Begins execution of the framework.
 *
 * @since  1.0.0
 * @return WPPF
 */
function wppf() {
	return WPPF\Core::get_instance();
}
