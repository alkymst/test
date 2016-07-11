<?php
/*
Plugin Name: 1Fee Core
Version: 1.0
Description: Adds the custom functionality for lead tracking and plugin mods.
Author: alkymst
Author URI: alkymst.com
Plugin URI:
Text Domain: 1fee-core
Domain Path: /languages
*/

include_once( plugin_dir_path( __FILE__ ) . 'includes/gf-cookie.php');

GFCookie::init();

if(!function_exists('gf_get_cookied_link')) {
function gf_get_cookied_link($url) {

    $cookies = GFCookie::get_cookie_data();
    $gfc_cookies = array();

    foreach($cookies as $key => $value) {
        if(strpos($key, GFCookie::$cookie_prefix) !== false) {
            $key = str_replace('gfc_', '', $key);
            $gfc_cookies[$key] = str_replace(array('http://', 'https://'), '', $value);
        }
    }

    return add_query_arg($gfc_cookies, $url);
}
}



function include_field_types_Gravity_Forms() {
  include_once( plugin_dir_path( __FILE__ ) .  'includes/acf-gforms.php' );
}
add_action('acf/include_field_types', 'include_field_types_gravity_forms');
