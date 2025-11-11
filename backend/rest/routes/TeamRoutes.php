<?php

//gets all team members
Flight::route('GET /team', function() {
    Flight::json(Flight::teamService()->getAll());
});

// gets member by ID
Flight::route('GET /team/@id', function($id) {
    Flight::json(Flight::teamService()->getById($id));
});

// Create new team member
Flight::route('POST /team', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::teamService()->create($data));
});

// Update team member (full update)
Flight::route('PUT /team/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::teamService()->update($id, $data));
});

// Partial update (optional)
Flight::route('PATCH /team/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::teamService()->update($id, $data));
});

// Delete team member
Flight::route('DELETE /team/@id', function($id) {
    Flight::json(Flight::teamService()->delete($id));
});
