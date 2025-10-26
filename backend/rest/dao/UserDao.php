<?php
require_once __DIR__ . '/BaseDao.php';

class UserDao extends BaseDao {

    public function __construct(){
        parent::__construct('users');
    }

    public function add_user($user){
        //still need to add logic 
        return $user;
    }

}