<?php

class SNSET_Blockeditor
{
    public function __construct()
    {
        //probably using soon.
        $turnoffblockeditor = get_option('snillrik_settings_blockeditor', array());
        if ($turnoffblockeditor == "on") {
			add_filter('use_block_editor_for_post', '__return_false', 10);
			add_filter('use_block_editor_for_post_type', '__return_false', 10);
        }
    }
}
