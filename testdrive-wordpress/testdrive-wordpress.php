<?php
/**
 * Plugin Name: Testdrive WordPress
 * Plugin URI: https://github.com/jessengatai/testdrive-wordpress
 * Description: A plugin that disables access to certain admin pages. Good for poopy.life, horrible for everything else
 * Version: 1.0
 * Author: Jesse Ngatai
 * Author URI: https://www.jessengatai.com
 */

/**
 * CHANGELOG
 * 22/05/2017 - Version 1.0
 * - initial release
 */

if ( ! class_exists( 'Testdrive_WordPress' ) ) {
	class Testdrive_WordPress {


		/**
		 * Construct the plugin
		 *
		 * @since 1.0
		 * @return void
		 */
		function __construct() {

			register_activation_hook( __FILE__, array( &$this, 'plugin_activation' ) );
			add_action( 'init', array( &$this, 'disable_access' ) );
			add_action( 'admin_menu', array( &$this, 'disable_pages' ), 9999 );
			add_action( 'init', array( &$this, 'welcome' ) );
			add_action( 'wp_before_admin_bar_render', array( &$this, 'links' ) );

		}


		/**
		 * Fire the init on activation
		 *
		 * @since 1.0
		 * @return void
		 */
		function plugin_activation() {
			$this->disable(); // tun up the heat!
			$this->welcome(); // drinks on the house!
			$this->links(); // if you need anything, anything at all...
			flush_rewrite_rules();
		}


		/**
		 * Redirect users who attempted to access restricted pages
		 *
		 * @since 1.0
		 * @return void
		 */
		function disable_access() {

			// control plugin access
			$role = get_role( 'administrator' );
			$role->remove_cap('activate_plugins');
			$role->remove_cap('update_plugins');
			$role->remove_cap('install_plugins');
			$role->remove_cap('upload_plugins');
			$role->remove_cap('delete_plugins');
			$role->remove_cap('edit_plugins');

			// control theme access
			$role->remove_cap('switch_themes');
			$role->remove_cap('update_themes');
			$role->remove_cap('install_themes');
			$role->remove_cap('upload_themes');
			$role->remove_cap('delete_themes');
			$role->remove_cap('edit_themes');

		}


		/**
		 * Remove menu items from the admin area
		 *
		 * @since 1.0
		 * @return void
		 */
		function disable_pages() {
			// hide the envato market plugin page (it's annoying)
			remove_menu_page( 'envato-market' );
		}


		/**
		 * Register
		 *
		 * @since 1.0
		 * @return void
		 */
		function welcome() {

			// TO DO: put it a welcome matt

		}


		/**
		 * Register
		 *
		 * @since 1.0
		 * @return void
		 */
		function links() {

			global $wp_admin_bar;
			$theme = wp_get_theme();
			$theme = $theme->get( 'Name' );

			// setup top bar links
			if( $theme=='Crush' ) {
				$buy 			= 'https://themeforest.net/item/crush-the-portfolio-theme/6613145?ref=jessengatai';
				$support 	= 'https://themeforest.net/item/crush-the-portfolio-theme/6613145/comments?ref=jessengatai';
				$docs 		= 'https://themes.jessengatai.com/crush/docs/';
				$log			= 'https://themes.jessengatai.com/crush/changelog/';
			}


			if( isset($buy) ) {
				// output links in the topbar
				$wp_admin_bar->add_node( array(
					'id'    => 'theme-buy',
					'title' => '<span class="ab-icon"></span> Purchase '.$theme,
					'href'  => $buy,
					'group' => false,
					'meta'	=> array(
						'target' => '_blank',
					),
				));
				$wp_admin_bar->add_node( array(
					'parent'    => 'theme-buy',
					'id'    => 'theme-support',
					'title' => 'Support',
					'href'  => $support,
					'group' => false,
					'meta'	=> array(
						'target' => '_blank',
					),
				));
				$wp_admin_bar->add_node( array(
					'parent'    => 'theme-buy',
					'id'    => 'theme-docs',
					'title' => 'Documentation',
					'href'  => $docs,
					'group' => false,
					'meta'	=> array(
						'target' => '_blank',
					),
				));
				$wp_admin_bar->add_node( array(
					'parent'    => 'theme-buy',
					'id'    => 'theme-changelog',
					'title' => 'Changelog',
					'href'  => $log,
					'group' => false,
					'meta'	=> array(
						'target' => '_blank',
					),
				));

				// add styles for buttons (very hacky! sorry fam)
				?>
				<style media="screen">
				li#wp-admin-bar-theme-buy {
					background: #7127f5 !important;
				}
				</style>
				<?php
			}

		}

	}

	// create a new instance of the above class
	new Testdrive_WordPress;

}

?>
