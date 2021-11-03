<?php

/**
 * To not show the title if h1 is present in content.
 */
class SNSET_ClassicWidgets
{
    public function __construct()
    {
        //probably using soon.
        $classicwidgets = get_option('snillrik_settings_classicwidgets', array());

        if ($classicwidgets == "on") {
            // Disables the block editor from managing widgets in the Gutenberg plugin.
            add_filter('gutenberg_use_widgets_block_editor', '__return_false');
            // Disables the block editor from managing widgets.
            add_filter('use_widgets_block_editor', '__return_false');
        }
    }
}
