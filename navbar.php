<nav class="sidebar">
    <a href="index.php">Home</a>
    <a href="announcements.php">Announcements</a>
    <a href="documents.php">Documents</a>
    <a href="homework.php">Homework</a>
    <a href="communication.php">Communication</a>
    <?php if ($_SESSION['role'] == 'Tutor'): ?>
        <a href="user_management.php">User Management</a>
    <?php endif; ?>


</nav>