<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * To turn of the block editor.
 */

new SNSET_Blockeditor();

class SNSET_Blockeditor
{
    public function __construct()
    {
        $turnoffblockeditor = get_option('snillrik_settings_blockeditor', array());
        if ($turnoffblockeditor == "on") {
            add_filter('use_block_editor_for_post', '__return_false', 10);
            add_filter('use_block_editor_for_post_type', '__return_false', 10);
        }
    }
}
