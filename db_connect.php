<?php
$servername = "webpagesdb.it.auth.gr:3306";
$username = "ES3591partB";
$password = "Stamoglou3%9!";
$dbname = "student3591partB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
