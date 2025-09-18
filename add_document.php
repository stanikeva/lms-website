<?php
session_start();
include 'db_connect.php';

// Set dynamic title and page heading
$title = "Add Document";  // Page title for <title> tag
$pageTitle = "Add Document";  // Heading for the page

if (!isset($_SESSION['loginName']) ) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] != 'Tutor') {
    header("Location: index.php");
    exit();
}

// Include the header and navbar
include 'header.php';
include 'navbar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $filePath = 'documents/' . basename($fileName);

    // Validate file upload
    if (empty($title) || empty($description) || empty($fileName)) {
        echo "All fields are required.";
    } elseif ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        echo "Error uploading file. Code: " . $_FILES['file']['error'];
    } else {
        // Move uploaded file to the designated folder
        if (move_uploaded_file($fileTmpName, $filePath)) {
            // Prepare SQL statement
            $sql = "INSERT INTO documents (title, description, fileName) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sss', $title, $description, $fileName);

            if ($stmt->execute()) {
                header("Location: documents.php");
                exit();
            } else {
                echo "Error inserting record: " . $conn->error;
            }
        } else {
            echo "Error moving uploaded file.";
        }
    }
}
?>

<main>
    <p class="text">Add a New Document</p>
    <form class="form" action="add_document.php" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
        <br>
        <label for="file">File:</label>
        <input type="file" id="file" name="file" required>
        <br>
        <button type="submit">Add Document</button>
    </form>
</main>

<?php include 'footer.php'; ?>
