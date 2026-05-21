<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direktori Pengguna - Hospital</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { font-family: 'Inter', 'Segoe UI', sans-serif; background-color: #ffffff; margin: 0; }
        .sidebar { background-color: #043622; color: #fff; width: 240px; min-height: 100vh; font-size: 0.95rem; }
        .sidebar a { color: rgba(255,255,255,0.9); text-decoration: none; display: block; padding: 15px 24px; }
        .sidebar a:hover, .sidebar a.active { background-color: rgba(255,255,255,0.1); color: #fff; }
        .sidebar-bottom { background-color: #20c997; padding: 16px 24px; color: #fff; }
        
        .header-info { padding: 25px 40px 15px; border-bottom: 2px solid #f1f1f1; }
        .header-title-top { font-size: 1.25rem; color: #111; font-weight: 800; margin-bottom: 2px; text-transform: uppercase; }
        .header-subtitle { font-size: 0.85rem; font-weight: 600; color: #777; }
        
        .content-area { padding: 30px 40px; }
        
        .search-box { position: relative; width: 300px; margin-bottom: 20px; }
        .search-box input { border-radius: 6px; padding: 8px 15px 8px 35px; border: 1px solid #ddd; font-size: 0.85rem; width: 100%; color: #555; }
        .search-box input:focus { border-color: #20c997; box-shadow: 0 0 0 0.2rem rgba(32, 201, 151, 0.25); outline: none; }
        .search-box input::placeholder { color: #aaa; }
        .search-box i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #aaa; font-size: 0.85rem; }
        
        .table-container { border: 1px solid #52cba1; border-radius: 8px; overflow: hidden; }
        .table-custom { margin-bottom: 0; }
        .table-custom th { background-color: #f9f9f9; font-weight: 700; color: #444; border-bottom: 1px solid #eaeaea; font-size: 0.7rem; padding: 16px; text-align: center; }
        .table-custom th.text-start { text-align: left; }
        .table-custom td { font-size: 0.75rem; vertical-align: middle; padding: 16px; border-bottom: 1px solid #eaeaea; color: #111; font-weight: 700; text-align: center; }
        .table-custom td.text-start { text-align: left; font-weight: 800; }
        .table-custom tr:last-child td { border-bottom: none; }
        
        .action-icons { display: flex; justify-content: center; gap: 12px; }
        .action-icons i { font-size: 1.1rem; cursor: pointer; color: #555; }
        .action-icons i:hover { color: #111; }
        .action-icons i.text-danger { color: #dc3545; }
        .action-icons i.text-danger:hover { color: #b02a37; }
    </style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column flex-shrink-0">
        <div class="p-4 d-flex align-items-center gap-2 mb-2">
            <img src="<?= BASEURL; ?>/assets/img/logo.png" width="34" height="34" alt="Logo" class="d-inline-block align-text-top">
            <span class="fs-5 fw-bold" style="letter-spacing: 1px;">HOSPITAL</span>
        </div>
        <div class="flex-grow-1">
            <a href="<?= BASEURL; ?>/perawat/dashboard">Dashboard</a>
            <a href="<?= BASEURL; ?>/perawat/input_data_pasien">Lihat Pasien Aktif</a>
            <a href="<?= BASEURL; ?>/perawat/tambah_pasien">Tambah Pasien</a>
            <a href="<?= BASEURL; ?>/perawat/direktori_pengguna" class="active">Direktori Pengguna</a>
        </div>
        <div class="sidebar-bottom d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle bg-dark text-white d-flex justify-content-center align-items-center" style="width: 32px; height: 32px; font-weight: bold; font-size: 0.9rem;">F</div>
                <div style="line-height: 1.2;">
                    <div class="fw-bold" style="font-size: 0.75rem;">FIRMANSYAH</div>
                    <div style="font-size: 0.65rem;">FRONT OFFICER</div>
                </div>
            </div>
            <i class="bi bi-gear-fill fs-6" style="cursor: pointer; color: black;"></i>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 overflow-auto" style="height: 100vh;">
        
        <!-- Header Info -->
        <div class="header-info">
            <div class="header-title-top">DASHBOARD AKUN</div>
            <div class="header-subtitle">Kumpulan Data Pasien</div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Cari Nama...">
            </div>

            <div class="table-container bg-white">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th style="width: 15%;">MRN</th>
                            <th class="text-start" style="width: 25%;">NAMA LENGKAP</th>
                            <th style="width: 15%;">JENIS KELAMIN</th>
                            <th style="width: 15%;">ASAL</th>
                            <th style="width: 15%;">NO.HP KELUARGA</th>
                            <th style="width: 15%;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for($i=0; $i<9; $i++): ?>
                        <tr>
                            <td>ICU-2024-001</td>
                            <td class="text-start">AHMAD SUCIPTO</td>
                            <td>L</td>
                            <td>JOMBANG</td>
                            <td>082156345634</td>
                            <td class="action-icons d-flex justify-content-center border-0" style="padding-top: 20px;">
                                <a href="<?= BASEURL; ?>/perawat/detail_pasien" class="text-dark"><i class="bi bi-eye"></i></a>
                                <a href="<?= BASEURL; ?>/perawat/edit_pasien" class="text-dark"><i class="bi bi-pencil-square"></i></a>
                                <a href="<?= BASEURL; ?>/perawat/pengaturan" class="text-dark"><i class="bi bi-gear-fill"></i></a>
                                <a href="<?= BASEURL; ?>/perawat/keluar_pasien"><i class="bi bi-box-arrow-right text-danger"></i></a>
                            </td>
                        </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>