<?php
include 'db_connect.php'; // Include your DB connection
$id = $_POST['id'];
$goals = $_POST['goals'];
$toTurnIn = $_POST['toTurnIn'];
$dueDate = $_POST['dueDate'];

// Check if a new file is uploaded
if (isset($_FILES['descriptionFileName']) && $_FILES['descriptionFileName']['error'] == UPLOAD_ERR_OK) {
    $fileName = $_FILES['descriptionFileName']['name'];
    $fileTmpName = $_FILES['descriptionFileName']['tmp_name'];
    $uploadDir = 'homework/';
    $uploadFilePath = $uploadDir . basename($fileName);

    // Move the uploaded file to the desired directory
    if (move_uploaded_file($fileTmpName, $uploadFilePath)) {
        // Update the record with the new file name
        $sql = "UPDATE homework SET goals='$goals', descriptionFileName='$fileName', toTurnIn='$toTurnIn', dueDate='$dueDate' WHERE id='$id'";
    } else {
        echo "File upload failed!";
        exit();
    }
} else {
    // If no new file is uploaded, keep the old file
    $sql = "UPDATE homework SET goals='$goals', toTurnIn='$toTurnIn', dueDate='$dueDate' WHERE id='$id'";
}

// Execute the query
if ($conn->query($sql) === TRUE) {
    header("Location: homework.php"); // Redirect to the homework page
    exit();
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
