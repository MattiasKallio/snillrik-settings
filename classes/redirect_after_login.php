<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * Redirect after login to this page.
 */

new SNSET_RedirectLogin();

class SNSET_RedirectLogin
{
    public function __construct()
    {
        $redirectlogin = get_option('snillrik_settings_redirectlogin', false);

        if ($redirectlogin == "on") {
            add_filter('login_redirect', array($this, 'redirect_to_page'),10,3);
        }
    }

    //Redirecting to the page.
    public function redirect_to_page($url, $request, $user)
    {
        if ( $user && is_object( $user ) && is_a( $user, 'WP_User' ) ) {
            if ( $user->has_cap( 'administrator' ) ) {
                $url = admin_url();
            } else {
                $snillrik_settings_redirectlogin_page = get_option('snillrik_settings_redirectlogin_page', "");
                if($snillrik_settings_redirectlogin_page != "" && is_numeric($snillrik_settings_redirectlogin_page))
                    $url = get_page_link($snillrik_settings_redirectlogin_page);
                else{
                    $url = $snillrik_settings_redirectlogin_page == "admin" ? admin_url() : get_home_url();
                }
            }
        }
        return $url;

    }

}
