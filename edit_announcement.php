<?php
session_start();
include 'db_connect.php';

$title = "Edit Announcement";
$pageTitle = "Edit Announcement";

if (!isset($_SESSION['loginName']) ) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] != 'Tutor') {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM announcements WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$announcement = $result->fetch_assoc();

if (!$announcement) {
    echo "Announcement not found.";
    exit();
}

include 'header.php';
include 'navbar.php';
?>

<main>
    <h2><?php echo $pageTitle; ?></h2>
    <form class="form" action="update_announcement.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($announcement['id']); ?>">

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($announcement['date']); ?>" required>

        <label for="topic">Topic:</label>
        <input type="text" id="topic" name="topic" value="<?php echo htmlspecialchars($announcement['topic']); ?>" required>

        <label for="text">Text:</label>
        <textarea id="text" name="text" required><?php echo htmlspecialchars($announcement['text']); ?></textarea>

        <button type="submit">Update Announcement</button>
    </form>
</main>

<?php include 'footer.php'; ?>
