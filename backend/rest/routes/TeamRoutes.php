<?php
Flight::route('OPTIONS *', function() {
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET,POST,PUT,PATCH,DELETE,OPTIONS');
  header('Access-Control-Allow-Headers: Content-Type, Authorization');
  Flight::halt(204);
});
if (!function_exists('payload')) {
  function payload() {
    $raw = Flight::request()->getBody();
    if ($raw) {
      $json = json_decode($raw, true);
      if (json_last_error() === JSON_ERROR_NONE) return $json;
    }
    return Flight::request()->data->getData();
  }
}

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
  $data = payload();
  try {
    Flight::json(Flight::teamService()->create($data), 201);
  } catch (Throwable $e) {
    Flight::json(['error' => $e->getMessage()], 400);
  }
});

// UPDATE team member (PUT)
Flight::route('PUT /team/@id', function($id) {
  $data = payload();
  Flight::json(Flight::teamService()->update($id, $data));
});

// PARTIAL UPDATE (PATCH)
Flight::route('PATCH /team/@id', function($id) {
  $data = payload();
  Flight::json(Flight::teamService()->update($id, $data));
});

// DELETE team member
Flight::route('DELETE /team/@id', function($id) {
  Flight::json(Flight::teamService()->delete($id));
});
