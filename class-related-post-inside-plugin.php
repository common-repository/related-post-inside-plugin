<?php
namespace JLTRPSI;

use JLTRPSI\Libs\Assets;
use JLTRPSI\Libs\Helper;
use JLTRPSI\Libs\Featured;
use JLTRPSI\Inc\Classes\Recommended_Plugins;
use JLTRPSI\Inc\Classes\Notifications\Notifications;
use JLTRPSI\Inc\Classes\Pro_Upgrade;
use JLTRPSI\Inc\Classes\Row_Links;
use JLTRPSI\Inc\Classes\Upgrade_Plugin;
use JLTRPSI\Inc\Classes\Feedback;

/**
 * Main Class
 *
 * @related-post-inside-plugin
 * Jewel Theme <support@jeweltheme.com>
 * @version     1.0.4
 */

// No, Direct access Sir !!!
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * JLT_RPSI Class
 */
if ( ! class_exists( '\JLTRPSI\JLT_RPSI' ) ) {

	/**
	 * Class: JLT_RPSI
	 */
	final class JLT_RPSI {

		const VERSION            = JLTRPSI_VER;
		private static $instance = null;

		/**
		 * what we collect construct method
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function __construct() {
			$this->includes();
			add_action( 'plugins_loaded', array( $this, 'jlt_rpsi_plugins_loaded' ), 999 );
			// Body Class.
			add_filter( 'admin_body_class', array( $this, 'jlt_rpsi_body_class' ) );
			// This should run earlier .
			// add_action( 'plugins_loaded', [ $this, 'jlt_rpsi_maybe_run_upgrades' ], -100 ); .

			add_action( 'admin_menu', [ $this, 'jeweltheme_rpi_add_menu' ] );

			// Register and define the settings
			add_action( 'admin_init', [ $this, 'jeweltheme_rpi_admin_init' ] );

			add_shortcode('rpi', [ $this, 'jeweltheme_related_posts_shortcode' ] );
		}

		
		function jeweltheme_rpi_add_menu() {
		    add_options_page( 'Jewel Theme Related Post Inside', 'Related Post Inside', 'manage_options', 'jeweltheme_rpi', [ $this, 'jeweltheme_rpi_option_page' ] );
		}		

		function jeweltheme_rpi_admin_init() {

		    register_setting( 'jeweltheme_rpi_options', 'jeweltheme_rpi_options', [ $this, 'jeweltheme_rpi_validate_options' ] );

		    add_settings_section( 'jeweltheme_rpi_main', 'Related Post Inside Settings', [ $this, 'jeweltheme_rpi_section_text' ], 'jeweltheme_rpi' );

		    add_settings_field( 'jeweltheme_rpi_title', 'Related Post Inside Title', [ $this, 'jeweltheme_rpi_setting_title' ], 'jeweltheme_rpi', 'jeweltheme_rpi_main' );

		    add_settings_field( 'jeweltheme_rpi_text_string', 'Number of posts to show', [ $this, 'jeweltheme_rpi_setting_input' ], 'jeweltheme_rpi', 'jeweltheme_rpi_main' );    

		    add_settings_field( 'jeweltheme_rpi_order', 'Order', [ $this, 'jeweltheme_rpi_order_setting' ], 'jeweltheme_rpi', 'jeweltheme_rpi_main' );

		    add_settings_field( 'jeweltheme_rpi_orderby', 'Order By', [ $this, 'jeweltheme_rpi_orderby_setting' ], 'jeweltheme_rpi', 'jeweltheme_rpi_main' );
		}




		    
		// Validate user input (we want text only)
		function jeweltheme_rpi_validate_options( $input ) {

		        $valid = array();

		        $valid['rpi_count'] = preg_replace('/[^0-9]/', '', $input['rpi_count'] );

		        $valid['rpi_order'] = preg_replace('/[^a-zA-Z]/', '', $input['rpi_order'] );

		        $valid['jeweltheme_rpi_title'] = preg_replace('/[^a-z A-Z]/', '', $input['jeweltheme_rpi_title'] );

		        $valid['rpi_orderby'] = preg_replace('/[^a-zA-Z]/', '', $input['rpi_orderby'] );

		        return $valid;

		}

		// Draw the section header
		function jeweltheme_rpi_section_text() {
		}

		// Display and fill the form field
		function jeweltheme_rpi_setting_title() {

		        // get option 'jeweltheme_rpi_title' value from the database
		        $options = get_option( 'jeweltheme_rpi_options' );

		        $jeweltheme_rpi_title = !empty( $options['jeweltheme_rpi_title'] ) ? $options['jeweltheme_rpi_title'] : '';

		        // echo the field
		        echo "<input type='text' id='jeweltheme_rpi_title' style='width:200px;' name='jeweltheme_rpi_options[jeweltheme_rpi_title]' value='$jeweltheme_rpi_title' />";

		}

		// Display and fill the form field
		function jeweltheme_rpi_setting_input() {

		        // get option 'rpi_count' value from the database
		        $options = get_option( 'jeweltheme_rpi_options' );

		        $rpi_count = !empty( $options['rpi_count'] ) ? $options['rpi_count'] : '';

		        // echo the field
		        echo "<input type='number' style='width:200px;' id='rpi_count' name='jeweltheme_rpi_options[rpi_count]' value='$rpi_count' />";
		}



		  
		//Query Order Posts  
		function jeweltheme_rpi_order_setting() {

		        // get option 'rpi_order' value from the database
		        $options = get_option( 'jeweltheme_rpi_options' );

		        $rpi_order = !empty( $options['rpi_order'] ) ? $options['rpi_order'] : '';
		    
		        $items = array("ASC","DESC");

		        echo "<select id='rpi_order' name='jeweltheme_rpi_options[rpi_order]' style='width:200px;'>";

		        foreach($items as $item) {

		        $selected = ($options['rpi_order']==$item) ? 'selected="selected"' : '';

		        echo "<option value='$item' $selected>$item</option>";
		    }

		        echo "</select>";  

		}

		//Query Posts Orderby
		function jeweltheme_rpi_orderby_setting() {

		        // get option 'rpi_orderby' value from the database
		        $options = get_option( 'jeweltheme_rpi_options' );

		        $rpi_orderby = !empty( $options['rpi_orderby'] ) ? $options['rpi_orderby'] : '';
		    
		        $items = array("ID","title","date","modified","author","post_name","rand");

		        echo "<select id='rpi_orderby' name='jeweltheme_rpi_options[rpi_orderby]' style='width:200px;'>";

		        foreach($items as $item) {

		        $selected = ($options['rpi_orderby']==$item) ? 'selected="selected"' : '';

		        echo "<option value='$item' $selected>$item</option>";

		    }

		   	echo "</select>";               
		}




		//Options menu page
		function jeweltheme_rpi_option_page() { ?>

		    <div class="wrap">

		        <h2>Related Post Inside</h2>

		        <form action="options.php" method="post">

		            <?php settings_fields('jeweltheme_rpi_options'); ?>

		            <?php do_settings_sections('jeweltheme_rpi'); ?>

		            <input name="Submit" class="button button-primary" type="submit" value="Save Changes" />
		        </form>
		    </div>

			<?php
		}


		/* related posts by category */
		function jeweltheme_related_posts_shortcode($atts){

		    $options = get_option( 'jeweltheme_rpi_options' );

		    $jeweltheme_rpi_title = $options['jeweltheme_rpi_title'];

		    $rpi_count = $options['rpi_count'];

		    $rpi_order = $options['rpi_order'];

		    $rpi_orderby = $options['rpi_orderby'];

		    extract(shortcode_atts(array(

		        'count' => $rpi_count,

		         ), $atts));

		        global $post;

		        $current_cat = get_the_category($post->ID);

		        $current_cat = $current_cat[0]->cat_ID;

		        $this_cat = '';

		        $tag_ids = array();

		        $tags = get_the_tags($post->ID);

		        if ($tags) {
		            foreach($tags as $tag) {
		                $tag_ids[] = $tag->term_id;
		            }

		        } else {

		        	$this_cat = $current_cat;

		        }

		        $args = array(

		            'post_type' => get_post_type(),

		            'numberposts' => $count,

		            'orderby' => $rpi_orderby,

		            'order' => $rpi_order,

		            'tag__in' => $tag_ids,

		            'cat' => $this_cat,

		            'exclude' => $post->ID

		        );

		        $dtwd_related_posts = get_posts($args);

		            if ( empty($dtwd_related_posts) ) {

		                $args['tag__in'] = '';

		                $args['cat'] = $current_cat;

		                $dtwd_related_posts = get_posts($args);

		                }

		            if ( empty($dtwd_related_posts) ) {

		                    return;
		                }

		    $post_list = '';

		    foreach($dtwd_related_posts as $dtwd_related) {

		        $options = get_option( 'jeweltheme_rpi_options' );

		        $jeweltheme_rpi_title = $options['jeweltheme_rpi_title'];

		        $title=$jeweltheme_rpi_title ;

		        $post_list .= '<li><a href="' . get_permalink($dtwd_related->ID) . '">' . $dtwd_related->post_title . '</a></li>';

		        }

		        return sprintf('

		            <div class="jeweltheme_related-posts">

		                <h4>%s</h4>

		                <ul style="list-style:none; margin:0px;">%s</ul>

		            </div> 

		        ', $title, $post_list );

		}

		/**
		 * plugins_loaded method
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jlt_rpsi_plugins_loaded() {
			$this->jlt_rpsi_activate();
		}

		/**
		 * Version Key
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public static function plugin_version_key() {
			return Helper::jlt_rpsi_slug_cleanup() . '_version';
		}

		/**
		 * Activation Hook
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public static function jlt_rpsi_activate() {
			$current_jlt_rpsi_version = get_option( self::plugin_version_key(), null );

			if ( get_option( 'jlt_rpsi_activation_time' ) === false ) {
				update_option( 'jlt_rpsi_activation_time', strtotime( 'now' ) );
			}

			if ( is_null( $current_jlt_rpsi_version ) ) {
				update_option( self::plugin_version_key(), self::VERSION );
			}

			$allowed = get_option( Helper::jlt_rpsi_slug_cleanup() . '_allow_tracking', 'no' );

			// if it wasn't allowed before, do nothing .
			if ( 'yes' !== $allowed ) {
				return;
			}
			// re-schedule and delete the last sent time so we could force send again .
			$hook_name = Helper::jlt_rpsi_slug_cleanup() . '_tracker_send_event';
			if ( ! wp_next_scheduled( $hook_name ) ) {
				wp_schedule_event( time(), 'weekly', $hook_name );
			}
		}


		/**
		 * Add Body Class
		 *
		 * @param [type] $classes .
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jlt_rpsi_body_class( $classes ) {
			$classes .= ' related-post-inside-plugin ';
			return $classes;
		}

		/**
		 * Run Upgrader Class
		 *
		 * @return void
		 */
		public function jlt_rpsi_maybe_run_upgrades() {
			if ( ! is_admin() && ! current_user_can( 'manage_options' ) ) {
				return;
			}

			// Run Upgrader .
			$upgrade = new Upgrade_Plugin();

			// Need to work on Upgrade Class .
			if ( $upgrade->if_updates_available() ) {
				$upgrade->run_updates();
			}
		}

		/**
		 * Include methods
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function includes() {
			new Assets();
			new Recommended_Plugins();
			new Row_Links();
			new Pro_Upgrade();
			new Notifications();
			new Featured();
			new Feedback();
		}


		/**
		 * Initialization
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jlt_rpsi_init() {
			$this->jlt_rpsi_load_textdomain();
		}


		/**
		 * Text Domain
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jlt_rpsi_load_textdomain() {
			$domain = 'related-post-inside-plugin';
			$locale = apply_filters( 'jlt_rpsi_plugin_locale', get_locale(), $domain );

			load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
			load_plugin_textdomain( $domain, false, dirname( JLTRPSI_BASE ) . '/languages/' );
		}
		
		
		

		/**
		 * Returns the singleton instance of the class.
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof JLT_RPSI ) ) {
				self::$instance = new JLT_RPSI();
				self::$instance->jlt_rpsi_init();
			}

			return self::$instance;
		}
	}

	// Get Instant of JLT_RPSI Class .
	JLT_RPSI::get_instance();
}