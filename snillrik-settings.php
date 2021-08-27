<?php
/*
Plugin Name: Snillrik Settings
Plugin URI: http://www.snillrik.se/
Description: Snillrik settings is a plugin for som basic settings like turning of Gutenberg, adding css, turning of comments etc.
Version: 0.1
Author: Mattias Kallio
Author URI: http://www.snillrik.se
License: GPL2
 */

DEFINE("SNILLRIK_SETTINGS_PLUGIN_URL", plugin_dir_url(__FILE__));
DEFINE("SNILLRIK_SETTINGS_DIR", plugin_dir_path(__FILE__));

require_once SNILLRIK_SETTINGS_DIR . 'settings.php';
require_once SNILLRIK_SETTINGS_DIR . 'classes/blockeditor.php';
require_once SNILLRIK_SETTINGS_DIR . 'classes/comments.php';
require_once SNILLRIK_SETTINGS_DIR . 'classes/blockemails.php';
require_once SNILLRIK_SETTINGS_DIR . 'classes/turnofftitle.php';
require_once SNILLRIK_SETTINGS_DIR . 'classes/admintoolbar.php';
require_once SNILLRIK_SETTINGS_DIR . 'classes/turnoffxmlrpc.php';
require_once SNILLRIK_SETTINGS_DIR . 'classes/redirect_after_login.php';

new SNSET_Blockeditor();
new SNSET_Comments();
new SNSET_BlockEmail();
new SNSET_TurnOffTitle();
new SNSET_AdminToolbar();
new SNSET_TurnOffXMLRPC();
new SNSET_RedirectLogin();

/**
 * ToD0
 */
// Google fonts script to test

//add custom css?

function snillrik_settings_addCSScripts(){
	wp_enqueue_script 	( 'snillrik-settings-script', SNILLRIK_SETTINGS_PLUGIN_URL . 'js/snillrik-settings.js', array ('jquery' ));
	wp_enqueue_script 	( 'jscolor', SNILLRIK_SETTINGS_PLUGIN_URL . 'js/jscolor.min.js', array ('jquery' ));
    wp_enqueue_style 	( 'snillrik-settings-main', SNILLRIK_SETTINGS_PLUGIN_URL . 'snillrik-settings.css' );
}
 
add_action('admin_enqueue_scripts','snillrik_settings_addCSScripts');

