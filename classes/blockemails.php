<?php
defined('ABSPATH') or die('This script cannot be accessed directly.');
/**
 * To block all outgoing emails, to ensure that no mails are sent to customers while testing stuff.
 */
new SNSET_BlockEmail();

class SNSET_BlockEmail
{
    public function __construct()
    {
        $turnoffemails = get_option('snillrik_settings_turnoffemail', false);

        if ($turnoffemails == "on") {
			add_filter( 'wp_mail', array( $this, 'redirect_mail' ), 9999, 1 );

        }
    }
// Disable support for comments and trackbacks in post types
    public function redirect_mail()
    {
        $site_admin = get_site_option( 'admin_email' );
        $blockemailemail = get_option('snillrik_settings_turnoffemail_email', false);
        $admin_email = $blockemailemail ? $blockemailemail :  $site_admin;
        // Only redirect email that is NOT going to the current site admin
        // Note: this isn't comparing with the value passed into the rea_admin_email filter
        if ( $$site_admin !== $mail_args['to'] ) {
            $mail_args['message'] = 'Was intended for: ' . $mail_args['to'] . "\n\n" . $mail_args['message'];
            $mail_args['subject'] = 'Redirected by Snillrik-plugin | ' . $mail_args['subject'];
            $mail_args['to'] = $admin_email;
        }
        return $mail_args;
    }

}
