<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Flight::group('/auth', function() {
   /**
     * @OA\Post(
     *     path="/auth/register",
     *     summary="Register new user",
     *     description="Add a new user (name, lastname, email, password)",
     *     tags={"auth"},
     *     @OA.RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","lastname","email","password"},
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 example="John",
     *                 description="User first name"
     *             ),
     *             @OA\Property(
     *                 property="lastname",
     *                 type="string",
     *                 example="Doe",
     *                 description="User last name"
     *             ),
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 example="john@example.com",
     *                 description="User email"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 example="secret123",
     *                 description="User password"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="User registered successfully"),
     *     @OA\Response(response=500, description="Internal server error")
     * )
     */
   Flight::route('/*', function() {
   if (
       strpos(Flight::request()->url, '/auth/login') === 0 ||
       strpos(Flight::request()->url, '/auth/register') === 0
   ) {
       return true;
   } else {
       try {
           $token = Flight::request()->getHeader("Authorization"); // Changed from "Authentication"
           $token = str_replace('Bearer ', '', $token);
           if (Flight::auth_middleware()->verifyToken($token))
               return true;
       } catch (\Exception $e) {
           Flight::halt(401, $e->getMessage());
       }
   }
});

   /**
    * @OA\Post(
    *      path="/auth/login",
    *      tags={"auth"},
    *      summary="Login to system using email and password",
    *      @OA\Response(
    *           response=200,
    *           description="User data and JWT"
    *      ),
    *      @OA\RequestBody(
    *          description="Login credentials",
    *          required=true,
    *          @OA\JsonContent(
    *              required={"email","password"},
    *              @OA\Property(
    *                  property="email",
    *                  type="string",
    *                  example="john@example.com",
    *                  description="User email address"
    *              ),
    *              @OA\Property(
    *                  property="password",
    *                  type="string",
    *                  example="secret123",
    *                  description="User password"
    *              )
    *          )
    *      )
    * )
    */

   Flight::route('POST /login', function() {
        $data = json_decode(Flight::request()->getBody(), true);

        if (!is_array($data)) {
            Flight::halt(400, 'Invalid request payload');
        }

        $response = Flight::auth_service()->login($data);

        if ($response['success']) {
            Flight::json([
                'message' => 'User logged in successfully',
                'data' => $response['data']
            ]);
        } else {
            Flight::halt(401, $response['error']);
        }
   });
});
?>
