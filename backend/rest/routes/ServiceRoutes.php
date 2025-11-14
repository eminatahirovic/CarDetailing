<?php

/**
 * @OA\Get(
 *     path="/services",
 *     tags={"Services"},
 *     summary="Get all services",
 *     @OA\Response(response=200, description="List of services")
 * )
 */


// GET all services
Flight::route('GET /services', function() {
  Flight::json(Flight::serviceService()->getAll());
});

/**
 * @OA\Get(
 *     path="/services/{id}",
 *     tags={"Services"},
 *     summary="Get service by ID",
 *     @OA\Parameter(name="id", in="path", required=true),
 *     @OA\Response(response=200, description="Service found")
 * )
 */


// GET service by ID
Flight::route('GET /services/@id', function($id) {
  Flight::json(Flight::serviceService()->getById($id));
});

/**
 * @OA\Post(
 *     path="/services",
 *     tags={"Services"},
 *     summary="Create new service",
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
  $data = Flight::request()->data->getData();
  Flight::json(Flight::serviceService()->create($data));
});

/**
 * @OA\Put(
 *     path="/services/{id}",
 *     tags={"Services"},
 *     summary="Update service",
 *     @OA\Parameter(name="id", in="path", required=true),
 *     @OA\RequestBody(@OA\JsonContent()),
 *     @OA\Response(response=200, description="Service updated")
 * )
 */


// UPDATE service
Flight::route('PUT /services/@id', function($id) {
  $data = Flight::request()->data->getData();
  Flight::json(Flight::serviceService()->update($id, $data));
});

/**
 * @OA\Patch(
 *     path="/services/{id}",
 *     tags={"Services"},
 *     summary="Partially update a service",
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
  $data = Flight::request()->data->getData();
  Flight::json(Flight::serviceService()->partial_update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/services/{id}",
 *     tags={"Services"},
 *     summary="Delete service",
 *     @OA\Parameter(name="id", in="path", required=true),
 *     @OA\Response(response=200, description="Service deleted")
 * )
 */


// DELETE service
Flight::route('DELETE /services/@id', function($id) {
  Flight::json(Flight::serviceService()->delete($id));
});
