<?php
require_once __DIR__ . '/BaseDao.php';

class UserDao extends BaseDao {

    public function __construct(){
        parent::__construct('users', 'user_id');
    }

// inserts a new user into the database with name, lastname, email, and password
public function addUser($name, $lastname, $email, $password) {
    $stmt = $this->connection->prepare(
        "INSERT INTO users (name, lastname, email, password) 
         VALUES (:name, :lastname, :email, :password)"
    );
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    return $stmt->execute(); // this will return true if the insertion of an user was successful
}


public function getByEmail($email) {
    $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    return $stmt->fetch();
} // retrieves a single user record from the database by their email address
// used to check if a user exists

public function getUsers() {
    return $this->getAll();
}
}