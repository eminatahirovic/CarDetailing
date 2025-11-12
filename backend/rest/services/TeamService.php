<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/TeamDao.php';

class TeamService extends BaseService {
    public function __construct() {
        parent::__construct(new TeamDao());
    }


 public function updateTeamMemberById($team_id, $name, $role, $status) {
       return $this->dao->updateTeamMemberById($team_id, $name, $role, $status);
   }

}