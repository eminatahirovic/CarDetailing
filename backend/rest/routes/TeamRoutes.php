<?php
/**
 * @OA\Get(
 *     path="/team",
 *     tags={"Team"},
 *     summary="Get all team members",
 *     @OA\Response(response=200, description="List of team members")
 * )
 */


// GET all team members
Flight::route('GET /team', function() {
  Flight::json(Flight::teamService()->getAll());
});

/**
 * @OA\Get(
 *     path="/team/{id}",
 *     tags={"Team"},
 *     summary="Get team member by ID",
 *     @OA\Parameter(name="id", in="path", required=true),
 *     @OA\Response(response=200, description="Team member found")
 * )
 */


// GET team member by ID
Flight::route('GET /team/@id', function($id) {
  Flight::json(Flight::teamService()->getById($id));
});

/**
 * @OA\Post(
 *     path="/team",
 *     tags={"Team"},
 *     summary="Create new team member",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","role"},
 *             @OA\Property(property="name", type="string", example="John"),
 *             @OA\Property(property="role", type="string", example="Detailer"),
 *             @OA\Property(property="status", type="string", example="active")
 *         )
 *     ),
 *     @OA\Response(
 *     response=200, 
 *     description="Team member created")
 * )
 */


// CREATE team member
Flight::route('POST /team', function() {
  $data = Flight::request()->data->getData();
  Flight::json(Flight::teamService()->create($data));
});

/**
 * @OA\Put(
 *     path="/team/{id}",
 *     tags={"Team"},
 *     summary="Update team member",
 *     @OA\Parameter(name="id", in="path", required=true),
 *     @OA\RequestBody(@OA\JsonContent()),
 *     @OA\Response(response=200, description="Team member updated")
 * )
 */

// UPDATE team member
Flight::route('PUT /team/@id', function($id) {
  $data = Flight::request()->data->getData();
  Flight::json(Flight::teamService()->update($id, $data));
});

/**
 * @OA\Patch(
 *     path="/team/{id}",
 *     tags={"Team"},
 *     summary="Partially update a team member",
 *     description="Update one or more fields of an existing team member.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Team member ID"
 *     ),
 *     @OA\RequestBody(
 *         required=false,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="John Updated"),
 *             @OA\Property(property="role", type="string", example="Senior Detailer"),
 *             @OA\Property(property="status", type="string", example="inactive")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Team member partially updated"
 *     )
 * )
 */

// PARTIAL update
Flight::route('PATCH /team/@id', function($id) {
  $data = Flight::request()->data->getData();
  Flight::json(Flight::teamService()->partial_update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/team/{id}",
 *     tags={"Team"},
 *     summary="Delete team member",
 *     @OA\Parameter(name="id", in="path", required=true),
 *     @OA\Response(response=200, description="Team member deleted")
 * )
 */


// DELETE
Flight::route('DELETE /team/@id', function($id) {
  Flight::json(Flight::teamService()->delete($id));
});
