<?php

// Database Configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "lms";

// Create Connection
$conn = new mysqli($servername, $username, $password, $database);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set Character Encoding
$conn->set_charset("utf8mb4");

// Base URL
define("BASE_URL", "http://yourwebsite.com/");

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>