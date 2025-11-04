<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');

// PriceDao i ServiceDao su u istom folderu kao ovaj test
require_once __DIR__ . '/PriceDao.php';
require_once __DIR__ . '/ServiceDao.php';

try {
    $priceDao   = new PriceDao();
    $serviceDao = new ServiceDao();

    // 1) Osiguraj service_id za cijenu
    $createdServiceId = null;
    $serviceIdToUse   = null;

    if (method_exists($serviceDao, 'create')) {
        // Napravi privremeni service da test bude samodostatan
        $createdServiceId = $serviceDao->create([
            'name'        => 'Test Service for Price ' . uniqid('', false),
            'description' => 'Temporary service for price test'
        ]);
        $serviceIdToUse = $createdServiceId;
    } else {
        // Ako BaseDao nema create(), probaj uzeti prvi postojeći service
        if (method_exists($serviceDao, 'getAll')) {
            $allServices = $serviceDao->getAll();
            if (!empty($allServices)) {
                $serviceIdToUse = (int)$allServices[0]['service_id'];
            } else {
                throw new RuntimeException(
                    'Nema dostupnih servisa u bazi, a BaseDao nema create(). ' .
                    'Dodaj barem jedan red u services ili implementiraj create() u BaseDao.'
                );
            }
        } else {
            throw new RuntimeException(
                'ServiceDao nema getAll() i BaseDao nema create(). ' .
                'Test ne može osigurati service_id.'
            );
        }
    }

    // 2) CREATE price (koristi BaseDao::create)
    if (!method_exists($priceDao, 'create')) {
        throw new RuntimeException('BaseDao nema create($data) metodu. Dodaj je u BaseDao.');
    }

    $newPriceId = $priceDao->create([
        'service_id'   => $serviceIdToUse,
        'package_name' => 'Test Package',
        'price'        => 99.99,
        'description'  => 'Temporary price for test'
    ]);

    // 3) UPDATE cijene (tvoja metoda)
    $updated = $priceDao->updatePriceById($newPriceId, 109.99);

    // 4) READ (sve cijene)
    $allPrices = method_exists($priceDao, 'getAll') ? $priceDao->getAll() : [];

    // 5) DELETE price (BaseDao::delete)
    $deletedPrice = method_exists($priceDao, 'delete') ? $priceDao->delete($newPriceId) : false;

    // 6) Po potrebi očisti i privremeni service
    $deletedService = false;
    if ($createdServiceId !== null && method_exists($serviceDao, 'delete')) {
        $deletedService = $serviceDao->delete($createdServiceId);
    }

    echo json_encode([
        'ok'                 => true,
        'created_service_id' => $createdServiceId,  // null ako je koristio postojeći
        'created_price_id'   => $newPriceId,
        'update_success'     => $updated,
        'delete_price'       => $deletedPrice,
        'delete_service'     => $deletedService,
        'all_after_ops'      => $allPrices
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
