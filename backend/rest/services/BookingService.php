<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/BookingDao.php';


class BookingService extends BaseService {
    public function __construct() {
        parent::__construct(new BookingDao());
    }

    public function create($data) {
        return $this->dao->create($data);
    }

    public function partial_update($id, $data) {
        return $this->dao->update($id, $data);
    }

    public function getByUserId($user_id) {
        if (method_exists($this->dao, 'getUserBookings')) {
            return $this->dao->getUserBookings($user_id);
        }
        return [];
    }
}