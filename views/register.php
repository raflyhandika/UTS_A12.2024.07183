<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Aplikasi Inventaris</title>
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
<body class="d-flex align-items-center py-4 bg-body-tertiary min-vh-100">
    <main class="form-signin w-100 m-auto" style="max-width: 400px;">
        <form method="POST" action="index.php?page=register" class="card p-4 shadow-lg border-secondary">
            <h2 class="mb-4 text-center">Registrasi</h2>
            
            <?php if(isset($error)): ?>
                <div class='alert alert-danger'><?= escape_output($error) ?></div>
            <?php endif; ?>

            <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
            
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required autocomplete="off">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required 
                       oninvalid="this.setCustomValidity('Isian tidak valid')" 
                       oninput="this.setCustomValidity('')">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            
            <button class="btn btn-success w-100 btn-transisi mb-3" type="submit">Simpan</button>
            
            <div class="text-center">
                <span class="text-light">Sudah punya akun? </span>
                <a href="index.php?page=login" class="text-decoration-none text-primary fw-bold">Masuk</a>
            </div>
        </form>
    </main>
</body>
</html>