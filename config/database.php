<?php
// Memulai sesi untuk Login dan CSRF Token
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Konfigurasi Kredensial Database
$db_host = "localhost";
$db_user = "root";
$db_pass = ""; // Sesuaikan jika MySQL Anda memiliki password
$db_name = "inventaris_roti";

// Menginisialisasi koneksi MySQLi
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi Database Gagal: " . $conn->connect_error);
}

/**
 * FUNGSI KEAMANAN GLOBAL
 */

// 1. Mencegah Serangan XSS (Cross-Site Scripting)
function escape_output($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// 2. Membuat Token CSRF (Cross-Site Request Forgery)
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// 3. Memverifikasi Token CSRF dari Form
function verify_csrf_token($token) {
    if (isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token)) {
        return true;
    }
    return false;
}
?>