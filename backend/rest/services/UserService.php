<?php


require_once 'BaseService.php';
require_once __DIR__ . '/../dao/UserDao.php'; 


    
   class UserService extends BaseService {
    public function __construct() {
        parent::__construct(new UserDao());
    }


    public function getUsers(){
        return $this->dao->getUsers(); 
    }
}
