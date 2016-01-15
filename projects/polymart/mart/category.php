<?php

require('config.php');

$endpoint = 'paginated/items';
$query = $_SERVER['QUERY_STRING'];

$url = "http://api.walmartlabs.com/v1/$endpoint?category=$query&format=json&apiKey=$apikey";

header('Content-Type: application/json');
echo file_get_contents($url);

?>