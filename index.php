<?php

require 'inc/snapi.class.php';

$snapi = new Snapi("GoogleEmailAddress", "GooglePassword");

echo "<pre>";
var_dump($snapi->login("SnapchatUsername", "SnapchatPassword"));
echo "</pre>";

?>
