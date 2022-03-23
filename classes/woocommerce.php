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
        $redirect_to_checkout = get_option('snillrik_settings_wootocheckout', array());

        if ($redirect_to_checkout == "on" && class_exists('woocommerce')) {
            add_filter('woocommerce_add_to_cart_redirect', 'redirect_checkout_add_cart');
        }
    }
    function redirect_checkout_add_cart()
    {
            return wc_get_checkout_url();
    }
}
