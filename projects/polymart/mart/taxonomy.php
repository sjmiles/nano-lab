<?php

require('config.php');

$endpoint = 'taxonomy';

$url="http://api.walmartlabs.com/v1/$endpoint?format=json&apiKey=$apikey";

header('Content-Type: application/json');
echo file_get_contents($url);

?>