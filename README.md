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

## Redirect profile
Select a page to redirect the profile link to, (the one in the admin bar etc.)

## Titles on pages
Filter the_title -function to not show a title if there is a H1 in content. The Idea is that if you have a large image or other stuff that you want above the title, you just add a H1 where you want it and the automatic one will not be shown.

## Admin toolbar in frontend
Does not show the toolbar in fronted.

## E-mails
Redirect all emails to admin to ensure that customers or users get no emails.
Probably mostly used for development and testing.

## XMLRPC
Turn off xmlrpc.php xmlrpc is used to communicate with WP and is mostly not used, but it is a way for haxxor type people to attack your site.

## WooCommerce
If WooCommerce is active on the site, you can choose to redirect to Checkout after "add to cart", so skipping the cart-part.

## Get the WordPress customizer back
In themes like the Twentytwentytwo it's really hard to find the link to the customizer. This adds it under Appearance, ...where he belongs!

== Changelog ==

1.0.3 - 22-12-05
Fixed minor bug in woo redirect to cart (sometimes it did not work)
Added a redirect for the profile page.
Also changed wrong date in changelog. :)

1.0.2 - 2022-11-25
Checking 6.1.1 and php 8.1.x

1.0.1 adding esc where needed and removed some unused code. Corrected missmatching versions

1.0.0 first version, still with hope of a bright future.