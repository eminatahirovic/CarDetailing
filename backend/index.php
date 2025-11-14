<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';

// SERVICES
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

// ROUTES
require_once __DIR__ . '/rest/routes/UserRoutes.php';
require_once __DIR__ . '/rest/routes/TeamRoutes.php';
require_once __DIR__ . '/rest/routes/ServiceRoutes.php';
require_once __DIR__ . '/rest/routes/PriceRoutes.php';
require_once __DIR__ . '/rest/routes/BookingRoutes.php';

Flight::start();
