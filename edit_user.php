<?php
session_start();
include 'db_connect.php';

$title = "Edit User";
$pageTitle = "Edit User";

if (!isset($_SESSION['loginName']) ) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] != 'Tutor') {
    header("Location: index.php");
    exit();
}
$loginName = $_GET['loginName'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $role = $_POST['role'];

    $sql = "UPDATE users SET firstName = ?, lastName = ?, Role = ? WHERE loginName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssss', $firstName, $lastName, $role, $loginName);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    $sql = "SELECT * FROM users WHERE loginName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $loginName);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}

include 'header.php';
include 'navbar.php';
?>

<main>
    <form class="form" action="edit_user.php?loginName=<?php echo $loginName; ?>" method="post">
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($user['firstName']); ?>" required>
        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($user['lastName']); ?>" required>
        <label for="role">Role:</label>
        <select id="role" name="role">
            <option value="Student" <?php if ($user['Role'] == 'Student') echo 'selected'; ?>>Student</option>
            <option value="Tutor" <?php if ($user['Role'] == 'Tutor') echo 'selected'; ?>>Tutor</option>
        </select>
        <br><br>
        <button type="submit">Update User</button>
    </form>
</main>
}
<?php include 'footer.php'; ?>