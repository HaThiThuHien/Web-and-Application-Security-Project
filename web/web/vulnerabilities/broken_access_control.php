<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Broken Access Control</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Broken Access Control</h1>
        <p>This page demonstrates the Broken Access Control vulnerability.</p>
        <a href="admin.php">Go to Admin Page</a>
        <a href="../index.php">Go to Home</a>
    </div>
</body>
</html>
