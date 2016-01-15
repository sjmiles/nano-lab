<?php

// prerequesites as determined by query (and perhaps device-sniffing), like polyfills and l10n data
$prereqs = '';
if (false) {
  $prereqs = '<script>' . file_get_contents('../../components/webcomponents-lite.min.js') . '</script>';
}

// critical segment: always required for first paint
$critical = concat([
  "../../components/nano/annotations.html",
  "src/simple-router.html",
  "l10n.html",
  "main-css.html"
]);

// contextual segment: other modules identified from query
$contextual = concat([]);

// lazy segment: optional modules that we choose to include in the primary payload
$lazy = concat([
  "src/primer-data.html",
  "src/nav-bar.html",
  "src/some-content.html",
  "src/service-worker.html",
  "src/google-analytics.html" 
]);

// collect dynamic payload
$payload = "$prereqs $critical $contextual $lazy";

// main index
$index = file_get_contents('main.html');

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