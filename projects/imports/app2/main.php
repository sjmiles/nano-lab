<?php

$modules = JSON_decode(file_get_contents('manifest.json'));

$payload = '';
foreach($modules as $module) {
  $payload .= 
    "<!--------------------------------------------------------------------------\n"
    ." $module\n"
    ."--------------------------------------------------------------------------->\n"
    .file_get_contents($module)."\n"
    ;
}

// main index
$index = file_get_contents('main.html');
// replace client-side load instruction with constructed payload
$index = str_replace('<link rel="import" href="imports.html">', $payload, $index);

echo $index;

?>