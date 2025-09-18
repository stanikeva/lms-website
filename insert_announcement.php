<?php
include 'db_connect.php';

$date = $_POST['date'];
$topic = $_POST['topic'];
$text = $_POST['text'];

$sql = "INSERT INTO announcements (date, topic, text) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $date, $topic, $text);

if ($stmt->execute()) {
    header("Location: announcements.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

