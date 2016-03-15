<?php
/**
 * Anypage Widgets
 */

myvox_register_event_handler('init', 'system', 'anypage_widgets_init');

/**
 * Anypage Widgets init
 */
function anypage_widgets_init() {
	myvox_extend_view('js/admin', 'anypage_widgets/js/admin');

	if (myvox_is_admin_logged_in()) {
		myvox_register_ajax_view('anypage_widgets/wizard');
	}

	myvox_register_plugin_hook_handler('advanced_context', 'widget_manager', 'anypage_widgets_advanced');
}

/**
 * Anypage Widgets convert
 *
 * Convers a description/text into content with widgets.
 * It replaces BBCode tags with content from widgets, for example:
 * [WIDGET:home]
 *
 * @param string $description Description to transform
 *
 * @return string Transformed description
 */
function anypage_widgets_convert($description) {

	return preg_replace_callback('/\[WIDGET:[^]]+\]/', function ($matches) {
		$paramsString = substr(strip_tags($matches[0]), 8, -1);
		$params = (array) explode(':', $paramsString);

		if (!isset($params[0])) {
			return 'Widget ID not defined.';
		}

		$widget = get_entity($params[0]);

		if (!myvox_instanceof($widget, 'object', 'widget')) {
			return 'Widget not found.';
		}

		$style = '';

		foreach ($params as $param) {
			$subparam = explode('|', $param);

			switch ($subparam[0]) {
				case 'style':
					if (isset($subparam[1]) && isset($subparam[2])) {
						$style .= $subparam[1] . ': ' . $subparam[2] . ';';
					}
					break;
			}
		}

		return myvox_view('anypage_widgets/widget', array(
			'body' => myvox_view_entity($widget),
			'style' => $style
		));
	}, $description);
}

/**
 * Plugin hook handler to add anypage as an advanced context
 *
 * @param string $hook    The name of the plugin hook
 * @param string $type    The type of the plugin hook
 * @param mixed  $value   The current value of the plugin hook
 * @param mixed  $params  Data passed from the trigger
 *
 * @return mixed if not null, this will be the new value of the plugin hook
 */
function anypage_widgets_advanced($hook, $type, $value, $params) {
	return array_merge($value, array('anypage'));
}