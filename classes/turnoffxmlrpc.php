<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * Turning off xmlrpc.
 */
new SNSET_TurnOffXMLRPC();

class SNSET_TurnOffXMLRPC
{
    public function __construct()
    {
        $turnoffxmlrpc = get_option('snillrik_settings_turnoffxmlrpc', array());
        
        if ($turnoffxmlrpc == "on") {
            add_filter('xmlrpc_enabled', '__return_false');
        }
    }

}
