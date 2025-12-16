<?php

/**
 * @OA\Get(
 *     path="/prices",
 *     tags={"Prices"},
 *     summary="Get all prices",
 *     security={{"BearerAuth": {}}},
 *     @OA\Response(response=200, description="List of prices")
 * )
 */


// GET all prices
Flight::route('GET /prices', function() {
  Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
  Flight::json(Flight::priceService()->getAll());
});

/**
 * @OA\Get(
 *     path="/prices/{id}",
 *     tags={"Prices"},
 *     summary="Get price by ID",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(name="id", in="path", required=true),
 *     @OA\Response(response=200, description="Price found")
 * )
 */


// GET price by ID
Flight::route('GET /prices/@id', function($id) {
  Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
  Flight::json(Flight::priceService()->getById($id));
});

/**
 * @OA\Post(
 *     path="/prices",
 *     tags={"Prices"},
 *     summary="Create a new price entry",
 *     security={{"BearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"service_id","package_name","price"},
 *             @OA\Property(property="service_id", type="integer", example=1),
 *             @OA\Property(property="package_name", type="string", example="Premium"),
 *             @OA\Property(property="price", type="number", format="float", example=49.99),
 *             @OA\Property(property="description", type="string", example="Full inside/out cleaning")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Price created")
 * )
 */


// CREATE price
Flight::route('POST /prices', function() {
  Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
  $data = Flight::request()->data->getData();
  Flight::json(Flight::priceService()->create($data));
});

/**
 * @OA\Put(
 *     path="/prices/{id}",
 *     tags={"Prices"},
 *     summary="Update price",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(name="id", in="path", required=true),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="service_id", type="integer"),
 *             @OA\Property(property="package_name", type="string"),
 *             @OA\Property(property="price", type="number"),
 *             @OA\Property(property="description", type="string")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Price updated")
 * )
 */


// UPDATE price
Flight::route('PUT /prices/@id', function($id) {
  Flight::auth_middleware()->authorizeRoles(Roles::ADMIN);
  $data = Flight::request()->data->getData();
  Flight::json(Flight::priceService()->update($id, $data));
});

/**
 * @OA\Patch(
 *     path="/prices/{id}",
 *     tags={"Prices"},
 *     summary="Partially update price",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(name="id", in="path", required=true),
 *     @OA\RequestBody(@OA\JsonContent()),
 *     @OA\Response(response=200, description="Price updated")
 * )
 */


// PARTIAL UPDATE
Flight::route('PATCH /prices/@id', function($id) {
  Flight::auth_middleware()->authorizeRoles(Roles::ADMIN);
  $data = Flight::request()->data->getData();
  Flight::json(Flight::priceService()->partial_update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/prices/{id}",
 *     tags={"Prices"},
 *     summary="Delete price by ID",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(name="id", in="path"),
 *     @OA\Response(response=200, description="Price deleted")
 * )
 */


// DELETE
Flight::route('DELETE /prices/@id', function($id) {
  Flight::auth_middleware()->authorizeRoles(Roles::ADMIN);
  Flight::json(Flight::priceService()->delete($id));
});
