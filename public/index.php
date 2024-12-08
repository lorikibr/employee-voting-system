<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to the Voting System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Welcome to the Employee Appreciation Voting System</h1>
    <?php if (isset($_SESSION['user_id'])): ?>
        <p>Hello, <?= $_SESSION['name'] ?>!</p>
        <a href="vote.php">Vote Now</a> |
        <a href="results.php">View Results</a> |
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a> |
        <a href="register.php">Register</a>
    <?php endif; ?>
</body>
</html>
