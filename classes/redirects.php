<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * Redirect after login to this page. and also redirect profile page to selected page.
 */

new SNSET_Redirects();

class SNSET_Redirects
{
    public function __construct()
    {
        add_action('admin_init', [$this, 'register']);
        $redirectlogin = get_option('snillrik_settings_redirectlogin', false);
        $redirectlogout = get_option('snillrik_settings_redirectlogout', false);
        $redirectprofile = get_option('snillrik_settings_redirectprofile', false);

        if ($redirectlogin == "on") {
            add_filter('login_redirect', array($this, 'redirect_to_page'), 10, 3);
        }
        if ($redirectlogout == "on") {
            add_filter('wp_logout', array($this, 'redirect_logout'), 10, 3);
        }
        if ($redirectprofile == "on") {
            add_filter('edit_profile_url', [$this, 'redirect_profile']);
        }
    }

    //register the settings
    function register()
    {
        $sanitize_args_str = array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        );
        register_setting('snillrik-settings-group', 'snillrik_settings_redirectlogin', $sanitize_args_str);
        register_setting('snillrik-settings-group', 'snillrik_settings_redirectlogout', $sanitize_args_str);
        register_setting('snillrik-settings-group', 'snillrik_settings_redirectprofile', $sanitize_args_str);
        register_setting('snillrik-settings-group', 'snillrik_settings_redirectlogin_page', $sanitize_args_str);
        register_setting('snillrik-settings-group', 'snillrik_settings_redirectlogout_page', $sanitize_args_str);
        register_setting('snillrik-settings-group', 'snillrik_settings_redirectprofile_page', $sanitize_args_str);
    }

    //html for the settings page
    public static function settings_html($field = "login")
    {
        switch ($field) {
            case "login":
                return self::login_html();
                break;
            case "logout":
                return self::logout_html();
                break;
            case "profile":
                return self::profile_html();
                break;
        }
    }

    public static function login_html()
    {
        $redirectlogin = get_option('snillrik_settings_redirectlogin', false);
        $snillrik_settings_redirectlogin_page = get_option('snillrik_settings_redirectlogin_page', "");

        $html_out = '<h3>Redirect login</h3>';
        $html_out .= '<p>Redirects to some other page than the admin page on login.</p>';
        $html_out .= '<label class="' . SNILLRIK_SETTINGS_SWITCHNAME . '">';
        $html_out .= '<input type="checkbox" ' . ($redirectlogin ? "checked" : "") . ' id="snillrik_settings_redirectlogin" name="snillrik_settings_redirectlogin">';
        $html_out .= '<div class="snillrik-settings-slider"></div>';
        $html_out .= '</label>';
        $html_out .= '<select name="snillrik_settings_redirectlogin_page">';
        $html_out .= '<option value="home" ' . selected('home', esc_attr($snillrik_settings_redirectlogin_page),false) . '>Home</option>';
        $html_out .= '<option value="admin" ' . selected('admin', esc_attr($snillrik_settings_redirectlogin_page),false) . '>Admin</option>';
        if ($pages = get_pages()) {
            foreach ($pages as $page) {
                $page_name = $page->post_title;
                if (strlen($page_name) > 23) {
                    $page_name = substr($page_name, 0, 23) . "...";
                }
                $html_out .= '<option value="' . intval($page->ID) . '" ' . selected(intval($page->ID), esc_attr($snillrik_settings_redirectlogin_page), false) . '>' . esc_attr($page_name) . '</option>';
            }
        }
        $html_out .= '</select>';
        return $html_out;
    }

    public static function logout_html()
    {
        $redirectlogout = get_option('snillrik_settings_redirectlogout', false);
        $snillrik_settings_redirectlogout_page = get_option('snillrik_settings_redirectlogout_page', "");

        $html_out = '<h3>Redirect logout</h3>';
        $html_out .= '<p>Redirects to some other page than the admin page on logout.</p>';
        $html_out .= '<label class="' . SNILLRIK_SETTINGS_SWITCHNAME . '">';
        $html_out .= '<input type="checkbox" ' . ($redirectlogout ? "checked" : "") . ' id="snillrik_settings_redirectlogout" name="snillrik_settings_redirectlogout">';
        $html_out .= '<div class="snillrik-settings-slider"></div>';
        $html_out .= '</label>';
        $html_out .= '<select name="snillrik_settings_redirectlogout_page">';
        $html_out .= '<option value="home" ' . selected('home', esc_attr($snillrik_settings_redirectlogout_page),false) . '>Home</option>';
        $html_out .= '<option value="admin" ' . selected('admin', esc_attr($snillrik_settings_redirectlogout_page),false) . '>Admin</option>';
        if ($pages = get_pages()) {
            foreach ($pages as $page) {
                $page_name = $page->post_title;
                if (strlen($page_name) > 23) {
                    $page_name = substr($page_name, 0, 23) . "...";
                }
                $html_out .= '<option value="' . intval($page->ID) . '" ' . selected(intval($page->ID), esc_attr($snillrik_settings_redirectlogout_page),false) . '>' . esc_attr($page_name) . '</option>';
            }
        }
        $html_out .= '</select>';
        return $html_out;
    }

    public static function profile_html()
    {
        $redirectprofile = get_option('snillrik_settings_redirectprofile', false);
        $snillrik_settings_redirectprofile_page = get_option('snillrik_settings_redirectprofile_page', "");

        $html_out = '<h3>Redirect profile</h3>';
        $html_out .= '<p>Redirects to some other page than the admin page on profile update.</p>';
        $html_out .= '<label class="' . SNILLRIK_SETTINGS_SWITCHNAME . '">';
        $html_out .= '<input type="checkbox" ' . ($redirectprofile ? "checked" : "") . ' id="snillrik_settings_redirectprofile" name="snillrik_settings_redirectprofile">';
        $html_out .= '<div class="snillrik-settings-slider"></div>';
        $html_out .= '</label>';
        $html_out .= '<select name="snillrik_settings_redirectprofile_page">';
        $html_out .= '<option value="home" ' . selected('home', esc_attr($snillrik_settings_redirectprofile_page),false) . '>Home</option>';
        $html_out .= '<option value="admin" ' . selected('admin', esc_attr($snillrik_settings_redirectprofile_page),false) . '>Admin</option>';
        if ($pages = get_pages()) {
            foreach ($pages as $page) {
                $page_name = $page->post_title;
                if (strlen($page_name) > 23) {
                    $page_name = substr($page_name, 0, 23) . "...";
                }
                $html_out .= '<option value="' . intval($page->ID) . '" ' . selected(intval($page->ID), esc_attr($snillrik_settings_redirectprofile_page),false) . '>' . esc_attr($page_name) . '</option>';
            }
        }
        $html_out .= '</select>';
        return $html_out;
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

    function redirect_logout()
    {
        $snillrik_settings_redirectlogout_page = get_option('snillrik_settings_redirectlogout_page', "");
        $url = get_page_link($snillrik_settings_redirectlogout_page);
        $url = $url == "" ? get_home_url() : $url;
        wp_safe_redirect($url);
        exit;
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
