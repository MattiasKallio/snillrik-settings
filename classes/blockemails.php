<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * To block all outgoing emails, to ensure that no mails are sent to customers while testing stuff.
 */
new SNSET_BlockEmail();

class SNSET_BlockEmail extends SNSET_SettingItem
{
    public function __construct()
    {
        add_action('admin_init', [$this, 'register']);

        $turnoffemails = get_option('snillrik_settings_turnoffemail', false);
        if ($turnoffemails == "on") {
            add_filter('wp_mail', array($this, 'redirect_mail'), 9999, 1);
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
        register_setting('snillrik-settings-group', 'snillrik_settings_turnoffemail', $sanitize_args_str);
        register_setting('snillrik-settings-group', 'snillrik_settings_turnoffemail_email', $sanitize_args_str);
    }

    // Disable support for comments and trackbacks in post types
    public function redirect_mail($mail_args)
    {
        $blockemailemail = get_option('snillrik_settings_turnoffemail_email', false);
        $admin_email = $blockemailemail ? $blockemailemail : get_site_option('admin_email');
        
        if (isset($mail_args['to']) && $admin_email !== $mail_args['to']) {
            $to_to_string = is_array($mail_args['to']) ? implode(", ", $mail_args['to']) : $mail_args['to'];
            $mail_args['to'] = $to_to_string;
            $mail_args['message'] = 'Was intended for: ' . sanitize_email($mail_args['to']) . "\n\n" . sanitize_text_field($mail_args['message']);
            $mail_args['subject'] = 'Redirected by Snillrik-plugin | ' . sanitize_text_field($mail_args['subject']);
            $mail_args['to'] = sanitize_email($admin_email);
        }
        return $mail_args;
    }

    // Add settings to the settings page
    public static function settings_html()
    {
        $turnoffemail = get_option('snillrik_settings_turnoffemail', false);
        $snillrik_settings_turnoffemail_email = get_option('snillrik_settings_turnoffemail_email', false);

        $html_out = '<h3>E-mails</h3>
        <p>Redirect all emails to admin to ensure that customers or users get no emails.<br />Probably mostly used for development and testing.</p>
        <label class="' . SNILLRIK_SETTINGS_SWITCHNAME . '">
            <input type="checkbox" ' . ($turnoffemail ? "checked" : "") . ' id="snillrik_settings_turnoffemail" name="snillrik_settings_turnoffemail">
            <div class="snillrik-settings-slider"></div>
        </label>
        <input type="text" value="' . esc_attr($snillrik_settings_turnoffemail_email) . '" id="snillrik_settings_turnoffemail_email" name="snillrik_settings_turnoffemail_email" autocomplete="email" />';
        
        return self::html_out($html_out);
    }
}
