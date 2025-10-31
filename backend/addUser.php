<?php
require_once __DIR__. . '/rest/services/UserService.php'; 

$user_service = new UserService(); 
$user_service->addUser([]);