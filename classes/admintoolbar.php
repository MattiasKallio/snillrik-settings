<?php

class SNSET_AdminToolbar
{
    public function __construct()
    {
        //probably using soon.
        $turnoffadmintoolbar = get_option('snillrik_settings_admintoolbar', array());
        if ($turnoffadmintoolbar == "on") {
			add_filter('show_admin_bar', '__return_false');
        }
    }
}
