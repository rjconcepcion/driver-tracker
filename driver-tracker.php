<?php
/*
Plugin Name: Driver Tracker
Plugin URI:  https://robert-john-concepcion.github.io
Description: Basic WordPress Plugin Header Comment
Version:     1
Author:      WordPress.org
Author URI:  https://robert-john-concepcion.github.io
Text Domain: wporg
Domain Path: /languages
License:     GPL2
 
{Plugin Name} is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
{Plugin Name} is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with {Plugin Name}. If not, see {License URI}.
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class DriverTracker {

    function __construct(){
        register_activation_hook( __FILE__, [ $this, 'activation' ] );
        register_deactivation_hook( __FILE__, [ $this, 'deactivation' ] );


 
        add_action('wp_dashboard_setup', [$this, 'my_custom_dashboard_widgets'] );

    }

    function my_custom_dashboard_widgets() {
        global $wp_meta_boxes;
        wp_add_dashboard_widget('custom_help_widget', 'Theme Support', [$this, 'custom_dashboard_help']);
    }
         
    function custom_dashboard_help() {

        $current_user_role = wp_get_current_user()->roles;
        echo "<pre>";
        var_dump(in_array('driver',$current_user_role));
        echo "</pre>";
    }

    function activation() {
        add_role( 'driver', 'Driver', array( 'read' => true ) );
    }

    function deactivation() {
        if( get_role('driver') ){
            remove_role( 'driver' );
        }
        if( get_role('custom_role') ){
            remove_role( 'custom_role' );
        } 
        flush_rewrite_rules();
    }
    
}
$obj = new DriverTracker();