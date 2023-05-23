<?php
$servername = "127.0.0.1";  // (localhost) to specify the port
$port = 8889;
$username = "root";
$password = "root";
$db = "subscription";

// Create connection
$conn = new mysqli($servername, $username, $password, $db, $port);

// Check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}
?>