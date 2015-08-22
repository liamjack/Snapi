<?php

require 'inc/snapi.class.php';

try {
	$storage = file_get_contents('snapi_storage');

	if(!$storage) {
		$snapi = new Snapi("GoogleEmailAddress", "GooglePassword");
		$snapi->login("SnapchatUsername", "SnapchatPassword");
	} else {
		$snapi = unserialize($storage);

		if(!$snapi) {
			throw new Exception("unserialize Exception: unserialization failed");
		}
	}

	// Get your own SnapTag in SVG Format
	echo '<img src="data:image/svg+xml;base64,' . $snapi->getSnapTag() . '">';

	// Serialize $snapi object to file
	file_put_contents('snapi_storage', serialize($snapi));
} catch(Exception $e) {
	echo "Error: " . $e->getMessage();
}

?>
