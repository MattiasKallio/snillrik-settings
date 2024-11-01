<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * Turn of admin toolbar.
 */
new SNSET_AjaxTransients();

class SNSET_AjaxTransients extends SNSET_SettingItem
{
    public function __construct()
    {
        add_action('wp_ajax_snillrik_delete_transients', [$this, 'delete_transients']);
    }

    public function delete_transients()
    {
        global $wpdb;

        // delete all "namespace" transients
        $sql = "
            DELETE 
            FROM {$wpdb->options}
            WHERE option_name like '\_transient\_namespace\_%'
            OR option_name like '\_transient\_timeout\_namespace\_%'
        ";

        $wpdb->query($sql);

        wp_send_json_success("Transients removed");
    }
}

