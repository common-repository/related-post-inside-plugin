<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @version       1.0.0
 * @package       JLT_RPSI
 * @license       Copyright JLT_RPSI
 */

if ( ! function_exists( 'jlt_rpsi_option' ) ) {
	/**
	 * Get setting database option
	 *
	 * @param string $section default section name jlt_rpsi_general .
	 * @param string $key .
	 * @param string $default .
	 *
	 * @return string
	 */
	function jlt_rpsi_option( $section = 'jlt_rpsi_general', $key = '', $default = '' ) {
		$settings = get_option( $section );

		return isset( $settings[ $key ] ) ? $settings[ $key ] : $default;
	}
}

if ( ! function_exists( 'jlt_rpsi_exclude_pages' ) ) {
	/**
	 * Get exclude pages setting option data
	 *
	 * @return string|array
	 *
	 * @version 1.0.0
	 */
	function jlt_rpsi_exclude_pages() {
		return jlt_rpsi_option( 'jlt_rpsi_triggers', 'exclude_pages', array() );
	}
}

if ( ! function_exists( 'jlt_rpsi_exclude_pages' ) ) {
	/**
	 * Get exclude pages except setting option data
	 *
	 * @return string|array
	 *
	 * @version 1.0.0
	 */
	function jlt_rpsi_exclude_pages_except() {
		return jlt_rpsi_option( 'jlt_rpsi_triggers', 'exclude_pages_except', array() );
	}
}