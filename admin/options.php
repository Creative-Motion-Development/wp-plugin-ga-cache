<?php
	/**
	 * Options for additionally form
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 21.01.2018, Webcraftic
	 * @version 1.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	/**
	 * @return array
	 */
	function wbcr_ga_get_plugin_options()
	{
		$options = array();

		$options[] = array(
			'type' => 'html',
			'html' => '<div class="wbcr-factory-page-group-header">' . __('<strong>Google Analytics cache</strong>.', 'google-analytics-cache') . '<p>' . __('To improve Google Page Speed indicators Analytics caching is needed. However, it can also slightly increase your website loading speed, because Analytics js files will load locally. The second case that you might need these settings is the usual Google Analytics connection to your website. You do not need to do this with other plugins or insert the tracking code into your theme.', 'google-analytics-cache') . '</p></div>'
		);

		$options[] = array(
			'type' => 'checkbox',
			'way' => 'buttons',
			'name' => 'ga_cache',
			'title' => __('Google Analytics Cache', 'google-analytics-cache'),
			'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
			'hint' => __('If you enable this option, the plugin will begin to save a local copy of Google Analytics to speed up the loading of your website and improve Google Page Speed.', 'google-analytics-cache') . '<br>--<br><span class="hint-warnign-color">' . __('ATTENTION! Before using this option, remove the previously installed Google Analytics code inside your theme or plugins associated with this feature!', 'google-analytics-cache') . '</span>',
			'default' => false,
			'eventsOn' => array(
				'show' => '#wbcr-clearfy-performance-ga-block'
			),
			'eventsOff' => array(
				'hide' => '#wbcr-clearfy-performance-ga-block'
			)

		);
		$options[] = array(
			'type' => 'div',
			'id' => 'wbcr-clearfy-performance-ga-block',
			'items' => array(
				array(
					'type' => 'textbox',
					'way' => 'buttons',
					'name' => 'ga_tracking_id',
					'title' => __('Google analytic Code', 'google-analytics-cache'),
					'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
					'hint' => __('Set the Google Analytics tracking code.', 'google-analytics-cache'),
					'placeholder' => 'UA-XXXXX-Y'
				),
				array(
					'type' => 'dropdown',
					'way' => 'buttons',
					'name' => 'ga_script_position',
					'data' => array(
						array('header', 'Header'),
						array('footer', 'Footer'),
					),
					'title' => __('Save GA in', 'google-analytics-cache'),
					'hint' => __('Select location for the Google Analytics code.', 'google-analytics-cache'),
					'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
					'default' => 'footer'
				),
				array(
					'type' => 'integer',
					'name' => 'ga_adjusted_bounce_rate',
					'title' => __('Use adjusted bounce rate?', 'google-analytics-cache'),
					'default' => 0,
					'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
					'hint' => __('Essentially, you set up an event which is triggered after a user spends a certain amount of time on the landing page, telling Google Analytics not to count these users as bounces. A user may come to your website, find all of the information they need (a phone number, for example) and then leave the site without visiting another page. Without adjusted bounce rate, such a user would be considered a bounce, even though they had a successful experience. By defining a time limit after which you can consider a user to be "engaged," that user would no longer count as a bounce, and you\'d get a more accurate idea of whether they found what they were looking for.', 'google-analytics-cache')
				),
				array(
					'type' => 'integer',
					'way' => 'buttons',
					'name' => 'ga_enqueue_order',
					'title' => __('Change enqueue order?', 'google-analytics-cache'),
					'default' => 0,
					'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
					'hint' => __('By default, Google Analytics code is loaded before other scripts and javasscript code, but if you set the value to 100, the GA code will be loaded after all other scripts. By changing the priority, you can set code position on the page.', 'google-analytics-cache')
				),
				array(
					'type' => 'checkbox',
					'way' => 'buttons',
					'name' => 'ga_caos_disable_display_features',
					'title' => __('Disable all display features functionality?', 'google-analytics-cache'),
					//'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
					'hint' => sprintf(__('Disable all <a href="%s">display features functionality?</a>', 'google-analytics-cache'), 'https://developers.google.com/analytics/devguides/collection/analyticsjs/display-features'),
					'default' => false
				),
				array(
					'type' => 'checkbox',
					'way' => 'buttons',
					'name' => 'ga_anonymize_ip',
					'title' => __('Use Anonymize IP? (Required by law for some countries)', 'google-analytics-cache'),
					//'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
					'hint' => sprintf(__('Use <a href="%s">Anonymize IP?</a> (Required by law for some countries)', 'google-analytics-cache'), 'https://support.google.com/analytics/answer/2763052'),
					'default' => false
				),
				array(
					'type' => 'checkbox',
					'way' => 'buttons',
					'name' => 'ga_track_admin',
					'title' => __('Track logged in Administrators?', 'google-analytics-cache'),
					'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
					'hint' => __('Track logged in Administrators?', 'google-analytics-cache'),
					'default' => false
				),
				array(
					'type' => 'checkbox',
					'way' => 'buttons',
					'name' => 'ga_caos_remove_wp_cron',
					'title' => __('Remove script from wp-cron?', 'google-analytics-cache'),
					'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
					'hint' => __('Clearfy creates a cron job to daily update Google Analytics cache scripts. After enabling this option, the plugin will not update Google Analytics cache file. Do not use this option if you do not understand why you need it!', 'google-analytics-cache'),
					'default' => false
				)
			)
		);

		return $options;
	}

	/**
	 * @param $form
	 * @param $page FactoryPages000_ImpressiveThemplate
	 * @return mixed
	 */
	function wbcr_ga_additionally_form_options($form, $page)
	{
		if( empty($form) ) {
			return $form;
		}

		$options = wbcr_ga_get_plugin_options();

		foreach(array_reverse($options) as $option) {
			array_unshift($form[0]['items'], $option);
		}

		return $form;
	}

	add_filter('wbcr_clr_additionally_form_options', 'wbcr_ga_additionally_form_options', 10, 2);

