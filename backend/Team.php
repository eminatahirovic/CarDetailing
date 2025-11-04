 <?php
header('Content-Type: application/json');
require_once __DIR__ . '/../dao/TeamDao.php';

$dao = new TeamDao();
$teams = $dao->getAll(); // inherited from BaseDao
echo json_encode($teams);
