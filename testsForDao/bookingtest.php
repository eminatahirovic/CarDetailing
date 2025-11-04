<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/BookingDao.php';
require_once __DIR__ . '/ServiceDao.php';
require_once __DIR__ . '/UserDao.php';

try {
    $bookingDao = new BookingDao();
    $serviceDao = new ServiceDao();
    $userDao    = new UserDao();

    // 1️⃣ — Osiguraj user_id
    $createdUserId = null;
    $userIdToUse = null;

    if (method_exists($userDao, 'create')) {
        $createdUserId = $userDao->create([
            'name'     => 'Booking Test User',
            'lastname' => 'Temp',
            'email'    => 'booking' . uniqid() . '@test.com',
            'password' => password_hash('12345', PASSWORD_BCRYPT)
        ]);
        $userIdToUse = $createdUserId;
    } else {
        $users = method_exists($userDao, 'getAll') ? $userDao->getAll() : [];
        if (!empty($users)) {
            $userIdToUse = (int)$users[0]['user_id'];
        } else {
            throw new RuntimeException('Nema dostupnih usera u bazi, a BaseDao nema create().');
        }
    }

    // 2️⃣ — Osiguraj service_id
    $createdServiceId = null;
    $serviceIdToUse = null;

    if (method_exists($serviceDao, 'create')) {
        $createdServiceId = $serviceDao->create([
            'name'        => 'Booking Test Service ' . uniqid(),
            'description' => 'Temporary booking test service'
        ]);
        $serviceIdToUse = $createdServiceId;
    } else {
        $services = method_exists($serviceDao, 'getAll') ? $serviceDao->getAll() : [];
        if (!empty($services)) {
            $serviceIdToUse = (int)$services[0]['service_id'];
        } else {
            throw new RuntimeException('Nema dostupnih servisa u bazi, a BaseDao nema create().');
        }
    }

    // 3️⃣ — CREATE booking (koristi tvoju metodu)
    $date = date('Y-m-d');
    $time = date('H:i:s', strtotime('+1 hour'));
    $created = $bookingDao->createBooking($userIdToUse, $serviceIdToUse, $date, $time);

    // 4️⃣ — Dohvati sve (getAllBookings)
    $allBookings = $bookingDao->getAllBookings();

    // 5️⃣ — Uzmi ID zadnjeg (najnovijeg) bookinga
    $createdBookingId = !empty($allBookings) ? (int)$allBookings[0]['booking_id'] : null;

    // 6️⃣ — Update status
    $updated = false;
    if ($createdBookingId) {
        $updated = $bookingDao->updateStatus($createdBookingId, 'confirmed');
    }

    // 7️⃣ — Delete booking
    $deletedBooking = false;
    if ($createdBookingId) {
        $deletedBooking = $bookingDao->deleteBooking($createdBookingId);
    }

    // 8️⃣ — Po potrebi očisti privremeni service i user
    $deletedService = false;
    $deletedUser = false;
    if ($createdServiceId && method_exists($serviceDao, 'delete')) {
        $deletedService = $serviceDao->delete($createdServiceId);
    }
    if ($createdUserId && method_exists($userDao, 'delete')) {
        $deletedUser = $userDao->delete($createdUserId);
    }

    echo json_encode([
        'ok'                 => true,
        'created_user_id'    => $createdUserId,
        'created_service_id' => $createdServiceId,
        'created_booking_id' => $createdBookingId,
        'update_success'     => $updated,
        'delete_booking'     => $deletedBooking,
        'delete_service'     => $deletedService,
        'delete_user'        => $deletedUser,
        'all_after_ops'      => $allBookings
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
