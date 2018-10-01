<?php
	/**
	 * Plugin Name: Webcraftic Local Google Analytics
	 * Plugin URI: https://wordpress.org/plugins/simple-google-analytics/
	 * Description: Old plugin name: Simple Google Analytics. To improve Google Page Speed indicators Analytics caching is needed. However, it can also slightly increase your website loading speed, because Analytics js files will load locally. The second case that you might need these settings is the usual Google Analytics connection to your website. You do not need to do this with other plugins or insert the tracking code into your theme.
	 * Author: Webcraftic <wordpress.webraftic@gmail.com>, JeromeMeyer62<jerome.meyer@hollywoud.net>
	 * Version: 3.0.1
	 * Text Domain: simple-google-analytics
	 * Domain Path: /languages/
	 * Author URI: http://clearfy.pro
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}
	
	define('WGA_PLUGIN_VERSION', '3.0.1');
	
	define('WGA_PLUGIN_DIR', dirname(__FILE__));
	define('WGA_PLUGIN_BASE', plugin_basename(__FILE__));
	define('WGA_PLUGIN_URL', plugins_url(null, __FILE__));

	#comp remove
	// the following constants are used to debug features of diffrent builds
	// on developer machines before compiling the plugin

	// build: free, premium, ultimate
	if( !defined('BUILD_TYPE') ) {
		define('BUILD_TYPE', 'free');
	}
	// language: en_US, ru_RU
	if( !defined('LANG_TYPE') ) {
		define('LANG_TYPE', 'en_EN');
	}
	// license: free, paid
	if( !defined('LICENSE_TYPE') ) {
		define('LICENSE_TYPE', 'free');
	}

	// wordpress language
	if( !defined('WPLANG') ) {
		define('WPLANG', LANG_TYPE);
	}
	// the compiler library provides a set of functions like onp_build and onp_license
	// to check how the plugin work for diffrent builds on developer machines

	if( !defined('LOADING_GA_CACHE_AS_ADDON') ) {
		require('libs/onepress/compiler/boot.php');
		// creating a plugin via the factory
	}
	// #fix compiller bug new Factory000_Plugin
	#endcomp
	
	if( !defined('LOADING_GA_CACHE_AS_ADDON') ) {
		require_once(WGA_PLUGIN_DIR . '/libs/factory/core/includes/check-compatibility.php');
		require_once(WGA_PLUGIN_DIR . '/libs/factory/clearfy/includes/check-clearfy-compatibility.php');
	}
	
	$plugin_info = array(
		'prefix' => 'wbcr_gac_',
		'plugin_name' => 'wbcr_gac',
		'plugin_title' => __('Webcraftic Local Google Analytics', 'simple-google-analytics'),
		'plugin_version' => WGA_PLUGIN_VERSION,
		'plugin_build' => BUILD_TYPE,
		//'updates' => WGA_PLUGIN_DIR . '/updates/'
	);
	
	/**
	 * Проверяет совместимость с Wordpress, php и другими плагинами.
	 */
	$compatibility = new Wbcr_FactoryClearfy000_Compatibility(array_merge($plugin_info, array(
		'plugin_already_activate' => defined('WGA_PLUGIN_ACTIVE'),
		'plugin_as_component' => defined('LOADING_GA_CACHE_AS_ADDON'),
		'plugin_dir' => WGA_PLUGIN_DIR,
		'plugin_base' => WGA_PLUGIN_BASE,
		'plugin_url' => WGA_PLUGIN_URL,
		'required_php_version' => '5.3',
		'required_wp_version' => '4.2.0',
		'required_clearfy_check_component' => true
	)));
	
	/**
	 * Если плагин совместим, то он продолжит свою работу, иначе будет остановлен,
	 * а пользователь получит предупреждение.
	 */
	if( !$compatibility->check() ) {
		return;
	}
	
	define('WGA_PLUGIN_ACTIVE', true);

	if( !defined('LOADING_GA_CACHE_AS_ADDON') ) {
		require_once(WGA_PLUGIN_DIR . '/libs/factory/core/boot.php');
	}

	require_once(WGA_PLUGIN_DIR . '/includes/class.plugin.php');

	if( !defined('LOADING_GA_CACHE_AS_ADDON') ) {
		new WGA_Plugin(__FILE__, $plugin_info);
	}
	