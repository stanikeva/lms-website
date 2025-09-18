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

// First, retrieve the file name from the database before deleting the document record
$sql = "SELECT fileName FROM documents WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$document = $result->fetch_assoc();

if ($document) {
    $filePath = 'documents/' . $

// Continue from where it left off
        $filePath = 'documents/' . $document['fileName'];

// Now delete the file from the documents folder
    if (file_exists($filePath)) {
        unlink($filePath);  // This deletes the file
    }

// After the file is deleted, delete the record from the database
    $sql = "DELETE FROM documents WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        // Check if there are no more rows in the table
        $sql = "SELECT COUNT(*) AS count FROM documents";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        if ($row['count'] == 0) {
            // If there are no rows, truncate the table
            $sql = "TRUNCATE TABLE documents";
            $conn->query($sql);
        }

        header("Location: documents.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>

