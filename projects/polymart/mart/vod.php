<?php

$apikey = 'd28558x2emkgzcup3b7r3ax7';
$endpoint = 'vod';

$url="http://api.walmartlabs.com/v1/$endpoint?format=json&apiKey=$apikey";

header('Content-Type: application/json');
echo file_get_contents($url);

?>