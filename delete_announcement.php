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

// Check if the ID is provided
if (empty($id)) {
    echo "Invalid ID.";
    exit();
}

// Start a transaction
$conn->begin_transaction();

try {
    // Delete the announcement
    $sql = "DELETE FROM announcements WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Check if there are any rows left
    $sql = "SELECT COUNT(*) AS count FROM announcements";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($row['count'] == 0) {
        // If no rows are left, truncate the table
        $sql = "TRUNCATE TABLE announcements";
        $conn->query($sql);
    }

    // Commit transaction
    $conn->commit();

    // Redirect to announcements page
    header("Location: announcements.php");
    exit();
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

$conn->close();
?>
