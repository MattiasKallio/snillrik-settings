<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * To turn of the block editor.
 */

new SNSET_Emojis();

class SNSET_Emojis extends SNSET_SettingItem
{
    //setting name
    const SETTING_NAME = 'snillrik_settings_turnoffemoji';
    public function __construct()
    {
        add_action('admin_init', [$this, 'register']);
        $no_emoji = get_option(self::SETTING_NAME, array());
        if ($no_emoji == "on") {
            add_action('init', array($this, 'disable_emojis'));
        }
    }

    //register the settings
    function register()
    {
        $sanitize_args_str = array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        );
        register_setting('snillrik-settings-group', self::SETTING_NAME, $sanitize_args_str);
    }

    //html for the settings page
    public static function settings_html()
    {
        $allow_svg = get_option(self::SETTING_NAME, array());
        $html_out = '<h3>Turn off WP Emojis</h3>
        <p>Turn off WP Emojis. :)</p>
        <label class="' . SNILLRIK_SETTINGS_SWITCHNAME . '">
            <input type="checkbox" ' . ($allow_svg ? "checked" : "") . ' id="' . self::SETTING_NAME . '" name="' . self::SETTING_NAME . '" />
            <div class="snillrik-settings-slider"></div>
        </label>';

        return self::html_out($html_out);
    }

    public function disable_emojis()
    {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
        add_filter('tiny_mce_plugins', array($this, 'disable_emojis_tinymce'));
        add_filter('wp_resource_hints', array($this, 'disable_emojis_remove_dns_prefetch'), 10, 2);
    }
    public function disable_emojis_tinymce($plugins)
    {
        if (is_array($plugins)) {
            return array_diff($plugins, array('wpemoji'));
        }
        return array();
    }

    public function disable_emojis_remove_dns_prefetch($urls, $relation_type)
    {
        if ('dns-prefetch' == $relation_type) {
            $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');
            $urls = array_diff($urls, array($emoji_svg_url));
        }
        return $urls;
    }
}
