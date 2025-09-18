<?php
session_start();
include 'db_connect.php';

// Set dynamic title and page heading
$title = "Announcements";  // Page title for <title> tag
$pageTitle = "Announcements";  // Heading for the page

if (!isset($_SESSION['loginName'])) {
    header("Location: login.php");
    exit();
}

// Include the header and navbar
include 'header.php';
include 'navbar.php';
?>

<main>
    <p class="text">What's New?</p>

    <?php if ($_SESSION['role'] == 'Tutor'): ?>
        <center>
            <button class="edit-button" onclick="window.location.href='add_announcement.php'">Add Announcement</button>
        </center>
    <?php endif; ?>

    <?php
    $sql = "SELECT * FROM announcements ORDER BY id DESC"; // Fetch announcements ordered by date
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $announcementCount = $result->num_rows;
        $currentIndex = 0;

        while ($row = $result->fetch_assoc()) {
            $currentIndex++;

            echo "<div class='dynamic-header'>";
            echo "<h2>Announcement " . htmlspecialchars($row['id']) . "</h2>";

            // Show edit/delete buttons for tutors only
            if ($_SESSION['role'] == 'Tutor') {
                echo "<div class='button-group'>";
                echo "<button class='edit-button' onclick=\"window.location.href='edit_announcement.php?id=" . $row['id'] . "'\">Edit</button>";
                echo "<button class='delete-button' onclick=\"window.location.href='delete_announcement.php?id=" . $row['id'] . "'\">Delete</button>";
                echo "</div>";
            }
            echo "</div>";

            echo "<p><span class='boldtext'>Date: </span><span>" . htmlspecialchars($row['date']) . "</span></p>";
            echo "<p><span class='boldtext'>Topic: </span><span>" . htmlspecialchars($row['topic']) . "</span></p>";
            echo "<p class='indent2'>" . htmlspecialchars($row['text']) . "</p>";

            // Check if this is not the last announcement
            if ($currentIndex < $announcementCount) {
                echo "<p class='indentBorder'></p>"; // Add space between announcements, but not after the last one
            }
        }
    } else {
        echo "<p>No announcements found.</p>";
    }

    $conn->close();
    ?>

    <button class="back-to-top" onclick="scrollToTop()">&#8679;</button>
</main>

<?php include 'footer.php'; ?>
