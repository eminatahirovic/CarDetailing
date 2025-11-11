<?php

// Get all price entries
Flight::route('GET /prices', function() {
    Flight::json(Flight::priceService()->getAll());
});

// Get single price by ID
Flight::route('GET /prices/@id', function($id) {
    Flight::json(Flight::priceService()->getById($id));
});

// Create new price entry
Flight::route('POST /prices', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::priceService()->create($data));
});

// Update price
Flight::route('PUT /prices/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::priceService()->update($id, $data));
});

// Partial update
Flight::route('PATCH /prices/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::priceService()->update($id, $data));
});

// Delete price
Flight::route('DELETE /prices/@id', function($id) {
    Flight::json(Flight::priceService()->delete($id));
});
