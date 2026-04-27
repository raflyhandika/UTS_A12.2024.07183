<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Inventaris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* 1. Modifikasi Tema Dasar Bootstrap (Background & Teks) */
        [data-bs-theme="dark"] {
            --bs-body-bg: #2c1a14; /* Cokelat Gelap (Dark Cocoa) */
            --bs-body-color: #fdf5e6; /* Krem Vanilla (Dough) */
            --bs-body-tertiary-bg: #2c1a14; 
        }

        /* 2. Modifikasi Kartu (Cards) & Header */
        .card {
            background-color: #42281e !important; /* Cokelat Susu (Milk Chocolate) */
            border-color: #5c382a !important;
            color: #fdf5e6;
        }
        .card-header, .table-active th {
            background-color: #24140f !important; /* Cokelat Sangat Gelap */
            color: #f5a623 !important; /* Teks Karamel Terang */
            border-bottom: 1px solid #5c382a;
        }

        /* 3. Modifikasi Tabel */
        .table-dark {
            --bs-table-bg: #3e251c;
            --bs-table-color: #fdf5e6;
            --bs-table-border-color: #5c382a;
            --bs-table-hover-bg: #4f3024;
        }

        /* 4. Modifikasi Tombol (Karamel & Roti Panggang) */
        .btn-primary {
            background-color: #d97706; /* Karamel */
            border-color: #b46102;
            color: #fff;
        }
        .btn-primary:hover {
            background-color: #b46102;
            border-color: #924f00;
        }
        
        .btn-success {
            background-color: #c25e00; /* Oranye Keemasan (Crust) */
            border-color: #a34e00;
            color: #fff;
        }
        .btn-success:hover {
            background-color: #a34e00;
            border-color: #853f00;
            color: #fff;
        }

        /* 5. Modifikasi Input Form */
        .form-control, .form-select {
            background-color: #2c1a14 !important;
            border-color: #5c382a !important;
            color: #fdf5e6 !important;
        }
        .form-control:focus, .form-select:focus {
            border-color: #d97706 !important;
            box-shadow: 0 0 0 0.25rem rgba(217, 119, 6, 0.25) !important;
        }

        /* --- KUMPULAN ANIMASI --- */
        .btn-transisi { transition: transform 0.3s ease, background-color 0.3s ease; }
        .btn-transisi:hover { transform: scale(1.05); }
        
        .card-animasi { animation: fadeUp 0.6s ease-out; }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        
        .form-animasi { animation: slideIn 0.5s ease-out; }
        @keyframes slideIn { from { opacity: 0; transform: translateX(-20px); } to { opacity: 1; transform: translateX(0); } }
        
        .row-hover { transition: background-color 0.3s ease; }
        .row-hover:hover { background-color: var(--bs-table-hover-bg); }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Inventaris Toko Roti</h2>
            <a href="index.php?page=logout" class="btn btn-outline-danger btn-transisi">Keluar</a>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4 card-animasi">
            
            <form method="GET" action="index.php" class="d-flex w-100 me-3" style="max-width: 500px;">
                <input type="hidden" name="page" value="dashboard">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari nama produk..." value="<?= isset($_GET['search']) ? escape_output($_GET['search']) : '' ?>">
                <button type="submit" class="btn btn-primary btn-transisi">Cari</button>
                
                <?php if(isset($_GET['search']) && $_GET['search'] !== ''): ?>
                    <a href="index.php?page=dashboard" class="btn btn-secondary ms-2 btn-transisi">Reset</a>
                <?php endif; ?>
            </form>

            <div>
                <a href="index.php?page=create" class="btn btn-success btn-transisi text-nowrap">Tambah Produk</a>
            </div>
            
        </div>

        <?php if(isset($_GET['msg'])): ?>
            <div id="notifikasi" class="alert alert-success shadow-sm">
                <?= escape_output($_GET['msg']) ?>
            </div>
        <?php endif; ?>

        <div class="card shadow-lg border-secondary card-animasi">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0 text-center">
                        <thead class="table-active">
                            <tr>
                                <th class="p-3 text-center">Gambar</th>
                                <th class="text-start">Nama Produk</th>
                                <th class="text-start">Harga</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($produkList as $row): ?>
                            <tr class="row-hover">
                                <td class="p-3 text-center">
                                    <?php if($row['thumbpath']): ?>
                                        <img src="<?= escape_output($row['thumbpath']) ?>" alt="Thumbnail" class="rounded shadow-sm" style="max-height: 60px;">
                                    <?php else: ?>
                                        <span class="text-muted">Tidak ada</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-start"><?= escape_output($row['nama']) ?></td>
                                <td class="text-start">Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                                <td><?= escape_output($row['stok']) ?></td>
                                <td>
                                    <?php 
                                        if ($row['status'] === 'Tersedia') {
                                            echo '<span class="text-success fw-bold">✔️ Tersedia</span>';
                                        } else {
                                            echo '<span class="text-danger fw-bold">❌ Tidak Tersedia</span>';
                                        }
                                    ?>
                                </td>
                                <td>
                                    <a href="index.php?page=edit&id=<?= $row['id'] ?>" class="btn btn-sm btn-warning btn-transisi">Edit</a>
                                    <a href="index.php?page=delete&id=<?= $row['id'] ?>" class="btn btn-sm btn-danger btn-transisi" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <footer class="mt-auto py-4 text-center" style="background-color: #24140f; border-top: 2px solid #5c382a;">
        <div class="container">
            <h6 class="fw-bold mb-1" style="color: #d97706;">Aplikasi Inventaris Toko Roti</h6>
            <small style="color: #fdf5e6;">
                Dikembangkan oleh: <strong>Muhammad Rafly Setyo Handika</strong> | 
                NIM: <strong>A12.2024.07183</strong><br>
                Universitas Dian Nuswantoro &copy; <?= date('Y') ?>
            </small>
        </div>
    </footer>
    <script>
        // Menjalankan script setelah seluruh elemen halaman dimuat
        document.addEventListener("DOMContentLoaded", function() {
            var notifikasi = document.getElementById('notifikasi');
            
            // Jika elemen notifikasi ada di halaman
            if (notifikasi) {
                // Tunggu selama 3 detik (3000 milidetik)
                setTimeout(function() {
                    // Berikan animasi memudar (fade out)
                    notifikasi.style.transition = "opacity 0.5s ease";
                    notifikasi.style.opacity = "0";
                    
                    // Hapus elemen dari memori/halaman setelah animasi selesai (500 milidetik)
                    setTimeout(function() {
                        notifikasi.remove();
                    }, 500);
                    
                }, 2000); 
            }
        });
    </script>
</body>
</html>