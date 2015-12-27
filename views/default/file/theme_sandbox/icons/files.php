<?php

$file = new ElggFile();

$mapping = array(
	'default' => array('application/otcet-stream', ''),
	'application' => array('application/otcet-stream', 'exe'),
	'archive' => array('application/zip', 'zip'),
	'audio' => array('audio/mp3', 'mp3'),
	'calendar' => array('text/calendar', 'ics'),
	'code' => array('text/css', 'css'),
	'document' => array('application/rtf', 'rtf'),
	'drawing' => array('application/illustrator', 'ia'),
	'excel' => array('application/excel', 'xls'),
	'image' => array('image/jpeg', 'jpg'),
	'map' => array('application/vnd.geo+json', 'json'),
	'pdf' => array('application/pdf', 'pdf'),
	'powerpoint' => array('application/powerpoint', 'ppt'),
	'presentation' => array('application/vnd.oasis.opendocument.presentation', 'odp'),
	'spreadsheet' => array('text/csv', 'csv'),
	'text' => array('text/plain', 'txt'),
	'vcard' => array('text/vcard', 'vcard'),
	'video' => array('video/mpeg', 'mp4'),
	'word' => array('application/msword', 'doc'),
);

?>
<ul class="elgg-gallery elgg-gallery-fluid">
	<?php
	foreach ($mapping as $type => $opts) {
		$type = elgg_format_element('div', [], $type);
		$file->mimetype = $opts[0];
		$file->setFilename("file.{$opts[1]}");
		echo elgg_format_element('li', [
			'class' => 'mas center',
		], elgg_view_entity_icon($file, 'medium') . $type);
	}
	?>
</ul>
