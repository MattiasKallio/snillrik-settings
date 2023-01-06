<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * To turn of the block editor.
 */

new SNSET_Blockeditor();

class SNSET_Blockeditor
{
    public function __construct()
    {
        $turnoffblockeditor = get_option('snillrik_settings_blockeditor', array());
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
        register_setting('snillrik-settings-group', 'snillrik_settings_blockeditor', $sanitize_args_str);
    }

    //html for the settings page
    public static function settings_html()
    {
        $turnoffblockeditor = get_option('snillrik_settings_blockeditor', array());
        $html_out = '<h3>Block editor / Gutenberg</h3>
        <p>Turn off the block editor.</p>
        <label class="' . SNILLRIK_SETTINGS_SWITCHNAME . '">
            <input type="checkbox" ' . ($turnoffblockeditor ? "checked" : "") . ' id="snillrik_settings_blockeditor" name="snillrik_settings_blockeditor" />
            <div class="snillrik-settings-slider"></div>
        </label>';
        echo $html_out;
    }
}
