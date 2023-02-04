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
        add_action('admin_init', [$this, 'register']);
        $turnoffadmintoolbar = get_option('snillrik_settings_admintoolbar', array());
        if ($turnoffadmintoolbar == "on") {
            add_filter('show_admin_bar', '__return_false');
        }
    }

    //register the settings
    function register()
    {
        $sanitize_args_str = array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        );
        register_setting('snillrik-settings-group', 'snillrik_settings_admintoolbar', $sanitize_args_str);
    }

    //html for the settings page
    public static function settings_html()
    {
        $turnoffadmintoolbar = get_option('snillrik_settings_admintoolbar', array());
        $html_out = '<h3>Admin toolbar frontend</h3>
        <p>Turn off the frontend admin toolbar.</p>
        <label class="' . SNILLRIK_SETTINGS_SWITCHNAME . '">
            <input type="checkbox" ' . ($turnoffadmintoolbar ? "checked" : "") . ' id="snillrik_settings_admintoolbar" name="snillrik_settings_admintoolbar" />
            <div class="snillrik-settings-slider"></div>
        </label>';
        return $html_out;
    }
}
