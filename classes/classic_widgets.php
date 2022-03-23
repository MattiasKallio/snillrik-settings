<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * Use classic widgets.
 */
new SNSET_ClassicWidgets();

class SNSET_ClassicWidgets
{
    public function __construct()
    {
        $classicwidgets = get_option('snillrik_settings_classicwidgets', array());

        if ($classicwidgets == "on") {
            // Disables the block editor from managing widgets in the Gutenberg plugin.
            add_filter('gutenberg_use_widgets_block_editor', '__return_false');
            // Disables the block editor from managing widgets.
            add_filter('use_widgets_block_editor', '__return_false');
        }
    }
}
