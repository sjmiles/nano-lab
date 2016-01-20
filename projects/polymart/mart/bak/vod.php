<?php

require('config.php');

$endpoint = 'vod';

$path = "cache/$endpoint"; 
$data = @file_get_contents($path);
if (!$data) {
  $url="http://api.walmartlabs.com/v1/$endpoint?format=json&apiKey=$apikey";
  $data = file_get_contents($url);
  file_put_contents($path, $data);
}

header('Content-Type: application/json');
echo $data;

?>