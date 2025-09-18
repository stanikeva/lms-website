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

$id = $_GET['id'];

// First, retrieve the file name from the database before deleting the homework record
$sql = "SELECT descriptionFileName FROM homework WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$homework = $result->fetch_assoc();

if ($homework) {
    $filePath = 'homework/' . $homework['descriptionFileName'];

    // Now delete the file from the homework folder
    if (file_exists($filePath)) {
        unlink($filePath);  // This deletes the file
    }

    // After the file is deleted, delete the record from the database
    $sql = "DELETE FROM homework WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();

    // Check if this was the last row in the table
    $sql = "SELECT COUNT(*) AS count FROM homework";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($row['count'] == 0) {
        // Truncate the table if no rows are left
        $sql = "TRUNCATE TABLE homework";
        $conn->query($sql);
    }

    header("Location: homework.php");
    exit();
} else {
    echo "Homework not found!";
}
?>

