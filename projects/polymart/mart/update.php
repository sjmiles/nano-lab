<?php

require('config.php');

/* categories */

// fetch and store raw taxonomy data
$taxonomy = fetch('taxonomy');
file_put_contents('cache/taxonomy-raw.json', $taxonomy);
  
// extract top categories
$taxonomy = JSON_decode($taxonomy)->categories;
$categories = array();
foreach ($taxonomy as &$category) {
  $categories[] = array(
    'name' => $category->name,
    'id' => $category->id
  );
}

// console output
echo "<pre>";
print_r($categories);
echo "</pre>";

// store top categories
$categories = JSON_encode($categories);
file_put_contents('cache/categories.json', $categories);

/* Value Of the Day */

// fetch and store raw VOD data
$vod = fetch('vod');
file_put_contents('cache/vod-raw.json', $vod);

// simplify the product record
$vod = JSON_decode($vod);
$vod = simplify($vod);

// console output
echo "<pre>";
print_r($vod);
echo "</pre>";

// store simplified record
$vod = JSON_encode($vod);
file_put_contents('cache/vod.json', $vod);

/* trends */

// fetch and store raw trends data
$trends = fetch('trends');
file_put_contents('cache/trends-raw.json', $trends);

// simplify product records
$records = JSON_decode($trends)->items;
$items = array();
foreach ($records as &$item) {
  $items[] = simplify($item);
}

// store complete simplified trends records
file_put_contents('cache/trends.json', JSON_encode($items));

// tranche simplified trends records
$slice = array_slice($items, 0, 8);

// console output
echo "<pre>";
print_r($slice);
echo "</pre>";

// store simplifed trend record tranche
$slice = JSON_encode($slice);
file_put_contents('cache/trends-top.json', $slice);

/* payload data */

$payload = "{\n"
  .'"categories": ' . $categories . ",\n"
  .'"vod": ' . $vod . ",\n"
  .'"trends": ' . $slice . "\n"
  .'}';

echo "<hr>";
echo "<pre>";
echo $payload;
echo "</pre>";

file_put_contents('cache/payload.json', $payload);

/* utils */

function fetch($endpoint) {
  global $apikey;
  return file_get_contents("http://api.walmartlabs.com/v1/$endpoint?format=json&apiKey=$apikey");
}

function oneOf($choices) {
  foreach ($choices as $choice) {
    if ($choice) {
      return $choice;
    }
  }
}

function simplify($item) {
  
  return array(
    'itemId' => @$item->itemId,
    'name' => @$item->name,
    //'msrp' => @$item->msrp,
    //'salePrice' => @$item->salePrice,
    'salePrice'=> oneOf(array(@$item->salePrice, @$item->msrp, @$item->bestMarketplacePrice->price, '(na)')),
    'shortDescription' => @$item->shortDescription,
    'thumbnailImage' => @$item->thumbnailImage,
    'customerRating' => @$item->customerRating,
    'customerRatingImage' => @$item->customerRatingImage,
    'numReviews' => @$item->numReviews
  );
  if (@$item->salePrice) {
    $result->salePrice = @$item->salePrice;
  }
}

exit();

$categories = array();
foreach ($taxonomy as $name=>$value) {
  $categories[] = $name;
}
echo implode('<br>', $categories);
exit();


$data = array();
$data[] = get('vod');
$data[] = get('trends');
$data[] = get('taxonomy');
$json = "{\n" . implode(",\n\n", $data) . "\n}";

header('Content-Type: application/json');
echo $json;

function get($endpoint) {
  global $apikey;
  $url = "http://api.walmartlabs.com/v1/$endpoint?format=json&apiKey=$apikey";
  return '"' . $endpoint. '":' . file_get_contents($url);
}

?>