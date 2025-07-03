<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * Turning off xmlrpc.
 */
new SNSET_TurnOffXMLRPC();

class SNSET_TurnOffXMLRPC extends SNSET_SettingItem
{
    const SETTING_NAME = 'snillrik_settings_turnoffxmlrpc';
    public function __construct()
    {
        add_action('admin_init', [$this, 'register']);
        $turnoffxmlrpc = get_option(self::SETTING_NAME, array());
        
        if ($turnoffxmlrpc == "on") {
            add_filter('xmlrpc_enabled', '__return_false');
        }
    }

    //register the settings
    function register()
    {
        $sanitize_args_str = array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        );
        register_setting('snillrik-settings-group', self::SETTING_NAME, $sanitize_args_str);
    }

    //html for the settings page
    public static function settings_html()
    {
        $turnoffxmlrpc = get_option(self::SETTING_NAME, []);
        $html_out = "<h3>Turn off XML-RPC</h3>
        <p>Turn off XML-RPC to prevent brute force attacks.</p>";
        $html_out .= '<label class="' . SNILLRIK_SETTINGS_SWITCHNAME . '">';
        $html_out .= '<input type="checkbox" ' . ($turnoffxmlrpc ? "checked" : "") . ' id="' . self::SETTING_NAME . '" name="' . self::SETTING_NAME . '" />';
        $html_out .= '<div class="snillrik-settings-slider"></div>';
        $html_out .= '</label>';
        
        return self::html_out($html_out);
    }

}
