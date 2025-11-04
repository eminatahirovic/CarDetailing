<?php
require_once 'BaseService.php';
require_once 'PriceDao.php';

class PriceService extends BaseService {
   public function __construct() {
       $dao = new PriceDao();
       parent::__construct($dao);
   }
}