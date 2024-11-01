<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * Turn of admin toolbar.
 */
new SNSET_AjaxPlugs();

class SNSET_AjaxPlugs extends SNSET_SettingItem
{
    public function __construct()
    {
        add_action('wp_ajax_snillrik_force_plugins', [$this, 'force_plugins']);
    }

    public function force_plugins()
    {
        wp_clean_update_cache();
        wp_update_themes();
        wp_update_plugins();

        wp_send_json_success("Plugins resetted and checked for update");
    }
}
