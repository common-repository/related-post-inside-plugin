<?php
namespace JLTRPSI\Libs;

// No, Direct access Sir !!!
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Assets' ) ) {

	/**
	 * Assets Class
	 *
	 * Jewel Theme <support@jeweltheme.com>
	 * @version     1.0.4
	 */
	class Assets {

		/**
		 * Constructor method
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'jlt_rpsi_enqueue_scripts' ), 100 );
			add_action( 'admin_enqueue_scripts', array( $this, 'jlt_rpsi_admin_enqueue_scripts' ), 100 );
		}


		/**
		 * Get environment mode
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function get_mode() {
			return defined( 'WP_DEBUG' ) && WP_DEBUG ? 'development' : 'production';
		}

		/**
		 * Enqueue Scripts
		 *
		 * @method wp_enqueue_scripts()
		 */
		public function jlt_rpsi_enqueue_scripts() {

			// CSS Files .
			wp_enqueue_style( 'related-post-inside-plugin-frontend', JLTRPSI_ASSETS . 'css/related-post-inside-plugin-frontend.css', JLTRPSI_VER, 'all' );

			// JS Files .
			wp_enqueue_script( 'related-post-inside-plugin-frontend', JLTRPSI_ASSETS . 'js/related-post-inside-plugin-frontend.js', array( 'jquery' ), JLTRPSI_VER, true );
		}


		/**
		 * Enqueue Scripts
		 *
		 * @method admin_enqueue_scripts()
		 */
		public function jlt_rpsi_admin_enqueue_scripts() {
			// CSS Files .
			wp_enqueue_style( 'related-post-inside-plugin-admin', JLTRPSI_ASSETS . 'css/related-post-inside-plugin-admin.css', array( 'dashicons' ), JLTRPSI_VER, 'all' );

			// JS Files .
			wp_enqueue_script( 'related-post-inside-plugin-admin', JLTRPSI_ASSETS . 'js/related-post-inside-plugin-admin.js', array( 'jquery' ), JLTRPSI_VER, true );
			wp_localize_script(
				'related-post-inside-plugin-admin',
				'JLTRPSICORE',
				array(
					'admin_ajax'        => admin_url( 'admin-ajax.php' ),
					'recommended_nonce' => wp_create_nonce( 'jlt_rpsi_recommended_nonce' ),
				)
			);
		}
	}
}