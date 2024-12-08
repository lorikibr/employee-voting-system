<?php

class Vote
{
    private $conn;

    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;
    }

    // Method to submit a vote
    public function submitVote($categoryId, $nomineeId, $comment, $voterId)
    {
        if ($nomineeId === $voterId) {
            return "You cannot vote for yourself.";
        }

        $query = "INSERT INTO votes (category_id, nominee_id, voter_id, comment, created_at) 
                  VALUES (:category_id, :nominee_id, :voter_id, :comment, NOW())";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->bindParam(':nominee_id', $nomineeId);
        $stmt->bindParam(':voter_id', $voterId);
        $stmt->bindParam(':comment', $comment);

        if ($stmt->execute()) {
            return "Vote submitted successfully.";
        } else {
            return "Failed to submit vote.";
        }
    }

    // Method to fetch all categories
    public function getCategories()
    {
        $query = "SELECT id, name FROM categories";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to fetch employees excluding the current user
    public function getEmployeesExcept($excludeId)
    {
        $query = "SELECT id, name FROM employees WHERE id != :exclude_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':exclude_id', $excludeId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to fetch voting results
    public function getResults()
    {
        $query = "SELECT c.name AS category, e.name AS nominee, COUNT(v.id) AS votes
                  FROM votes v
                  INNER JOIN categories c ON v.category_id = c.id
                  INNER JOIN employees e ON v.nominee_id = e.id
                  GROUP BY v.category_id, v.nominee_id
                  ORDER BY c.name, votes DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $results = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[$row['category']][$row['nominee']] = $row['votes'];
        }

        return $results;
    }

    // Method to fetch the most active voters
    public function getMostActiveVoters()
    {
        $query = "SELECT e.name, COUNT(v.id) AS votes
                  FROM votes v
                  INNER JOIN employees e ON v.voter_id = e.id
                  GROUP BY v.voter_id
                  ORDER BY votes DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
