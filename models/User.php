<?php
class User {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Mengambil data user berdasarkan username
    public function getUserByUsername($username) {
        $stmt = $this->conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    // Mendaftarkan user baru
    public function registerUser($username, $password) {
        // Cek apakah username sudah ada
        $stmtCheck = $this->conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmtCheck->bind_param("s", $username);
        $stmtCheck->execute();
        if ($stmtCheck->get_result()->num_rows > 0) {
            return false; // Username sudah terdaftar
        }

        // Hash password menggunakan Bcrypt
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Simpan ke database
        $stmt = $this->conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashedPassword);
        return $stmt->execute();
    }
}
?>