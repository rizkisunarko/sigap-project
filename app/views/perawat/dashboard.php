<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_staff'])) {
    $_SESSION['user']['nama'] = $_POST['namaLengkap'];
    $_SESSION['user']['role'] = $_POST['divisi'];
    $_SESSION['user']['shift'] = $_POST['shift'];
    
    // Redirect untuk menghindari form resubmission (PRG Pattern)
    $clean_url = strtok($_SERVER["REQUEST_URI"], '?');
    header("Location: " . $clean_url);
    exit;
}

// Tangkap data dari dummy login halaman portal-staff (jika ada disubmit melalui metode GET)
if (isset($_GET['namaLengkap'])) {
    $_SESSION['user']['nama'] = $_GET['namaLengkap'];
    $_SESSION['user']['role'] = $_GET['divisi'];
    $_SESSION['user']['shift'] = $_GET['shift'];
    
    // Hilangkan parameter GET di URL agar tidak nimpa data saat form POST (EDIT)
    $clean_url = strtok($_SERVER["REQUEST_URI"], '?');
    header("Location: " . $clean_url);
    exit;
}

// Mendapatkan data user dari session atau menggunakan default untuk tampilan frontend
$userName = !empty($_SESSION['user']['nama']) ? $_SESSION['user']['nama'] : 'FIRMANSYAH';
$userRole = !empty($_SESSION['user']['role']) ? $_SESSION['user']['role'] : 'FRONT OFFICER';
$userShift = !empty($_SESSION['user']['shift']) ? $_SESSION['user']['shift'] : 'Shift 2';
$userInitial = strtoupper(substr($userName, 0, 1));
?>
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
        .task-checked { text-decoration: line-through; color: #888 !important; }
        
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
                <div class="rounded-circle bg-dark text-white d-flex justify-content-center align-items-center" style="width: 32px; height: 32px; font-weight: bold; font-size: 0.9rem;"><?= htmlspecialchars($userInitial) ?></div>
                <div style="line-height: 1.2;">
                    <div class="fw-bold text-uppercase" style="font-size: 0.75rem; max-width: 140px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?= htmlspecialchars($userName) ?>"><?= htmlspecialchars($userName) ?></div>
                    <div class="text-uppercase" style="font-size: 0.65rem; max-width: 140px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?= htmlspecialchars($userRole) ?>"><?= htmlspecialchars($userRole) ?></div>
                </div>
            </div>
            <i class="bi bi-gear-fill fs-6" style="cursor: pointer; color: black;" data-bs-toggle="modal" data-bs-target="#staffAccountModal"></i>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 p-5 overflow-auto" style="height: 100vh; background-color: #ffffff;">
        <!-- Header -->
        <div class="mb-4">
            <h1 class="header-title">Shift <?= htmlspecialchars($userShift) ?> <?= htmlspecialchars($userRole) ?></h1>
            <p class="mb-0" style="font-size: 0.85rem; color: #444;"><?= date('l, d M Y') ?></p>
        </div>

        <!-- Stat Cards -->
        <div class="row g-4 mb-5" style="max-width: 900px;">
            <div class="col-md-4">
                <div class="card stat-card h-100 p-4">
                    <div class="text-uppercase mb-2" style="font-size: 0.7rem; font-weight: 700; color: #111;">TOTAL PASIEN AKTIF</div>
                    <div class="value-huge mb-4"><?= str_pad($data['pasien_aktif'], 2, '0', STR_PAD_LEFT) ?></div>
                    <div class="mt-auto" style="font-size: 0.65rem; font-weight: 700; color: #555;">KAPASITAS : <?= htmlspecialchars($data['kapasitas']) ?> BED</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card h-100 p-4">
                    <div class="text-uppercase mb-2" style="font-size: 0.7rem; font-weight: 700; color: #111;">KONDISI PASIEN KRITIS</div>
                    <div class="value-huge text-danger mb-4"><?= str_pad($data['pasien_kritis'], 2, '0', STR_PAD_LEFT) ?></div>
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
                    <?php if (!empty($data['beds'])): ?>
                        <?php foreach ($data['beds'] as $bed): ?>
                            <tr>
                                <td class="ps-4"><?= htmlspecialchars($bed['nomor_bed']) ?></td>
                                <td><span class="desk"><?= htmlspecialchars($bed['detail_status']) ?></span></td>
                                <td class="pe-4"><?= strtoupper($bed['status_bed']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td class="ps-4" colspan="3">Tidak ada data bed.</td>
                        </tr>
                    <?php endif; ?>
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
                    <?php if (!empty($data['queue'])): ?>
                        <?php $idx = 1; foreach ($data['queue'] as $q): ?>
                            <tr>
                                <td class="ps-4"><?= str_pad($idx++, 3, '0', STR_PAD_LEFT) ?></td>
                                <td><?= htmlspecialchars($q['nama_lengkap']) ?></td>
                                <td class="pe-4 text-urgensi"><?= strtoupper($q['urgensi']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td class="ps-4" colspan="3">Tidak ada antrean hari ini.</td>
                        </tr>
                    <?php endif; ?>
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

            <?php if (!empty($data['tasks'])): ?>
                <?php foreach ($data['tasks'] as $task): ?>
                    <div class="task-card">
                        <div class="task-text <?= ($task['status_dilakukan'] === 'sudah') ? 'task-checked' : '' ?>" style="width: 50%; font-size: 0.8rem; font-weight: 600; transition: all 0.3s;"><?= htmlspecialchars($task['tugas_shift']) ?></div>
                        <div style="width: 30%; text-align: center; font-size: 0.8rem; font-weight: 600;"><?= date('H.i', strtotime($task['tenggat'])) ?> WIB</div>
                        <div style="width: 20%; display: flex; justify-content: center;">
                            <input type="checkbox" class="task-checkbox" style="width: 18px; height: 18px; cursor: pointer; border-radius: 4px;" <?= ($task['status_dilakukan'] === 'sudah') ? 'checked' : '' ?>>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>

    </div>
</div>

<!-- Modal Staff Account -->
<div class="modal fade" id="staffAccountModal" tabindex="-1" aria-labelledby="staffAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content px-4 py-3" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 pb-1 px-0 d-flex justify-content-between align-items-center">
                <h5 class="modal-title m-0" id="staffAccountModalLabel" style="color: #043622; font-weight: 800; font-size: 1.1rem;">STAFF ACCOUNT</h5>
                <span data-bs-dismiss="modal" aria-label="Close" style="cursor: pointer; font-size: 1.25rem; font-weight: 800; color: #111;">X</span>
            </div>
            <hr style="border-top: 1.5px solid #111; opacity: 1; margin: 0 0 35px 0;">
            
            <div class="modal-body p-0">
                <form id="staffUpdateForm" method="POST" action="">
                    <input type="hidden" name="update_staff" value="1">
                    <div class="row mb-3 align-items-center">
                        <label class="col-4 col-form-label text-end pe-2" style="color: #043622; font-weight: 500; font-size: 0.85rem;">Nama Lengkap :</label>
                        <div class="col-8 ps-2">
                            <input type="text" name="namaLengkap" class="form-control" value="<?= htmlspecialchars($userName) ?>" readonly style="border-radius: 50px; border: 1px solid #111; padding: 4px 15px; font-weight: 500; font-size: 0.85rem;">
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <label class="col-4 col-form-label text-end pe-2" style="color: #043622; font-weight: 500; font-size: 0.85rem;">Divisi :</label>
                        <div class="col-8 ps-2">
                            <select name="divisi" class="form-select text-dark" disabled style="border-radius: 50px; border: 1px solid #111; padding: 4px 15px; font-weight: 500; font-size: 0.85rem; background-color: #fff; cursor: not-allowed; background-image: none;">
                                <option value="Rekam Medis" <?= ($userRole == 'Rekam Medis') ? 'selected' : '' ?>>Rekam Medis</option>
                                <option value="Front Officer" <?= ($userRole == 'Front Officer') ? 'selected' : '' ?>>Front Officer</option>
                            </select>
                        </div>
                    </div>
                    <div class="row align-items-center mb-4">
                        <label class="col-4 col-form-label text-end pe-2" style="color: #043622; font-weight: 500; font-size: 0.85rem;">Shift :</label>
                        <div class="col-8 ps-2">
                            <?php $currentShift = $_SESSION['user']['shift'] ?? 'Shift 2'; ?>
                            <select name="shift" class="form-select text-dark" disabled style="border-radius: 50px; border: 1px solid #111; padding: 4px 15px; font-weight: 500; font-size: 0.85rem; background-color: #fff; cursor: not-allowed; background-image: none;">
                                <option value="Shift 1" <?= ($currentShift == 'Shift 1') ? 'selected' : '' ?>>Shift 1</option>
                                <option value="Shift 2" <?= ($currentShift == 'Shift 2') ? 'selected' : '' ?>>Shift 2</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex flex-column gap-3 align-items-center mt-5 mb-2">
                        <button type="button" id="btnEditSave" class="btn" style="background-color: #20c997; color: white; border: 1px solid #111; font-weight: 700; width: 65%; border-radius: 8px; padding: 8px; font-size: 0.85rem; letter-spacing: 0.5px;">EDIT</button>
                        <a href="<?= BASEURL; ?>/portal-staff/logout" class="btn" style="background-color: #dc3545; color: white; border: 1px solid #111; font-weight: 700; width: 65%; border-radius: 8px; padding: 8px; font-size: 0.85rem; text-decoration: none; text-align: center; letter-spacing: 0.5px;">LOGOUT</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnEditSave = document.getElementById('btnEditSave');
        const updateForm = document.getElementById('staffUpdateForm');
        const inputs = updateForm.querySelectorAll('input[type="text"], select');

        btnEditSave.addEventListener('click', function() {
            if (btnEditSave.innerText.trim() === 'EDIT') {
                // Berubah ke mode edit
                inputs.forEach(input => {
                    input.removeAttribute('readonly');
                    input.removeAttribute('disabled');
                    input.style.borderColor = '#13c898';
                    input.style.boxShadow = '0 0 5px rgba(19, 200, 152, 0.5)';
                    input.style.backgroundColor = '#fdfdfd';
                });
                
                // Kembalikan ikon panah dan kursor untuk dropdown
                const selects = updateForm.querySelectorAll('select');
                selects.forEach(sel => {
                    sel.style.backgroundImage = '';
                    sel.style.cursor = 'pointer';
                });

                inputs[0].focus();
                btnEditSave.innerText = 'SAVE';
            } else {
                // Submit data
                updateForm.submit();
            }
        });

        // Handle Shift Task Checkboxes
        const taskCheckboxes = document.querySelectorAll('.task-checkbox');
        taskCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const taskCard = this.closest('.task-card');
                const taskText = taskCard.querySelector('.task-text');
                if (this.checked) {
                    taskText.classList.add('task-checked');
                } else {
                    taskText.classList.remove('task-checked');
                }
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
