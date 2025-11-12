<?php
require_once __DIR__ . "/../../config.php"; 


class BaseDao{
    protected $connection; 
    private $table; 
    private $idColumn; 

    public function __construct($table, $idColumn = 'user_id'){
        $this->table = $table; 
        $this->idColumn = $idColumn;

        try{
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
        }
    }

    public function getAll() {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE " . $this->idColumn . " = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

//     public function create(array $data): int {
//         $columns = array_keys($data);
//         $placeholders = array_map(fn($col) => ':' . $col, $columns);
//         $sql = "INSERT INTO `{$this->table}` (`" . implode("`,`", $columns) . "`)
//             VALUES (" . implode(",", $placeholders) . ")";
//         $stmt = $this->connection->prepare($sql);
//         $stmt->execute($data);
//         return (int)$this->connection->lastInsertId();
// }

/*public function create($entity) {
    // $entity is an associative array: ['name' => '...', 'email' => '...', ...]
    $columns = array_keys($entity); // ['name', 'lastname', 'email', 'password']
    $columnList = implode(", ", $columns);
    $placeholders = ":" . implode(", :", $columns);
    $sql = "INSERT INTO {$this->table} ({$columnList}) VALUES ({$placeholders})";
    $stmt = $this->connection->prepare($sql);
    $stmt->execute($entity);
    $entity[$this->idColumn] = $this->connection->lastInsertId();
    return $entity;
} */

    // CREATE (POST)
    public function create(array $data) {
        if (empty($data)) {
            throw new Exception("No data to insert");
        }

        $columns = array_keys($data);
        $placeholders = array_map(fn($c) => ':' . $c, $columns);

        $sql = "INSERT INTO `{$this->table}` (`" . implode("`,`", $columns) . "`)
                VALUES (" . implode(",", $placeholders) . ")";
        $stmt = $this->connection->prepare($sql);

        // Bind all params
        foreach ($data as $col => $val) {
            $stmt->bindValue(':' . $col, $val);
        }
        $stmt->execute();

        $id = (int)$this->connection->lastInsertId();
        return $this->getById($id);
    }




// UPDATE (PUT)
  public function update($id, array $data) {
        if (empty($data)) {
            // Avoid "UPDATE table SET  WHERE id = :id"
            return $this->getById($id);
        }

        $set = [];
        foreach ($data as $col => $val) {
            $set[] = "`{$col}` = :{$col}";
        }

        $sql = "UPDATE `{$this->table}` SET " . implode(", ", $set) .
               " WHERE `{$this->idColumn}` = :id";

        $stmt = $this->connection->prepare($sql);
        foreach ($data as $col => $val) {
            $stmt->bindValue(':' . $col, $val);
        }
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $this->getById($id);
    }




    public function insert($data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO " . $this->table . " ($columns) VALUES ($placeholders)";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute($data);
    }
    

    /*public function update($id, $data) {
        $fields = "";
        foreach ($data as $key => $value) {
            $fields .= "$key = :$key, ";
        }
        $fields = rtrim($fields, ", ");
        $sql = "UPDATE " . $this->table . " SET $fields WHERE " . $this->idColumn . " = :id";
        $stmt = $this->connection->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }
*/

    public function delete($id) {
    $sql = "DELETE FROM `{$this->table}` WHERE `{$this->idColumn}` = :id";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}


}
