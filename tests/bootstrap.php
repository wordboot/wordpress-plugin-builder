<?php
/**
 * PHPUnit bootstrap file
 *
 * @package Wp_Plugin_Framework
 */
putenv( 'WP_TEST_WP_DIR=' . dirname( __DIR__ ) . '/tests/wp/wordpress/' );

$_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $_tests_dir ) {
	$_tests_dir = dirname( __DIR__ ) . '/tests/wp/wordpress-tests-lib';
}

if ( ! file_exists( $_tests_dir . '/includes/functions.php' ) ) {
	echo "Could not find $_tests_dir/includes/functions.php, have you run bin/install-wp-tests.sh ?" . PHP_EOL; // WPCS: XSS ok.
	exit( 1 );
}

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';

// Start up the WP testing environment.
require $_tests_dir . '/includes/bootstrap.php';

require_once dirname( dirname( __FILE__ ) ) . '/vendor/autoload.php';
