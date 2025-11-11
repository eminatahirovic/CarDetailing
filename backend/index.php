

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'vendor/autoload.php';
require_once __DIR__ . '/config.php';

/*
|--------------------------------------------------------------------------
| REGISTER SERVICES
|--------------------------------------------------------------------------
*/
require_once __DIR__ . '/rest/services/UserService.php';
require_once __DIR__ . '/rest/services/TeamService.php';
require_once __DIR__ . '/rest/services/ServiceService.php';
require_once __DIR__ . '/rest/services/PriceService.php';
require_once __DIR__ . '/rest/services/BookingService.php';

Flight::register('userService', 'UserService');
Flight::register('teamService', 'TeamService');
Flight::register('serviceService', 'ServiceService');
Flight::register('priceService', 'PriceService');
Flight::register('bookingService', 'BookingService');

/*
|--------------------------------------------------------------------------
| CORS HEADERS
|--------------------------------------------------------------------------
| Allow frontend (React, JS, etc.) to access your API from localhost.
*/
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight OPTIONS requests
Flight::route('OPTIONS *', function () {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    exit(0);
});

/*
|--------------------------------------------------------------------------
| INCLUDE ROUTE FILES
|--------------------------------------------------------------------------
*/
require_once __DIR__ . '/rest/routes/UserRoutes.php';
require_once __DIR__ . '/rest/routes/TeamRoutes.php';
require_once __DIR__ . '/rest/routes/ServiceRoutes.php';
require_once __DIR__ . '/rest/routes/PriceRoutes.php';
require_once __DIR__ . '/rest/routes/BookingRoutes.php';

/*
|--------------------------------------------------------------------------
| ROOT ROUTES (for browser testing)
|--------------------------------------------------------------------------
*/
Flight::route('GET /', function () {
    echo 'CarDetailing API is running.';
});

Flight::route('GET /index.php', function () {
    echo 'CarDetailing API is running.';
});

/*
|--------------------------------------------------------------------------
| START FLIGHT
|--------------------------------------------------------------------------
*/
Flight::start();

?> 