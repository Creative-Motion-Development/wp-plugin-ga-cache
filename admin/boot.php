<?php
	/**
	 * Admin boot
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright Webcraftic 25.05.2017
	 * @version 1.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	/**
	 * @param $options
	 * @return array
	 */
	function wbcr_ga_group_options($options)
	{
		$options[] = array(
			'name' => 'ga_cache',
			'title' => __('Google Analytics Cache', 'google-analytics-cache'),
			'tags' => array()
		);

		$options[] = array(
			'name' => 'ga_tracking_id',
			'title' => __('Google analytic Code', 'clearfy'),
			'tags' => array()
		);
		$options[] = array(
			'name' => 'ga_adjusted_bounce_rate',
			'title' => __('Use adjusted bounce rate?', 'clearfy'),
			'tags' => array()
		);
		$options[] = array(
			'name' => 'ga_enqueue_order',
			'title' => __('Change enqueue order?', 'clearfy'),
			'tags' => array()
		);
		$options[] = array(
			'name' => 'ga_caos_disable_display_features',
			'title' => __('Disable all display features functionality?', 'clearfy'),
			'tags' => array()
		);
		$options[] = array(
			'name' => 'ga_anonymize_ip',
			'title' => __('Use Anonymize IP? (Required by law for some countries)', 'clearfy'),
			'tags' => array()
		);
		$options[] = array(
			'name' => 'ga_track_admin',
			'title' => __('Track logged in Administrators?', 'clearfy'),
			'tags' => array()
		);
		$options[] = array(
			'name' => 'ga_caos_remove_wp_cron',
			'title' => __('Remove script from wp-cron?', 'clearfy'),
			'tags' => array()
		);

		return $options;
	}

	add_filter("wbcr_clearfy_group_options", 'wbcr_ga_group_options');

	/**
	 * Download ultimate plugin link
	 *
	 * @param $links
	 * @param $file
	 * @return array
	 */
	function wbcr_ga_set_plugin_meta($links, $file)
	{
		if( $file == WCTR_PLUGIN_BASE ) {

			$url = 'https://clearfy.pro';

			if( get_locale() == 'ru_RU' ) {
				$url = 'https://ru.clearfy.pro';
			}

			$url .= '?utm_source=wordpress.org&utm_campaign=' . WGA_Plugin::app()->getPluginName();

			$links[] = '<a href="' . $url . '" style="color: #FF5722;font-weight: bold;" target="_blank">' . __('Get ultimate plugin free', 'google-analytics-cache') . '</a>';
		}

		return $links;
	}

	if( !defined('LOADING_GA_CACHE_AS_ADDON') ) {
		add_filter('plugin_row_meta', 'wbcr_ga_set_plugin_meta', 10, 2);
	}

	/**
	 * Rating widget url
	 *
	 * @param string $page_url
	 * @param string $plugin_name
	 * @return string
	 */
	function wbcr_ga_rating_widget_url($page_url, $plugin_name)
	{
		if( $plugin_name == WGA_Plugin::app()->getPluginName() ) {
			return 'https://goo.gl/68ucHp';
		}

		return $page_url;
	}

	add_filter('wbcr_factory_imppage_rating_widget_url', 'wbcr_ga_rating_widget_url', 10, 2);



