<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * To block all outgoing emails, to ensure that no mails are sent to customers while testing stuff.
 */
new SNSET_ChangeEmail();
 
class SNSET_ChangeEmail extends SNSET_SettingItem
{
    public function __construct()
    {
        add_action('admin_init', [$this, 'register']);

        $changeemail = get_option('snillrik_settings_changeemail', false);
        if ($changeemail == "on") {
            add_filter('wp_mail_from', [$this, 'from_email']);
            add_filter('wp_mail_from_name', [$this, 'from_name']);
        }
    }

    /**
     * Register the settings
     */
    function register()
    {
        $sanitize_args_str = array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        );
        register_setting('snillrik-settings-group', 'snillrik_settings_changeemail', $sanitize_args_str);
        register_setting('snillrik-settings-group', 'snillrik_settings_change_name', $sanitize_args_str);
        register_setting('snillrik-settings-group', 'snillrik_settings_change_email', $sanitize_args_str);
    }

    function from_email($old)
    {
        $changes_email = get_option('snillrik_settings_change_email', false);
        $changes_email = sanitize_email($changes_email);
        return $changes_email;
    }
    function from_name($old)
    {
        $change_name = get_option('snillrik_settings_change_name', false);
        return esc_attr($change_name);
    }


    // Add settings to the settings page
    public static function settings_html()
    {
        $changeemail = get_option('snillrik_settings_changeemail', false);
        $snillrik_settings_change_name = get_option('snillrik_settings_change_name', false);
        $snillrik_settings_change_email = get_option('snillrik_settings_change_email', false);
        $wp_mail_from = get_option('wp_mail_from', false);
        $html_out = '<h3>Default E-mail</h3>
        <p>Change default email '.$wp_mail_from.' so that when mails are sent from the site it from the name and email below.</p>
        <label class="' . SNILLRIK_SETTINGS_SWITCHNAME . '">
            <input type="checkbox" ' . ($changeemail ? "checked" : "") . ' id="snillrik_settings_changeemail" name="snillrik_settings_changeemail" />
            <div class="snillrik-settings-slider"></div>
        </label><br><br>
        <input type="text" value="' . esc_attr($snillrik_settings_change_name) . '" id="snillrik_settings_change_name" name="snillrik_settings_change_name" autocomplete="site-name" placeholder="'.esc_attr__("Name",SNILLRIK_SETTINGS_NAME).'" />
        <input type="email" value="' . esc_attr($snillrik_settings_change_email) . '" id="snillrik_settings_change_email" name="snillrik_settings_change_email" autocomplete="email" placeholder="'.esc_attr__("Email",SNILLRIK_SETTINGS_NAME).'" />';
        
        return self::html_out($html_out);
    }
}
