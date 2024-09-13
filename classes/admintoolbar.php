<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * Turn of admin toolbar.
 */
new SNSET_AdminToolbar();

class SNSET_AdminToolbar extends SNSET_SettingItem
{
    public function __construct()
    {
        add_action('admin_init', [$this, 'register']);
        $turnoffadmintoolbar = get_option('snillrik_settings_admintoolbar', array());
        if ($turnoffadmintoolbar == "on") {
            add_action('init', [$this, 'after_init']);
        }
    }

    //to be ables to use current user.
    public static function after_init()
    {
        $current_user = wp_get_current_user();
        $admintoolbarroles = get_option('snillrik_settings_admintoolbar_role', array());
        $is_admin = false;

        foreach ($admintoolbarroles as $role) {
            if (in_array($role, $current_user->roles)) {
                $is_admin = true;
            }
        }
        if (!$is_admin) {
            add_filter('show_admin_bar', '__return_false');
        }
    }

    //register the settings
    function register()
    {
        $sanitize_args_str = array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        );
        //sanitize_array
        $sanitize_args_arr = array(
            'type' => 'array',
            'sanitize_callback' => function ($arr) {
                $new_arr = array();
                
                if(!is_array($arr))
                    return false;

                foreach ($arr as $key => $value) {
                    if(is_string($value) && $value!="")
                        $new_arr[$key] = sanitize_text_field($value);
                }
                
                return count($new_arr) > 0 ? $new_arr : false;
            },
        );
        register_setting('snillrik-settings-group', 'snillrik_settings_admintoolbar', $sanitize_args_str);
        register_setting('snillrik-settings-group', 'snillrik_settings_admintoolbar_role', $sanitize_args_arr);
    }

    //html for the settings page
    public static function settings_html()
    {
        $turnoffadmintoolbar = get_option('snillrik_settings_admintoolbar', array());
        $admintoolbarroles = get_option('snillrik_settings_admintoolbar_role', array());
        $all_roles = get_editable_roles();
        $select_str = "<option value=''>" . esc_attr__("No one", SNILLRIK_SETTINGS_NAME) . "</option>";
        foreach ($all_roles as $role => $role_data) {
            $role_name = $role_data['name'];
            $selected = "";
            if (is_array($admintoolbarroles) && in_array($role, $admintoolbarroles)) {
                $selected = "selected";
            }
            $select_str .= '<option value="' . $role . '" ' . $selected . '>' . $role_name . '</option>';
        }

        $html_out = '<h3>Admin toolbar frontend</h3>
        <p>Turn off the frontend admin toolbar, select the roles you want to see the toolbar anyway.</p>
        <label class="' . SNILLRIK_SETTINGS_SWITCHNAME . '">
            <input type="checkbox" ' . ($turnoffadmintoolbar ? "checked" : "") . ' id="snillrik_settings_admintoolbar" name="snillrik_settings_admintoolbar" />
            <div class="snillrik-settings-slider"></div>
        </label>
        <select name="snillrik_settings_admintoolbar_role[]" id="snillrik_settings_admintoolbar_role" multiple="multiple">
            ' . $select_str . '
        </select>';
        
        return self::html_out($html_out);
    }
}
