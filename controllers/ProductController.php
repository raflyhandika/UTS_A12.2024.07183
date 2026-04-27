<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Product.php';

class ProductController {
    private $productModel;
    // Ubah arah path agar masuk ke folder publics terlebih dahulu
    private $uploadDir = __DIR__ . '/../public/uploads/';
    private $thumbDir = __DIR__ . '/../public/uploads/thumbnails/';

    public function __construct($conn) {
        $this->productModel = new Product($conn);
        // Pastikan folder ada
        if (!is_dir($this->uploadDir)) mkdir($this->uploadDir, 0777, true);
        if (!is_dir($this->thumbDir)) mkdir($this->thumbDir, 0777, true);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'])) die("CSRF Token tidak valid!");

            $nama = trim($_POST['nama_produk']);
            $harga = floatval($_POST['harga']);
            $stok = intval($_POST['stok']);
            $status = trim($_POST['status']);
            
            $gambarPath = null;
            $thumbPath = null;

            // Logika Upload dan Resize Gambar
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['gambar'];
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $allowedExt = ['jpg', 'jpeg', 'png'];
                $maxSize = 2 * 1024 * 1024; // 2MB

                if (!in_array($ext, $allowedExt)) {
                    return "Ekstensi file hanya boleh .jpg atau .png!";
                }

                if ($file['size'] > $maxSize) {
                    return "Ukuran file maksimal 2MB!";
                }

                $fileName = time() . '_' . uniqid() . '.' . $ext;
                $targetFile = $this->uploadDir . $fileName;
                $targetThumb = $this->thumbDir . 'thumb_' . $fileName;

                if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                    // Buat Thumbnail menggunakan GD Library
                    $this->generateThumbnail($targetFile, $targetThumb, $ext, 200); // Lebar thumbnail 200px
                    
                    $gambarPath = 'uploads/' . $fileName;
                    $thumbPath = 'uploads/thumbnails/thumb_' . $fileName;
                }
                
            }

            $success = $this->productModel->createProduct($nama, $harga, $stok, $status, $gambarPath, $thumbPath);
            if ($success) {
                header("Location: index.php?page=dashboard&msg=Data berhasil ditambahkan!");
                exit;
            }
        }
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'])) return "CSRF Token tidak valid!";

            $nama = trim($_POST['nama_produk']);
            $harga = floatval($_POST['harga']);
            $stok = intval($_POST['stok']);
            $status = trim($_POST['status']);
            
            $gambarPath = null;
            $thumbPath = null;

            // Jika ada file gambar baru yang diunggah
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['gambar'];
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $allowedExt = ['jpg', 'jpeg', 'png'];
                $maxSize = 2 * 1024 * 1024; // 2MB

                if (!in_array($ext, $allowedExt)) return "Ekstensi file hanya boleh .jpg atau .png!";
                if ($file['size'] > $maxSize) return "Ukuran file maksimal 2MB!";

                $fileName = time() . '_' . uniqid() . '.' . $ext;
                $targetFile = $this->uploadDir . $fileName;
                $targetThumb = $this->thumbDir . 'thumb_' . $fileName;

                if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                    $this->generateThumbnail($targetFile, $targetThumb, $ext, 200);
                    $gambarPath = 'uploads/' . $fileName;
                    $thumbPath = 'uploads/thumbnails/thumb_' . $fileName;
                }
            }

            $success = $this->productModel->updateProduct($id, $nama, $harga, $stok, $status, $gambarPath, $thumbPath);
            if ($success) {
                header("Location: index.php?page=dashboard&msg=Data berhasil diperbarui!");
                exit;
            } else {
                return "Gagal memperbarui data!";
            }
        }
        return null;
    }

    // Menghapus data dan file gambar fisik
    public function delete($id) {
        // Ambil data produk untuk mendapatkan path/lokasi gambar
        $data = $this->productModel->getProductById($id);

        if ($data) {
            // Hapus data dari database
            $success = $this->productModel->deleteProduct($id);

            if ($success) {
                // Hapus Gambar Asli jika ada dan file fisiknya eksis
                if (!empty($data['gambar']) && file_exists(__DIR__ . '/../public/' . $data['gambar'])) {
                    unlink(__DIR__ . '/../public/' . $data['gambar']);
                }
                
                // Hapus Gambar Thumbnail jika ada dan file fisiknya eksis
                if (!empty($data['thumbpath']) && file_exists(__DIR__ . '/../public/' . $data['thumbpath'])) {
                    unlink(__DIR__ . '/../public/' . $data['thumbpath']);
                }
            }
        }

        // Redirect kembali ke dashboard dengan pesan
        header("Location: index.php?page=dashboard&msg=Data berhasil dihapus !");
        exit;
    }

    // Fungsi GD Library untuk Resize Gambar
    private function generateThumbnail($source, $destination, $ext, $targetWidth) {
        if ($ext === 'jpg' || $ext === 'jpeg') {
            $image = imagecreatefromjpeg($source);
        } elseif ($ext === 'png') {
            $image = imagecreatefrompng($source);
        }

        if (!$image) return false;

        $origWidth = imagesx($image);
        $origHeight = imagesy($image);
        $targetHeight = floor($origHeight * ($targetWidth / $origWidth));

        $thumbnail = imagecreatetruecolor($targetWidth, $targetHeight);

        // Pertahankan transparansi untuk PNG
        if ($ext === 'png') {
            imagealphablending($thumbnail, false);
            imagesavealpha($thumbnail, true);
        }

        imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, $targetWidth, $targetHeight, $origWidth, $origHeight);

        if ($ext === 'jpg' || $ext === 'jpeg') {
            imagejpeg($thumbnail, $destination, 85); // Kualitas 85%
        } elseif ($ext === 'png') {
            imagepng($thumbnail, $destination, 8); // Kompresi PNG
        }

        // Fungsi imagedestroy() dihapus karena PHP 8+ sudah melakukan 
        // garbage collection otomatis pada objek GdImage.
    
        
    }
}
?>