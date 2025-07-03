<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * Turning off specualtive loading.
 */
new SNSET_TurnOffSpcualtive();

class SNSET_TurnOffSpcualtive extends SNSET_SettingItem
{
    public function __construct()
    {
        add_action('admin_init', [$this, 'register']);
        //$current_option = get_option(self::get_option_name(), array());

       /*  if ($current_option == "on") { */
            add_filter('wp_speculation_rules_configuration', function ($config) {
                $eagerness = get_option('snillrik-settings-select-eagerness', 'auto');
                $mode = get_option('snillrik-settings-select-mode', 'auto');
                if( $mode == 'off' && $eagerness == 'off' ){
                    return null;
                }
                $config = array(
                    'mode' => $mode,
                    'eagerness' => $eagerness,
                );
                return $config;
            });
       /*  } */
    }

    //register the settings
    function register()
    {
        $sanitize_args_str = array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        );
        //register_setting('snillrik-settings-group', self::get_option_name(), $sanitize_args_str);
        register_setting('snillrik-settings-group', 'snillrik-settings-select-mode', $sanitize_args_str);
        register_setting('snillrik-settings-group', 'snillrik-settings-select-eagerness', $sanitize_args_str);
    }

    //html for the settings page
    public static function settings_html()
    {
        $html_out = "<h3>Specualtive loading</h3>
        <p>Settings for speculative loading of pages, to turn off, choose off for both.</p>";
        //select for mode and eagerness
        $selected_mode = get_option('snillrik-settings-select-mode', 'auto');
        $selected_eagerness = get_option('snillrik-settings-select-eagerness', 'auto');
        $html_out .= '<div class="snillrik-settings-select snillrik-settings-inner-row">';
        $html_out .= '<div><strong>Mode:</strong> ';
        $html_out .= '<select id="snillrik-settings-select-mode" name="snillrik-settings-select-mode">';
        $html_out .= '<option value="auto" ' . ($selected_mode == 'auto' ? 'selected' : '') . '>Default (auto)</option>';
        $html_out .= '<option value="off" ' . ($selected_mode == 'off' ? 'selected' : '') . '>Off</option>';
        $html_out .= '<option value="prefetch" ' . ($selected_mode == 'prefetch' ? 'selected' : '') . '>Prefetch</option>';
        $html_out .= '<option value="prerender" ' . ($selected_mode == 'prerender' ? 'selected' : '') . '>Prerender</option>';
        $html_out .= '</select></div>';
        $html_out .= '<div><strong>Eagerness:</strong> ';
        $html_out .= '<select id="snillrik-settings-select-eagerness" name="snillrik-settings-select-eagerness">';
        $html_out .= '<option value="auto" ' . ($selected_eagerness == 'auto' ? 'selected' : '') . '>Default (auto)</option>';
        $html_out .= '<option value="off" ' . ($selected_eagerness == 'off' ? 'selected' : '') . '>Off</option>';
        $html_out .= '<option value="conservative" ' . ($selected_eagerness == 'conservative' ? 'selected' : '') . '>Conservative</option>';
        $html_out .= '<option value="moderate" ' . ($selected_eagerness == 'moderate' ? 'selected' : '') . '>Moderate</option>';
        $html_out .= '<option value="aggressive" ' . ($selected_eagerness == 'aggressive' ? 'selected' : '') . '>Aggressive</option>';
        $html_out .= '</select></div>';
        $html_out .= '</div>';

        return self::html_out($html_out);
    }

    public static function get_option_name()
    {
        return 'snillrik_settings_turnoffspeculation';
    }
}