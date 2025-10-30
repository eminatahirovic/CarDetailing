<?php
//require_once 'BaseDao.php';
require_once __DIR__ . '/BaseDao.php';


class TeamDao extends BaseDao {
    protected $table;

    public function __construct() {
        $this->table = "team";
        parent::__construct($this->table, 'team_id');
    }

     public function updateTeamMemberById($team_id, $name, $role, $status) {
    $stmt = $this->connection->prepare("
        UPDATE " . $this->table . " 
        SET name = :name, role = :role, status = :status 
        WHERE team_id = :team_id
    ");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':team_id', $team_id);
    return $stmt->execute();
} //used to update team members 

}
?>
