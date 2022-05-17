<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * To not show the title if h1 is present in content.
 */
new SNSET_TurnOffTitle();

class SNSET_TurnOffTitle
{
    public function __construct()
    {
        $turnofftitle = get_option('snillrik_settings_turnofftitle', array());

        if ($turnofftitle == "on") {
            add_filter('the_title', array($this, 'title_update'), 10, 2);
            add_filter('pre_wp_nav_menu', array($this, 'remove_title_filter_nav_menu'), 10, 2);
            add_filter('wp_nav_menu_items', array($this, 'add_title_filter_non_menu'), 10, 2);
        }
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
