<?php
$host = "localhost"; // Or Hostinger-provided host
$dbname = "u102894479_siplookup"; // Replace with your database name
$username = "u102894479_sipuser"; // Replace with your database username
$password = "qwertyA7@"; // Replace with your database password

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>