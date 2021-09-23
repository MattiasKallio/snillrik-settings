<?php

/**
 * To not show the title if h1 is present in content.
 */
class SNSET_WooCommerce
{
    public function __construct()
    {
        $redirect_to_checkout = get_option('snillrik_settings_wootocheckout', array());

        if ($redirect_to_checkout == "on" && class_exists( 'woocommerce' )) {
            add_filter('woocommerce_add_to_cart_redirect', 'redirect_checkout_add_cart');
        }
    }
    function redirect_checkout_add_cart()
    {
        return wc_get_checkout_url();
    }
}
