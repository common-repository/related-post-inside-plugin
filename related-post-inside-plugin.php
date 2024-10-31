<?php
/**
 * Plugin Name: Related Post Inside Plugin
 * Plugin URI:  http://jeweltheme.com
 * Description: Related Post Inside plugin allows you to insert related posts inside of Posts. Related Post Inside plugin will make your website more SEO friendly, increase post views dramatically. Makes your blogging career more useful and very fast blogging.
 * Version:     1.0.4
 * Author:      Jewel Theme
 * Author URI:  https://jeweltheme.com
 * Text Domain: related-post-inside-plugin
 * Domain Path: languages/
 * License:     GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package related-post-inside-plugin
 */

/*
 * don't call the file directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	wp_die( esc_html__( 'You can\'t access this page', 'related-post-inside-plugin' ) );
}

$jlt_rpsi_plugin_data = get_file_data(
	__FILE__,
	array(
		'Version'     => 'Version',
		'Plugin Name' => 'Plugin Name',
		'Author'      => 'Author',
		'Description' => 'Description',
		'Plugin URI'  => 'Plugin URI',
	),
	false
);

// Define Constants.
if ( ! defined( 'JLTRPSI' ) ) {
	define( 'JLTRPSI', $jlt_rpsi_plugin_data['Plugin Name'] );
}

if ( ! defined( 'JLTRPSI_VER' ) ) {
	define( 'JLTRPSI_VER', $jlt_rpsi_plugin_data['Version'] );
}

if ( ! defined( 'JLTRPSI_AUTHOR' ) ) {
	define( 'JLTRPSI_AUTHOR', $jlt_rpsi_plugin_data['Author'] );
}

if ( ! defined( 'JLTRPSI_DESC' ) ) {
	define( 'JLTRPSI_DESC', $jlt_rpsi_plugin_data['Author'] );
}

if ( ! defined( 'JLTRPSI_URI' ) ) {
	define( 'JLTRPSI_URI', $jlt_rpsi_plugin_data['Plugin URI'] );
}

if ( ! defined( 'JLTRPSI_DIR' ) ) {
	define( 'JLTRPSI_DIR', __DIR__ );
}

if ( ! defined( 'JLTRPSI_FILE' ) ) {
	define( 'JLTRPSI_FILE', __FILE__ );
}

if ( ! defined( 'JLTRPSI_SLUG' ) ) {
	define( 'JLTRPSI_SLUG', dirname( plugin_basename( __FILE__ ) ) );
}

if ( ! defined( 'JLTRPSI_BASE' ) ) {
	define( 'JLTRPSI_BASE', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'JLTRPSI_PATH' ) ) {
	define( 'JLTRPSI_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
}

if ( ! defined( 'JLTRPSI_URL' ) ) {
	define( 'JLTRPSI_URL', trailingslashit( plugins_url( '/', __FILE__ ) ) );
}

if ( ! defined( 'JLTRPSI_INC' ) ) {
	define( 'JLTRPSI_INC', JLTRPSI_PATH . '/Inc/' );
}

if ( ! defined( 'JLTRPSI_LIBS' ) ) {
	define( 'JLTRPSI_LIBS', JLTRPSI_PATH . 'Libs' );
}

if ( ! defined( 'JLTRPSI_ASSETS' ) ) {
	define( 'JLTRPSI_ASSETS', JLTRPSI_URL . 'assets/' );
}

if ( ! defined( 'JLTRPSI_IMAGES' ) ) {
	define( 'JLTRPSI_IMAGES', JLTRPSI_ASSETS . 'images' );
}

if ( ! class_exists( '\\JLTRPSI\\JLT_RPSI' ) ) {
	// Autoload Files.
	include_once JLTRPSI_DIR . '/vendor/autoload.php';
	// Instantiate JLT_RPSI Class.
	include_once JLTRPSI_DIR . '/class-related-post-inside-plugin.php';
}