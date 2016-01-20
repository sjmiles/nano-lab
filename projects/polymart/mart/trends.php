<?php

$endpoint = 'trends';

header('Content-Type: application/json');
echo file_get_contents("cache/$endpoint.json");
                              
?>