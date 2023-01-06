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
?>

	<div class="wrap snillrik-settings">

		<h1>Snillrik settings</h1>
		<p>Some settings that often is some sort of hack that you put in the functions.php file.</p>
		<form method="post" action="options.php" autocomplete="off">
			<?php
			settings_fields('snillrik-settings-group');
			do_settings_sections('snillrik-settings-group');
			?>

			<div class="snillrik-settings-main">
				<div class="snillrik-settings-row">
					<div class="snillrik-settings-item">
						<div class="snillrik-settings-item-inner">
							<?php SNSET_Blockeditor::settings_html(); ?>
						</div>
					</div>
					<div class="snillrik-settings-item">
						<div class="snillrik-settings-item-inner">
							<?php SNSET_Classicwidgets::settings_html(); ?>
						</div>
					</div>
					<div class="snillrik-settings-item">
						<div class="snillrik-settings-item-inner">
							<?php SNSET_Comments::settings_html(); ?>
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
<?php } ?>