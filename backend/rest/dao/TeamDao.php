<?php
require_once 'BaseDao.php';

class TeamDao extends BaseDao {
    protected $table;

    public function __construct() {
        $this->table = "team";
        parent::__construct($this->table, 'team_id');
    }

}
?>
