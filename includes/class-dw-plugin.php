<?php
if ( ! class_exists( 'DW_Plugin' ) ) {
	class DW_Plugin {

		protected static $instance = null;

		/**
		 * Get the singleton instance of the class.
		 *
		 * @return DW_Plugin|null
		 */
		public static function get_instance() {
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

		private function __construct() {
			$this->includes();
			$this->init_hooks();
		}

		/**
		 * Include required files.
		 */
		private function includes() {
			require_once DW_PLUGIN_PATH . 'includes/class-dw-rest-api.php';
			require_once DW_PLUGIN_PATH . 'includes/class-dw-widget.php';
		}

		/**
		 * Initialize hooks.
		 */
		private function init_hooks() {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'wp_dashboard_setup', array( 'DW_Widget', 'add_dashboard_widget' ) );
		}

		/**
		 * Enqueue scripts and styles.
		 *
		 * @param string $hook The current admin page.
		 */
		public function enqueue_scripts( $hook ) {
			if ( 'index.php' !== $hook ) {
				return;
			}
			wp_enqueue_script( 'wp-api-fetch' );
			wp_enqueue_script( 'wp-components' );
			wp_enqueue_script( 'wp-element' );
			wp_enqueue_style( 'wp-components' );
			$js_file  = glob( DW_PLUGIN_PATH . 'build/static/js/main.*.js' );
			$css_file = glob( DW_PLUGIN_PATH . 'build/static/css/main.*.css' );
			if ( ! empty( $js_file ) ) {
				$js_version = substr( $js_file[0], strpos( $js_file[0], 'main.' ) + 5, -3 );
				wp_enqueue_script( 'dw_react_app', DW_PLUGIN_URL . 'build/static/js/main.' . $js_version . '.js', array( 'jquery', 'wp-element' ), $js_version, true );
			}
			if ( ! empty( $css_file ) ) {
				$css_version = substr( $css_file[0], strpos( $css_file[0], 'main.' ) + 5, -4 );
				wp_enqueue_style( 'dw_styles', DW_PLUGIN_URL . 'build/static/css/main.' . $css_version . '.css', array(), $css_version );
			}
			wp_localize_script(
				'dw-plugin-script',
				'wpApiSettings',
				array(
					'nonce'   => wp_create_nonce( 'wp_rest' ),
					'siteUrl' => get_site_url(),
					'baseUrl' => rest_url(),
				)
			);
		}

		/**
		 * Plugin activation callback.
		 */
		public static function activate() {
			self::create_table();
			self::insert_dummy_data();
		}

		/**
		 * Plugin deactivation callback.
		 */
		public static function deactivate() {
		}

		/**
		 * Create database table.
		 */
		private static function create_table() {
			global $wpdb;
			$table_name      = $wpdb->prefix . 'dw_static_data';
			$charset_collate = $wpdb->get_charset_collate();
			$sql             = "CREATE TABLE $table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				date date NOT NULL,
				value float NOT NULL,
				PRIMARY KEY (id)
			) $charset_collate;";
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
			dbDelta( $sql );
		}

		/**
		 * Insert dummy data into the database.
		 */
		private static function insert_dummy_data() {
			global $wpdb;
			$table_name = $wpdb->prefix . 'dw_static_data';

			$data = array(
				array( '2024-06-15', 10.5 ),
				array( '2024-06-13', 11.5 ),
				array( '2024-06-14', 15 ),
				array( '2024-06-15', 18 ),
				array( '2024-06-16', 22 ),
				array( '2024-06-17', 25 ),
				array( '2024-06-18', 30 ),
				array( '2024-06-05', 12 ),
				array( '2024-06-06', 18 ),
				array( '2024-06-07', 20 ),
				array( '2024-06-08', 22 ),
				array( '2024-06-09', 24 ),
				array( '2024-06-10', 26 ),
				array( '2024-06-11', 28 ),
				array( '2024-05-19', 15 ),
				array( '2024-05-20', 18 ),
				array( '2024-05-21', 20 ),
				array( '2024-05-22', 22 ),
				array( '2024-05-23', 24 ),
				array( '2024-05-24', 26 ),
				array( '2024-05-25', 28 ),
				array( '2024-05-26', 30 ),
				array( '2024-05-27', 32 ),
				array( '2024-05-28', 34 ),
				array( '2024-05-29', 36 ),
			);

			foreach ( $data as $entry ) {
				$wpdb->insert(
					$table_name,
					array(
						'date'  => $entry[0],
						'value' => $entry[1],
					)
				);
			}
		}
	}
}
