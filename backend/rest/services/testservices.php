<?php
// testservices.php — fixed paths for your project layout

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$baseDir = __DIR__; // this = /backend/rest/services

$requires = [
  "$baseDir/../dao/BaseDao.php",
  "$baseDir/../dao/UserDao.php",
  "$baseDir/../dao/TeamDao.php",
  "$baseDir/../dao/ServiceDao.php",
  "$baseDir/../dao/PriceDao.php",
  "$baseDir/../dao/BookingDao.php",
  "$baseDir/BaseService.php",
  "$baseDir/TeamService.php",
  "$baseDir/ServiceService.php",
  "$baseDir/PriceService.php",
  "$baseDir/BookingService.php",
  "$baseDir/UserService.php",
];

foreach ($requires as $file) {
  if (file_exists($file)) require_once $file;
  else echo "<div style='color:red'>Missing file: $file</div>";
}

// helpers
function h3($t){ echo "<h3 style='margin-top:20px'>$t</h3>"; }
function pre($v){ echo "<pre>".htmlspecialchars(print_r($v,true))."</pre>"; }
function ok($m){ echo "<div style='color:green'>✔ $m</div>"; }
function err($m){ echo "<div style='color:red'>✖ $m</div>"; }
function warn($m){ echo "<div style='color:#b58900'>⚠ $m</div>"; }

function safeNew($class){
  try{ return class_exists($class)? new $class():null; }
  catch(Throwable $e){ err("$class failed: ".$e->getMessage()); return null; }
}
function safeCall($obj,$m,$args=[]){
  try{
    if(!method_exists($obj,$m)){ warn(get_class($obj)." has no $m"); return; }
    $r=$obj->$m(...$args);
    ok(get_class($obj)."::$m() executed");
    pre($r);
  }catch(Throwable $e){ err(get_class($obj)."::$m() → ".$e->getMessage()); }
}

// header
echo "<h2>🚗 CarDetailing Service/DAO Tester</h2>";

// USER DAO TEST
if(class_exists('UserDao')){
  h3('UserDao: addUser → getByEmail → getUsers');
  $userDao = safeNew('UserDao');
  if($userDao){
    $uniqueEmail = 'test+'.time().'@example.com';
    safeCall($userDao,'addUser',['Emina','Tahirović',$uniqueEmail,password_hash('secret',PASSWORD_BCRYPT)]);
    safeCall($userDao,'getByEmail',[$uniqueEmail]);
    if(method_exists($userDao,'getUsers')) safeCall($userDao,'getUsers');
    else safeCall($userDao,'getAll');
  }
} else warn('UserDao missing');

// TEAM SERVICE TEST
if(class_exists('TeamService')){
  h3('TeamService');
  $svc = safeNew('TeamService');
  if($svc) safeCall($svc,'getAll');
} else warn('TeamService missing');

// SERVICE SERVICE TEST
if(class_exists('ServiceService')){
  h3('ServiceService');
  $svc = safeNew('ServiceService');
  if($svc) safeCall($svc,'getAll');
} else warn('ServiceService missing');

// PRICE SERVICE TEST
if(class_exists('PriceService')){
  h3('PriceService');
  $svc = safeNew('PriceService');
  if($svc){
    safeCall($svc,'getAll');
    if(method_exists($svc,'getByServiceId')) safeCall($svc,'getByServiceId',[1]);
  }
} else warn('PriceService missing');

// BOOKING SERVICE TEST
if(class_exists('BookingService')){
  h3('BookingService');
  $svc = safeNew('BookingService');
  if($svc) safeCall($svc,'getAll');
} else warn('BookingService missing');

echo "<hr><b>✅ Test finished. Check results above.</b>";
?>
