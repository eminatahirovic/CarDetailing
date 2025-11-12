<?php
// ---- CORS / Preflight (safe to duplicate across files) ----
Flight::route('OPTIONS *', function() {
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET,POST,PUT,PATCH,DELETE,OPTIONS');
  header('Access-Control-Allow-Headers: Content-Type, Authorization');
  Flight::halt(204);
});

// ---- Helper to read JSON or form-data ----
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
  $data = payload();
  try {
    Flight::json(Flight::userService()->create($data), 201);
  } catch (Throwable $e) {
    Flight::json(['error' => $e->getMessage()], 400);
  }
});

// UPDATE user (PUT)
Flight::route('PUT /users/@id', function($id) {
  $data = payload();
  Flight::json(Flight::userService()->update($id, $data));
});

// PARTIAL UPDATE user (PATCH)
Flight::route('PATCH /users/@id', function($id) {
  $data = payload();
  Flight::json(Flight::userService()->update($id, $data));
});

// DELETE user
Flight::route('DELETE /users/@id', function($id) {
  Flight::json(Flight::userService()->delete($id));
});
