<?php

Flight::route('GET /test', function () {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT . ";charset=utf8mb4",
            DB_USER,
            DB_PASSWORD,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        Flight::json([
            "success" => true,
            "message" => "Database connection successful"
        ]);

    } catch (PDOException $e) {
        Flight::json([
            "success" => false,
            "error" => $e->getMessage()
        ], 500);
    }
});
