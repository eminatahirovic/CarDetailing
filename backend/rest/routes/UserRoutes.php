<?php
 /**
 * @OA\Get(
 *     path="/users",
 *     tags={"users"},
 *     summary="Get all users",
 *     @OA\Response(
 *         response=200,
 *         description="Array of all users in the database"
 *     )
 * )
 */

// GET all users
Flight::route('GET /users', function() {
  Flight::json(Flight::userService()->getAll());
});

/**
 * @OA\Get(
 *     path="/users/{id}",
 *     tags={"users"},
 *     summary="Get user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the user",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the user with the given ID"
 *     )
 * )
 */

// GET user by ID
Flight::route('GET /users/@id', function($id) {
  Flight::json(Flight::userService()->getById($id));
});

/**
 * @OA\Post(
 *     path="/users",
 *     tags={"users"},
 *     summary="Create a new user",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name"},
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", example="john@example.com")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="New user created"
 *     )
 * )
 */

// CREATE user
Flight::route('POST /users', function() {
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userService()->create($data));
});

/**
 * @OA\Put(
 *     path="/users/{id}",
 *     tags={"users"},
 *     summary="Update a user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Updated Name"),
 *   @OA\Property(property="lastname", type="string", example="Updated last name"),
 *             @OA\Property(property="email", type="string", example="updated@example.com"),
 *   @OA\Property(property="password", type="string", example="Updated password"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User updated"
 *     )
 * )
 */

// FULL UPDATE user
Flight::route('PUT /users/@id', function($id) {
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userService()->update($id, $data));
});

/**
 * @OA\Patch(
 *     path="/users/{id}",
 *     tags={"users"},
 *     summary="Partially update a user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Only updated name"),
 *             @OA\Property(property="email", type="string", example="optional@example.com")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User partially updated"
 *     )
 * )
 */

// PARTIAL UPDATE user / PATCH
Flight::route('PATCH /users/@id', function($id) {
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userService()->partial_update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/users/{id}",
 *     tags={"users"},
 *     summary="Delete a user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User deleted"
 *     )
 * )
 */

// DELETE user
Flight::route('DELETE /users/@id', function($id) {
  Flight::json(Flight::userService()->delete($id));
});
