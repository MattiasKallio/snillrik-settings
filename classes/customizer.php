<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * Just to add a link to the customizer.
 */
new SNSET_Customizer();

class SNSET_Customizer
{
    public function __construct()
    {
        $showcustomizerlinke = get_option('snillrik_settings_customizerlink', array());
        if($showcustomizerlinke == 'on'){
            add_action('admin_init', [$this, 'snillrik_customizer_link']);
        }
    }

    public function snillrik_customizer_link()
    {
        global $submenu;
        $submenu['themes.php'][] = [esc_attr__('Customize'), 'edit_theme_options', 'customize.php'];
    }
}