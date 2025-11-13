<?php

// GET all users
Flight::route('GET /users', function() {
  Flight::json(Flight::userService()->getUsers());
});

// GET user by ID
Flight::route('GET /users/@id', function($id) {
  Flight::json(Flight::userService()->getById($id));
});

// CREATE user
Flight::route('POST /users', function(){
   $data = Flight::request()->data->getData();
   Flight::json(Flight::userService()->addUser($data));
});


// UPDATE user (PUT)
Flight::route('PUT /users/@id', function($id) {
  $data = Flight::request() ->data->getData; 
  Flight::json(Flight::userService()->update($id, $data));
});

// PARTIAL UPDATE user (PATCH)
Flight::route('PATCH /users/@id', function($id) {
  $data = Flight::request() ->data->getData; 
  Flight::json(Flight::userService()->partial_update($id, $data));
});

// DELETE user
Flight::route('DELETE /users/@id', function($id) {
  Flight::json(Flight::userService()->delete($id));
});
