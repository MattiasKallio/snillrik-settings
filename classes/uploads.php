<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * To turn of the block editor.
 */

new SNSET_Uploads();

class SNSET_Uploads extends SNSET_SettingItem
{
    //setting name
    const SETTING_NAME = 'snillrik_settings_uploads_allow_svg';
    public function __construct()
    {
        add_action('admin_init', [$this, 'register']);
        $allow_svg = get_option(self::SETTING_NAME, array());
        if ($allow_svg == "on") {
            add_filter('upload_mimes', [$this, 'snillrik_upload_mimes'], 10, 1);
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
        $allow_svg = get_option(self::SETTING_NAME, array());
        $html_out = '<h3>Allow Media Uploads</h3>
        <p>Allow SVG uploads.</p>
        <label class="' . SNILLRIK_SETTINGS_SWITCHNAME . '">
            <input type="checkbox" ' . ($allow_svg ? "checked" : "") . ' id="'.self::SETTING_NAME.'" name="'.self::SETTING_NAME.'" />
            <div class="snillrik-settings-slider"></div>
        </label>';
        
        return self::html_out($html_out);
    }

    public function snillrik_upload_mimes($mimes)
    {
        $mimes['svg'] = 'image/svg+xml';
        $mimes['svgz'] = 'image/svg+xml';
        return $mimes;
    }
}
