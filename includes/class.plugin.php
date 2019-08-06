<?php
/**
 * Plugin class
 *
 * @author        Alex Kovalev <alex.kovalevv@gmail.com>
 * @copyright (c) 19.02.2018, Webcraftic
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class WGA_Plugin extends Wbcr_Factory000_Plugin {

	/**
	 * @var Wbcr_Factory000_Plugin
	 */
	private static $app;
	private $plugin_data;

	/**
	 * WGA_Plugin constructor.
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * /**
	 *
	 * @param string $plugin_path
	 * @param array  $data
	 *
	 * @throws Exception
	 */
	public function __construct( $plugin_path, $data ) {
		parent::__construct( $plugin_path, $data );

		self::$app         = $this;
		$this->plugin_data = $data;

		$this->global_scripts();

		if ( is_admin() ) {
			$this->init_activation();
			$this->admin_scripts();
		}
	}

	/**
	 * @return Wbcr_Factory000_Plugin
	 */
	public static function app() {
		return self::$app;
	}

	/**
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  3.0.0
	 */
	private function init_activation() {
		require_once( WGA_PLUGIN_DIR . '/admin/activation.php' );
		self::app()->registerActivation( 'WGA_Activation' );
	}

	/**
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  3.0.0
	 * @throws \Exception
	 */
	private function register_pages() {
		if ( $this->as_addon ) {
			return;
		}

		if ( $this->isNetworkActive() and ! is_network_admin() ) {
			return;
		}
		self::app()->registerPage( 'WGA_CachePage', WGA_PLUGIN_DIR . '/admin/pages/class-pages-general-settings.php' );
		self::app()->registerPage( 'WGA_MoreFeaturesPage', WGA_PLUGIN_DIR . '/admin/pages/class-pages-more-features.php' );
	}

	/**
	 * Регистрирует рекламные объявления от студии Webcraftic
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.1.0
	 */
	private function register_adverts_blocks() {
		global $wdan_adverts;

		$wdan_adverts = new WBCR\Factory_Adverts_000\Base( __FILE__, array_merge( $this->plugin_data, [
			'dashboard_widget' => true, // show dashboard widget (default: false)
			'right_sidebar'    => true, // show adverts sidebar (default: false)
			'notice'           => false, // show notice message (default: false)
		] ) );
	}

	/**
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  3.0.0
	 * @throws \Exception
	 */
	private function admin_scripts() {
		require( WGA_PLUGIN_DIR . '/admin/options.php' );
		require( WGA_PLUGIN_DIR . '/admin/boot.php' );

		$this->register_pages();
		$this->register_adverts_blocks();
	}

	/**
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  3.0.0
	 */
	private function global_scripts() {
		require( WGA_PLUGIN_DIR . '/includes/classes/class.configurate-ga.php' );
		new WGA_ConfigGACache( self::$app );
	}
}

