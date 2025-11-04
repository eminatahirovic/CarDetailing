<?php


require_once 'BaseService.php';
require_once __DIR__ . '/../dao/UserDao.php'; 

class UserService {
    
    private $user_dao;

    public function __construct(){
        $this->user_dao = new userDao; 
    }
    public function add_patient($patient){
        return $this->user_dao->add_user($user); 
    }


}