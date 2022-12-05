<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * Redirect after login to this page. and also redirect profile page to selected page.
 */

new SNSET_RedirectLogin();

class SNSET_RedirectLogin
{
    public function __construct()
    {
        $redirectlogin = get_option('snillrik_settings_redirectlogin', false);
        $redirectprofile = get_option('snillrik_settings_redirectprofile', false);

        if ($redirectlogin == "on") {
            add_filter('login_redirect', array($this, 'redirect_to_page'), 10, 3);
        }
        if ($redirectprofile == "on") {
            add_filter('edit_profile_url', [$this, 'redirect_profile']);
        }
    }

    //Redirecting to the page.
    public function redirect_to_page($url, $request, $user)
    {
        if ($user && is_object($user) && is_a($user, 'WP_User')) {
            if ($user->has_cap('administrator')) {
                $url = admin_url();
            } else {
                $snillrik_settings_redirectlogin_page = get_option('snillrik_settings_redirectlogin_page', "");
                if ($snillrik_settings_redirectlogin_page != "" && is_numeric($snillrik_settings_redirectlogin_page))
                    $url = get_page_link($snillrik_settings_redirectlogin_page);
                else {
                    $url = $snillrik_settings_redirectlogin_page == "admin" ? admin_url() : get_home_url();
                }
            }
        }
        return $url;
    }

    //Redirecting to the selected profile page.
    public function redirect_profile($url)
    {
        $snillrik_settings_redirectprofile_page = get_option('snillrik_settings_redirectprofile_page', "");
        $user = wp_get_current_user();
        if ($user->has_cap('administrator')) {
        } else if ($snillrik_settings_redirectprofile_page != "" && is_numeric($snillrik_settings_redirectprofile_page))
            $url = get_page_link($snillrik_settings_redirectprofile_page);

        return $url;
    }
}
