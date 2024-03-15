<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * Add a field for color to the category
 */
new SNSET_CategoryColor();

class SNSET_CategoryColor extends SNSET_SettingItem
{
    public function __construct()
    {
        add_action('admin_init', [$this, 'register']);

        $turnoncatcolor = get_option('snillrik_settings_categorycolor', false);
        if ($turnoncatcolor == "on") {
            add_action('edit_term', [$this, 'save_color_field']);
            add_action('create_term', [$this, 'save_color_field']);
        }
    }

    /**
     * Register the settings
     */
    function register()
    {
        $turnoncatcolor = get_option('snillrik_settings_categorycolor', false);
        if ($turnoncatcolor == "on") {
            $taxonomies = apply_filters("snset_categories_for_categorycolor", ['category', 'post_tag']);
            foreach ($taxonomies as $taxonomy) {
                add_action($taxonomy . '_add_form_fields', [$this, 'color_field']);
                add_action($taxonomy . '_edit_form_fields', [$this, 'edit_color_field']);
            }
        }
        $sanitize_args_str = array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        );
        register_setting('snillrik-settings-group', 'snillrik_settings_categorycolor', $sanitize_args_str);
    }
    // Add settings to the settings page
    public static function settings_html()
    {
        $turnoncatcolor = get_option('snillrik_settings_categorycolor', false);
        $html_out = '<h3>Category Color</h3>
        <p>Add a color field to the category to be able to add a background color to the category. you get it by using something like this:<br><strong>get_term_meta( $post_term_id, \'category_color\', true )</strong></p>
        <label class="' . SNILLRIK_SETTINGS_SWITCHNAME . '">
            <input type="checkbox" ' . ($turnoncatcolor ? "checked" : "") . ' id="snillrik_settings_categorycolor" name="snillrik_settings_categorycolor">
            <div class="snillrik-settings-slider"></div>
        </label>';
        echo self::html_out($html_out);
    }

    function color_field()
    {
        //form field for color with color picker
        $html_out = '<div class="form-field">
        <label for="category_color">Color</label>
        <input type="text" name="category_color" id="category_color" class="snset-color-field" value="" />
        </div>';

        echo self::html_out($html_out);
    }

    function save_color_field($term_id)
    {
        if (isset($_POST['category_color'])) {
            //set term meta color
            update_term_meta($term_id, 'category_color', $_POST['category_color']);
        }
    }

    function edit_color_field($category)
    {
        $color = get_term_meta($category->term_id, 'category_color', true);
        $html_out = '<tr class="form-field">
        <th scope="row" valign="top"><label for="category_color">Color</label></th>
        <td>
            <input type="text" class="snset-color-field" name="category_color" id="category_color" value="' . $color . '" />
        </td>
        </tr>';

        echo self::html_out($html_out);
    }
}
