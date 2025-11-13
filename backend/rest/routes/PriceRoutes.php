<?php

// GET all prices
Flight::route('GET /prices', function() {
  Flight::json(Flight::priceService()->getAll());
});

// GET price by ID
Flight::route('GET /prices/@id', function($id) {
  Flight::json(Flight::priceService()->getById($id));
});

// CREATE price
Flight::route('POST /prices', function() {
  $data = Flight::request()->data->getData();
  Flight::json(Flight::priceService()->create($data));
});

// UPDATE price
Flight::route('PUT /prices/@id', function($id) {
  $data = Flight::request()->data->getData();
  Flight::json(Flight::priceService()->update($id, $data));
});

// PARTIAL UPDATE
Flight::route('PATCH /prices/@id', function($id) {
  $data = Flight::request()->data->getData();
  Flight::json(Flight::priceService()->partial_update($id, $data));
});

// DELETE
Flight::route('DELETE /prices/@id', function($id) {
  Flight::json(Flight::priceService()->delete($id));
});
