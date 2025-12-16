<?php
/**
 * @OA\Get(
 *     path="/bookings",
 *     tags={"Bookings"},
 *     summary="Get all bookings",
 *     security={{"BearerAuth": {}}},
 *     description="Returns a list of all bookings",
 *     @OA\Response(
 *         response=200,
 *         description="List of bookings returned successfully"
 *     )
 * )
 */


// GET all bookings
Flight::route('GET /bookings', function() {
  Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
  Flight::json(Flight::bookingService()->getAll());
});

/**
 * @OA\Get(
 *     path="/bookings/{id}",
 *     tags={"Bookings"},
 *     summary="Get booking by ID",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Booking ID"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Booking found"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Booking not found"
 *     )
 * )
 */


// GET booking by ID
Flight::route('GET /bookings/@id', function($id) {
  Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
  Flight::json(Flight::bookingService()->getById($id));
});

/**
 * @OA\Post(
 *     path="/bookings",
 *     tags={"Bookings"},
 *     summary="Create a new booking",
 *     security={{"BearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"user_id", "service_id", "booking_date"},
 *             @OA\Property(property="user_id", type="integer", example=5),
 *             @OA\Property(property="team_id", type="integer", nullable=true, example=1),
 *             @OA\Property(property="service_id", type="integer", example=3),
 *             @OA\Property(property="booking_date", type="string", example="2025-12-01 14:00:00")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Booking created")
 * )
 */


// CREATE booking
Flight::route('POST /bookings', function() {
  Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
  $data = Flight::request()->data->getData();
  Flight::json(Flight::bookingService()->create($data));
});

/**
 * @OA\Put(
 *     path="/bookings/{id}",
 *     tags={"Bookings"},
 *     summary="Update an existing booking",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(name="id", in="path", required=true),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="user_id", type="integer", example=5),
 *             @OA\Property(property="team_id", type="integer", example=1),
 *             @OA\Property(property="service_id", type="integer", example=3),
 *             @OA\Property(property="booking_date", type="string", example="2025-12-01 14:00:00")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Booking updated")
 * )
 */


// UPDATE booking
Flight::route('PUT /bookings/@id', function($id) {
  Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
  $data = Flight::request()->data->getData();
  Flight::json(Flight::bookingService()->update($id, $data));
});

/**
 * @OA\Patch(
 *     path="/bookings/{id}",
 *     tags={"Bookings"},
 *     summary="Partially update a booking",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(name="id", in="path", required=true),
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             @OA\Property(property="user_id", type="integer"),
 *             @OA\Property(property="team_id", type="integer"),
 *             @OA\Property(property="service_id", type="integer"),
 *             @OA\Property(property="booking_date", type="string")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Booking updated")
 * )
 */


// PARTIAL update
Flight::route('PATCH /bookings/@id', function($id) {
  Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
  $data = Flight::request()->data->getData();
  Flight::json(Flight::bookingService()->partial_update($id, $data));
});


/**
 * @OA\Delete(
 *     path="/bookings/{id}",
 *     tags={"Bookings"},
 *     summary="Delete booking by ID",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(name="id", in="path", required=true),
 *     @OA\Response(response=200, description="Booking deleted")
 * )
 */


// DELETE booking
Flight::route('DELETE /bookings/@id', function($id) {
  Flight::auth_middleware()->authorizeRoles(Roles::ADMIN);
  Flight::json(Flight::bookingService()->delete($id));
});

Flight::route('GET /bookings/user/@user_id', function($user_id) {
    $response = Flight::booking_service()->getByUserId($user_id);
    
    if ($response['success']) {
        Flight::json([
            'message' => 'Bookings retrieved',
            'data' => $response['data']
        ]);
    } else {
        Flight::halt(404, $response['error']);
    }
});
/**
 * @OA\Get(
 *     path="/bookings/user/{user_id}",
 *     tags={"Bookings"},
 *     summary="Get bookings by User ID",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         description="User ID"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Bookings found"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="No bookings found for the user"
 *     )
 * )
 */

Flight::route('GET /bookings/user/@user_id', function($user_id) {
    // Get bookings for this user
    $bookings = Flight::booking_service()->getByUserId($user_id);
    
    if ($bookings) {
        Flight::json([
            'message' => 'Bookings retrieved',
            'data' => $bookings
        ]);
    } else {
        Flight::json([
            'message' => 'No bookings found',
            'data' => []
        ]);
    }
});
/**
 * @OA\Get(
 *     path="/bookings/user/{user_id}",
 *     tags={"Bookings"},
 *     summary="Get bookings by User ID",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         description="User ID"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Bookings found"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="No bookings found for the user"
 *     )
 * )
 */