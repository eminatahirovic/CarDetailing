<?php


require_once 'BaseService.php';
require_once __DIR__ . '/../dao/UserDao.php'; 


    
   class UserService extends BaseService {
    public function __construct() {
        parent::__construct(new UserDao());
    }

    public function add_patient($patient){
        return $this->user_dao->add_user($user); 
    }
}
