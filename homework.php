<?php
session_start();
include 'db_connect.php';

// Set dynamic title and page heading
$title = "Homework";  // Page title for <title> tag
$pageTitle = "Homework";  // Heading for the page

if (!isset($_SESSION['loginName'])) {
    header("Location: login.php");
    exit();
}

// Include the header and navbar
include 'header.php';
include 'navbar.php';
?>

<main>
    <p class="text">Course Assignments</p>

    <!-- Add button for tutors only -->
    <?php if ($_SESSION['role'] == 'Tutor'): ?>
        <center>
            <button class="edit-button" onclick="window.location.href='add_homework.php'">Add Homework</button>
        </center>
    <?php endif; ?>

    <?php
    $sql = "SELECT * FROM homework";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $assignments = $result->fetch_all(MYSQLI_ASSOC); // Fetch all assignments
        $totalAssignments = count($assignments);
        $currentIndex = 0;

        foreach ($assignments as $row) {
            $currentIndex++;

            echo "<div class='homework'>";

            // Container for assignment number and buttons
            echo "<div class='dynamic-header'>";
            echo "<h2>Assignment " . htmlspecialchars($row['id']) . "</h2>";

            // Show edit/delete buttons for tutors only
            if ($_SESSION['role'] == 'Tutor') {
                echo "<div class='button-group'>";
                echo "<button class='edit-button' onclick=\"window.location.href='edit_homework.php?id=" . $row['id'] . "'\">Edit</button>";
                echo "<button class='delete-button' onclick=\"window.location.href='delete_homework.php?id=" . $row['id'] . "'\">Delete</button>";
                echo "</div>";
            }

                echo "</div>";

            // Display Goals
            echo "<p>";
            echo "<span class='boldtext'>Goals: </span>";
            echo "<ul class='indent'>";
            $goals = htmlspecialchars($row['goals']);
            $items = explode(',', $goals); // Assuming items are comma-separated in the DB
            foreach ($items as $item) {
                echo "<li>" . trim($item) . "</li>";
            }
            echo "</ul>";

            // Display Description
            echo "<p>";
            echo "<span class='boldtext'>Description: </span>";
            echo "<span>You can download the document describing the assignment's guidelines here:</span>";
            echo "</p>";

            // Display Download Link
            $filePath = 'homework/' . htmlspecialchars($row['descriptionFileName']);
            echo "<a class='indent' href='" . $filePath . "' download>";
            echo "<img class='downldImg' src='images/Download.png' alt='Download " . htmlspecialchars($row['descriptionFileName']) . "' title='Download " . htmlspecialchars($row['descriptionFileName']) . "'>";
            echo "</a>";

            // Display To Turn In
            echo "<p class='boldtext'>What you need to submit:</p>";
            echo "<ul class='indent'>";
            $toTurnIn = htmlspecialchars($row['toTurnIn']);
            $items = explode(',', $toTurnIn); // Assuming items are comma-separated in the DB
            foreach ($items as $item) {
                echo "<li>" . trim($item) . "</li>";
            }
            echo "</ul>";

            // Display Deadline
            echo "<h3>Deadline: " . htmlspecialchars($row['dueDate']) . "</h3>";

            // Conditionally display the empty paragraph if not the last assignment
            if ($currentIndex < $totalAssignments) {
                echo "<p class='indentBorder'></p>"; // Empty paragraph for styling
            }

            echo "</div>";
        }
    } else {
        echo "<p>No homework assignments found.</p>";
    }
    ?>

    <button class="back-to-top" onclick="scrollToTop()">&#8679;</button>
</main>

<?php include 'footer.php'; ?>
