<?php
session_start();
include 'db_connect.php';

// Set dynamic title and page heading
$title = "Communication";  // Page title for <title> tag
$pageTitle = "Communication";  // Heading for the page

if (!isset($_SESSION['loginName'])) {
    header("Location: login.php");
    exit();
}

// Include the header and navbar
include 'header.php';
include 'navbar.php';

$error = ""; // Error message placeholder
$success = ""; // Success message placeholder

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userEmail = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Fetch all tutor emails
    $sql = "SELECT loginName FROM users WHERE Role = 'Tutor'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Collect all tutor emails
        $tutorEmails = [];
        while ($row = $result->fetch_assoc()) {
            $tutorEmails[] = $row['loginName'];
        }

        // Send email to all tutors
        $to = implode(',', $tutorEmails);
        $headers = "From: " . $userEmail . "\r\n";
        $headers .= "Reply-To: " . $userEmail . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        $sent = mail($to, $subject, $message, $headers);
        if ($sent) {
            $success = "Message sent to all tutors successfully!";
        } else {
            $error = "Failed to send the message.";
        }
    } else {
        $error = "No tutors found.";
    }
}
?>

<main>
    <p class="text">Ways of Communication</p>
    <h2>Communication via web form</h2>
    <p>You can communicate with the course instructor by filling in the following details:</p>

    <?php if ($error): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form class="form" action="" method="POST">
        <div>
            <input type="email" placeholder="Your Email" name="email" required />
        </div>
        <div>
            <input type="text" placeholder="Subject" name="subject" required />
        </div>
        <div>
            <textarea placeholder="Your message" name="message" required></textarea>
        </div>
        <div>
            <button type="submit">Send a message</button>
        </div>
    </form>
    <p class="indentBorder"></p>
    <h2>Communication via email addresses</h2>
    <p>Alternatively, you can communicate by sending an email to the following addresses:</p>

    <?php
    $sql = "SELECT loginName FROM users WHERE Role = 'Tutor'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Collect all tutor emails
        $tutorEmails = [];
        while ($row = $result->fetch_assoc()) {
            $tutorEmails[] = $row['loginName'];
        }
    }
    if (count($tutorEmails) > 0): ?>
        <ul>
            <?php foreach ($tutorEmails as $email): ?>
                <li><a href="mailto:<?php echo htmlspecialchars($email); ?>"><?php echo htmlspecialchars($email); ?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No tutor emails available.</p>
    <?php endif; ?>

    <button class="back-to-top" onclick="scrollToTop()">&#8679;</button>
</main>

<?php include 'footer.php'; ?>
