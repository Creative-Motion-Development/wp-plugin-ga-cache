<?php
	/**
	 * Plugin Name: Webcraftic Google Analytics Cache
	 * Plugin URI:
	 * Description:
	 * Author: Webcraftic <wordpress.webraftic@gmail.com>
	 * Version: 1.0.0
	 * Text Domain: google-analytics-cache
	 * Domain Path: /languages/
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	if( defined('WGA_PLUGIN_ACTIVE') || (defined('WCL_PLUGIN_ACTIVE') && !defined('LOADING_GA_CACHE_AS_ADDON')) ) {
		function wbcr_ga_admin_notice_error()
		{
			?>
			<div class="notice notice-error">
				<p><?php _e('We found that you have the "Clearfy - disable unused features" plugin installed, this plugin already has Google Analytics cache functions, so you can deactivate plugin "Google Analytics Cache"!'); ?></p>
			</div>
		<?php
		}

		add_action('admin_notices', 'wbcr_ga_admin_notice_error');

		return;
	} else {

		define('WGA_PLUGIN_ACTIVE', true);
		define('WGA_PLUGIN_DIR', dirname(__FILE__));
		define('WGA_PLUGIN_BASE', plugin_basename(__FILE__));
		define('WGA_PLUGIN_URL', plugins_url(null, __FILE__));

		
		
		if( !defined('LOADING_GA_CACHE_AS_ADDON') ) {
			require_once(WGA_PLUGIN_DIR . '/libs/factory/core/boot.php');
		}

		require_once(WGA_PLUGIN_DIR . '/includes/class.plugin.php');

		if( !defined('LOADING_GA_CACHE_AS_ADDON') ) {

			new WGA_Plugin(__FILE__, array(
				'prefix' => 'wbcr_ga_',
				'plugin_name' => 'wbcr_ga',
				'plugin_title' => __('Webcraftic Google Analytics Cache', 'google_analytics_cache'),
				'plugin_version' => '1.0.0',
				'required_php_version' => '5.2',
				'required_wp_version' => '4.2',
				'plugin_build' => 'free',
				'updates' => WGA_PLUGIN_DIR . '/updates/'
			));
		}
	}