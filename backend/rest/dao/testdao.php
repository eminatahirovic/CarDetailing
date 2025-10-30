<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/BaseDao.php';
require_once __DIR__ . '/UserDao.php';



$userDao = new UserDao();
//$userDao->addUser("Emina", "Tahirovic", "test@gmail.com", "emin123");
//$users = $userDao->getUsers();
print_r($users);



// Ako je baza prazna, ubaci jednog test korisnika
// if (count($users) === 0) {
//     echo "➕ Ubacujem test korisnika...\n";
//     $userDao->insert([
//         'name' => 'Test',
//         'lastname' => 'User',
//         'email' => 'test@example.com',
//         'password' => password_hash('secret', PASSWORD_BCRYPT)
//     ]);
//     $users = $userDao->getAll();
//     echo "📋 Poslije inserta korisnika u bazi: " . count($users) . "\n";
// }

// // Nađi korisnika po emailu (ako imaš metodu getByEmail)
// if (method_exists($userDao, 'getByEmail')) {
//     $u = $userDao->getByEmail('test@example.com');
//     echo "🔎 getByEmail('test@example.com') -> user_id: " . ($u['user_id'] ?? 'n/a') . "\n";

//     // Primjer update-a
//     if (!empty($u['user_id'])) {
//         $userDao->update($u['user_id'], ['name' => 'Test2']);
//         $u2 = $userDao->getById($u['user_id']);
//         echo "✏️  Update name -> " . ($u2['name'] ?? 'n/a') . "\n";

//         // Primjer delete-a (po želji, možeš komentarisati)
//         // $userDao->delete($u['user_id']);
//         // $u3 = $userDao->getById($u['user_id']);
//         // echo "🗑️  Deleted? " . (empty($u3) ? "YES" : "NO") . "\n";
//     }
// }
// echo "<hr><pre>";

// require_once __DIR__ . '/ServiceDao.php';
// require_once __DIR__ . '/TeamDao.php';
// require_once __DIR__ . '/PriceDao.php';

// $ts = time();

// echo "[SERVICES]\n";
// $serviceDao = new ServiceDao();
// $svcName = "Test Service $ts";
// $serviceDao->insert(['name'=>$svcName,'description'=>'Test opis']);
// $svc = $serviceDao->getByName($svcName);
// echo "service_id: ".($svc['service_id']??'NULL')."\n";
// if(!empty($svc['service_id'])){
//   $serviceDao->update($svc['service_id'], ['description'=>'Promijenjen opis']);
//   $s2 = $serviceDao->getById($svc['service_id']);
//   echo "description: ".($s2['description']??'')."\n";
// }

// echo "\n[TEAM]\n";
// $teamDao = new TeamDao();
// $teamDao->insert(['name'=>'Test Tech','role'=>'detailer','status'=>'active']);
// $teams = $teamDao->getAll();
// $teamId = $teams ? max(array_column($teams,'team_id')) : null;
// echo "team_id: ".($teamId??'NULL')."\n";
// if($teamId){
//   $teamDao->update($teamId, ['status'=>'inactive']);
//   $t2 = $teamDao->getById($teamId);
//   echo "status: ".($t2['status']??'')."\n";
// }

// echo "\n[PRICES]\n";
// $priceDao = new PriceDao();
// $serviceId = $svc['service_id'] ?? null;
// if(!$serviceId){
//   $allS = $serviceDao->getAll();
//   $serviceId = $allS[0]['service_id'] ?? null;
// }
// if($serviceId){
//   $pkg = "Basic $ts";
//   $priceDao->insert([
//     'service_id'=>$serviceId,
//     'package_name'=>$pkg,
//     'price'=>19.99,
//     'description'=>'Test paket'
//   ]);
//   $prices = $priceDao->getAll();
//   $found = null;
//   foreach($prices as $pr){ if($pr['package_name']===$pkg && (int)$pr['service_id']===(int)$serviceId){ $found=$pr; break; } }
//   $priceId = $found['price_id'] ?? null;
//   echo "price_id: ".($priceId??'NULL')."\n";
//   if($priceId){
//     $priceDao->update($priceId, ['price'=>24.99]);
//     $p2 = $priceDao->getById($priceId);
//     echo "price: ".($p2['price']??'')."\n";
//   }
// } else {
//   echo "SKIP: nema service_id\n";
// }

// echo "</pre>";

?>





