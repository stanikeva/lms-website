<?php
session_start();
include 'db_connect.php';

// Set dynamic title and page heading
$title = "Documents";  // Page title for <title> tag
$pageTitle = "Documents";  // Heading for the page

if (!isset($_SESSION['loginName'])) {
    header("Location: login.php");
    exit();
}

// Include the header and navbar
include 'header.php';
include 'navbar.php';
?>

<main>
    <p class="text">Course Material</p>

    <!-- Add button for tutors only -->
    <?php if ($_SESSION['role'] == 'Tutor'): ?>
        <center>
            <button class="edit-button" onclick="window.location.href='add_document.php'">Add Document</button>
        </center>
    <?php endif; ?>

    <?php
    $sql = "SELECT * FROM documents";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $documents = $result->fetch_all(MYSQLI_ASSOC); // Fetch all documents
        $totalDocuments = count($documents);
        $currentIndex = 0;

        foreach ($documents as $row) {
            $currentIndex++;

            echo "<div class='document'>";

            // Container for document title and buttons
            echo "<div class='dynamic-header'>";
            echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";

            // Show edit/delete buttons for tutors only
            if ($_SESSION['role'] == 'Tutor') {
                echo "<div class='button-group'>";
                echo "<button class='edit-button' onclick=\"window.location.href='edit_document.php?id=" . $row['id'] . "'\">Edit</button>";
                echo "<button class='delete-button' onclick=\"window.location.href='delete_document.php?id=" . $row['id'] . "'\">Delete</button>";
                echo "</div>";
            }
            echo "</div>";

            // Display Description
            echo "<p>";
            echo "<span class='boldtext'>Description: </span>";
            echo "<span>" . htmlspecialchars($row['description']) . "</span>";
            echo "</p>";

            // Display Download Link
            $filePath = 'documents/' . htmlspecialchars($row['fileName']);
            echo "<p class='indent2'>";
            echo "<a href='" . $filePath . "' download>";
            echo "<img class='downldImg' src='images/Download.png' alt='Download " . htmlspecialchars($row['fileName']) . "' title='Download " . htmlspecialchars($row['fileName']) . "'>";
            echo "</a>";
            echo "</p>";

            // Conditionally display the empty paragraph if not the last document
            if ($currentIndex < $totalDocuments) {
                echo "<p class='indentBorder'></p>"; // Empty paragraph for styling
            }

            echo "</div>";
        }
    } else {
        echo "<p>No documents found.</p>";
    }
    ?>

    <button class="back-to-top" onclick="scrollToTop()">&#8679;</button>
</main>

<?php include 'footer.php'; ?>
