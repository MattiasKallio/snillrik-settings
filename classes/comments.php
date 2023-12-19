<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * Turn off comments, everywhere.
 */
new SNSET_Comments();

class SNSET_Comments extends SNSET_SettingItem
{
    public function __construct()
    {
        add_action('admin_init', [$this, 'register']);
        $turnoffcomments = get_option('snillrik_settings_turnoffcomments', array());

        if ($turnoffcomments == "on") {
            add_action('admin_init', array($this, 'disable_comments_post_types_support'));
            add_filter('comments_open', array($this, 'disable_comments_status'), 20, 2);
            add_filter('pings_open', array($this, 'disable_comments_status'), 20, 2);
            add_filter('comments_array', array($this, 'disable_comments_hide_existing_comments'), 10, 2);
            add_filter('comments_array', array($this, 'disable_comments_hide_existing_comments'), 10, 2);
            add_action('admin_menu', array($this, 'disable_comments_admin_menu'));
            add_action('admin_init', array($this, 'disable_comments_admin_menu_redirect'));
            add_action('admin_init', array($this, 'disable_comments_dashboard'));
            add_action('init', array($this, 'disable_comments_admin_bar'));
            add_filter('comments_template', array($this, 'filter_comments_template'), 10, 1);
        }
    }

    //register the settings
    function register()
    {
        $sanitize_args_str = array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        );
        register_setting('snillrik-settings-group', 'snillrik_settings_turnoffcomments', $sanitize_args_str);
    }

    //html for the settings page
    public static function settings_html()
    {
        $turnoffcomments = get_option('snillrik_settings_turnoffcomments', array());
        $html_out = '<h3>Turn off comments</h3>
        <p>To turn off all the comments everywhere. (does not erase old comments)</p>
        <label class="' . SNILLRIK_SETTINGS_SWITCHNAME . '">
            <input type="checkbox" ' . ($turnoffcomments ? "checked" : "") . ' id="snillrik_settings_turnoffcomments" name="snillrik_settings_turnoffcomments" />
            <div class="snillrik-settings-slider"></div>
        </label>';
        
        return self::html_out($html_out);
    }

    // add the filter 
    public function filter_comments_template($theme_template)
    {
        // make filter magic happen here... 
        return $theme_template;
    }
    // Disable support for comments and trackbacks in post types
    public function disable_comments_post_types_support()
    {
        $post_types = get_post_types();
        foreach ($post_types as $post_type) {
            if (post_type_supports($post_type, 'comments')) {
                remove_post_type_support($post_type, 'comments');
                remove_post_type_support($post_type, 'trackbacks');
            }
        }
    }

    // Close comments on the front-end
    public function disable_comments_status()
    {
        return false;
    }

    // Hide existing comments
    public function disable_comments_hide_existing_comments($comments)
    {
        $comments = array();
        return $comments;
    }

    // Remove comments page in menu
    public function disable_comments_admin_menu()
    {
        remove_menu_page('edit-comments.php');
    }

    // Redirect any user trying to access comments page
    public function disable_comments_admin_menu_redirect()
    {
        global $pagenow;
        if ($pagenow === 'edit-comments.php') {
            wp_redirect(admin_url());
            exit();
        }
    }

    // Remove comments metabox from dashboard
    public function disable_comments_dashboard()
    {
        remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
    }

    // Remove comments links from admin bar
    public function disable_comments_admin_bar()
    {
        if (is_admin_bar_showing()) {
            remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
        }
    }
}
