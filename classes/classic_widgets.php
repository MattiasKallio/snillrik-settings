<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * Use classic widgets.
 */
new SNSET_ClassicWidgets();

class SNSET_ClassicWidgets
{
    public function __construct()
    {
        add_action('admin_init', [$this, 'register']);
        $classicwidgets = get_option('snillrik_settings_classicwidgets', array());

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
        register_setting('snillrik-settings-group', 'snillrik_settings_classicwidgets', $sanitize_args_str);
    }

    //html for the settings page
    public static function settings_html()
    {
        $classicwidgets = get_option('snillrik_settings_classicwidgets', array());
        $html_out = '<h3>Classic widgets</h3>
        <p>Use classic widgets.</p>
        <label class="' . SNILLRIK_SETTINGS_SWITCHNAME . '">
            <input type="checkbox" ' . ($classicwidgets ? "checked" : "") . ' id="snillrik_settings_classicwidgets" name="snillrik_settings_classicwidgets" />
            <div class="snillrik-settings-slider"></div>
        </label>';
        return $html_out;
    }
}
