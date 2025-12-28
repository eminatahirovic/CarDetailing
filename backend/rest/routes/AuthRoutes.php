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
Flight::route('POST /auth/register', function () {

    $data = Flight::request()->data->getData();
    if (!is_array($data) || empty($data)) {
        $data = json_decode(Flight::request()->getBody(), true);
    }
    if (!is_array($data)) {
        validation_error('Invalid request payload');
        return;
    }

    $name = sanitize_string($data['name'] ?? '');
    $lastname = sanitize_string($data['lastname'] ?? '');
    $email = sanitize_string($data['email'] ?? '');
    $password = $data['password'] ?? '';

    $fields = [];
    if ($name === '') $fields['name'] = 'First name is required.';
    if ($lastname === '') $fields['lastname'] = 'Last name is required.';
    if ($email === '') {
        $fields['email'] = 'Email is required.';
    } elseif (!is_valid_email($email)) {
        $fields['email'] = 'Invalid email address.';
    }
    if ($password === '') {
        $fields['password'] = 'Password is required.';
    } elseif (!is_valid_password($password)) {
        $fields['password'] = 'Password must be 8+ chars with letters and numbers.';
    }

    if (!empty($fields)) {
        validation_error('Please correct the highlighted fields.', $fields);
        return;
    }

    $data['name'] = $name;
    $data['lastname'] = $lastname;
    $data['email'] = $email;

    $response = Flight::authService()->register($data);

    if ($response['success']) {
        Flight::json([
            'success' => true,
            'message' => 'User registered successfully',
            'data' => $response['data']
        ], 201);
    } else {
        if ($response['error'] === 'Email already registered.') {
            validation_error('Please correct the highlighted fields.', [
                'email' => 'Email is already registered.'
            ]);
            return;
        }
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
    $data = Flight::request()->data->getData();
    if (!is_array($data) || empty($data)) {
        $data = json_decode(Flight::request()->getBody(), true);
    }
    if (!is_array($data)) {
        validation_error('Invalid request payload');
        return;
    }

    $email = sanitize_string($data['email'] ?? '');
    $password = $data['password'] ?? '';

    $fields = [];
    if ($email === '') {
        $fields['email'] = 'Email is required.';
    } elseif (!is_valid_email($email)) {
        $fields['email'] = 'Invalid email address.';
    }
    if ($password === '') {
        $fields['password'] = 'Password is required.';
    }
    if (!empty($fields)) {
        validation_error('Please correct the highlighted fields.', $fields);
        return;
    }

    $data['email'] = $email;
    
    $response = Flight::authService()->login($data);
    
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

Flight::route('GET /auth/me', function() {
    $token = Flight::request()->getHeader("Authorization");
    $token = str_replace('Bearer ', '', $token);
    if (!$token) {
        Flight::halt(401, 'Missing authentication header');
        return;
    }
    try {
        $decoded = JWT::decode($token, new Key(Config::JWT_SECRET(), 'HS256'));
        Flight::json([
            'success' => true,
            'data' => $decoded->user
        ]);
    } catch (Exception $e) {
        Flight::halt(401, 'Invalid token');
    }
});
?>
