<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');

// TeamDao je u ISTOM folderu kao ovaj test
require_once __DIR__ . '/TeamDao.php';

try {
    $dao = new TeamDao();

    // 1) CREATE (oslanja se na BaseDao::create)
    if (!method_exists($dao, 'create')) {
        throw new RuntimeException('BaseDao nema create($data) metodu.');
    }
    $newId = $dao->create([
        'name'   => 'Test User',
        'role'   => 'Detailer',
        'status' => 'active'
    ]);

    // 2) UPDATE (tvoja funkcija)
    $updated = $dao->updateTeamMemberById($newId, 'Test User Edited', 'Lead Detailer', 'inactive');

    // 3) READ (BaseDao::getAll)
    $all = method_exists($dao, 'getAll') ? $dao->getAll() : [];

    // 4) DELETE (BaseDao::delete)
    $deleted = method_exists($dao, 'delete') ? $dao->delete($newId) : false;

    echo json_encode([
        'ok'                => true,
        'created_team_id'   => $newId,
        'update_success'    => $updated,
        'delete_success'    => $deleted,
        'all_after_ops'     => $all
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
