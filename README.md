# snillrik-settings
 To easily turn on and off some settings that often is done with hacks and filters in WordPress.

## Turn off Gutenberg
To turn off the default editor and use classic instead.

## Turn off new Widgets
To use classic widgets instead of the new.

## Turn off comments
For turning off the comments, both the fronten and in admin. Does not delete old comments.

## Redirect login
Select a page to redirect to after logging in. Admins will still redirect to wp-admin.

## Redirect logout
Select a page to redirect to after logging out.

## Redirect profile
Select a page to redirect the profile link to, (the one in the admin bar etc.)

## Login logo
Use the custom logo as login logo. If you have a logo in the customizer, it will be used. If not, the default logo will be used.

## Titles on pages
Filter the_title -function to not show a title if there is a H1 in content. The Idea is that if you have a large image or other stuff that you want above the title, you just add a H1 where you want it and the automatic one will not be shown.

## Admin toolbar in frontend
Does not show the toolbar in fronted. You can select witch roles that should still see it.

## E-mails
Redirect all emails to admin to ensure that customers or users get no emails.
Probably mostly used for development and testing.

## Default wordpress email 
Set the default name and email address for all emails sent from the site. ie the wordpress@mydomain.org mail.

## XMLRPC
Turn off xmlrpc.php xmlrpc is used to communicate with WP and is mostly not used, but it is a way for haxxor type people to attack your site.

## WooCommerce
If WooCommerce is active on the site, you can choose to redirect to Checkout after "add to cart", so skipping the cart-part.
A very simple honeypot-function for the register form.

## Get the WordPress customizer back
In themes like the Twentytwentytwo it's really hard to find the link to the customizer. This adds it under Appearance, ...where he belongs!

## Colors for Categories.
Add a color field to the category to be able to add a background color to the category. you get it by using something like this:
```php
get_term_meta( $post_term_id, 'category_color', true )
```
It has a filter for what taxonomies to use, so it can be used for other taxonomies than categories.

```php
add_filter("snset_categories_for_categorycolor", function ($taxonomies) {
    $taxonomies[] = "dude-type";
    return $taxonomies;
}, 10, 1);
```

== Changelog ==
1.3.0.1 - 2025-01-17
Fixed login logo that did not work on multisites.

1.3.0 - 2024-10-30
Test compability with WP 6.7

1.2.6.1 - 2024-08-18
Minor buggfix login logo if no logo is set.

1.2.5 - 2024-08-15
Minor buggfix and check with 6.6.1

1.2.4 - 2024-03-12
Added a color field to the category.

1.2.3 - 2023-12-19
Code prettyfying and more clever honeypot. Still very simple.

1.2.2 - 2023-12-13
Bugfix space before start of file sometimes caused error message..

1.2.1 - 2023-12-13
Bugfix missing file.

1.2.0 - 2023-12-13
Some code prettyfying and minor security fixes.

1.1.7 - 2023-12-13
Added a very simple honeypot function to the register form.

1.1.5 - 2023-05-08
CSS fix for the settings page -fix. 
Changed the top image for the plugin page.

1.1.4 -2023-03-29
Had to be able to turn off the admin toolbar in frontend, but show it for a couple of roles. So added a setting for that.
Prettyfying UI
Test compability with WP 6.2

1.1.3 -2023-03-27
Added a link to the settings page in the plugins page.

1.1.2 -2023-03-27
Added a setting for using the logo set in the customizer as login logo.

1.1.1
Fixed som bugs settings did not save properly.

1.1.0 - 2023-01-06
Moved all settings html for each setting to its class.
Addes a new setting for default email and email name (ie the wordpress@mydomain.org)

1.0.4 - 2022-12-28
Added a redirect option for logout.

1.0.3 - 22-12-05
Fixed minor bug in woo redirect to cart (sometimes it did not work)
Added a redirect for the profile page.
Also changed wrong date in changelog. :)

1.0.2 - 2022-11-25
Checking 6.1.1 and php 8.1.x

1.0.1 adding esc where needed and removed some unused code. Corrected missmatching versions

1.0.0 first version, still with hope of a bright future.