<?php
session_start();
include 'db_connect.php';

// Set dynamic title and page heading
$title = "User Management";  // Page title for <title> tag
$pageTitle = "User Management";  // Heading for the page

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

    // Check if the user is a tutor
    if ($_SESSION['role'] == 'Tutor') {
        // Fetch users from the database
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);

        echo "<main>";
        echo "<div class='table-container'>";
        echo "<p class='text'>User Management</p>";
        echo "<center>";
        echo "<button class='edit-button' onclick=\"window.location.href='add_user.php'\">Add User</button>";
        echo "</center>";
        echo "<table class='user-table'>";
        echo "<tr><th>First Name</th><th>Last Name</th><th>Login Name</th><th>Role</th></tr>";

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['firstName']) . "</td>";
                echo "<td>" . htmlspecialchars($row['lastName']) . "</td>";
                echo "<td>" . htmlspecialchars($row['loginName']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Role']) . "</td>";
                echo "</tr>";
                echo "<tr class='action-row'>";
                echo "<td colspan='4' style='text-align: center;'>";
                echo "<button onclick=\"window.location.href='edit_user.php?loginName=" . $row['loginName'] . "'\" class='edit-button'>Edit</button> ";
                if ($row['loginName'] != $_SESSION['loginName']){
                    echo "<button onclick=\"window.location.href='delete_user.php?loginName=" . $row['loginName'] . "'\" class='delete-button'>Delete</button>";
                }
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No users found.</td></tr>";
        }
        echo "</table>";
        echo "</div>";
        echo "</main>";
    }
        ?>


    <button class="back-to-top" onclick="scrollToTop()">&#8679;</button>


<?php include 'footer.php'; ?>

