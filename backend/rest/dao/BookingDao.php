<?php
require_once 'BaseDao.php';

class BookingDao extends BaseDao {
    protected $table;

    public function __construct() {
        $this->table = "bookings";
        parent::__construct($this->table, 'booking_id'); 
    }
}

     public function createBooking($user_id, $service_id, $date, $time) {
        $stmt = $this->connection->prepare("
            INSERT INTO " . $this->table . " (user_id, service_id, date, time, status, created_at)
            VALUES (:user_id, :service_id, :date, :time, 'pending', NOW())
        ");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':service_id', $service_id);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time', $time);
        return $stmt->execute();
    } //creates new bookings
    

    public function getUserBookings($user_id) {
        $stmt = $this->connection->prepare("
            SELECT * FROM " . $this->table . " 
            WHERE user_id = :user_id 
            ORDER BY date DESC, time DESC
        ");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    } //shows bookings that are made


    public function deleteBooking($booking_id) {
        $stmt = $this->connection->prepare("
            DELETE FROM " . $this->table . " 
            WHERE booking_id = :booking_id
        ");
        $stmt->bindParam(':booking_id', $booking_id);
        return $stmt->execute();
    } // deletes booking if a customer cancels it 
?>
