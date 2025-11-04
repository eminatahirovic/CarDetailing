<?php
require_once 'BaseService.php';
require_once 'ServiceDao.php';



   class ServiceService extends BaseService {
   public function __construct() {
       $dao = new ServiceDao();
       parent::__construct($dao);
   }

}