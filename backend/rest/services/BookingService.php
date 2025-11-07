<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/BookingDao.php';


   
class BookingService extends BaseService {
   public function __construct() {
       $dao = new BookingDao();
       parent::__construct($dao);
   }
}