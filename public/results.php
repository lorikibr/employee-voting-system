<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/Vote.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$vote = new Vote($conn);
$results = $vote->getResults();
$mostActiveVoters = $vote->getMostActiveVoters();
?>

<?php include('../templates/header.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Results</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Voting Results</h1>

        <!-- Display Results in Table Format -->
        <?php foreach ($results as $category => $data): ?>
            <h2><?= $category ?> - Results</h2>
            <table>
                <caption><?= $category ?> Results</caption>
                <thead>
                    <tr>
                        <th>Nominee</th>
                        <th>Votes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $nominee => $voteCount): ?>
                        <tr>
                            <td><?= $nominee ?></td>
                            <td><?= $voteCount ?> votes</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endforeach; ?>

        <!-- Display Most Active Voters in Table Format -->
        <h2>Most Active Voters</h2>
        <table>
            <caption>Most Active Voters</caption>
            <thead>
                <tr>
                    <th>Voter Name</th>
                    <th>Votes Cast</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mostActiveVoters as $voter): ?>
                    <tr>
                        <td><?= $voter['name'] ?></td>
                        <td><?= $voter['votes'] ?> votes</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
