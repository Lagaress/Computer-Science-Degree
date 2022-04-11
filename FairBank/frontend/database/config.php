<?php

// Database with MySQLi
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fairbank";

// Create connection
$connection = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($connection->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

/* DB WITH PDconnection
define('USER', 'root');
define('PASSWORD', '');
define('HOST', 'localhost');
define('DATABASE', 'fairbank');
 

try {
    $connection = new PDO("mysql:host=".HOST.";dbname=".DATABASE, USER, PASSWORD);
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}
*/
?>