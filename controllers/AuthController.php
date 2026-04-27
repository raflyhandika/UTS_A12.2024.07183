<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $userModel;

    public function __construct($conn) {
        $this->userModel = new User($conn);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'])) {
                die("Token CSRF tidak valid!");
            }

            $username = trim($_POST['username']);
            $password = $_POST['password'];

            $user = $this->userModel->getUserByUsername($username);

            // Verifikasi hash password
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: index.php?page=dashboard");
                exit;
            } else {
                return "Login Gagal!";
            }
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'])) return "Token CSRF tidak valid!";

            $username = trim($_POST['username']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            if (empty($username) || empty($password)) {
                return "Username dan Password tidak boleh kosong!";
            }

            if ($password !== $confirm_password) {
                return "Konfirmasi password tidak cocok!";
            }

            $success = $this->userModel->registerUser($username, $password);

            if ($success) {
                // Redirect ke halaman login dengan pesan sukses
                header("Location: index.php?page=login&msg=Registrasi berhasil! Silakan Masuk.");
                exit;
            } else {
                return "Username sudah terdaftar, silakan gunakan yang lain!";
            }
        }
        
        return null;
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?page=login");
        exit;
    }
}


return null

?>
