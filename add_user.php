<?php
session_start();
include 'db_connect.php';

// Set dynamic title and page heading
$title = "Add User";  // Page title for <title> tag
$pageTitle = "Add User";  // Heading for the page

if (!isset($_SESSION['loginName'])) {
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

$error = "";  // Variable to store error message

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $loginName = $_POST['loginName'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Server-side validation for email format
    if (!filter_var($loginName, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        // Check if the loginName (email) already exists
        $sql = "SELECT * FROM users WHERE loginName = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $loginName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "A user with this email address already exists. Please choose a different email.";
        } else {
            // Insert new user with plain text password
            $sql = "INSERT INTO users (firstName, lastName, loginName, password, Role) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sssss', $firstName, $lastName, $loginName, $password, $role);

            if ($stmt->execute()) {
                header("Location: user_management.php");
                exit();
            } else {
                $error = "Error: " . $stmt->error;
            }
        }
    }
}
?>

<main>
    <p class="text">Add a New User</p>

    <?php if ($error): ?>
        <center>
            <p style="color: red;"><?php echo $error; ?></p>
        </center>
    <?php endif; ?>

    <div class='form-container'>
        <form action='add_user.php' method='post'>
            <label for='firstName'>First Name:</label>
            <input type='text' id='firstName' name='firstName' required>

            <label for='lastName'>Last Name:</label>
            <input type='text' id='lastName' name='lastName' required>

            <label for='loginName'>Email (Login Name):</label>
            <input type='email' id='loginName' name='loginName' required> <!-- Changed input type to 'email' -->

            <label for='password'>Password:</label>
            <input type='password' id='password' name='password' required>

            <label for='role'>Role:</label>
            <select id='role' name='role'>
                <option value='Student'>Student</option>
                <option value='Tutor'>Tutor</option>
            </select>

            <button type='submit' class='edit-button'>Add User</button>
        </form>
    </div>
</main>

<?php include 'footer.php'; ?>
