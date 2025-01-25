<?php
$conn = new mysqli('localhost', 'root', '', 'sport');

// Check the connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
