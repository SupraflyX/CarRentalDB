<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$servername = "localhost";
$username = "root";
$password = "";
$database = "Car_rental";

$conn = new mysqli($servername, $username, $password, $database);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}
?>
