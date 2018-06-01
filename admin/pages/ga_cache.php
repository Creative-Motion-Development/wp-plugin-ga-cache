<?php

	/**
	 * The page Settings.
	 *
	 * @since 1.0.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	class WGA_CachePage extends Wbcr_FactoryPages400_ImpressiveThemplate {

		/**
		 * The id of the page in the admin menu.
		 *
		 * Mainly used to navigate between pages.
		 * @see FactoryPages400_AdminPage
		 *
		 * @since 1.0.0
		 * @var string
		 */
		public $id = "ga_cache";
		public $page_menu_dashicon = 'dashicons-testimonial';

		/**
		 * @param Wbcr_Factory400_Plugin $plugin
		 */
		public function __construct(Wbcr_Factory400_Plugin $plugin)
		{
			$this->menu_title = __('Google Analytics Cache', 'google-analytics-cache');

			if( !defined('LOADING_GA_CACHE_AS_ADDON') ) {
				$this->internal = false;
				$this->menu_target = 'options-general.php';
				$this->add_link_to_plugin_actions = true;
			}

			parent::__construct($plugin);

			$this->plugin = $plugin;
		}

		public function getMenuTitle()
		{
			return defined('LOADING_GA_CACHE_AS_ADDON')
				? __('Google Analytics Cache', 'google-analytics-cache')
				: __('General', 'google-analytics-cache');
		}


		/**
		 * We register notifications for some actions
		 * @param array $notices
		 * @param Wbcr_Factory400_Plugin $plugin
		 * @return array
		 */
		public function actionsNotice($notices)
		{


			return $notices;
		}

		/**
		 * Permalinks options.
		 *
		 * @since 1.0.0
		 * @return mixed[]
		 */
		public function getOptions()
		{
			$options = wbcr_ga_get_plugin_options();

			$formOptions = array();

			$formOptions[] = array(
				'type' => 'form-group',
				'items' => $options,
				//'cssClass' => 'postbox'
			);

			return apply_filters('wbcr_ga_notices_form_options', $formOptions, $this);
		}
	}