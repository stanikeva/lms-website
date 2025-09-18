<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['loginName']) ) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] != 'Tutor') {
    header("Location: index.php");
    exit();
}

$loginName = $_GET['loginName'];

$sql = "DELETE FROM users WHERE loginName = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $loginName);

if ($stmt->execute()) {
    header("Location: user_management.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}
?>
