<?php
require_once 'BaseDao.php';

class ServiceDao extends BaseDao {
    protected $table;

    public function __construct() {
        $this->table = "services";
        parent::__construct($this->table, 'service_id');
    }

    // retrieves a single service record by its name
    public function getByName($name) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table. " WHERE name = :name");
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        return $stmt->fetch();
    }

}
?>
