<?php
if ( ! class_exists( 'DW_REST_API' ) ) {

	class DW_REST_API {

		/**
		 * Register REST API routes.
		 */
		public static function register_routes() {
			register_rest_route(
				'dw/v1',
				'/data',
				array(
					'methods'             => 'GET',
					'callback'            => array( __CLASS__, 'get_data' ),
					'permission_callback' => array( __CLASS__, 'permissions_check' ),
					'args'                => array(
						'start_date' => array(
							'required'          => true,
							'validate_callback' => function ( $param, $request, $key ) {
								return strtotime( $param ) !== false;
							},
						),
						'end_date'   => array(
							'required'          => true,
							'validate_callback' => function ( $param, $request, $key ) {
								return strtotime( $param ) !== false;
							},
						),
					),
				)
			);
		}

		/**
		 * Check if a given request has access to the route.
		 *
		 * @return bool
		 */
		public static function permissions_check() {
			return current_user_can( 'manage_options' );
		}

		/**
		 * Get data from the database.
		 *
		 * @param WP_REST_Request $data The request object.
		 * @return array The data from the database.
		 */
		public static function get_data( $data ) {
			global $wpdb;
			$table_name = $wpdb->prefix . 'dw_static_data';
			$start_date = sanitize_text_field( $data['start_date'] );
			$end_date   = sanitize_text_field( $data['end_date'] );
			$results    = $wpdb->get_results(
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

	add_action( 'rest_api_init', array( 'DW_REST_API', 'register_routes' ) );
}
