<?php

if (!class_exists('DW_Plugin')) {
    class DW_Plugin
    {

        protected static $instance = null;

        /**
         * Get the singleton instance of the class.
         *
         * @return DW_Plugin|null
         */

        public static function get_instance()
        {
            if (null == self::$instance) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        private function __construct()
        {
            $this->includes();
            $this->init_hooks();
        }

        /**
         * Include required files.
         */

        private function includes()
        {
            require_once DW_PLUGIN_PATH . 'includes/class-dw-rest-api.php';
            require_once DW_PLUGIN_PATH . 'includes/class-dw-widget.php';
        }

        /**
         * Initialize hooks.
         */

        private function init_hooks()
        {
            add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
            add_action('wp_dashboard_setup', array('DW_Widget', 'add_dashboard_widget'));
        }

        /**
         * Enqueue scripts and styles.
         *
         * @param string $hook The current admin page.
         */
        public function enqueue_scripts($hook)
        {
            if ('index.php' !== $hook) {
                return;
            }
            $js_file = glob(DW_PLUGIN_PATH . 'build/static/js/main.*.js');
            $css_file = glob(DW_PLUGIN_PATH . 'build/static/css/main.*.css');
            if (!empty($js_file)) {
                $js_version = substr($js_file[0], strpos($js_file[0], 'main.') + 5, -3);
                wp_enqueue_script('dw_react_app', DW_PLUGIN_URL . 'build/static/js/main.' . $js_version . '.js', array('jquery', 'wp-element'), $js_version, true);
            }
            if (!empty($css_file)) {
                $css_version = substr($css_file[0], strpos($css_file[0], 'main.') + 5, -4);
                wp_enqueue_style('dw_styles', DW_PLUGIN_URL . 'build/static/css/main.' . $css_version . '.css', array(), $css_version);
            }
        }

        /**
         * Plugin activation callback.
         */

        public static function activate()
        {
            self::create_table();
            self::insert_dummy_data();
        }

        /**
         * Plugin deactivation callback.
         */
        public static function deactivate()
        {
        }

        /**
         * Create database table.
         */
        private static function create_table()
        {
            global $wpdb;
            $table_name = $wpdb->prefix . 'dw_static_data';
            $charset_collate = $wpdb->get_charset_collate();
            $sql = "CREATE TABLE $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                date date NOT NULL,
                value float NOT NULL,
                PRIMARY KEY (id)
            ) $charset_collate;";
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }

        /**
         * Insert dummy data into the database.
         */
        private static function insert_dummy_data()
        {
            global $wpdb;
            $table_name = $wpdb->prefix . 'dw_static_data';
            $wpdb->insert($table_name, array('date' => '2024-06-15', 'value' => 10.5));
            $wpdb->insert($table_name, array('date' => '2024-06-13', 'value' => 11.5));
            $wpdb->insert($table_name, array('date' => '2024-06-14', 'value' => 15));
            $wpdb->insert($table_name, array('date' => '2024-06-15', 'value' => 18));
            $wpdb->insert($table_name, array('date' => '2024-06-16', 'value' => 22));
            $wpdb->insert($table_name, array('date' => '2024-06-17', 'value' => 25));
            $wpdb->insert($table_name, array('date' => '2024-06-18', 'value' => 30));

            $wpdb->insert($table_name, array('date' => '2024-06-05', 'value' => 12));
            $wpdb->insert($table_name, array('date' => '2024-06-06', 'value' => 18));
            $wpdb->insert($table_name, array('date' => '2024-06-07', 'value' => 20));
            $wpdb->insert($table_name, array('date' => '2024-06-08', 'value' => 22));
            $wpdb->insert($table_name, array('date' => '2024-06-09', 'value' => 24));
            $wpdb->insert($table_name, array('date' => '2024-06-10', 'value' => 26));
            $wpdb->insert($table_name, array('date' => '2024-06-11', 'value' => 28));

            $wpdb->insert($table_name, array('date' => '2024-05-19', 'value' => 15));
            $wpdb->insert($table_name, array('date' => '2024-05-20', 'value' => 18));
            $wpdb->insert($table_name, array('date' => '2024-05-21', 'value' => 20));
            $wpdb->insert($table_name, array('date' => '2024-05-22', 'value' => 22));
            $wpdb->insert($table_name, array('date' => '2024-05-23', 'value' => 24));
            $wpdb->insert($table_name, array('date' => '2024-05-24', 'value' => 26));
            $wpdb->insert($table_name, array('date' => '2024-05-25', 'value' => 28));
            $wpdb->insert($table_name, array('date' => '2024-05-26', 'value' => 30));
            $wpdb->insert($table_name, array('date' => '2024-05-27', 'value' => 32));
            $wpdb->insert($table_name, array('date' => '2024-05-28', 'value' => 34));
            $wpdb->insert($table_name, array('date' => '2024-05-29', 'value' => 36));
        }
    }
}
