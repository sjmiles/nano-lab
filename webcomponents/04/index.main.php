<?php

// prerequesites as determined by query (and perhaps device-sniffing), like polyfills and l10n data
$prereqs = '';
if (false) {
  $prereqs = '<script>' . file_get_contents('../../components/webcomponents-lite.min.js') . '</script>';
}

// critical segment: always necessary
$critical = concat([
  "src/index.css.html",
  "src/service-worker.html",
  "src/nav-bar.html",
  "src/some-content.html"
]);

// contextual segment: other modules identified from query
$contextual = concat([]);

// lazy segment: optional modules
$lazy = concat([]);

// collect dynamic payload
$payload = "$prereqs $critical $contextual $lazy";

// main index
$index = file_get_contents('index.main.html');

// replace client-side load instruction with constructed payload
$index = str_replace('<link rel="import" href="src/imports.html">', $payload, $index);

// serve
echo $index;

// concatenate module-content into a string
function concat($modules) {
  $result = "";
  foreach ($modules as $module) {
    $result .= file_get_contents($module);
  }
  return $result;
}
  
?>