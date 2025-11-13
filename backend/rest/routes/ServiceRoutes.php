<?php
// Flight::route('OPTIONS *', function() {
//   header('Access-Control-Allow-Origin: *');
//   header('Access-Control-Allow-Methods: GET,POST,PUT,PATCH,DELETE,OPTIONS');
//   header('Access-Control-Allow-Headers: Content-Type, Authorization');
//   Flight::halt(204);
// });
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

// GET all services
Flight::route('GET /services', function() {
  Flight::json(Flight::serviceService()->getAll());
});

// GET service by ID
Flight::route('GET /services/@id', function($id) {
  Flight::json(Flight::serviceService()->getById($id));
});

// CREATE service
Flight::route('POST /services', function(){
   $data = Flight::request()->data->getData();
   Flight::json(Flight::ServiceService()->addService($data));
});


// UPDATE service (PUT)
Flight::route('PUT /services/@id', function($id) {
  $data = Flight::request()->data->getData(); 
  Flight::json(Flight::serviceService()->update($id, $data));
});

// PARTIAL UPDATE (PATCH)
Flight::route('PATCH /services/@id', function($id) {
  $data = Flight::request()->data->getData(); 
  Flight::json(Flight::serviceService()->partial_update($id, $data));
});

// DELETE service
Flight::route('DELETE /services/@id', function($id) {
  Flight::json(Flight::serviceService()->delete($id));
});
