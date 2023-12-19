<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * Redirect to checkout after add to cart.
 */

new SNSET_WooCommerce();

class SNSET_WooCommerce extends SNSET_SettingItem
{
    public function __construct()
    {
        add_action('admin_init', [$this, 'register']);
        $redirect_to_checkout = get_option('snillrik_settings_wootocheckout', array());
        if ($redirect_to_checkout == "on" && class_exists('woocommerce')) {
            add_filter('woocommerce_add_to_cart_redirect', [$this, 'redirect_checkout_add_cart']);
        }

        $simple_honeypot = get_option('snillrik_settings_simplehoneypot', array());
        if ($simple_honeypot == "on" ) { //&& class_exists('woocommerce')
            add_action('woocommerce_register_form', [$this, 'register_form_honeypot'], 9999);
            add_filter('woocommerce_registration_errors', [$this, 'register_form_honeypot_check'], 9999, 3);
        }
    }


    function register_form_honeypot()
    {
        $snillrik_settings_simplehoneypot_name = get_option('snillrik_settings_simplehoneypot_name', 'repeat_email_field');
        echo self::html_out('<input type="text" name="'.$snillrik_settings_simplehoneypot_name.'" value="" tabindex="-1" autocomplete="off" style="position: absolute; left: -9999px;">');
    }

    function register_form_honeypot_check($errors, $username, $email)
    {
        $snillrik_settings_simplehoneypot_name = get_option('snillrik_settings_simplehoneypot_name', 'repeat_email_field');

        if (isset($_POST[$snillrik_settings_simplehoneypot_name]) && !empty($_POST[$snillrik_settings_simplehoneypot_name])) {
            $errors->add('registration-error-invalid-honeypot', esc_attr__('Yeah, no. Nice try robot.', SNILLRIK_SETTINGS_NAME));
        }
        return $errors;
    }

    //register the settings
    function register()
    {
        $sanitize_args_str = array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        );
        register_setting('snillrik-settings-group', 'snillrik_settings_wootocheckout', $sanitize_args_str);
        register_setting('snillrik-settings-group', 'snillrik_settings_simplehoneypot', $sanitize_args_str);
        register_setting('snillrik-settings-group', 'snillrik_settings_simplehoneypot_name', $sanitize_args_str);
    }

    //html for the settings page
    public static function settings_html()
    {
        $snillrik_settings_wootocheckout = get_option('snillrik_settings_wootocheckout', []);
        $html_out = '<h3>WooCommerce</h3><p>Redirect to Checkout after "add to cart"</p>';
        if (class_exists('woocommerce')) {
            $html_out .= '<label class="' . SNILLRIK_SETTINGS_SWITCHNAME . '">';
            $html_out .= '<input type="checkbox" ' . ($snillrik_settings_wootocheckout ? "checked" : "") . ' id="snillrik_settings_wootocheckout" name="snillrik_settings_wootocheckout" />';
            $html_out .= '<div class="snillrik-settings-slider"></div>';
            $html_out .= '</label>';

            $snillrik_settings_simplehoneypot = get_option('snillrik_settings_simplehoneypot', []);
            $html_out .= '<p>Simple honeypot for registration form. I\'s a good idea to pick a name that\'s not used for anything else, but also kinda looks like something that could be used.</p>';
            $html_out .= '<label class="' . SNILLRIK_SETTINGS_SWITCHNAME . '">';
            $html_out .= '<input type="checkbox" ' . ($snillrik_settings_simplehoneypot ? "checked" : "") . ' id="snillrik_settings_simplehoneypot" name="snillrik_settings_simplehoneypot" />';
            $html_out .= '<div class="snillrik-settings-slider"></div>';
            $html_out .= '</label>';
            $snillrik_settings_simplehoneypot_name = get_option('snillrik_settings_simplehoneypot_name', 'repeat_email_field');
            $html_out .= '<input type="text" id="snillrik_settings_simplehoneypot_name" name="snillrik_settings_simplehoneypot_name" value="' . $snillrik_settings_simplehoneypot_name . '" />';
        } else {
            $html_out .= esc_attr("(WooCommerce is not activated so this is not in use)", SNILLRIK_SETTINGS_NAME);
        }
        
        return self::html_out($html_out);
    }


    /**
     * Redirect to checkout after add to cart.
     */
    function redirect_checkout_add_cart()
    {
        return wc_get_checkout_url(); //it sure does, if woocommerce is activated
    }
}
