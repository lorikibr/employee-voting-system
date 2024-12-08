<?php
// Start the session
session_start();

// Include database connection
require_once '../includes/db.php';

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch categories from the database
function getCategories($conn) {
    $query = "SELECT id, name FROM categories";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch employees except the current user
function getEmployeesExcept($conn, $userId) {
    $query = "SELECT id, name FROM employees WHERE id != :userId";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch categories and employees for the form
$categories = getCategories($conn);
$employees = getEmployeesExcept($conn, $_SESSION['user_id']);
?>

<?php include('../templates/header.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Vote for Employees</h1>

    <!-- Error handling for missing data-->
    <?php if (empty($categories)): ?>
        <p>No categories available. Input the categories in database.</p>
        <?php exit; ?>
<?php endif; ?>

    <?php if (empty($employees)): ?>
        <p>No employees available to vote for.</p>
        <?php exit; ?>
<?php endif; ?>

    <!-- Voting form -->
    <form action="submit_vote.php" method="POST">

        <label for="category">Category:</label>
        <select name="category" id="category" required>
            <option value="">Select a category</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>">
                    <?= $category['name'] ?>
                </option>
            <?php endforeach; ?>
        </select><br>


        <label for="nominee">Nominee:</label>
        <select name="nominee" id="nominee" required>
            <option value="">Select a nominee</option>
            <?php foreach ($employees as $employee): ?>
                <option value="<?= $employee['id'] ?>">
                    <?= $employee['name'] ?>
                </option>
            <?php endforeach; ?>
        </select><br>

 
        <label for="comment">Comment:</label>
        <textarea name="comment" id="comment" required></textarea><br>

        <button type="submit">Submit Vote</button>
    </form>
</body>
</html>
