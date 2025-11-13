<?php

// GET all services
Flight::route('GET /services', function() {
  Flight::json(Flight::serviceService()->getAll());
});

// GET service by ID
Flight::route('GET /services/@id', function($id) {
  Flight::json(Flight::serviceService()->getById($id));
});

// CREATE service
Flight::route('POST /services', function() {
  $data = Flight::request()->data->getData();
  Flight::json(Flight::serviceService()->create($data));
});

// UPDATE service
Flight::route('PUT /services/@id', function($id) {
  $data = Flight::request()->data->getData();
  Flight::json(Flight::serviceService()->update($id, $data));
});

// PARTIAL UPDATE
Flight::route('PATCH /services/@id', function($id) {
  $data = Flight::request()->data->getData();
  Flight::json(Flight::serviceService()->partial_update($id, $data));
});

// DELETE service
Flight::route('DELETE /services/@id', function($id) {
  Flight::json(Flight::serviceService()->delete($id));
});
