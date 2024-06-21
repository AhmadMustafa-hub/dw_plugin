<?php
if (!class_exists('DW_REST_API')) {

    class DW_REST_API
    {
        /**
         * Register REST API routes.
         */
        public static function register_routes()
        {
            register_rest_route(
                'dw/v1',
                '/data',
                array(
                    'methods' => 'GET',
                    'callback' => array(__CLASS__, 'get_data'),
                    'args' => array(
                        'start_date' => array(
                            'required' => true,
                            'validate_callback' => function ($param, $request, $key) {
                                return strtotime($param) !== false;
                            }
                        ),
                        'end_date' => array(
                            'required' => true,
                            'validate_callback' => function ($param, $request, $key) {
                                return strtotime($param) !== false;
                            }
                        ),
                    ),
                )
            );
        }
        
        /**
         * Get data from the database.
         *
         * @param WP_REST_Request $data The request object.
         * @return array The data from the database.
         */
        
        public static function get_data($data)
        {
            global $wpdb;
            $table_name = $wpdb->prefix . 'dw_static_data';
            $start_date = sanitize_text_field($data['start_date']);
            $end_date = sanitize_text_field($data['end_date']);
            $results = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT * FROM $table_name WHERE date >= %s AND date <= %s",
                    $start_date,
                    $end_date
                ),
                OBJECT
            );
            return $results;
        }
    }
    add_action('rest_api_init', array('DW_REST_API', 'register_routes'));
}
