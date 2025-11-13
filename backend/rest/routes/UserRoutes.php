<?php

// GET all users
Flight::route('GET /users', function() {
  Flight::json(Flight::userService()->getAll());
});

// GET user by ID
Flight::route('GET /users/@id', function($id) {
  Flight::json(Flight::userService()->getById($id));
});

// CREATE user
Flight::route('POST /users', function() {
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userService()->create($data));
});

// FULL UPDATE user
Flight::route('PUT /users/@id', function($id) {
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userService()->update($id, $data));
});

// PARTIAL UPDATE user
Flight::route('PATCH /users/@id', function($id) {
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userService()->partial_update($id, $data));
});

// DELETE user
Flight::route('DELETE /users/@id', function($id) {
  Flight::json(Flight::userService()->delete($id));
});
