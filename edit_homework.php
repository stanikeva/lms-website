<?php
session_start();
include 'db_connect.php';

// Set dynamic title and page heading
$title = "Assignment Editor";  // Page title for <title> tag
$pageTitle = "Assignment Editor";  // Heading for the page

if (!isset($_SESSION['loginName']) ) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] != 'Tutor') {
    header("Location: index.php");
    exit();
}

// Fetch the homework ID from the URL or POST request
$id = isset($_GET['id']) ? intval($_GET['id']) : 0; // Assuming the ID is passed via GET

if ($id <= 0) {
    echo "Invalid assignment ID.";
    exit();
}

// Fetch the homework data from the database
$sql = "SELECT * FROM homework WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Assignment not found.";
    exit();
}

$homework = $result->fetch_assoc();

// Include the header and navbar
include 'header.php';
include 'navbar.php';
?>

<main>
    <form class="form" action="update_homework.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($homework['id']); ?>">

        <label for="goals">Goals:</label>
        <p>Seperate the goals with commas to create bullet points</p>
        <textarea id="goals" name="goals" required><?php echo htmlspecialchars($homework['goals']); ?></textarea>

        <div>
            <label for="descriptionFileName">Description File:</label>
            <input type="file" id="descriptionFileName" name="descriptionFileName">
            <?php if (!empty($homework['descriptionFileName'])): ?>
                <p>Current File: <a href="homework/<?php echo htmlspecialchars($homework['descriptionFileName']); ?>" download><?php echo htmlspecialchars($homework['descriptionFileName']); ?></a></p>
            <?php endif; ?>
        </div>

        <label for="toTurnIn">What to Turn In:</label>
        <textarea id="toTurnIn" name="toTurnIn" required><?php echo htmlspecialchars($homework['toTurnIn']); ?></textarea>

        <label for="dueDate">Due Date:</label>
        <input type="date" id="dueDate" name="dueDate" value="<?php echo htmlspecialchars($homework['dueDate']); ?>" required>

        <button type="submit">Update Homework</button>
    </form>
</main>

<?php include 'footer.php'; ?>
