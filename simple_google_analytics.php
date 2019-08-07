<?php
/**
 * Plugin Name: Webcraftic Local Google Analytics
 * Plugin URI: https://webcraftic.com
 * Description: Old plugin name: Simple Google Analytics. To improve Google Page Speed indicators Analytics caching is needed. However, it can also slightly increase your website loading speed, because Analytics js files will load locally. The second case that you might need these settings is the usual Google Analytics connection to your website. You do not need to do this with other plugins or insert the tracking code into your theme.
 * Author: Webcraftic <wordpress.webraftic@gmail.com>
 * Version: 3.1.0
 * Text Domain: simple-google-analytics
 * Domain Path: /languages/
 * Author URI: http://webcraftic.com
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Developers who contributions in the development plugin:
 *
 * Alexander Kovalev
 * ---------------------------------------------------------------------------------
 * Full plugin development.
 *
 * Email:         alex.kovalevv@gmail.com
 * Personal card: https://alexkovalevv.github.io
 * Personal repo: https://github.com/alexkovalevv
 * ---------------------------------------------------------------------------------
 */

/**
 * -----------------------------------------------------------------------------
 * CHECK REQUIREMENTS
 * Check compatibility with php and wp version of the user's site. As well as checking
 * compatibility with other plugins from Webcraftic.
 * -----------------------------------------------------------------------------
 */

require_once( dirname( __FILE__ ) . '/libs/factory/core/includes/class-factory-requirements.php' );

// @formatter:off
$plugin_info = array(
	'prefix'         => 'wbcr_gac_',
	'plugin_name'    => 'wbcr_gac',
	'plugin_title'   => __( 'Webcraftic Local Google Analytics', 'simple-google-analytics' ),

	// PLUGIN SUPPORT
	'support_details'      => array(
		'url'       => 'https://webcraftic.com',
		'pages_map' => array(
			'support'  => 'support',           // {site}/support
			'docs'     => 'docs'               // {site}/docs
		)
	),

	// FRAMEWORK MODULES
	'load_factory_modules' => array(
		array( 'libs/factory/bootstrap', 'factory_bootstrap_000', 'admin' ),
		array( 'libs/factory/forms', 'factory_forms_000', 'admin' ),
		array( 'libs/factory/pages', 'factory_pages_000', 'admin' ),
		array( 'libs/factory/clearfy', 'factory_clearfy_000', 'all' ),
		array( 'libs/factory/adverts', 'factory_adverts_000', 'admin')
	)
);

$wga_compatibility = new Wbcr_Factory000_Requirements( __FILE__, array_merge( $plugin_info, array(
	'plugin_already_activate'          => defined( 'WGA_PLUGIN_ACTIVE' ),
	'required_php_version'             => '5.4',
	'required_wp_version'              => '4.2.0',
	'required_clearfy_check_component' => false
) ) );


/**
 * If the plugin is compatible, then it will continue its work, otherwise it will be stopped,
 * and the user will throw a warning.
 */
if ( ! $wga_compatibility->check() ) {
	return;
}

/**
 * -----------------------------------------------------------------------------
 * CONSTANTS
 * Install frequently used constants and constants for debugging, which will be
 * removed after compiling the plugin.
 * -----------------------------------------------------------------------------
 */

// This plugin is activated
define( 'WGA_PLUGIN_ACTIVE', true );
define( 'WGA_PLUGIN_VERSION', $wga_compatibility->get_plugin_version() );
define( 'WGA_PLUGIN_DIR', dirname( __FILE__ ) );
define( 'WGA_PLUGIN_BASE', plugin_basename( __FILE__ ) );
define( 'WGA_PLUGIN_URL', plugins_url( null, __FILE__ ) );


#comp remove
// Эта часть кода для компилятора, не требует редактирования.
// Все отладочные константы будут удалены после компиляции плагина.

// Сборка плагина
// build: free, premium, ultimate
if ( ! defined( 'BUILD_TYPE' ) ) {
	define( 'BUILD_TYPE', 'free' );
}
// Языки уже не используются, нужно для работы компилятора
// language: en_US, ru_RU
if ( ! defined( 'LANG_TYPE' ) ) {
	define( 'LANG_TYPE', 'en_EN' );
}

// Тип лицензии
// license: free, paid
if ( ! defined( 'LICENSE_TYPE' ) ) {
	define( 'LICENSE_TYPE', 'free' );
}

// wordpress language
if ( ! defined( 'WPLANG' ) ) {
	define( 'WPLANG', LANG_TYPE );
}

/**
 * Включить режим отладки миграций с версии x.x.x до x.x.y. Если true и
 * установлена константа FACTORY_MIGRATIONS_FORCE_OLD_VERSION, ваш файл
 * миграции будет вызваться постоянно.
 */
if ( ! defined( 'FACTORY_MIGRATIONS_DEBUG' ) ) {
	define( 'FACTORY_MIGRATIONS_DEBUG', false );

	/**
	 * Так как, после первого выполнения миграции, плагин обновляет
	 * опцию plugin_version, чтобы миграция больше не выполнялась,
	 * в тестовом режиме миграций, старая версия плагина берется не
	 * из опции в базе данных, а из текущей константы.
	 *
	 * Новая версия плагина всегда берется из константы WGA_PLUGIN_VERSION
	 * или из комментариев к входному файлу плагина.
	 */
	//define( 'FACTORY_MIGRATIONS_FORCE_OLD_VERSION', '1.1.9' );
}

/**
 * Включить режим отладки обновлений плагина и обновлений его премиум версии.
 * Если true, плагин не будет кешировать результаты проверки обновлений, а
 * будет проверять обновления через установленный интервал в константе
 * FACTORY_CHECK_UPDATES_INTERVAL.
 */
if ( ! defined( 'FACTORY_UPDATES_DEBUG' ) ) {
	define( 'FACTORY_UPDATES_DEBUG', false );

	// Через какой интервал времени проверять обновления на удаленном сервере?
	define( 'FACTORY_CHECK_UPDATES_INTERVAL', MINUTE_IN_SECONDS );
}

/**
 * Включить режим отладки для рекламного модуля. Если FACTORY_ADVERTS_DEBUG true,
 * то рекламный модуля не будет кешировать запросы к сереверу. Упрощает настройку
 * рекламы.
 */
if ( ! defined( 'FACTORY_ADVERTS_DEBUG' ) ) {
	define( 'FACTORY_ADVERTS_DEBUG', true );
}

// the compiler library provides a set of functions like onp_build and onp_license
// to check how the plugin work for diffrent builds on developer machines

require_once( WGA_PLUGIN_DIR . '/libs/onepress/compiler/boot.php' );
// creating a plugin via the factory

// #fix compiller bug new Factory000_Plugin
#endcomp

/**
 * -----------------------------------------------------------------------------
 * PLUGIN INIT
 * -----------------------------------------------------------------------------
 */

require_once( WGA_PLUGIN_DIR . '/libs/factory/core/boot.php' );
require_once( WGA_PLUGIN_DIR . '/includes/class-plugin.php' );

try {
	new WGA_Plugin( __FILE__, array_merge( $plugin_info, array(
		'plugin_version'     => WGA_PLUGIN_VERSION,
		'plugin_text_domain' => $wga_compatibility->get_text_domain(),
	) ) );
} catch( Exception $e ) {
	// Plugin wasn't initialized due to an error
	define( 'WGA_PLUGIN_THROW_ERROR', true );

	$wga_plugin_error_func = function () use ( $e ) {
		$error = sprintf( "The %s plugin has stopped. <b>Error:</b> %s Code: %s", 'Webcraftic Local Google Analytics', $e->getMessage(), $e->getCode() );
		echo '<div class="notice notice-error"><p>' . $error . '</p></div>';
	};

	add_action( 'admin_notices', $wga_plugin_error_func );
	add_action( 'network_admin_notices', $wga_plugin_error_func );
}
// @formatter:on