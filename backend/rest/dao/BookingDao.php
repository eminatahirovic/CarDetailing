<?php
require_once __DIR__ . '/BaseDao.php';
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);


class BookingDao extends BaseDao {
    protected $table;

    public function __construct() {
        $this->table = "bookings";
        parent::__construct($this->table, 'booking_id'); 
    }

    public function createBooking($user_id, $service_id, $date, $time) {
        $stmt = $this->connection->prepare("
            INSERT INTO " . $this->table . " (user_id, service_id, date, time, status, created_at)
            VALUES (:user_id, :service_id, :date, :time, 'pending', NOW())
        ");
        return $stmt->execute([
            ':user_id'    => $user_id,
            ':service_id' => $service_id,
            ':date'       => $date,
            ':time'       => $time
        ]);
    }

    public function getUserBookings($user_id) {
        $stmt = $this->connection->prepare("
            SELECT * FROM " . $this->table . " 
            WHERE user_id = :user_id 
            ORDER BY date DESC, time DESC
        ");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getBookingsByDate($date) {
        $stmt = $this->connection->prepare("
            SELECT * FROM " . $this->table . " 
            WHERE date = :date 
            ORDER BY time ASC
        ");
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // public function getAllBookings() {
    //     $stmt = $this->connection->query("
    //         SELECT * FROM " . $this->table . " 
    //         ORDER BY date DESC, time DESC
    //     ");
    //     return $stmt->fetchAll();
        
    // }

    // public function updateStatus($booking_id, $status) {
    //     $stmt = $this->connection->prepare("
    //         UPDATE " . $this->table . " 
    //         SET status = :status 
    //         WHERE booking_id = :booking_id
    //     ");
    //     return $stmt->execute([
    //         ':status' => $status, 
    //         ':booking_id' => $booking_id
    //     ]);
    // }

    // public function deleteBooking($booking_id) {
    //     $stmt = $this->connection->prepare("
    //         DELETE FROM " . $this->table . " 
    //         WHERE booking_id = :booking_id
    //     ");
    //     $stmt->bindParam(':booking_id', $booking_id);
    //     return $stmt->execute();
    // }
}
?>
