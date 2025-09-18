<?php
session_start();
include 'db_connect.php';

if (isset($_POST['loginName']) && isset($_POST['password'])) {
    $loginName = $_POST['loginName'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE loginName='$loginName' AND password='$password'";
    $result = $conn->query($sql);

    if (!$result) {
        echo "Error: " . $conn->error; // This will show the error in case of a query problem
    }

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $_SESSION['loginName'] = $row['loginName'];
        $_SESSION['role'] = $row['Role'];
        header("Location: index.php");
        exit();
    } else {
        header("Location: login.php?error=Invalid username or password");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>