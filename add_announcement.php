<?php
session_start();
include 'db_connect.php';

$title = "Add Announcement";
$pageTitle = "Add Announcement";

if (!isset($_SESSION['loginName']) ) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] != 'Tutor') {
    header("Location: index.php");
    exit();
}

include 'header.php';
include 'navbar.php';
?>

<main>
    <p class="text">Add a New Announcement</p>
    <form class="form" action="insert_announcement.php" method="post">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>

        <label for="topic">Topic:</label>
        <input type="text" id="topic" name="topic" required>

        <label for="text">Text:</label>
        <textarea id="text" name="text" required></textarea>

        <button type="submit">Add Announcement</button>
    </form>
</main>

<?php include 'footer.php'; ?>
