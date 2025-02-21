<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * Turn of admin toolbar.
 */
new SNSET_LoginPage();

class SNSET_LoginPage extends SNSET_SettingItem
{
    public function __construct()
    {
        add_action('admin_init', [$this, 'register']);
        $customlogo = get_option('snillrik_settings_loginpage_logo', array());
        if ($customlogo == "on") {
            add_action('login_head', [$this, 'custom_login_logo']);
            add_action( 'login_headerurl', [$this, 'custom_login_url'] );
        }
    }

    public function custom_login_logo()
    {
        //get wordpress logo url
        $icon_vs_logo = false ? 'custom_logo' : 'site_icon';
        $logo_ob = wp_get_attachment_image_src(get_theme_mod($icon_vs_logo), 'full');
        if(!$logo_ob) {
            $logo_ob = wp_get_attachment_image_src(get_option('site_icon'), 'full');
        }
        if ($logo_ob) {
            $logo_url = esc_url($logo_ob[0]);
            $ratio = is_numeric($logo_ob[1]) && is_numeric($logo_ob[2]) ? $logo_ob[1] / $logo_ob[2] : 1;
            $width = 180;
            $height = $width / $ratio;

            echo self::html_out('<style type="text/css">' .
                'h1 a {
                    background-image:url(' . $logo_url . ') !important;
                    background-size:100% !important;
                    width: ' . $width . 'px !important;
                    height: ' . $height . 'px !important;
                    line-height:inherit !important;
                    margin:0 auto !important;
                    margin-bottom: 10px !important;
                    }' .
                '</style>');
       } 
    }

    public function custom_login_url() {
        return home_url();
    }

    //register the settings
    function register()
    {
        $sanitize_args_str = array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        );
        register_setting('snillrik-settings-group', 'snillrik_settings_loginpage_logo', $sanitize_args_str);
    }

    //html for the settings page
    public static function settings_html()
    {
        $use_logologo = get_option('snillrik_settings_loginpage_logo', array());
        $html_out = '<h3>Login logoype</h3>
        <p>Use the logotype set in the customizer on the login page instead of the default WP logo.</p>
        <label class="' . SNILLRIK_SETTINGS_SWITCHNAME . '">
            <input type="checkbox" ' . ($use_logologo ? "checked" : "") . ' id="snillrik_settings_loginpage_logo" name="snillrik_settings_loginpage_logo" />
            <div class="snillrik-settings-slider"></div>
        </label>';

        return self::html_out($html_out);
    }
}
