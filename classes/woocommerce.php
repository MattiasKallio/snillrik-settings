<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * Redirect to checkout after add to cart.
 */

new SNSET_WooCommerce();

class SNSET_WooCommerce
{
    public function __construct()
    {
        add_action('admin_init', [$this, 'register']);
        $redirect_to_checkout = get_option('snillrik_settings_wootocheckout', array());
        if ($redirect_to_checkout == "on" && class_exists('woocommerce')) {
            add_filter('woocommerce_add_to_cart_redirect', [$this, 'redirect_checkout_add_cart']);
        }
    }

    //register the settings
    function register()
    {
        $sanitize_args_str = array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        );
        register_setting('snillrik-settings-group', 'snillrik_settings_wootocheckout', $sanitize_args_str);
    }

    //html for the settings page
    public static function settings_html()
    {
        $snillrik_settings_wootocheckout = get_option('snillrik_settings_wootocheckout', []);
        $html_out = '<h3>WooCommerce</h3><p>Redirect to Checkout after "add to cart"</p>';
            if (class_exists('woocommerce')){
                $html_out .= '<label class="' . SNILLRIK_SETTINGS_SWITCHNAME . '">';
                $html_out .= '<input type="checkbox" ' . ($snillrik_settings_wootocheckout ? "checked" : "") . ' id="snillrik_settings_wootocheckout" name="snillrik_settings_wootocheckout" />';
                $html_out .= '<div class="snillrik-settings-slider"></div>';
                $html_out .= '</label>';
            } else {
                $html_out .= "(WooCommerce is not activated so this is not in use)";
            }
            return $html_out;
    }


    /**
     * Redirect to checkout after add to cart.
     */
    function redirect_checkout_add_cart()
    {
            return wc_get_checkout_url(); //it sure does, if woocommerce is activated
    }
}
