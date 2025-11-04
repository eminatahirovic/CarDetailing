<?php
require_once 'BaseService.php';
require_once 'ServiceDao.php';

 public function getByName($name) {
       return $this->dao->getByName($name);
   }