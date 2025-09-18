<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Default Title'; ?></title> <!-- Dynamic title -->
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="favicon.png" type="image/png">
</head>
<body>
<div class="loading">
    <div class="spinner"></div>
</div>

<header>
    <button class="menu-toggle" onclick="toggleMenu()">&#9776;</button>
    <h1><?php echo $pageTitle ; ?></h1> <!-- Dynamic page heading -->
    <button class="logout-button" onclick="window.location.href='logout.php'">Logout</button>
</header>
