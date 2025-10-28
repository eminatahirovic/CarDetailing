<?php
require_once 'BaseDao.php';

class BookingDao extends BaseDao {
    protected $table;

    public function __construct() {
        $this->table = "bookings";
        parent::__construct($this->table, 'booking_id'); 
    }
}
?>
