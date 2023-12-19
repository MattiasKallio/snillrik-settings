<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * To not show the title if h1 is present in content.
 */
new SNSET_TurnOffTitle();

class SNSET_TurnOffTitle extends SNSET_SettingItem
{
    public function __construct()
    {
        add_action('admin_init', [$this, 'register']);
        $turnofftitle = get_option('snillrik_settings_turnofftitle', array());

        if ($turnofftitle == "on") {
            add_filter('the_title', array($this, 'title_update'), 10, 2);
            add_filter('pre_wp_nav_menu', array($this, 'remove_title_filter_nav_menu'), 10, 2);
            add_filter('wp_nav_menu_items', array($this, 'add_title_filter_non_menu'), 10, 2);
        }
    }

    //register the settings
    function register()
    {
        $sanitize_args_str = array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        );
        register_setting('snillrik-settings-group', 'snillrik_settings_turnofftitle', $sanitize_args_str);
    }

    //html for the settings page
    public static function settings_html()
    {
        $turnoffetitle = get_option('snillrik_settings_turnofftitle', array());
        $html_out = "<h3>Title on pages</h3>";
        $html_out .= "<p>Filter the_title -function to not show a title if there is a H1 in content. The Idea is that if you have a large image or other stuff that you want above the title, you just add a H1 where you want it and the automatic one will not be shown.</p>";
        $html_out .= '<label class="' . SNILLRIK_SETTINGS_SWITCHNAME . '">
            <input type="checkbox" ' . ($turnoffetitle ? "checked" : "") . ' id="snillrik_settings_turnofftitle" name="snillrik_settings_turnofftitle" />
            <div class="snillrik-settings-slider"></div>
        </label>';
        return self::html_out($html_out);
    }

    public function title_update($title, $id = null)
    {
        if (!is_admin() && !is_null($id)) {
            $post = get_post($id);
            if ($post instanceof WP_Post && ($post->post_type == 'post' || $post->post_type == 'page')) {
                if (strpos($post->post_content, "h1>") == false) {
                    return esc_attr($title);
                } else {
                    return "";
                }

            }
        }
        return $title;
    }

    public function remove_title_filter_nav_menu($nav_menu, $args)
    {
        // we are working with menu, so remove the title filter
        remove_filter('the_title', array($this, 'title_update'), 10, 2);
        return $nav_menu;
    }

    public function add_title_filter_non_menu($items, $args)
    {
        // we are done working with menu, so add the title filter back
        add_filter('the_title', array($this, 'title_update'), 10, 2);
        return $items;
    }

}
