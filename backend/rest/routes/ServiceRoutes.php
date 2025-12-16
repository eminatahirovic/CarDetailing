<?php

/**
 * @OA\Get(
 *     path="/services",
 *     tags={"Services"},
 *     summary="Get all services",
 *     security={{"BearerAuth": {}}},
 *     @OA\Response(response=200, description="List of services")
 * )
 */


// GET all services
Flight::route('GET /services', function() {
  Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
  Flight::json(Flight::serviceService()->getAll());
});

/**
 * @OA\Get(
 *     path="/services/{id}",
 *     tags={"Services"},
 *     summary="Get service by ID",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(name="id", in="path", required=true),
 *     @OA\Response(response=200, description="Service found")
 * )
 */


// GET service by ID
Flight::route('GET /services/@id', function($id) {
  Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
  Flight::json(Flight::serviceService()->getById($id));
});

/**
 * @OA\Post(
 *     path="/services",
 *     tags={"Services"},
 *     summary="Create new service",
 *     security={{"BearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Deep Cleaning"),
 *             @OA\Property(property="description", type="string", example="Full car detailing service")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Service created")
 * )
 */


// CREATE service
Flight::route('POST /services', function() {
  Flight::auth_middleware()->authorizeRoles(Roles::ADMIN);
  $data = Flight::request()->data->getData();
  Flight::json(Flight::serviceService()->create($data));
});

/**
 * @OA\Put(
 *     path="/services/{id}",
 *     tags={"Services"},
 *     summary="Update service",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(name="id", in="path", required=true),
 *     @OA\RequestBody(@OA\JsonContent()),
 *     @OA\Response(response=200, description="Service updated")
 * )
 */


// UPDATE service
Flight::route('PUT /services/@id', function($id) {
  Flight::auth_middleware()->authorizeRoles(Roles::ADMIN);
  $data = Flight::request()->data->getData();
  Flight::json(Flight::serviceService()->update($id, $data));
});

/**
 * @OA\Patch(
 *     path="/services/{id}",
 *     tags={"Services"},
 *     summary="Partially update a service",
 *     security={{"BearerAuth": {}}},
 *     description="Update one or more fields of an existing service",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Service ID"
 *     ),
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Interior Cleaning"),
 *             @OA\Property(property="description", type="string", example="Only interior deep cleaning")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Service partially updated"
 *     )
 * )
 */


// PARTIAL UPDATE
Flight::route('PATCH /services/@id', function($id) {
  Flight::auth_middleware()->authorizeRoles(Roles::ADMIN);
  $data = Flight::request()->data->getData();
  Flight::json(Flight::serviceService()->partial_update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/services/{id}",
 *     tags={"Services"},
 *     summary="Delete service",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(name="id", in="path", required=true),
 *     @OA\Response(response=200, description="Service deleted")
 * )
 */


// DELETE service
Flight::route('DELETE /services/@id', function($id) {
  Flight::auth_middleware()->authorizeRoles(Roles::ADMIN);
  Flight::json(Flight::serviceService()->delete($id));
});
