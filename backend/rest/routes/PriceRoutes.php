<?php
Flight::route('OPTIONS *', function() {
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET,POST,PUT,PATCH,DELETE,OPTIONS');
  header('Access-Control-Allow-Headers: Content-Type, Authorization');
  Flight::halt(204);
});
if (!function_exists('payload')) {
  function payload() {
    $raw = Flight::request()->getBody();
    if ($raw) {
      $json = json_decode($raw, true);
      if (json_last_error() === JSON_ERROR_NONE) return $json;
    }
    return Flight::request()->data->getData();
  }
}

// GET all prices
Flight::route('GET /prices', function() {
  Flight::json(Flight::priceService()->getAll());
});

// GET price by ID
Flight::route('GET /prices/@id', function($id) {
  Flight::json(Flight::priceService()->getById($id));
});

// CREATE price
Flight::route('POST /prices', function(){
   $data = Flight::request()->data->getData();
   Flight::json(Flight::priceService()->addPrice($data));
});

// UPDATE price (PUT)
Flight::route('PUT /prices/@id', function($id) {
  $data = Flight::request()->data->getData();
  Flight::json(Flight::priceService()->updatePrice($id, $data));
});

// PARTIAL UPDATE (PATCH)
Flight::route('PATCH /prices/@id', function($id) {
  $data = Flight::request()->data->getData();
  Flight::json(Flight::priceService()->partial_update($id, $data));
});

// DELETE price
Flight::route('DELETE /prices/@id', function($id) {
  Flight::json(Flight::priceService()->delete($id));
});
