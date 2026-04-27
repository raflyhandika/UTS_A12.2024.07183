<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Edit Data - Inventaris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
       /* TEMA TOKO ROTI: Cokelat Gelap, Krem, dan Karamel */
        
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

        /* --- KUMPULAN ANIMASI  --- */
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
<body>
    <div class="container mt-5" style="max-width: 600px;">
        <div class="card shadow-lg border-secondary form-animasi">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">Edit</h4>
            </div>
            <div class="card-body">
                <?php if(isset($error)): ?>
                    <div class='alert alert-danger'><?= escape_output($error) ?></div>
                <?php endif; ?>

                <form method="POST" action="index.php?page=edit&id=<?= $data['id'] ?>" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" value="<?= escape_output($data['nama']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" name="harga" class="form-control" value="<?= $data['harga'] ?>" required min="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control" value="<?= $data['stok'] ?>" required min="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="Tersedia" <?= $data['status'] === 'Tersedia' ? 'selected' : '' ?>>Tersedia</option>
                            <option value="Tidak Tersedia" <?= $data['status'] === 'Tidak Tersedia' ? 'selected' : '' ?>>Tidak Tersedia</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Gambar Produk (Biarkan kosong jika tidak ingin mengubah)</label>
                        <?php if($data['thumbpath']): ?>
                            <div class="mb-2">
                                <img src="<?= escape_output($data['thumbpath']) ?>" class="img-thumbnail" alt="Thumbnail Saat Ini" style="max-height: 100px;">
                            </div>
                        <?php endif; ?>
                        <input type="file" name="gambar" class="form-control" accept=".jpg, .jpeg, .png">
                        <div class="form-text text-light">Format wajib .jpg atau .png (Maksimal 2MB).</div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="index.php?page=dashboard" class="btn btn-secondary btn-transisi">Batal</a>
                        <button type="submit" class="btn btn-primary btn-transisi">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>