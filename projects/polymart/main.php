<?php

// prerequesites as determined by query (and perhaps device-sniffing), like polyfills and l10n data
$prereqs = '';
if (false) {
  $prereqs = '<script>' . file_get_contents('../../components/webcomponents-lite.min.js') . '</script>';
}

// critical segment: always required for first paint
$critical = concat([
  "../../components/polymer/polymer-nano.html",
  "../../components/icons-simple.html",
  "../../components/nano-elements/nano-layout.html",
  "src/polymart-view.html"
]);

// contextual segment: other modules identified from query
$contextual = concat([
  "src/mart-data.html",
  "src/nav-bar.html",
  "../../components/nano-elements/nano-carousel.html",
  "src/product-view.html",
  "src/home-view.html",
  "src/cart-view.html",
  "src/cart-item-view.html",
  "src/grid-layout.html",
  "src/categories-view.html"
]);
  
// optional segment: modules that we choose to include in the primary payload
$optional = concat([
  "../../components/nano-elements/nano-ajax.html",
  "../../components/nano-elements/nano-serviceworker.html"
]);

// lazy segment: modules that we choose to load async (but early)
$lazy = "\n\n";
$lazy .= implode("\n", [
  '<link async rel="import" href="src/search-view.html">',
  '<link async rel="import" href="src/simple-router.html">',
  '<link async rel="import" href="src/category-view.html">'
]);

// contextual data
$data = "\n\n";
$payload = @file_get_contents('mart/cache/payload.json');
if ($payload) {
  $data .= "<script>window.payload=$payload;</script>\n";
}

/*
$trends = @file_get_contents('mart/cache/trends');
if ($trends) {
  $data .= "<script>window.trends=$trends;</script>";
}
$vod = @file_get_contents('mart/cache/vod');
if ($vod) {
  $data .= "\n<script>window.vod=$vod;</script>";
}
$taxonomy = @file_get_contents('mart/cache/taxonomy');
if ($taxonomy) {
  $data .= "\n<script>window.taxonomy=$taxonomy;</script>";
}
*/

// collect dynamic payload
$payload = "$prereqs $critical $contextual $optional $lazy $data";

// main index
$index = file_get_contents('main.html');

// replace client-side load instruction with constructed payload
$index = str_replace('<link rel="import" href="imports.html">', $payload, $index);

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