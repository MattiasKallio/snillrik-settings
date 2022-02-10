<?php
/**
 *
 * The settings page for the plugin.
 */
add_action('admin_menu', 'snillrik_settings_create_menu');
function snillrik_settings_create_menu()
{
    add_menu_page(
        'Snillrik settings',
        'Snillrik',
        'administrator',
        __FILE__,
        'snillrik_settings_page',
        plugins_url('/images/snillrik_icon.svg', __FILE__)
    );
    add_action('admin_init', 'register_snillrik_settings_settings');
}

/**
 * Register the settings
 */
function register_snillrik_settings_settings()
{
	$sanitize_args_str = array(
		'type' => 'string',
		'sanitize_callback' => 'sanitize_text_field',
	);
    register_setting('snillrik-settings-group', 'snillrik_settings_blockeditor', $sanitize_args_str);
	register_setting('snillrik-settings-group', 'snillrik_settings_classicwidgets', $sanitize_args_str);
    register_setting('snillrik-settings-group', 'snillrik_settings_turnoffcomments', $sanitize_args_str);
    register_setting('snillrik-settings-group', 'snillrik_settings_turnoffemail', $sanitize_args_str);
    register_setting('snillrik-settings-group', 'snillrik_settings_turnoffemail_email', $sanitize_args_str);
    register_setting('snillrik-settings-group', 'snillrik_settings_turnofftitle', $sanitize_args_str);
    register_setting('snillrik-settings-group', 'snillrik_settings_admintoolbar', $sanitize_args_str);
    register_setting('snillrik-settings-group', 'snillrik_settings_turnoffxmlrpc', $sanitize_args_str);
	register_setting('snillrik-settings-group', 'snillrik_settings_redirectlogin', $sanitize_args_str);
	register_setting('snillrik-settings-group', 'snillrik_settings_redirectlogin_page', $sanitize_args_str);
	register_setting('snillrik-settings-group', 'snillrik_settings_wootocheckout', $sanitize_args_str);
	register_setting('snillrik-settings-group', 'snillrik_settings_wootocheckout2', $sanitize_args_str);
}

/**
 * The settings page
 */
function snillrik_settings_page()
{
    ?>

<div class="wrap snillrik-settings">

	<h1>Snillrik settings</h1>
	<p>Some settings that often is some sort of hack that you put in the functions.php file.</p>
	<form method="post" action="options.php">
    <?php
	settings_fields('snillrik-settings-group');
    do_settings_sections('snillrik-settings-group');
    $turnoffblockeditor = get_option('snillrik_settings_blockeditor', array());
	$classicwidgets = get_option('snillrik_settings_classicwidgets', array());
    $turnoffcomments = get_option('snillrik_settings_turnoffcomments', array());
    $turnoffemail = get_option('snillrik_settings_turnoffemail', array());
    $snillrik_settings_turnoffemail_email = get_option('snillrik_settings_turnoffemail_email', "");

    $turnoffetitle = get_option('snillrik_settings_turnofftitle', array());
    $turnoffeadmintoolbar = get_option('snillrik_settings_admintoolbar', array());
    $turnoffxmlrpc = get_option('snillrik_settings_turnoffxmlrpc', array());
    $redirectlogin = get_option('snillrik_settings_redirectlogin', array());
    $snillrik_settings_redirectlogin_page = get_option('snillrik_settings_redirectlogin_page', "");
	$snillrik_settings_wootocheckout = get_option('snillrik_settings_wootocheckout', "");
	$snillrik_settings_wootocheckout2 = get_option('snillrik_settings_wootocheckout2', "");
	
    ?>

	<div class="snillrik-settings-main">
		<div class="snillrik-settings-row">
			<div class="snillrik-settings-item">
				<div class="snillrik-settings-item-inner">
				<h3>Gutenberg</h3>
				<p>To turn of Gutenberg block editor</p>
				<label class="switch">
  					<input type="checkbox" <?php echo $turnoffblockeditor ? "checked" : ""; ?> class="" id="snillrik_settings_blockeditor" name="snillrik_settings_blockeditor">
  					<div class="snillrik-settings-slider"></div>
				</label>
				</div>
			</div>
			<div class="snillrik-settings-item">
				<div class="snillrik-settings-item-inner">
				<h3>Widgets</h3>
				<p>To use classic widgets</p>
				<label class="switch">
  					<input type="checkbox" <?php echo $classicwidgets ? "checked" : ""; ?> class="" id="snillrik_settings_classicwidgets" name="snillrik_settings_classicwidgets">
  					<div class="snillrik-settings-slider"></div>
				</label>
				</div>
			</div>			
			
			<div class="snillrik-settings-item">
				<div class="snillrik-settings-item-inner">
				<h3>Comments</h3>
				<p>To turn off all the comments everywhere. (does not erase old comments)</p>
				<label class="switch">
  					<input type="checkbox" <?php echo $turnoffcomments ? "checked" : ""; ?> id="snillrik_settings_turnoffcomments" name="snillrik_settings_turnoffcomments">
  					<div class="snillrik-settings-slider"></div>
				</label>
				</div>
			</div>
		</div>


		<div class="snillrik-settings-row">
			<div class="snillrik-settings-item">
				<div class="snillrik-settings-item-inner">
				<h3>Redirect login</h3>
				<p>Redirects to some other page than the admin page on login.</p>
    			<label class="switch">
  					<input type="checkbox" <?php echo $redirectlogin ? "checked" : ""; ?> id="snillrik_settings_redirectlogin" name="snillrik_settings_redirectlogin">
  					<div class="snillrik-settings-slider"></div>
				</label>
				
				<select name="snillrik_settings_redirectlogin_page">
					<?php
					echo '<option value="home" ' . selected( 'home', esc_attr($snillrik_settings_redirectlogin_page )) . '>Home</option>';
					echo '<option value="admin" ' . selected( 'admin', esc_attr($snillrik_settings_redirectlogin_page )) . '>Admin</option>';
                    if( $pages = get_pages() ){
						foreach( $pages as $page ){
                    		echo '<option value="' . intval($page->ID) . '" ' . selected( intval($page->ID), esc_attr($snillrik_settings_redirectlogin_page) ) . '>' . esc_attr($page->post_title) . '</option>';
                    	}
                    }
                	?>
                </select>
				</div>
			</div>
			<div class="snillrik-settings-item">
				<div class="snillrik-settings-item-inner">
				<h3>Title on pages</h3>
				<p>Filter the_title -function to not show a title if there is a H1 in content. The Idea is that if you have a large image or other stuff that you want above the title, you just add a H1 where you want it and the automatic one will not be shown.</p>
    			<label class="switch">
  					<input type="checkbox" <?php echo $turnoffetitle ? "checked" : ""; ?> id="snillrik_settings_turnofftitle" name="snillrik_settings_turnofftitle">
  					<div class="snillrik-settings-slider"></div>
				</label>
				</div>
			</div>
			<div class="snillrik-settings-item">
				<div class="snillrik-settings-item-inner">
				<h3>Admin toolbar frontend</h3>
				<p>Turn off the frontend admin toolbar.</p>
    			<label class="switch">
  					<input type="checkbox" <?php echo $turnoffeadmintoolbar ? "checked" : ""; ?> id="snillrik_settings_admintoolbar" name="snillrik_settings_admintoolbar">
  					<div class="snillrik-settings-slider"></div>
				</label>
				</div>
			</div>
		</div>
		<div class="snillrik-settings-row">
		<div class="snillrik-settings-item">
				<div class="snillrik-settings-item-inner">
				<h3>E-mails</h3>
				<p>Redirect all emails to admin to ensure that customers or users get no emails.<br />Probably mostly used for development and testing.</p>
    			<label class="switch">
  					<input type="checkbox" <?php echo $turnoffemail ? "checked" : ""; ?> id="snillrik_settings_turnoffemail" name="snillrik_settings_turnoffemail">
  					<div class="snillrik-settings-slider"></div>
				</label>
				<input type="text" value="<?php echo esc_attr($snillrik_settings_turnoffemail_email); ?>" id="snillrik_settings_turnoffemail_email" name="snillrik_settings_turnoffemail_email">
				</div>
			</div>
			<div class="snillrik-settings-item">
				<div class="snillrik-settings-item-inner">
				<h3>XMLRPC</h3>
				<p>Turn off xmlrpc.php xmlrpc is used to communicate with WP and is mostly not used, but it is a way for haxxor type people to attack your site.</p>
    			<label class="switch">
  					<input type="checkbox" <?php echo $turnoffxmlrpc ? "checked" : ""; ?> id="snillrik_settings_turnoffxmlrpc" name="snillrik_settings_turnoffxmlrpc">
  					<div class="snillrik-settings-slider"></div>
				</label>
				</div>
			</div>
			
			<div class="snillrik-settings-item">
				<div class="snillrik-settings-item-inner">
				<h3>WooCommerce</h3>
				<p>Redirect to Checkout after "add to cart"</p>
				<?php if(class_exists( 'woocommerce' )): ?>
    			<label class="switch">
  					<input type="checkbox" <?php echo $snillrik_settings_wootocheckout ? "checked" : ""; ?> id="snillrik_settings_wootocheckout" name="snillrik_settings_wootocheckout">
  					<div class="snillrik-settings-slider"></div>
				</label>
    			<!--label class="switch">
  					<input type="checkbox" <?php echo $snillrik_settings_wootocheckout2 ? "checked" : ""; ?> id="snillrik_settings_wootocheckout2" name="snillrik_settings_wootocheckout2">
  					<div class="snillrik-settings-slider"></div>
				</label-->
				<?php else: ?>
					(WooCommerce is not activated so this is not in use)
				<?php endif; ?>				
				</div>
			</div>
					
		</div>			
	</div>


    <?php submit_button();?>
	</form>

</div>
<?php }?>
