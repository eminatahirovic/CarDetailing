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
 Flight::json(Flight::teamService()->addTeamMember($data));
});

// UPDATE team member (PUT)
Flight::route('PUT /team/@id', function($id) {
  $data = Flight::request()->data->getData();
  Flight::json(Flight::teamService()->update($id, $data));
});

// PARTIAL UPDATE (PATCH)
Flight::route('PATCH /team/@id', function($id) {
  $data = Flight::request()->data->getData();
  Flight::json(Flight::teamService()->partial_update($id, $data));
});

// DELETE team member
Flight::route('DELETE /team/@id', function($id) {
  Flight::json(Flight::teamService()->delete($id));
});
