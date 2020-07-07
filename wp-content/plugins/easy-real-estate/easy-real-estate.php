<?php
/**
 * Plugin Name: Easy Real Estate
 * Plugin URI: http://themeforest.net/item/real-homes-wordpress-real-estate-theme/5373914
 * Description: Provides real estate functionality for Real Homes theme.
 * Version: 0.4.1
 * Author: Inspiry Themes
 * Author URI: https://themeforest.net/user/inspirythemes/portfolio?order_by=sales
 * Text Domain: easy-real-estate
 * Domain Path: /languages
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Easy_Real_Estate' ) ) :

	final class Easy_Real_Estate {

		/**
		 * Plugin's current version
		 *
		 * @var string
		 */
		public $version;

		/**
		 * Plugin Name
		 *
		 * @var string
		 */
		public $plugin_name;

		/**
		 * Plugin's singleton instance.
		 *
		 * @var Easy_Real_Estate
		 */
		protected static $_instance;

		/**
		 * Constructor function.
		 */
		public function __construct() {

			$this->plugin_name = 'easy-real-estate';
			$this->version     = '0.4.1';

			$this->define_constants();

			$this->includes();

			$this->initialize_custom_post_types();

			$this->initialize_meta_boxes();

			$this->initialize_admin_menu();

			$this->init_hooks();

			do_action( 'ere_loaded' );  // Easy Real Estate plugin loaded action hook
		}

		/**
		 * Provides singleton instance.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Defines constants.
		 */
		protected function define_constants() {

			if ( ! defined( 'ERE_VERSION' ) ) {
				define( 'ERE_VERSION', $this->version );
			}

			// Full path and filename
			if ( ! defined( 'ERE_PLUGIN_FILE' ) ) {
				define( 'ERE_PLUGIN_FILE', __FILE__ );
			}

			// Plugin directory path
			if ( ! defined( 'ERE_PLUGIN_DIR' ) ) {
				define( 'ERE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			}

			// Plugin directory URL
			if ( ! defined( 'ERE_PLUGIN_URL' ) ) {
				define( 'ERE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			}

			// Plugin file path relative to plugins directory
			if ( ! defined( 'ERE_PLUGIN_BASENAME' ) ) {
				define( 'ERE_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
			}

			// Real Homes selected design variation.
			if ( ! defined( 'INSPIRY_DESIGN_VARIATION' ) ) {
				define( 'INSPIRY_DESIGN_VARIATION', get_option( 'inspiry_design_variation', 'classic' ) );
			}

		}

		/**
		 * Includes files required on admin and on frontend.
		 */
		public function includes() {
			$this->include_functions();
			$this->include_shortcodes();
			$this->include_widgets();
		}

		/**
		 * Functions
		 */
		public function include_functions() {
			include_once( ERE_PLUGIN_DIR . 'includes/functions/basic.php' );   // basic functions
			include_once( ERE_PLUGIN_DIR . 'includes/functions/price.php' );   // price functions
			include_once( ERE_PLUGIN_DIR . 'includes/functions/real-estate.php' );   // real estate functions
			include_once( ERE_PLUGIN_DIR . 'includes/functions/agents.php' );   // agents functions
			include_once( ERE_PLUGIN_DIR . 'includes/functions/agencies.php' );   // agencies functions
			include_once( ERE_PLUGIN_DIR . 'includes/functions/form-handlers.php' );   // form handlers
			include_once( ERE_PLUGIN_DIR . 'includes/functions/members.php' );   // members functions
			include_once( ERE_PLUGIN_DIR . 'includes/functions/property-submit.php' );   // members functions

			if ( inspiry_is_realhomes_registered() ) {
				include_once( ERE_PLUGIN_DIR . 'includes/functions/plugin-update.php' );   // plugin update functions
			}
		}

		/**
		 * Shortcodes
		 */
		public function include_shortcodes() {
			include_once( ERE_PLUGIN_DIR . 'includes/shortcodes/columns.php' );
			include_once( ERE_PLUGIN_DIR . 'includes/shortcodes/elements.php' );
			include_once( ERE_PLUGIN_DIR . 'includes/shortcodes/vc-map.php' );
		}

		/**
		 * Widgets
		 */
		public function include_widgets() {
			include_once( ERE_PLUGIN_DIR . 'includes/widgets/agent-properties-widget.php' );
			include_once( ERE_PLUGIN_DIR . 'includes/widgets/agents-list-widget.php' );
			include_once( ERE_PLUGIN_DIR . 'includes/widgets/agent-featured-properties-widget.php' );
			include_once( ERE_PLUGIN_DIR . 'includes/widgets/featured-properties-widget.php' );
			include_once( ERE_PLUGIN_DIR . 'includes/widgets/properties-widget.php' );
			include_once( ERE_PLUGIN_DIR . 'includes/widgets/property-types-widget.php' );
			include_once( ERE_PLUGIN_DIR . 'includes/widgets/advance-search-widget.php' );
			if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
				include_once( ERE_PLUGIN_DIR . 'includes/widgets/rh-contact-information-widget.php' );
			}
		}

		/**
		 * Admin menu.
		 */
		public function initialize_admin_menu() {
			include_once( ERE_PLUGIN_DIR . 'includes/admin-menu/class-ere-admin-menu.php' );
		}

		/**
		 * Custom Post Types
		 */
		public function initialize_custom_post_types() {
			include_once( ERE_PLUGIN_DIR . 'includes/custom-post-types/property.php' );   // Property post type
			include_once( ERE_PLUGIN_DIR . 'includes/custom-post-types/agent.php' );   // Agent post type
			include_once( ERE_PLUGIN_DIR . 'includes/custom-post-types/agency.php' );   // Agent post type
			include_once( ERE_PLUGIN_DIR . 'includes/custom-post-types/partners.php' );   // Agent post type
			include_once( ERE_PLUGIN_DIR . 'includes/custom-post-types/slide.php' );   // Agent post type
		}

		/**
		 * Meta boxes
		 */
		public function initialize_meta_boxes() {
			include_once( ERE_PLUGIN_DIR . 'includes/mb/class-ere-meta-boxes.php' );
		}

		/**
		 * Initialize hooks.
		 */
		public function init_hooks() {
			add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );  // plugin's admin styles
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) ); // plugin's admin scrips
		}

		/**
		 * Load text domain for translation.
		 */
		public function load_plugin_textdomain() {
			load_plugin_textdomain( 'easy-real-estate', false, dirname( ERE_PLUGIN_BASENAME ) . '/languages' );
		}

		/**
		 * Enqueue admin styles
		 */
		public function enqueue_admin_styles() {
			wp_enqueue_style( 'easy-real-estate-admin', ERE_PLUGIN_URL . 'css/ere-admin.css', array(), $this->version, 'all' );
		}

		/**
		 * Enqueue JavaScript
		 */
		public function enqueue_admin_scripts() {
			wp_enqueue_script( 'easy-real-estate-admin', ERE_PLUGIN_URL . 'js/ere-admin.js', array(
				'jquery',
				'jquery-ui-sortable'
            ), $this->version );

			$ere_social_links_strings = array(
				'title'       => esc_html__( 'Title', 'easy-real-estate' ),
				'profileURL'  => esc_html__( 'Profile URL', 'easy-real-estate' ),
				'iconClass'   => esc_html__( 'Icon Class', 'easy-real-estate' ),
				'iconExample' => esc_html__( 'Example: fa-flicker', 'easy-real-estate' ),
				'iconLink'    => esc_html__( 'Get icon!', 'easy-real-estate' ),
			);
			wp_localize_script( 'easy-real-estate-admin', 'ereSocialLinksL10n', $ere_social_links_strings );
		}

		/**
		 * Tabs
		 */
		public function tabs() {

			$tabs = array(
				'price'   => esc_html__( 'Price Format', 'easy-real-estate' ),
				'slug'    => esc_html__( 'URL Slugs', 'easy-real-estate' ),
				'map'     => esc_html__( 'Maps', 'easy-real-estate' ),
				'captcha' => esc_html__( 'reCAPTCHA', 'easy-real-estate' ),
				'social'  => esc_html__( 'Social', 'easy-real-estate' ),
				'gdpr'    => esc_html__( 'GDPR', 'easy-real-estate' ),
			);

			return $tabs;
		}

		/**
		 * Generates tabs navigation
		 */
		public function tabs_nav( $current_tab ) {

			$tabs = $this->tabs();
			?>
            <div id="inspiry-ere-tabs" class="inspiry-ere-tabs">
				<?php
				if ( ! empty( $tabs ) && is_array( $tabs ) ) {
					foreach ( $tabs as $slug => $title ) {
						if ( file_exists( ERE_PLUGIN_DIR . 'includes/settings/' . $slug . '.php' ) ) {
							$active_tab = ( $current_tab === $slug ) ? ' inspiry-is-active-tab' : '';
							$admin_url  = ( $current_tab === $slug ) ? '#' : admin_url( 'admin.php?page=ere-settings&tab=' . $slug );
							echo '<a class="inspiry-ere-tab ' . esc_attr( $active_tab ) . '" href="' . esc_url_raw( $admin_url ) . '" data-tab="' . esc_attr( $slug ) . '">' . esc_html( $title ) . '</a>';
						}
					}
				}
				?>
            </div>
			<?php
		}

		/**
		 * Settings page callback
		 */
		public function settings_page() {
			require_once ERE_PLUGIN_DIR . 'includes/settings/settings.php';
		}

		/**
		 * Retrieves an option value based on an option name.
		 *
		 * @param string $value
		 * @param bool   $default
		 * @param string $type
		 *
		 * @return mixed|string
		 */
		public function get_option( $value, $default = false, $type = 'text' ) {

			$option = get_option( $value, $default );

			if ( isset( $_POST[ $value ] ) ) {

				$value = $_POST[ $value ];

				switch ( $type ) {
					case 'textarea':
						$allowed_html = array(
							'a'      => array(
								'class'  => array(),
								'href'   => array(),
								'target' => array(),
								'title'  => array()
							),
							'br'     => array(),
							'em'     => array(),
							'strong' => array(),
						);
						$value        = wp_kses( $value, $allowed_html );
						break;

					default:
						$value = sanitize_text_field( $value );
				}

				return $value;
			}

			return $option;
		}

		/**
		 * Sanitize additional social networks array.
		 */
		public function sanitize_social_networks( $social_networks ) {

			// Initialize the new array that will hold the sanitize values
			$sanitized_social_networks = array();

			foreach ( $social_networks as $index => $social_network ) {
				foreach ( $social_network as $key => $value ) {
					$sanitized_social_networks[ $index ][ $key ] = sanitize_text_field( $value );
				}
			}

			return $sanitized_social_networks;
		}

		/**
		 * Add notice when settings are saved.
		 */
		public function notice() {
			?>
            <div id="setting-error-ere_settings_updated" class="updated notice is-dismissible">
                <p><strong><?php esc_html_e( 'Settings saved successfully!', 'easy-real-estate' ); ?></strong></p>
            </div>
			<?php
		}

		/**
		 * Cloning is forbidden.
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cloning is forbidden!', 'easy-real-estate' ), ERE_VERSION );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Unserializing is forbidden!', 'easy-real-estate' ), ERE_VERSION );
		}

	}

endif; // End if class_exists check.


/**
 * Main instance of Easy_Real_Estate.
 *
 * Returns the main instance of Easy_Real_Estate to prevent the need to use globals.
 *
 * @return Easy_Real_Estate
 */
function ERR() {
	return Easy_Real_Estate::instance();
}

// Get ERR Running.
ERR();