<?php

// Get all bookings
Flight::route('GET /bookings', function() {
    Flight::json(Flight::bookingService()->getAll());
});

// Get single booking by ID
Flight::route('GET /bookings/@id', function($id) {
    Flight::json(Flight::bookingService()->getById($id));
});

// Create new booking
Flight::route('POST /bookings', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::bookingService()->create($data));
});

// Update booking
Flight::route('PUT /bookings/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::bookingService()->update($id, $data));
});

// Partial update
Flight::route('PATCH /bookings/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::bookingService()->update($id, $data));
});

// Delete booking
Flight::route('DELETE /bookings/@id', function($id) {
    Flight::json(Flight::bookingService()->delete($id));
});
