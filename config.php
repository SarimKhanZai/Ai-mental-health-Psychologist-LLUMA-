<?php
define('GEMINI_API_KEY', 'AIzaSyC95gig0zuGj26Qp8ENQdFdsuZq3nO3qVI');

$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "lluma_db";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>
