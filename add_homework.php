<?php
session_start();
include 'db_connect.php';

// Set dynamic title and page heading
$title = "Add Assignment";  // Page title for <title> tag
$pageTitle = "Add Assignment";  // Heading for the page

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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $goals = $_POST['goals'];
    $toTurnIn = $_POST['toTurnIn'];
    $dueDate = $_POST['dueDate'];

    // Handle file upload
    $fileName = $_FILES['descriptionFileName']['name'];
    $fileTmpName = $_FILES['descriptionFileName']['tmp_name'];
    $fileSize = $_FILES['descriptionFileName']['size'];
    $fileError = $_FILES['descriptionFileName']['error'];
    $fileType = $_FILES['descriptionFileName']['type'];

    $fileExt = strtolower(end(explode('.', $fileName)));
    $allowed = array('jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx');

    if (in_array($fileExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000) { // Limit file size to 1MB
                $fileNameNew = uniqid('', true) . "." . $fileExt;
                $fileDestination = 'homework/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);

                // Insert into database
                $sql = "INSERT INTO homework (goals, descriptionFileName, toTurnIn, dueDate) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ssss', $goals, $fileNameNew, $toTurnIn, $dueDate);

                if ($stmt->execute()) {
                    // Prepare announcement details
                    $topic = "New assignment added";
                    $date = date('Y-m-d'); // Current date
                    $text = "The due date for the new assignment is $dueDate";

                    // Insert announcement into the database
                    $announcementSql = "INSERT INTO announcements (date, topic, text) VALUES (?, ?, ?)";
                    $announcementStmt = $conn->prepare($announcementSql);
                    $announcementStmt->bind_param('sss', $date, $topic, $text);

                    if ($announcementStmt->execute()) {
                        echo "<p>Homework added and announcement created successfully.</p>";
                        header("Location: homework.php");
                        exit();
                    } else {
                        echo "<p>Error creating announcement: " . $announcementStmt->error . "</p>";
                    }
                } else {
                    echo "<p>Error: " . $stmt->error . "</p>";
                }
            } else {
                echo "<p>Your file is too big!</p>";
            }
        } else {
            echo "<p>There was an error uploading your file!</p>";
        }
    } else {
        echo "<p>You cannot upload files of this type!</p>";
    }
}
?>


<main>
    <p class="text">Add a New Homework Assignment</p>

    <form class="form" action="add_homework.php" method="post" enctype="multipart/form-data">
        <div>
            <label for="goals">Goals:</label>
            <p>Seperate the goals with commas to create bullet points</p>
            <input type="text" id="goals" name="goals" required>
        </div>
        <div>
            <label for="descriptionFileName">Description File:</label>
            <input type="file" id="descriptionFileName" name="descriptionFileName" required>
        </div>
        <div>
            <label for="toTurnIn">To Turn In:</label>
            <input type="text" id="toTurnIn" name="toTurnIn" required>
        </div>
        <div>
            <label for="dueDate">Due Date:</label>
            <input type="date" id="dueDate" name="dueDate" required>
        </div>
        <button type="submit">Add Homework</button>
    </form>

    <button class="back-to-top" onclick="scrollToTop()">&#8679;</button>
</main>

<?php include 'footer.php'; ?>