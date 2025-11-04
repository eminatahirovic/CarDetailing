<?php
require_once 'BaseService.php';
require_once 'TeamDao.php';

 public function updateTeamMemberById($team_id, $name, $role, $status) {
       return $this->dao->updateTeamMemberById($team_id, $name, $role, $status);
   }