<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * To use maintenance mode.
 */

new SNSET_Maintenance();

class SNSET_Maintenance extends SNSET_SettingItem
{
    const SETTING_NAME = 'snillrik_settings_maintenance';
    public function __construct()
    {
        add_action('admin_init', [$this, 'register']);
        $maintenance_mode = get_option(self::SETTING_NAME, array());
        if ($maintenance_mode == "on") {
            add_action('get_header', [$this, 'maintenance_mode']);
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
        $maintenance_mode = get_option(self::SETTING_NAME, array());
        $html_out = '<h3>Maintenance Mode</h3>
        <p>Enable WP maintenance mode. (So the same as when updating plugins or themes)</p>
        <label class="' . SNILLRIK_SETTINGS_SWITCHNAME . '">
            <input type="checkbox" ' . ($maintenance_mode == "on" ? "checked" : "") . ' id="' . self::SETTING_NAME . '" name="' . self::SETTING_NAME . '" />
            <div class="snillrik-settings-slider"></div>
        </label>';
        
        return self::html_out($html_out);
    }

    public function maintenance_mode()
    {
        if (!current_user_can('edit_themes') || !is_user_logged_in()) {
            //get wp site logo from customizer if set, otherwise use plugin logo
            $site_logo_id = get_theme_mod('custom_logo');
            if ($site_logo_id) {
                $site_logo_url = wp_get_attachment_image_url($site_logo_id, 'full');
            } else {
                $site_logo_url = SNILLRIK_SETTINGS_PLUGIN_URL . '/images/snillrik_logo_modern.svg';
            }
            $text_out = apply_filters('snillrik_settings_maintenance_text', 'Sorry, we are doing some maintenance. Please check back later.');
            
            wp_die(
                '<div style="text-align: center;">
                    <img src="' . esc_url($site_logo_url) . '" alt="Site logo" style="max-width: 150px; margin-bottom: 20px;" />
                    <h1>Under maintenance</h1><p>' . esc_html($text_out) . '</p>
                </div>',
                'Maintenance Mode',
                array('response' => 503)
            );
        }
    }
}
