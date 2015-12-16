<?php

// device reqs
$prereqs = '';
if (false) {
  $prereqs = '<script>' . file_get_contents('../../components/webcomponents-lite.min.js') . '</script>';
}

// critical build
$critical = file_get_contents('critical.html');
// contextual build
$contextual = "";

if (false) {
  // lazy modules
  $modules = [
  ];
  // `provide` modules
  $provide = '<script>Nano.provide("' . implode('","', $modules) . '");</script>';
  // inject modules
  foreach ($modules as $module) {
    $provide .= file_get_contents($module);
  }
  $contextual .= $provide;
}

// dynamic payload
$payload = "$prereqs $critical $contextual";

// main index
$index = file_get_contents('index.html');

// replace client-side load instruction with constructed payload
$index = str_replace('<link rel="import" href="critical.html">', $payload, $index);

// serve
echo $index;

?>