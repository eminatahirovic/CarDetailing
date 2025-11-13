<?php

// GET all team members
Flight::route('GET /team', function() {
  Flight::json(Flight::teamService()->getAll());
});

// GET team member by ID
Flight::route('GET /team/@id', function($id) {
  Flight::json(Flight::teamService()->getById($id));
});

// CREATE team member
Flight::route('POST /team', function() {
  $data = Flight::request()->data->getData();
  Flight::json(Flight::teamService()->create($data));
});

// UPDATE team member
Flight::route('PUT /team/@id', function($id) {
  $data = Flight::request()->data->getData();
  Flight::json(Flight::teamService()->update($id, $data));
});

// PARTIAL update
Flight::route('PATCH /team/@id', function($id) {
  $data = Flight::request()->data->getData();
  Flight::json(Flight::teamService()->partial_update($id, $data));
});

// DELETE
Flight::route('DELETE /team/@id', function($id) {
  Flight::json(Flight::teamService()->delete($id));
});
