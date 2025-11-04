<?php
require_once 'BaseService.php';
require_once 'BookingDao.php';

class BookingService extends BaseService {
   public function __construct() {
       $dao = new BookingDao();
       parent::__construct($dao);
   }



   
}