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
	 * Notice that the plugin has been seriously updated!
	 *
	 * @param array $notices
	 * @param string $plugin_name
	 * @return array
	 */
	function wbcr_ga_admin_conflict_notices_error($notices, $plugin_name)
	{
		if( $plugin_name != WGA_Plugin::app()->getPluginName() ) {
			return $notices;
		}

		$notices[] = array(
			'id' => 'ga_plugin_upgrade_notice',
			'type' => 'warning',
			'dismissible' => true,
			'dismiss_expires' => 0,
			'text' => '<p>' . __('В плагине Simple Google Analytics были внесены серьезные изменения.', 'simple-google-analytics') . '</p>' . '<p>' . __('К сожалению, старая версия плагина 2.2.2 больше не поддерживается, но вы можете скачать ее из репозитория Wordpress, если новое обновление вам не подходит.', 'simple-google-analytics') . '</p>' . '<p>' . __('Мы обновили код и решили проблемы с совместимостью последних версий Wordpress и PHP. Также мы добавили возможность кеширования google аналитики, чтобы ваш сайт загружался еще быстрее. Название плагина было изменено на Google Analytic cache, но все функции подключения Google аналитики остались прежними.', 'simple-google-analytics') . '</p>' . '<p>' . __('Пожалуйста, проверьте настройки плагина и его работу на вашем сайте, мы беспокоимся о вас и хотим, чтобы у вас не было никаких проблем с новой версией нашего плагина.', 'simple-google-analytics') . '</p>' . '<p>' . __('Мы хотим лучше заботиться о скорости и безопасности вашего сайта, по мимо этого простого плагина, вы должны обязательно попробовать наш плагин базовой оптимизации Wordpress (Clearfy), он уже включает в себя функции этого плагина и содержит огромное количество функции для оптимизации вашего сайта. Подробнее о плагине Clearfy', 'simple-google-analytics') . '</p>'
		);

		return $notices;
	}

	add_filter('wbcr_factory_admin_notices', 'wbcr_ga_admin_conflict_notices_error', 10, 2);

	/**
	 * Migrate settings from the old plugin to the new one.
	 */
	function wbcr_ga_upgrade()
	{
		global $wpdb;

		$is_migrate_up_to_230 = WGA_Plugin::app()->getOption('is_migrate_up_to_230', false);

		if( !$is_migrate_up_to_230 ) {
			$old_plugin_tracking_id = get_option('sga_analytics_id');
			$old_plugin_code_location = get_option('sga_code_location');
			$old_plugin_demographic_and_interest = (int)get_option('sga_demographic_and_interest');
			$old_plugin_sga_render_when_loggedin = (int)get_option('sga_render_when_loggedin');

			if( !empty($old_plugin_tracking_id) ) {
				WGA_Plugin::app()->updateOption('ga_cache', 1);
				WGA_Plugin::app()->updateOption('ga_tracking_id', $old_plugin_tracking_id);

				$script_position = 'footer';

				if( $old_plugin_code_location == 'head' ) {
					$script_position = 'header';
				}

				WGA_Plugin::app()->updateOption('ga_script_position', $script_position);
				WGA_Plugin::app()->updateOption('ga_anonymize_ip', $old_plugin_demographic_and_interest);
				WGA_Plugin::app()->updateOption('ga_track_admin', $old_plugin_sga_render_when_loggedin);

				$wpdb->query("DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE 'sga_%';");
			}

			WGA_Plugin::app()->updateOption('is_migrate_up_to_230', 1);
		}
	}

	add_action('init', 'wbcr_ga_upgrade');

	/**
	 * @param $options
	 * @return array
	 */
	function wbcr_ga_group_options($options)
	{
		$options[] = array(
			'name' => 'ga_cache',
			'title' => __('Google Analytics Cache', 'simple-google-analytics'),
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

			$links[] = '<a href="' . $url . '" style="color: #FF5722;font-weight: bold;" target="_blank">' . __('Get ultimate plugin free', 'simple-google-analytics') . '</a>';
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
			return 'https://wordpress.org/support/plugin/simple-google-analytics/reviews/#new-post';
		}

		return $page_url;
	}

	add_filter('wbcr_factory_imppage_rating_widget_url', 'wbcr_ga_rating_widget_url', 10, 2);



