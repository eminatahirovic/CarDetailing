<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * @OA\Post(
 *     path="/auth/register",
 *     tags={"Authentication"},
 *     summary="Register a new user",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "password", "name"},
 *             @OA\Property(property="email", type="string", example="john@example.com"),
 *             @OA\Property(property="password", type="string", example="secret123"),
 *             @OA\Property(property="name", type="string", example="John Doe")
 *         )
 *     ),
 *     @OA\Response(response=200, description="User registered successfully")
 * )
 */
Flight::route('POST /auth/register', function() {
    $data = json_decode(Flight::request()->getBody(), true);
    
    if (!is_array($data)) {
        Flight::json(['success' => false, 'error' => 'Invalid request payload'], 400);
        return;
    }

    $response = Flight::auth_service()->register($data);
    
    if ($response['success']) {
        Flight::json([
            'success' => true,
            'message' => 'User registered successfully',
            'data' => $response['data']
        ]);
    } else {
        Flight::json([
            'success' => false,
            'error' => $response['error']
        ], 400);
    }
});

/**
 * @OA\Post(
 *     path="/auth/login",
 *     tags={"Authentication"},
 *     summary="Login to system",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "password"},
 *             @OA\Property(property="email", type="string", example="john@example.com"),
 *             @OA\Property(property="password", type="string", example="secret123")
 *         )
 *     ),
 *     @OA\Response(response=200, description="User logged in successfully")
 * )
 */
Flight::route('POST /auth/login', function() {
    $data = json_decode(Flight::request()->getBody(), true);
    
    if (!is_array($data)) {
        Flight::json(['success' => false, 'error' => 'Invalid request payload'], 400);
        return;
    }

    $response = Flight::auth_service()->login($data);
    
    if ($response['success']) {
        Flight::json([
            'success' => true,
            'message' => 'User logged in successfully',
            'data' => $response['data']
        ]);
    } else {
        Flight::json([
            'success' => false,
            'error' => $response['error']
        ], 401);
    }
});
?>