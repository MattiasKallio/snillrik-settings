<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * Just to add a link to the customizer.
 */
new SNSET_Customizer();

class SNSET_Customizer extends SNSET_SettingItem
{
    public function __construct()
    {
        add_action('admin_init', [$this, 'register']);
        $showcustomizerlinke = get_option('snillrik_settings_customizerlink', array());
        if ($showcustomizerlinke == 'on') {
            add_action('admin_init', [$this, 'snillrik_customizer_link']);
        }
    }

    public function snillrik_customizer_link()
    {
        global $submenu;
        $submenu['themes.php'][] = [esc_attr__('Customize'), 'edit_theme_options', 'customize.php'];
    }

    //register the settings
    function register()
    {
        $sanitize_args_str = array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        );
        register_setting('snillrik-settings-group', 'snillrik_settings_customizerlink', $sanitize_args_str);
    }

    //html for the settings page
    public static function settings_html()
    {
        $showcustomizerlinke = get_option('snillrik_settings_customizerlink', array());
        $html_out = '<h3>Customizer link</h3>
        <p>If you\'re using TwentyTwentyTwo and want the customizer back (or at least the custom css)</p>
        <label class="' . SNILLRIK_SETTINGS_SWITCHNAME . '">
            <input type="checkbox" ' . ($showcustomizerlinke ? "checked" : "") . ' id="snillrik_settings_customizerlink" name="snillrik_settings_customizerlink" />
            <div class="snillrik-settings-slider"></div>
        </label>';
        
        return self::html_out($html_out);
    }
}
