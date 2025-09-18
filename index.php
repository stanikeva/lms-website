<?php
session_start();
include 'db_connect.php';

// Set dynamic title and page heading
$title = "Home";  // Page title for <title> tag
$pageTitle = "Home";  // Heading for the page

if (!isset($_SESSION['loginName'])) {
    header("Location: login.php");
    exit();
}

// Include the header and navbar
include 'header.php';
include 'navbar.php';
?>

<main>
    <p class="text">Welcome!</p>
    <p>Hello there! This is an assignment in Web Development for the subject Internet Educational Environments.</p>
    <ul>
        <li>Announcements - in the Announcements page</li>
        <li>Documents - in the Documents page</li>
        <li>Assignments - in the Homework page</li>
        <li>Communication - in the Communication page</li>
        <?php if ($_SESSION['role'] == 'Tutor'): ?>
            <li>
                User Management - in the User Management page
            </li>
        <?php endif; ?>
    </ul>
    <img class="homeImg" src="images/Home.jpg" class="cntr">
    <button class="back-to-top" onclick="scrollToTop()">&#8679;</button>
</main>

<?php include 'footer.php'; ?>
