<?php
require_once 'BaseDao.php';

class PriceDao extends BaseDao {
    protected $table;

    public function __construct() {
        $this->table = "prices";
        parent::__construct($this->table, 'price_id');
    }

}
?>
