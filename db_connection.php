<?php
// Database connection parameters
$servername = "localhost";
$username = "root";  // Replace with your MySQL username
$password = "18thmay2000@-";      // Replace with your MySQL password
$dbname = "student_registration_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>