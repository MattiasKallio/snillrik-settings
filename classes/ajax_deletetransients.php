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
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Direct DELETE query needed to remove transients by pattern, no WP API available, caching not applicable for DELETE operations
        $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM {$wpdb->options}
                WHERE option_name LIKE %s
                OR option_name LIKE %s",
                $wpdb->esc_like('_transient_namespace_') . '%',
                $wpdb->esc_like('_transient_timeout_namespace_') . '%'
            )
        );

        wp_send_json_success("Transients removed");
    }
}

