<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * To turn of the block editor.
 */

new SNSET_Blockeditor();

class SNSET_Blockeditor extends SNSET_SettingItem
{
    const SETTING_NAME = 'snillrik_settings_blockeditor';
    public function __construct()
    {
        add_action('admin_init', [$this, 'register']);
        $turnoffblockeditor = get_option(self::SETTING_NAME, array());
        if ($turnoffblockeditor == "on") {
            add_filter('use_block_editor_for_post', '__return_false', 10);
            add_filter('use_block_editor_for_post_type', '__return_false', 10);
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
        $turnoffblockeditor = get_option(self::SETTING_NAME, array());
        $html_out = '<h3>Block editor / Gutenberg</h3>
        <p>Turn off the block editor.</p>
        <label class="' . SNILLRIK_SETTINGS_SWITCHNAME . '">
            <input type="checkbox" ' . ($turnoffblockeditor ? "checked" : "") . ' id="' . self::SETTING_NAME . '" name="' . self::SETTING_NAME . '" />
            <div class="snillrik-settings-slider"></div>
        </label>';
        
        return self::html_out($html_out);
    }
}
