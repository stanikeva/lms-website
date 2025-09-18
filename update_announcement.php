<?php
include 'db_connect.php';

$id = $_POST['id'];
$date = $_POST['date'];
$topic = $_POST['topic'];
$text = $_POST['text'];

$sql = "UPDATE announcements SET date = ?, topic = ?, text = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $date, $topic, $text, $id);

if ($stmt->execute()) {
    header("Location: announcements.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
