<?php
/**
 * To not show the title if h1 is present in content.
 */
class SNSET_TurnOffXMLRPC
{
    public function __construct()
    {
        //probably using soon.
        $turnoffxmlrpc = get_option('snillrik_settings_turnoffxmlrpc', array());
        
        if ($turnoffxmlrpc == "on") {
            add_filter('xmlrpc_enabled', '__return_false');
        }
    }

}
