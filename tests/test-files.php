<?php
/**
 * Define tests for files.
 *
 * @package WPPF
 * @subpackage tests
 */

/**
 * File related tests.
 *
 * @since 1.0.0
 */
class FilesTest extends WP_UnitTestCase {

	/**
	 * Test for root files existence.
	 */
	public function test_root_files() {
		$this->assertTrue( file_exists( WPPF_DIR . 'constants.php' ) );
		$this->assertTrue( file_exists( WPPF_DIR . 'Core.php' ) );
		$this->assertTrue( file_exists( WPPF_DIR . 'helpers.php' ) );
		$this->assertTrue( is_dir( WPPF_DIR . 'Classes' ) );
		$this->assertTrue( is_dir( WPPF_DIR . 'languages' ) );
	}

	/**
	 * Check existence of classes file.
	 */
	public function test_classes() {
		$this->assertTrue( file_exists( WPPF_DIR . 'Classes/I18n.php' ) );
		$this->assertTrue( file_exists( WPPF_DIR . 'Classes/Singleton.php' ) );
	}

	// public function test_direct_access() {
	// 	$files = glob( WPPF_DIR . '*' );

	// 	// Remove constant.
	// 	runkit_constant_remove( 'ABSPATH' );

	// 	foreach ( $files as $file ) {
	// 		if ( ! is_dir( $file ) ) {
	// 			try {
	// 				require $file;
	// 				//$this->assertTrue( $file );
	// 			} catch ( \ExitException $e ) {
	// 				$this->assertTrue( $e );
	// 			}
	// 		}
	// 	}
	// }
}
