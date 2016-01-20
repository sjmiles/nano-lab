<?php

require('config.php');

$endpoint = 'taxonomy';

$path = "cache/$endpoint"; 
$data = @file_get_contents($path);
if (!$data) {
  header('Php-Mart: required fetch');
  $url="http://api.walmartlabs.com/v1/$endpoint?format=json&apiKey=$apikey";
  $data = file_get_contents($url);
  file_put_contents($path, $data);
} else {
  header('Php-Mart: using cache');
}

header('Content-Type: application/json');
echo $data;

?>