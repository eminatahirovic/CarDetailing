<?php


require_once 'BaseService.php';
require_once __DIR__ . '/../dao/UserDao.php'; 


    
    class UserService extends BaseService {
   public function __construct() {
       $dao = new UserDao();
       parent::__construct($dao);
   }

    public function add_patient($patient){
        return $this->user_dao->add_user($user); 
    }
}
