<?php
/**
 * Defines tests for file constants.php
 *
 * @package    WPPF
 * @subpackage tests
 */

/**
 * Class to check constants.
 *
 * @since 1.0.0
 */
class Constants_Test extends WP_UnitTestCase {

	/**
	 * Check constants.
	 *
	 * @since 1.0.0
	 */
	public function test_defines() {
		$constants = [
			'WPPF_VERSION',
			'WPPF_DIR',
		];

		foreach ( $constants as $c ) {
			$this->assertTrue( defined( $c ), "$c is not defined" );
		}
	}
}
