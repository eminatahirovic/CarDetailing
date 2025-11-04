<?php
require_once 'BaseService.php';
require_once 'TeamDao.php';


class TeamService extends BaseService {
   public function __construct() {
       $dao = new TeamDao();
       parent::__construct($dao);
   }


 public function updateTeamMemberById($team_id, $name, $role, $status) {
       return $this->dao->updateTeamMemberById($team_id, $name, $role, $status);
   }

}