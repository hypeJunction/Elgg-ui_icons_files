<?php

/**
 * File Icons
 *
 * @author Ismayil Khayredinov <info@hypejunction.com>
 * @copyright Copyright (c) 2015, Ismayil Khayredinov
 */
elgg_register_event_handler('init', 'system', 'ui_icons_files_init');

/**
 * Initialize the plugin
 * @return void
 */
function ui_icons_files_init() {
	elgg_register_plugin_hook_handler('entity:icon:url', 'object', 'ui_icons_files_set_icon_url', 600);
}

/**
 * Replaces file type icons
 *
 * @param string $hook   "entity:icon:url"
 * @param string $type   "object"
 * @param string $return Icon URL
 * @param array  $params Hook params
 * @return string
 */
function ui_icons_files_set_icon_url($hook, $type, $return, $params) {

	$entity = elgg_extract('entity', $params);
	$size = elgg_extract('size', $params);

	if (!$entity instanceof \ElggFile) {
		return;
	}

	$mimetype = $entity->mimetype ? : $entity->detectMimeType();
	if (!$mimetype) {
		$mimetype = 'application/otcet-stream';
	}

	if (!in_array($size, array('topbar', 'tiny')) && 0 === strpos($mimetype, 'image/') && $entity->icontime && $return) {
		return $return;
	}

	$extension = pathinfo($entity->getFilenameOnFilestore(), PATHINFO_EXTENSION);
	$filetype = ui_icons_files_map_type($mimetype, $extension);

	$view = "icon/object/file/{$filetype}.svg";
	if (!elgg_view_exists($view)) {
		$view = "icon/default.svg";
	}
	
	return elgg_get_simplecache_url($view);
}

/**
 * Maps mime type to a file type icon
 *
 * @param string $mimetype  Mimetype
 * @param string $extension File name extension
 * @return string
 */
function ui_icons_files_map_type($mimetype = 'application/otcet-stream', $extension = '') {
	switch ($mimetype) {
		case 'application/pdf' :
		case 'application/vnd.pdf' :
		case 'application/x-pdf' :
			return 'pdf';

		case 'application/ogg' :
			return 'audio';

		case 'text/plain' :
		case 'text/richtext' :
			return 'text';

		case 'text/html':
		case 'application/rtf' :
		case 'application/vnd.oasis.opendocument.text' :
		case 'application/wordperfect' :
		case 'application/vnd.google-apps.document' :
			return 'document';


		case 'application/vnd.oasis.opendocument.presentation' :
		case 'application/vnd.google-apps.presentation' :
			return 'presentation';

		case 'text/csv':
		case 'text/x-markdown' :
		case 'application/csv' :
		case 'application/vnd.oasis.opendocument.spreadsheet' :
		case 'application/vnd.google-apps.spreadsheet' :
			return 'spreadsheet';


		case 'image/vnd.adobe.photoshop' :
		case 'application/eps':
		case 'application/vnd.oasis.opendocument.graphics' :
		case 'image/vnd.adobe.premiere':
		case 'application/illustrator' :
		case 'application/vnd.google-apps.drawing' :
			return 'drawing';

		case 'application/vnd.oasis.opendocument.image' :
			return 'image';

		case 'application/xhtml+xml' :
		case 'text/xml' :
		case 'application/json' :
		case 'text/javascript' :
		case 'application/javascript' :
		case 'application/x-javascript' :
		case 'application/rss+xml' :
		case 'text/css' :
		case 'text/php' :
		case 'text/x-php' :
		case 'application/php' :
		case 'application/x-php' :
			return 'code';

		case 'application/x-zip' :
		case 'application/x-gzip' :
		case 'application/x-gtar' :
		case 'application/x-tar' :
		case 'application/x-rar-compressed' :
		case 'application/x-stuffit' :
			return 'archive';

		case 'application/vnd.google-earth.kml+xml' :
		case 'application/vnd.google-earth.kmz' :
		case 'application/gml+xml' :
		case 'application/vnd.geo+json' :
		case 'application/vnd.google-apps.map' :
			return 'map';

		case 'text/v-card' :
		case 'text/directory' :
		case 'text/vcard' :
			return 'vcard';

		case 'text/calendar' :
		case 'application/calendar' :
		case 'application/calendar+json' :
		case 'application/calendar+xml' :
			return 'calendar';

		case 'application/zip' :
		case 'application/vnd.ms-office':
		case 'application/msword' :
		case 'application/excel' :
		case 'application/vnd.ms-excel' :
		case 'application/powerpoint' :
		case 'application/vnd.ms-powerpoint' :
		case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' :
		case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' :
		case 'application/vnd.openxmlformats-officedocument.presentationml.presentation' :

			switch ($extension) {
				case 'docx':
				case 'doc':
					return 'word';

				case 'xlsx':
				case 'xls':
					return 'excel';

				case 'pptx':
				case 'ppt' :
				case 'pot' :
					return 'powerpoint';

				case 'zip' :
				case 'war' :
				case 'jar' :
				case 'ear' :
					return 'archive';

				default :
					return 'default';
			}
			break;

		default :
			switch ($extension) {
				case 'bin' :
				case 'exe' :
					return 'application';
			}
			if (preg_match('~^(audio|image|video)/~', $mimetype, $m)) {
				return $m[1];
			} else {
				return 'default';
			}
			break;
	}
}
