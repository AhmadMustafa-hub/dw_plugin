<?php

if(!class_exists('DW_Widget')){

    class DW_Widget{

        public static function add_dashboard_widget()
        {
            wp_add_dashboard_widget(
            'dw_dashboard_widget',
            'Custom Dashboard Widget',
            array(__CLASS__,'render_dashboard_widget') 
        );
        }

        public static function render_dashboard_widget(){
            echo '<div id="root"></div>';
        }
    }
}