<?php
session_start();
include 'db_connect.php';

$title = "Edit Document";
$pageTitle = "Edit Document";

if (!isset($_SESSION['loginName']) ) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] != 'Tutor') {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $filePath = 'documents/' . basename($fileName);

    if ($fileName) {
        // Upload new file and delete old file
        $sql = "SELECT fileName FROM documents WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $doc = $result->fetch_assoc();
        $oldFilePath = 'documents/' . $doc['fileName'];
        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }

        if (move_uploaded_file($fileTmpName, $filePath)) {
            $sql = "UPDATE documents SET title = ?, description = ?, fileName = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sssi', $title, $description, $fileName, $id);
        } else {
            echo "Error uploading file.";
            exit();
        }
    } else {
        // No new file uploaded
        $sql = "UPDATE documents SET title = ?, description = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $title, $description, $id);
    }

    if ($stmt->execute()) {
        header("Location: documents.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch current data for pre-filling the form
$sql = "SELECT * FROM documents WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$doc = $result->fetch_assoc();

include 'header.php';
include 'navbar.php';
?>

<main>
    <h2><?php echo $pageTitle; ?></h2>
    <form class="form" action="edit_document.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($doc['title']); ?>" required>
        <br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($doc['description']); ?></textarea>
        <br>
        <label for="file">File (Leave blank if not changing):</label>
        <input type="file" id="file" name="file">
        <br>
        <button type="submit">Update Document</button>
    </form>
</main>
<?php include 'footer.php'; ?>