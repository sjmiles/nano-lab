<?php

// device reqs
$prereqs = '';
if (true) {
  $prereqs = '<script>' . file_get_contents('../../components/webcomponents-lite.min.js') . '</script>';
}

// critical build
$critical = file_get_contents('serve/critical.html');

// lazy modules
$modules = [
  '../../components/nano/nano-router.html',
  '../../components/nano/nano-ripple.html',
  'lazy/settings-content.html',
  'lazy/nav-bar.html',
  'lazy/crumb-bar.html',
  'lazy/settings-card.html',
  'lazy/card-banner.html',
  'lazy/ic-view.html',
  'lazy/wifi-view.html'
];
// `provide` modules
$provide = '<script>Nano.provide("' . implode('","', $modules) . '");</script>';
// inject modules
foreach ($modules as $module) {
  $provide .= file_get_contents($module);
}

$contextual = ""
  .$provide
  ;

// dynamic payload
$payload = "$prereqs $critical $contextual";

// main index
$index = file_get_contents('index.html');

// replace client-side load instruction with constructed payload
$index = str_replace('<link rel="import" href="serve/critical.html">', $payload, $index);

// serve
echo $index;

?>