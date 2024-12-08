<?php
class Employee {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($name, $email, $password) {
        // Check if the email exists
        $stmt = $this->conn->prepare("SELECT * FROM employees WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            return "Email already exists.";
        }

        // Hash password and insert new employee
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("INSERT INTO employees (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $passwordHash]);

        return "Registration successful!";
    }

    public function login($email, $password) {
        // Check credentials
        $stmt = $this->conn->prepare("SELECT * FROM employees WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return null;  // Invalid login
    }

    public function getAllEmployees() {
        $stmt = $this->conn->query("SELECT * FROM employees");
        return $stmt->fetchAll();
    }
}
?>