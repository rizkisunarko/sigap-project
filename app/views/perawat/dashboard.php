<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { font-family: 'Inter', 'Segoe UI', sans-serif; background-color: #ffffff; }
        .sidebar { background-color: #043622; color: #fff; width: 240px; min-height: 100vh; font-size: 0.95rem; }
        .sidebar a { color: rgba(255,255,255,0.9); text-decoration: none; display: block; padding: 15px 24px; }
        .sidebar a:hover, .sidebar a.active { background-color: rgba(255,255,255,0.1); color: #fff; }
        .sidebar-bottom { background-color: #20c997; padding: 16px 24px; color: #fff; }
        .stat-card { border: 1px solid #cce3d8; border-radius: 8px; box-shadow: none; }
        .stat-card:hover { box-shadow: 0 2px 8px rgba(0,0,0,0.02); }
        .table-custom th { font-weight: 600; color: #444; border-bottom: 1px solid #eaeaea; font-size: 0.75rem; padding: 14px 16px; }
        .table-custom td { font-size: 0.85rem; vertical-align: middle; padding: 14px 16px; border-bottom: 1px solid #eaeaea; color: #111; font-weight: 600; }
        .table-custom td span.desk { font-weight: 500; }
        .task-card { border: 1px solid #111; border-radius: 6px; padding: 12px 16px; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between; }
        .header-title { font-size: 1.1rem; color: #111; font-weight: 700; margin-bottom: 6px; }
        .section-title { font-size: 0.9rem; font-weight: 700; margin-bottom: 16px; color: #111; }
        .value-huge { font-size: 3.2rem; font-weight: 800; line-height: 1; letter-spacing: -1px; }
        .text-urgensi { font-weight: 700; color: #333; }
        .text-rusak { color: #000; }
        
        .progress-bar-custom { height: 10px; background-color: #eaeaea; border-radius: 5px; overflow: hidden; }
        .progress-bar-fill { height: 100%; background-color: #20c997; }
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
            <a href="<?= BASEURL; ?>/perawat/dashboard" class="active">Dashboard</a>
            <a href="<?= BASEURL; ?>/perawat/input_data_pasien">Lihat Pasien Aktif</a>
            <a href="<?= BASEURL; ?>/perawat/tambah_pasien">Tambah Pasien</a>
            <a href="<?= BASEURL; ?>/perawat/direktori_pengguna">Direktori Pengguna</a>
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
    <div class="flex-grow-1 p-5 overflow-auto" style="height: 100vh; background-color: #ffffff;">
        <!-- Header -->
        <div class="mb-4">
            <h1 class="header-title">Shift 2 Front Officer & Rekam Medis</h1>
            <p class="mb-0" style="font-size: 0.85rem; color: #444;">Sabtu, 11 Mei 2026</p>
        </div>

        <!-- Stat Cards -->
        <div class="row g-4 mb-5" style="max-width: 900px;">
            <div class="col-md-4">
                <div class="card stat-card h-100 p-4">
                    <div class="text-uppercase mb-2" style="font-size: 0.7rem; font-weight: 700; color: #111;">TOTAL PASIEN AKTIF</div>
                    <div class="value-huge mb-4">05</div>
                    <div class="mt-auto" style="font-size: 0.65rem; font-weight: 700; color: #555;">KAPASITAS : 12 BED</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card h-100 p-4">
                    <div class="text-uppercase mb-2" style="font-size: 0.7rem; font-weight: 700; color: #111;">KONDISI PASIEN KRITIS</div>
                    <div class="value-huge text-danger mb-4">02</div>
                    <div class="mt-auto" style="font-size: 0.65rem; font-weight: 700; color: #555;">LIHAT PASIEN &rarr;</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card h-100 p-4">
                    <div class="text-uppercase mb-2" style="font-size: 0.7rem; font-weight: 700; color: #111;">STATUS LOGISTIK OKSIGEN</div>
                    <div class="value-huge mb-3">92%</div>
                    <div class="mt-auto">
                        <div class="progress-bar-custom">
                            <div class="progress-bar-fill" style="width: 92%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Ketersediaan Bed -->
        <h6 class="section-title">KETERSEDIAAN BED</h6>
        <div class="card stat-card p-0 mb-5 overflow-hidden" style="max-width: 1000px; border-radius: 6px;">
            <table class="table table-custom mb-0">
                <thead>
                    <tr>
                        <th class="ps-4" style="width: 15%;">NO.RANJANG</th>
                        <th style="width: 60%;">DESKRIPSI</th>
                        <th class="pe-4" style="width: 25%;">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ps-4">BED 08</td>
                        <td><span class="desk">Proses dekontaminasi ozon. Estimasi selesai 45 menit.</span></td>
                        <td class="pe-4">STERILISASI</td>
                    </tr>
                    <tr>
                        <td class="ps-4">BED 07</td>
                        <td><span class="desk">Siap digunakan. Oksigen sentral dan monitor aktif.</span></td>
                        <td class="pe-4">TERSEDIA</td>
                    </tr>
                    <tr>
                        <td class="ps-4">BED 08</td>
                        <td><span class="desk">Perbaikan fungsi pengereman dan hidrolik sisi kanan.</span></td>
                        <td class="pe-4">MAINTENANCE</td>
                    </tr>
                    <tr>
                        <td class="ps-4">BED 09</td>
                        <td><span class="desk">Menunggu konfirmasi pemulangan pasien (Discharge).</span></td>
                        <td class="pe-4">DIORDER</td>
                    </tr>
                    <tr>
                        <td class="ps-4">BED 10</td>
                        <td><span class="desk">Penggantian linen dan pembersihan rutin area bed.</span></td>
                        <td class="pe-4">TERSEDIA</td>
                    </tr>
                    <tr>
                        <td class="ps-4">BED 11</td>
                        <td><span class="desk">Siap digunakan. Oksigen sentral dan monitor aktif.</span></td>
                        <td class="pe-4">TERSEDIA</td>
                    </tr>
                    <tr>
                        <td class="ps-4 border-bottom-0">BED 12</td>
                        <td class="border-bottom-0"><span class="desk">Kerusakan pada sistem sensor monitor vital sign.</span></td>
                        <td class="border-bottom-0 pe-4 text-rusak">RUSAK</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Table Antrean Masuk -->
        <h6 class="section-title">ANTREAN MASUK</h6>
        <div class="card stat-card p-0 mb-5 overflow-hidden" style="max-width: 750px; border-radius: 6px;">
            <table class="table table-custom mb-0">
                <thead>
                    <tr>
                        <th class="ps-4" style="width: 20%;">NO.PASIEN</th>
                        <th style="width: 50%;">NAMA PASIEN</th>
                        <th class="pe-4" style="width: 30%;">URGENSI</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ps-4">001</td>
                        <td>DARMAYANA</td>
                        <td class="pe-4 text-urgensi">TINGKAT 1</td>
                    </tr>
                    <tr>
                        <td class="ps-4">002</td>
                        <td>SUTIEH</td>
                        <td class="pe-4 text-urgensi">TINGKAT 2</td>
                    </tr>
                    <tr>
                        <td class="ps-4 border-bottom-0">003</td>
                        <td class="border-bottom-0">MATTOHER</td>
                        <td class="pe-4 border-bottom-0 text-urgensi">TINGKAT 2</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Tugas Shift -->
        <div class="card stat-card p-4" style="max-width: 650px; border-radius: 6px;">
            <h6 class="section-title mb-4">TUGAS SHIFT</h6>
            
            <div class="d-flex justify-content-between px-3" style="font-size: 0.7rem; font-weight: 700; color: #111; margin-bottom: 8px;">
                <div style="width: 50%;">TUGAS</div>
                <div style="width: 30%; text-align: center;">TENGGAT</div>
                <div style="width: 20%; text-align: center;">STATUS</div>
            </div>

            <div class="task-card">
                <div style="width: 50%; font-size: 0.8rem; font-weight: 600;">MEMERIKSA KONDISI PASIEN DI AWAL SHIFT</div>
                <div style="width: 30%; text-align: center; font-size: 0.8rem; font-weight: 600;">10.00 WIB</div>
                <div style="width: 20%; display: flex; justify-content: center;">
                    <div style="width: 18px; height: 18px; border: 1px solid #111; border-radius: 4px;"></div>
                </div>
            </div>

            <div class="task-card">
                <div style="width: 50%; font-size: 0.8rem; font-weight: 600;">Cek AGD Bed 01</div>
                <div style="width: 30%; text-align: center; font-size: 0.8rem; font-weight: 600;">12.00 WIB</div>
                <div style="width: 20%; display: flex; justify-content: center;">
                    <div style="width: 18px; height: 18px; border: 1px solid #111; border-radius: 4px;"></div>
                </div>
            </div>

            <div class="task-card mb-0">
                <div style="width: 50%; font-size: 0.8rem; font-weight: 600;">Miring Kanan All Bed</div>
                <div style="width: 30%; text-align: center; font-size: 0.8rem; font-weight: 600;">13.00 WIB</div>
                <div style="width: 20%; display: flex; justify-content: center;">
                    <div style="width: 18px; height: 18px; border: 1px solid #111; border-radius: 4px;"></div>
                </div>
            </div>

        </div>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
