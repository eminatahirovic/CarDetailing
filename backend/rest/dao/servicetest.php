<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');

// ServiceDao je u istom folderu kao i ovaj test
require_once __DIR__ . '/ServiceDao.php';

try {
    $dao = new ServiceDao();

    // 1️⃣ CREATE – koristi BaseDao::create()
    if (!method_exists($dao, 'create')) {
        throw new RuntimeException('BaseDao nema create($data) metodu.');
    }

    $newId = $dao->create([
        'name'        => 'Test Service',
        'description' => 'Temporary test description'
    ]);

    // 2️⃣ READ BY NAME – koristi tvoju funkciju getByName()
    $fetched = $dao->getByName('Test Service');

    // 3️⃣ GET ALL – koristi BaseDao::getAll()
    $all = method_exists($dao, 'getAll') ? $dao->getAll() : [];

    // 4️⃣ DELETE – koristi BaseDao::delete()
    $deleted = method_exists($dao, 'delete') ? $dao->delete($newId) : false;

    // 5️⃣ Rezultat
    echo json_encode([
        'ok'              => true,
        'created_service_id' => $newId,
        'fetched_by_name' => $fetched,
        'delete_success'  => $deleted,
        'all_after_ops'   => $all
    ], JSON_PRETTY_PRINT);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'ok'   => false,
        'err'  => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ], JSON_PRETTY_PRINT);
}
