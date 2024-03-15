<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * To not show the title if h1 is present in content.
 */

class SNSET_SettingItem
{

    //expected functions to be overriden
    public static function settings_html()
    {
        return "";
    }

    public function register()
    {
        return "";
    }

    public static function html_out($html_out)
    {
        return wp_kses($html_out, [
            'a' => array(
                'href' => array(),
                'title' => array()
            ),
            'h3' => array(),
            'h1' => array(),
            'br' => array(),
            'em' => array(),
            'strong' => array(),
            'p' => array(),
            'tr' => array(),
            'td' => array(),
            'th' => array(),
            'div' => array(
                'class' => array()
            ),
            'label' => array(
                'class' => array()
            ),
            'input' => array(
                'type' => array(),
                'class' => array(),
                'checked' => array(),
                'id' => array(),
                'name' => array(),
                'value' => array(),
                'tabindex' => array(),
                'autocomplete' => array(),
                'placeholder' => array(),
                'style' => array(),
            ),
            'button' => array(
                'type' => array(),
                'class' => array(),
                'id' => array(),
                'name' => array(),
                'value' => array(),
                'style' => array(),
            ),
            'select' => array(
                'id' => array(),
                'name' => array(),
                'multiple' => array(),
            ),
            'option' => array(
                'value' => array(),
                'selected' => array()
            ),
            'style' => array(
                'type' => array(),
                'media' => array(),
                'scoped' => array(),
                'title' => array(),
                'nonce' => array(),
                'position' => array(),
                'left' => array(),
            ),
        ]);
    }
}
