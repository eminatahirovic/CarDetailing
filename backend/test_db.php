<?php
// 1. DIRECT SETTINGS (No Flight, No Routes, No Complex Logic)
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>Database & Insert Diagnostic</h1>";

// 2. CONNECTION SETTINGS (VERIFY THESE!)
$host = 'localhost';
$user = 'root'; 
$pass = ''; // Leave empty for XAMPP default
$dbname = 'carDetailing'; // ⚠️ REPLACE WITH YOUR EXACT DB NAME

// 3. ATTEMPT CONNECTION
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p style='color:green'>✅ Database Connection Successful!</p>";
} catch (PDOException $e) {
    die("<p style='color:red'>❌ Connection Failed: " . $e->getMessage() . "</p>");
}

// 4. ATTEMPT DIRECT INSERT (Bypassing Services/DAOs)
$test_email = "test_" . time() . "@example.com";
$password = password_hash("secret123", PASSWORD_BCRYPT);

try {
    $sql = "INSERT INTO users (name, lastname, email, password) VALUES (:name, :lastname, :email, :pass)";
    $stmt = $conn->prepare($sql);
    
    $result = $stmt->execute([
        ':name' => 'Test',
        ':lastname' => 'User',
        ':email' => $test_email,
        ':pass' => $password
    ]);

    if ($result) {
        $id = $conn->lastInsertId();
        echo "<p style='color:green'>✅ Insert Successful! New User ID: <strong>$id</strong></p>";
        echo "<p>Go check your database table 'users' now.</p>";
    } else {
        echo "<p style='color:red'>❌ Insert Returned False (No error exception, but failed).</p>";
    }

} catch (PDOException $e) {
    echo "<p style='color:red'>❌ Insert Failed: " . $e->getMessage() . "</p>";
    echo "<p><strong>Possible Causes:</strong><br>";
    echo "1. Table 'users' does not exist.<br>";
    echo "2. Column 'lastname' is missing.<br>";
    echo "3. 'email' column length is too short.</p>";
}
?>
