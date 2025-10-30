<?php
require_once 'BaseDao.php';

class PriceDao extends BaseDao {
    protected $table;

    public function __construct() {
        $this->table = "prices";
        parent::__construct($this->table, 'price_id');
    }


    public function updatePriceById($price_id, $price) {
        $stmt = $this->connection->prepare("UPDATE " . $this->table . " SET price = :price WHERE price_id = :price_id");
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':price_id', $price_id);
        return $stmt->execute();
    } //updates prices 

}
?>
