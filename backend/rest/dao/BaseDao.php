<?php
require_once __DIR__ . "/../../config.php"; 

class BaseDao{
    protected $connection; 
    private $table; 

    public function __construct($table){
        $this->table = $table; 

        try{
               // establishes the database connection using constants from config.php
               $this->connection = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT . ";charset=utf8mb4",
                DB_USER, 
                DB_PASSWORD, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
                 );

        } catch(PDOException $e){
            throw $e; 
        }  //fetches elements as an associative array

    }

     public function getAll() {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table);
        $stmt->execute();
        return $stmt->fetchAll();
   }

     public function getById($id) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $id);
        $stmt->execute();
        return $stmt->fetch();
   }

     public function insert($data) {
       $columns = implode(", ", array_keys($data));
       $placeholders = ":" . implode(", :", array_keys($data));
       $sql = "INSERT INTO " . $this->table . " ($columns) VALUES ($placeholders)";
       $stmt = $this->connection->prepare($sql);
       return $stmt->execute($data);
   }

     public function update($id, $data) {
       $fields = "";
       foreach ($data as $key => $value) {
           $fields .= "$key = :$key, ";
       }
       $fields = rtrim($fields, ", ");
       $sql = "UPDATE " . $this->table . " SET $fields WHERE user_id = :user_id";
       $stmt = $this->connection->prepare($sql);
       $data['user_id'] = $id;
       return $stmt->execute($data);
   }

     public function delete($id) {
       $stmt = $this->connection->prepare("DELETE FROM " . $this->table . " WHERE user_id = :user_id");
       $stmt->bindParam(':user_id', $id);
       return $stmt->execute();
   }

}

 

