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
        add_action('admin_enqueue_scripts', [$this, 'my_enqueue']);
        add_action( 'wp_dashboard_setup', [$this, 'metabox_general_map'] );
        add_filter( 'login_redirect', [ $this, 'loginRedirect' ], 10, 3);
    }   

    function my_enqueue($hook) {
        wp_register_script( 'googlemap-api', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBbiaQ3VC5MMjkzJnAOFr0bP1RGyjmfnRA', array(), true, true );
        wp_enqueue_script('mapjs', plugin_dir_url(__FILE__) . '/assets/js/map.js',  array('googlemap-api'), true, true );  
    }

    function loginRedirect( $redirect_to, $request, $user ){
        return "wp-admin/index.php";
    }

    function metabox_general_map() {
        global $wp_meta_boxes;
        remove_meta_box( 'dashboard_primary','dashboard','side' );
        remove_meta_box('dashboard_activity','dashboard', 'normal');
        wp_add_dashboard_widget('custom_help_widget', 'General Map', [$this, 'custom_dashboard_help']);
    }
         
    function custom_dashboard_help() {
        wp_enqueue_script('mapjs');
        $current_user_role = wp_get_current_user()->roles;
        ?>
            <style> #map{height: 400px;width: 100%;}</style> 
            <div id="map"></div>      
        <?php
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