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

function validate_booking_payload($data, $is_partial = false) {
  $fields = [];
  $clean = $data;

  if (!$is_partial || array_key_exists('user_id', $data)) {
    $user_id = $data['user_id'] ?? null;
    if ($user_id === null || $user_id === '') {
      $fields['user_id'] = 'User is required.';
    } elseif (!is_valid_int($user_id)) {
      $fields['user_id'] = 'User must be a number.';
    } else {
      $clean['user_id'] = (int)$user_id;
    }
  }

  if (!$is_partial || array_key_exists('service_id', $data)) {
    $service_id = $data['service_id'] ?? null;
    if ($service_id === null || $service_id === '') {
      $fields['service_id'] = 'Service is required.';
    } elseif (!is_valid_int($service_id)) {
      $fields['service_id'] = 'Service must be a number.';
    } else {
      $clean['service_id'] = (int)$service_id;
    }
  }

  if (array_key_exists('team_id', $data)) {
    $team_id = $data['team_id'];
    if ($team_id !== null && $team_id !== '' && !is_valid_int($team_id)) {
      $fields['team_id'] = 'Team must be a number.';
    } elseif ($team_id !== null && $team_id !== '') {
      $clean['team_id'] = (int)$team_id;
    }
  }

  if (!$is_partial || array_key_exists('booking_date', $data)) {
    $booking_date = sanitize_string($data['booking_date'] ?? '');
    if ($booking_date === '') {
      $fields['booking_date'] = 'Booking date is required.';
    } elseif (!is_valid_datetime($booking_date)) {
      $fields['booking_date'] = 'Booking date is invalid.';
    } else {
      $clean['booking_date'] = $booking_date;
    }
  }

  return [$clean, $fields];
}


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
  if (!is_array($data) || empty($data)) {
    $data = json_decode(Flight::request()->getBody(), true);
  }
  if (!is_array($data)) {
    validation_error('Invalid request payload');
    return;
  }

  list($clean, $fields) = validate_booking_payload($data, false);
  if (!empty($fields)) {
    validation_error('Please correct the highlighted fields.', $fields);
    return;
  }

  Flight::json(Flight::bookingService()->create($clean));
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
  if (!is_array($data) || empty($data)) {
    $data = json_decode(Flight::request()->getBody(), true);
  }
  if (!is_array($data)) {
    validation_error('Invalid request payload');
    return;
  }

  list($clean, $fields) = validate_booking_payload($data, false);
  if (!empty($fields)) {
    validation_error('Please correct the highlighted fields.', $fields);
    return;
  }

  Flight::json(Flight::bookingService()->update($id, $clean));
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
  if (!is_array($data) || empty($data)) {
    $data = json_decode(Flight::request()->getBody(), true);
  }
  if (!is_array($data)) {
    validation_error('Invalid request payload');
    return;
  }

  list($clean, $fields) = validate_booking_payload($data, true);
  if (!empty($fields)) {
    validation_error('Please correct the highlighted fields.', $fields);
    return;
  }

  Flight::json(Flight::bookingService()->partial_update($id, $clean));
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
    // Get bookings for this user
    if (!is_valid_int($user_id)) {
        validation_error('Invalid user id', ['user_id' => 'User id must be a number.']);
        return;
    }
    $bookings = Flight::bookingService()->getByUserId((int)$user_id);
    
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
