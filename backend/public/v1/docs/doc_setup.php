<?php

/**
 * @OA\Info(
 *     title="Car Detailing API",
 *     version="1.0.0",
 *     description="API documentation for the Car Detailing project. This API manages users, teams, bookings, prices, and services.",
 *     @OA\Contact(
 *         email="support@cardetailing.com",
 *         name="Car Detailing API Support"
 *     )
 * )
 */

/**
 * @OA\Server(
 *     url="http://localhost/CarDetailing/backend",
 *     description="Local development server for Car Detailing API"
 * )
 */


/**
 * @OA\SecurityScheme(
 *     securityScheme="ApiKey",
 *     type="apiKey",
 *     in="header",
 *     name="Authentication"
 * )
 */
