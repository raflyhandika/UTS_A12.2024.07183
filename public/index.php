<?php
// Gunakan ../ untuk naik satu folder dari 'publics'
require_once '../config/database.php';
require_once '../controllers/AuthController.php';
require_once '../controllers/ProductController.php';

$auth = new AuthController($conn);
$product = new ProductController($conn);

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

$allowed_pages = ['login', 'register'];
if (!isset($_SESSION['user_id']) && !in_array($page, $allowed_pages)) {
    header("Location: index.php?page=login");
    exit;
}

switch ($page) {
    case 'login':
        $error = $auth->login();
        require '../views/login.php';
        break;
        
    case 'register':
        $error = $auth->register();
        require '../views/register.php';
        break;
        
    case 'logout':
        $auth->logout();
        break;
        
    case 'dashboard':
        require_once '../models/Product.php';
        $productModel = new Product($conn);
        $keyword = isset($_GET['search']) ? trim($_GET['search']) : "";
        $produkList = $productModel->getAllProducts($keyword);
        require '../views/dashboard.php';
        break;
        
    case 'create':
        $error = $product->create();
        require '../views/create.php';
        break;
        
    case 'edit':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            require_once '../models/Product.php';
            $productModel = new Product($conn);
            $error = $product->update($id);
            $data = $productModel->getProductById($id);
            if (!$data) die("Data tidak ditemukan!");
            require '../views/edit.php';
        } else {
            header("Location: index.php?page=dashboard");
        }
        break;
        
    case 'delete':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $product->delete($id); 
        } else {
            header("Location: index.php?page=dashboard");
        }
        break;
        
    default:
        echo "Halaman tidak ditemukan!";
        break;
}
?>