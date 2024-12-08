<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/Vote.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vote = new Vote($conn);
    $category = $_POST['category'];
    $nominee = $_POST['nominee'];
    $comment = $_POST['comment'];
    $voterId = $_SESSION['user_id'];

    $message = $vote->submitVote($category, $nominee, $comment, $voterId);
    echo $message;
}

?>
