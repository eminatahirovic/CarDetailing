<?php

// Get all services
Flight::route('GET /services', function() {
    Flight::json(Flight::serviceService()->getAll());
});

// Get single service by ID
Flight::route('GET /services/@id', function($id) {
    Flight::json(Flight::serviceService()->getById($id));
});

// Create new service
Flight::route('POST /services', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::serviceService()->create($data));
});

// Update service
Flight::route('PUT /services/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::serviceService()->update($id, $data));
});

// Partial update (optional)
Flight::route('PATCH /services/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::serviceService()->update($id, $data));
});

// Delete service
Flight::route('DELETE /services/@id', function($id) {
    Flight::json(Flight::serviceService()->delete($id));
});
