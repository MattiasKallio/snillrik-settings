<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * Use classic widgets.
 */
new SNSET_ClassicWidgets();

class SNSET_ClassicWidgets extends SNSET_SettingItem
{
    const SETTING_NAME = 'snillrik_settings_classicwidgets';
    public function __construct()
    {
        add_action('admin_init', [$this, 'register']);
        $classicwidgets = get_option(self::SETTING_NAME, array());

        if ($classicwidgets == "on") {
            // Disables the block editor from managing widgets in the Gutenberg plugin.
            add_filter('gutenberg_use_widgets_block_editor', '__return_false');
            // Disables the block editor from managing widgets.
            add_filter('use_widgets_block_editor', '__return_false');
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
        $classicwidgets = get_option(self::SETTING_NAME, array());
        $html_out = '<h3>Classic widgets</h3>
        <p>Use classic widgets.</p>
        <label class="' . SNILLRIK_SETTINGS_SWITCHNAME . '">
            <input type="checkbox" ' . ($classicwidgets ? "checked" : "") . ' id="' . self::SETTING_NAME . '" name="' . self::SETTING_NAME . '" />
            <div class="snillrik-settings-slider"></div>
        </label>';
        
        return self::html_out($html_out);
    }
}
