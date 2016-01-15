<?php

// device reqs
$prereqs = '';
if (false) {
  $prereqs = '<script>' . file_get_contents('../../components/webcomponents-lite.min.js') . '</script>';
}

// critical segment: always necessary
$critical = '';
if (true) {
  $modules = [
    "../../components/polymer/polymer-nano.html", 
    "../../components/nano-elements/nano-import.html",
    "../../components/nano-elements/nano-serviceworker.html",
    "src/pica-view.html",
    "topics.html"
  ];
  // inject modules
  foreach ($modules as $module) {
    $critical .= file_get_contents($module);
  }
}

// contextual segment: modules identified from query
$contextual = '';

// lazy segment: optional modules
$lazy = '';
if (true) {
  // lazy modules
  $modules = [
    "src/feed-data.html",
    "src/feed-view.html",
    "src/article-view.html"
  ];
  // `provide` modules
  //$lazy = '<script>Nano.provide("' . implode('","', $modules) . '");</script>';
  // inject modules
  foreach ($modules as $module) {
    $lazy .= file_get_contents($module);
  }
}

// collect dynamic payload
$payload = "$prereqs $critical $contextual $lazy";

// main index
$index = file_get_contents('index.template');

// replace client-side load instruction with constructed payload
$index = str_replace('<link href="critical.html" rel="import">', $payload, $index);

// serve
echo $index;

?>