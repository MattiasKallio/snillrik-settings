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
}

/**
 * The settings page
 */
function snillrik_settings_page()
{
	$snillrik_logo = SNILLRIK_SETTINGS_PLUGIN_URL.'/images/snillrik_logo_modern.svg';
?>

	<div class="wrap snillrik-main-wrap">
		<div class="snillrik-main-left-side">
			<div class="snillrik-main-side-inner">
				<img src="<?php echo $snillrik_logo; ?>" alt="Snillrik logo" class="snillrik-logo" />
				<h1>Snillrik settings</h1>
				<h3>Some settings that often is some sort of hack that you put in the functions.php file.</h3>
				<form method="post" action="options.php" autocomplete="off">
					<?php
					settings_fields('snillrik-settings-group');
					do_settings_sections('snillrik-settings-group');
					?>

					<div class="snillrik-settings-main">
						<div class="snillrik-settings-row">
							<div class="snillrik-settings-item">
								<div class="snillrik-settings-item-inner">
									<?php echo SNSET_Blockeditor::settings_html(); ?>
								</div>
							</div>
							<div class="snillrik-settings-item">
								<div class="snillrik-settings-item-inner">
									<?php echo SNSET_Classicwidgets::settings_html(); ?>
								</div>
							</div>
							<div class="snillrik-settings-item">
								<div class="snillrik-settings-item-inner">
									<?php echo SNSET_Comments::settings_html(); ?>
								</div>
							</div>
							<div class="snillrik-settings-item">
								<div class="snillrik-settings-item-inner">
									<?php echo SNSET_Customizer::settings_html(); ?>
								</div>
							</div>
						</div>


						<div class="snillrik-settings-row">
							<div class="snillrik-settings-item">
								<div class="snillrik-settings-item-inner">
									<?php echo SNSET_Redirects::settings_html("login"); ?>
								</div>
							</div>
							<div class="snillrik-settings-item">
								<div class="snillrik-settings-item-inner">
									<?php echo SNSET_Redirects::settings_html("logout"); ?>
								</div>
							</div>
							<div class="snillrik-settings-item">
								<div class="snillrik-settings-item-inner">
									<?php echo SNSET_Redirects::settings_html("profile"); ?>
								</div>
							</div>
							<div class="snillrik-settings-item">
								<div class="snillrik-settings-item-inner">
									<?php echo SNSET_LoginPage::settings_html(); ?>
								</div>
							</div>
						</div>


						<div class="snillrik-settings-row">
							<div class="snillrik-settings-item">
								<div class="snillrik-settings-item-inner">
									<?php echo SNSET_AdminToolbar::settings_html(); ?>
								</div>
							</div>
							<div class="snillrik-settings-item">
								<div class="snillrik-settings-item-inner">
									<?php echo SNSET_BlockEmail::settings_html(); ?>
								</div>
							</div>
							<div class="snillrik-settings-item">
								<div class="snillrik-settings-item-inner">
									<?php echo SNSET_ChangeEmail::settings_html(); ?>
								</div>
							</div>
						</div>


						<div class="snillrik-settings-row">
							<div class="snillrik-settings-item">
								<div class="snillrik-settings-item-inner">
									<?php echo SNSET_TurnOffXMLRPC::settings_html(); ?>
								</div>
							</div>
							<div class="snillrik-settings-item">
								<div class="snillrik-settings-item-inner">
									<?php echo SNSET_TurnOffTitle::settings_html(); ?>
								</div>
							</div>
							<div class="snillrik-settings-item">
								<div class="snillrik-settings-item-inner">
									<?php echo SNSET_WooCommerce::settings_html(); ?>
								</div>
							</div>
						</div>
					</div>


					<?php submit_button(); ?>
				</form>

			</div>
		</div>
		<div class="snillrik-main-right-side">
			<div class="snillrik-main-side-inner">
				<div class="snillrik-main-side-block">
					<div>
						<h3>Snillrik Dudes</h3>
						<img src="<?php echo SNILLRIK_SETTINGS_PLUGIN_URL . '/images/dudes.png'; ?>" alt="Snillrik Dudes" class="snillrik-dudes" />
						<h4>Manage your co-workers with ease</h4>
						<p>Well, at least how they are presented on your site. Dudes is a plugin for managing people or companies on your site.</p>
						<p>Read more and buy it on <a href="https://codecanyon.net/item/dudes/35819561">CodeCanyon</a>.</p>
					</div>
					<div>
						<h3>Snillrik Settings</h3>
						<img src="<?php echo SNILLRIK_SETTINGS_PLUGIN_URL . '/images/snillrik_icon.svg'; ?>" alt="Snillrik icon" />
						<h4>Manage your settings with ease</h4>
						<p>Yes, everything is done with ease. :D But this plugin also free! I build a lot of websites, and I often do the same hacks, hooks, filters and things for common things. So I made a plugin for those settings. Maybe you want to use it too. :)</p>
						<p>Read more and download it (for free!) from <a href="https://wordpress.org/plugins/snillrik-settings/">WordPress.org</a>.</p>
					</div>
					<div>
						<h3>Snillrik Restaurant</h3>
						<img src="<?php echo SNILLRIK_SETTINGS_PLUGIN_URL . '/images/snillrik_icon.svg'; ?>" alt="Snillrik icon" />
						<h4>Manage your dishes and menus with ease</h4>
						<p>Yes, everything is done with ease. :D But this plugin also free! The idea is to add dishes with prices, etc. And then select them for menues. It can be used in many ways, but it's especially great for Today's special and menues that change from day to day.</p>
						<p>Read more and download it (for free!) from <a href="https://wordpress.org/plugins/snillrik-restaurant-menu/">WordPress.org</a>.</p>
					</div>
					<div>
						<h3>Skolmaten</h3>
						<img src="<?php echo SNILLRIK_SETTINGS_PLUGIN_URL . '/images/snillrik_icon.svg'; ?>" alt="Snillrik icon" />
						<h4>Mange your school's lunch menu with ease</h4>
						<p>If your school are using the service Skolmaten.se, then this plugin is for you. It will show the lunch menu for the week, and also the lunch menu for today. You can also choose to show the lunch menu for a specific week.</p>
						<p>Read more and download it, (for free!) from <a href="https://wordpress.org/plugins/skolmaten/">WordPress.org</a>.</p>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php } ?>