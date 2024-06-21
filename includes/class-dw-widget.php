<?php

if (!class_exists('DW_Widget')) {

    class DW_Widget
    {

        /**
         * Add the dashboard widget.
         */
        public static function add_dashboard_widget()
        {
            wp_add_dashboard_widget(
                'dw_dashboard_widget',
                'Graph Widget',
                array(__CLASS__, 'render_dashboard_widget')
            );
        }

        /**
         * Render the dashboard widget.
         */
        public static function render_dashboard_widget()
        {
            echo '<div id="root"></div>';
        }
    }
}
