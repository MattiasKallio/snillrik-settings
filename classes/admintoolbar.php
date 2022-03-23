<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * Turn of admin toolbar.
 */
new SNSET_AdminToolbar();

class SNSET_AdminToolbar
{
    public function __construct()
    {
        $turnoffadmintoolbar = get_option('snillrik_settings_admintoolbar', array());
        if ($turnoffadmintoolbar == "on") {
            add_filter('show_admin_bar', '__return_false');
        }
    }
}
