<?php
class Product {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllProducts($keyword = "") {
        if ($keyword !== "") {
            // Jika ada pencarian, gunakan Prepared Statement dengan LIKE
            $search = "%{$keyword}%";
            $stmt = $this->conn->prepare("SELECT * FROM produk WHERE nama LIKE ? ORDER BY id DESC");
            $stmt->bind_param("s", $search);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } else {
            // Jika tidak ada pencarian, tampilkan semua data
            $query = "SELECT * FROM produk ORDER BY id DESC";
            $result = $this->conn->query($query);
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function getProductById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM produk WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function createProduct($nama, $harga, $stok, $status, $gambar, $thumbpath) {
        $stmt = $this->conn->prepare("INSERT INTO produk (nama, harga, stok, status, gambar, thumbpath) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sdisss", $nama, $harga, $stok, $status, $gambar, $thumbpath);
        return $stmt->execute();
    }

    public function deleteProduct($id) {
        $stmt = $this->conn->prepare("DELETE FROM produk WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
        }
        public function updateProduct($id, $nama, $harga, $stok, $status, $gambar = null, $thumbpath = null) {
        if ($gambar !== null && $thumbpath !== null) {
            // Jika ada gambar baru
            $stmt = $this->conn->prepare("UPDATE produk SET nama = ?, harga = ?, stok = ?, status = ?, gambar = ?, thumbpath = ? WHERE id = ?");
            $stmt->bind_param("sdisssi", $nama, $harga, $stok, $status, $gambar, $thumbpath, $id);
        } else {
            // Jika gambar tidak diubah
            $stmt = $this->conn->prepare("UPDATE produk SET nama = ?, harga = ?, stok = ?, status = ? WHERE id = ?");
            $stmt->bind_param("sdisi", $nama, $harga, $stok, $status, $id);
        }
        return $stmt->execute();
    }
}
?>