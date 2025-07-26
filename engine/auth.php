<?php
session_start();
require_once 'config.php';

class Auth {
    private mysqli $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->conn;
    }

    public function login(string $email, string $password): bool {
        $email = $this->conn->real_escape_string($email);
        $sql = "SELECT id, password FROM users WHERE email = '$email'";
        $result = $this->conn->query($sql);

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['u_id'] = $user['id'];
                return true;
            }
        }

        return false;
    }

    public function logout(): void {
        session_unset();
        session_destroy();
    }

    public function isLoggedIn(): bool {
        return isset($_SESSION['u_id']);
    }

    public function getUserId(): ?int {
        return $_SESSION['u_id'] ?? null;
    }
}
