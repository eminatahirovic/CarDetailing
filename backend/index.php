<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}


require 'vendor/autoload.php';

require_once __DIR__ . '/rest/services/UserService.php';
require_once __DIR__ . '/rest/services/TeamService.php';
require_once __DIR__ . '/rest/services/ServiceService.php';
require_once __DIR__ . '/rest/services/PriceService.php';
require_once __DIR__ . '/rest/services/BookingService.php';
require_once __DIR__ . '/rest/services/AuthService.php';
require_once __DIR__ . '/middleware/AuthMiddleware.php';
require_once __DIR__ . '/rest/routes/test.php';



Flight::register('userService', 'UserService');
Flight::register('teamService', 'TeamService');
Flight::register('serviceService', 'ServiceService');
Flight::register('priceService', 'PriceService');
Flight::register('bookingService', 'BookingService');
Flight::register('authService', 'AuthService');
Flight::register('authMiddleware', 'AuthMiddleware');

Flight::route('/*', function() {
   if (
       strpos(Flight::request()->url, '/auth/login') === 0 ||
       strpos(Flight::request()->url, '/auth/register') === 0
   ) {
       return true; 
   } else {
       try {
           $token = Flight::request()->getHeader("Authorization"); 
           $token = str_replace('Bearer ', '', $token);
           if (Flight::auth_middleware()->verifyToken($token))
               return true;
       } catch (\Exception $e) {
           Flight::halt(401, $e->getMessage());
       }
   }
});


require_once __DIR__ . '/rest/routes/AuthRoutes.php';
require_once __DIR__ . '/rest/routes/UserRoutes.php';
require_once __DIR__ . '/rest/routes/TeamRoutes.php';
require_once __DIR__ . '/rest/routes/ServiceRoutes.php';
require_once __DIR__ . '/rest/routes/PriceRoutes.php';
require_once __DIR__ . '/rest/routes/BookingRoutes.php';


Flight::start();