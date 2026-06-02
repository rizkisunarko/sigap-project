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

// Mendapatkan data user dari session atau menggunakan default untuk tampilan frontend
$userName = !empty($_SESSION['user']['nama']) ? $_SESSION['user']['nama'] : 'FIRMANSYAH';
$userRole = !empty($_SESSION['user']['role']) ? $_SESSION['user']['role'] : 'FRONT OFFICER';
$userInitial = strtoupper(substr($userName, 0, 1));
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesi Aktif Perawat - Data Pasien Aktif</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background-color: #ffffff;
            margin: 0;
        }

        .sidebar {
            background-color: #043622;
            color: #fff;
            width: 240px;
            min-height: 100vh;
            font-size: 0.95rem;
        }

        .sidebar a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            display: block;
            padding: 15px 24px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .sidebar-bottom {
            background-color: #20c997;
            padding: 16px 24px;
            color: #fff;
        }

        .header-info {
            padding: 25px 40px 15px;
            border-bottom: 1px solid #eaeaea;
        }

        .header-title-top {
            font-size: 1.05rem;
            color: #111;
            font-weight: 700;
            margin-bottom: 2px;
            text-transform: uppercase;
        }

        .header-subtitle {
            font-size: 0.75rem;
            font-weight: 600;
            color: #777;
            text-transform: uppercase;
        }

        .content-area {
            padding: 30px 40px;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: #111;
            text-transform: uppercase;
            margin: 0;
        }

        .search-box {
            position: relative;
            width: 280px;
        }

        .search-box input {
            border-radius: 20px;
            padding: 8px 15px 8px 35px;
            border: 1px solid #ddd;
            font-size: 0.8rem;
            width: 100%;
            color: #555;
        }

        .search-box input:focus {
            border-color: #20c997;
            box-shadow: 0 0 0 0.2rem rgba(32, 201, 151, 0.25);
            outline: none;
        }

        .search-box input::placeholder {
            color: #aaa;
        }

        .search-box i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            font-size: 0.85rem;
        }

        .table-container {
            border: 1px solid #52cba1;
            border-radius: 8px;
            overflow: hidden;
            margin-top: 25px;
        }

        .table-custom {
            margin-bottom: 0;
        }

        .table-custom th {
            background-color: #fafafa;
            font-weight: 700;
            color: #555;
            border-bottom: 1px solid #eaeaea;
            font-size: 0.7rem;
            padding: 14px 20px;
        }

        .table-custom td {
            font-size: 0.8rem;
            vertical-align: middle;
            padding: 14px 20px;
            border-bottom: 1px solid #eaeaea;
            color: #111;
            font-weight: 700;
        }

        .table-custom tr:last-child td {
            border-bottom: none;
        }

        .text-kritis {
            color: #dc3545;
            font-weight: 800;
            font-size: 0.75rem;
            text-transform: uppercase;
        }

        .action-icons {
            display: flex;
            justify-content: center;
            gap: 16px;
            align-items: center;
            border-bottom: none !important;
        }

        .action-icons a {
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .action-icons i {
            font-size: 1.2rem;
            cursor: pointer;
            color: #111;
            margin: 0;
            transition: color 0.2s;
        }

        .action-icons a:hover i {
            color: #555;
        }

        .action-icons i.text-danger {
            color: #dc3545;
        }

        .action-icons a:hover i.text-danger {
            color: #a71d2a;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column flex-shrink-0">
            <div class="p-4 d-flex align-items-center gap-2 mb-2">
                <img src="<?= BASEURL; ?>/assets/img/logo.png" width="34" height="34" alt="Logo"
                    class="d-inline-block align-text-top">
                <span class="fs-5 fw-bold" style="letter-spacing: 1px;">HOSPITAL</span>
            </div>
            <div class="flex-grow-1">
                <a href="<?= BASEURL; ?>/perawat/dashboard">Dashboard</a>
                <a href="<?= BASEURL; ?>/perawat/input_data_pasien" class="active">Lihat Pasien Aktif</a>
                <a href="<?= BASEURL; ?>/perawat/tambah_pasien">Tambah Pasien</a>
                <a href="<?= BASEURL; ?>/perawat/direktori_pengguna">Direktori Pengguna</a>
            </div>
            <div class="sidebar-bottom d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-dark text-white d-flex justify-content-center align-items-center"
                        style="width: 32px; height: 32px; font-weight: bold; font-size: 0.9rem;">
                        <?= htmlspecialchars($userInitial) ?></div>
                    <div style="line-height: 1.2;">
                        <div class="fw-bold text-uppercase"
                            style="font-size: 0.75rem; max-width: 140px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                            title="<?= htmlspecialchars($userName) ?>"><?= htmlspecialchars($userName) ?></div>
                        <div class="text-uppercase"
                            style="font-size: 0.65rem; max-width: 140px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                            title="<?= htmlspecialchars($userRole) ?>"><?= htmlspecialchars($userRole) ?></div>
                    </div>
                </div>
                <i class="bi bi-gear-fill fs-6" style="cursor: pointer; color: black;" data-bs-toggle="modal"
                    data-bs-target="#staffAccountModal"></i>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 overflow-auto" style="height: 100vh;">

            <!-- Header Info -->
            <div class="header-info">
                <div class="header-title-top">SESI AKTIF PERAWAT</div>
                <div class="header-subtitle">UNIT PERAWATAN INSENTIF</div>
            </div>

            <!-- Content Area -->
            <div class="content-area">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="section-title">DATA PASIEN AKTIF</div>
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" placeholder="Cari MRN atau Nama...">
                    </div>
                </div>

                <div class="table-container bg-white">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th style="width: 15%;">NO.BED</th>
                                <th style="width: 25%;">NAMA LENGKAP</th>
                                <th style="width: 25%;">MRN (REKAM MEDIS)</th>
                                <th style="width: 15%;">STATUS KLINIS</th>
                                <th style="width: 20%;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['patients'])): ?>
                                <?php foreach ($data['patients'] as $patient): ?>
                                    <tr>
                                        <td class="ps-4"><?= htmlspecialchars($patient['nomor_bed'] ?: 'TBA') ?></td>
                                        <td><?= htmlspecialchars($patient['nama_lengkap']) ?></td>
                                        <td>ICU-2026-<?= str_pad($patient['id_pasien'], 3, '0', STR_PAD_LEFT) ?></td>
                                        <td class="text-kritis"><?= htmlspecialchars(strtoupper($patient['status_klinis'] ?: 'STABIL')) ?></td>
                                        <td class="action-icons">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#patientDetailModal"
                                                class="text-dark btn-view-pasien" 
                                                data-nama="<?= htmlspecialchars($patient['nama_lengkap']) ?>"
                                                data-mrn="ICU-2026-<?= str_pad($patient['id_pasien'], 3, '0', STR_PAD_LEFT) ?>" 
                                                data-jk="<?= htmlspecialchars($patient['jenis_kelamin']) ?>" 
                                                data-asal="<?= htmlspecialchars($patient['asal']) ?>"
                                                data-nik="<?= htmlspecialchars($patient['nik']) ?>"
                                                data-nohp="<?= htmlspecialchars($patient['no_hp_wali']) ?>"><i class="bi bi-eye"></i></a>
                                            
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#patientEditModal"
                                                class="text-dark btn-edit-pasien" 
                                                data-idrm="<?= $patient['id_rekam_medis'] ?>"
                                                data-username="<?= htmlspecialchars($patient['username'] ?: '') ?>"
                                                data-password="" 
                                                data-nik="<?= htmlspecialchars($patient['nik'] ?: '') ?>"
                                                data-nama="<?= htmlspecialchars($patient['nama_lengkap'] ?: '') ?>" 
                                                data-asal="<?= htmlspecialchars($patient['asal'] ?: '') ?>" 
                                                data-tgllahir="<?= htmlspecialchars($patient['tgl_lahir'] ?: '') ?>"
                                                data-jk="<?= htmlspecialchars($patient['jenis_kelamin'] ?: 'L') ?>" 
                                                data-agama="<?= htmlspecialchars($patient['agama'] ?: '') ?>" 
                                                data-statuskawin="<?= htmlspecialchars($patient['status_perkawinan'] ?: '') ?>" 
                                                data-pekerjaan="<?= htmlspecialchars($patient['pekerjaan'] ?: '') ?>"
                                                data-alamat="<?= htmlspecialchars($patient['alamat'] ?: '') ?>"
                                                data-bpjs="<?= htmlspecialchars($patient['nomor_bpjs'] ?: '') ?>"
                                                data-goldarah="<?= htmlspecialchars($patient['golongan_darah'] ?: '') ?>"
                                                data-alergi="" 
                                                data-kewarganegaraan="<?= htmlspecialchars($patient['kewarganegaraan'] ?: '') ?>"
                                                data-namawali="<?= htmlspecialchars($patient['nama_wali'] ?: '') ?>"
                                                data-statuswali="<?= htmlspecialchars($patient['status_wali'] ?: '') ?>"
                                                data-nikwali="<?= htmlspecialchars($patient['nik_wali'] ?: '') ?>"
                                                data-nohpwali="<?= htmlspecialchars($patient['no_hp_wali'] ?: '') ?>"
                                                data-alamatwali="<?= htmlspecialchars($patient['alamat_wali'] ?: '') ?>"><i class="bi bi-pencil-square"></i></a>
                                            
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#editRekamMedisModal"
                                                class="text-dark btn-edit-rekammedis" data-nobed="<?= htmlspecialchars($patient['nomor_bed'] ?: 'TBA') ?>"><i class="bi bi-gear-fill"></i></a>
                                            
                                            <a href="javascript:void(0);" class="btn-exit-pasien" data-idrm="<?= $patient['id_rekam_medis'] ?>"><i class="bi bi-box-arrow-right text-danger"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Tidak ada pasien aktif saat ini.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Staff Account -->
    <div class="modal fade" id="staffAccountModal" tabindex="-1" aria-labelledby="staffAccountModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
            <div class="modal-content px-4 py-3"
                style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                <div class="modal-header border-0 pb-1 px-0 d-flex justify-content-between align-items-center">
                    <h5 class="modal-title m-0" id="staffAccountModalLabel"
                        style="color: #043622; font-weight: 800; font-size: 1.1rem;">STAFF ACCOUNT</h5>
                    <span data-bs-dismiss="modal" aria-label="Close"
                        style="cursor: pointer; font-size: 1.25rem; font-weight: 800; color: #111;">X</span>
                </div>
                <hr style="border-top: 1.5px solid #111; opacity: 1; margin: 0 0 35px 0;">

                <div class="modal-body p-0">
                    <form id="staffUpdateForm" method="POST" action="">
                        <input type="hidden" name="update_staff" value="1">
                        <div class="row mb-3 align-items-center">
                            <label class="col-4 col-form-label text-end pe-2"
                                style="color: #043622; font-weight: 500; font-size: 0.85rem;">Nama Lengkap :</label>
                            <div class="col-8 ps-2">
                                <input type="text" name="namaLengkap" class="form-control"
                                    value="<?= htmlspecialchars($userName) ?>" readonly
                                    style="border-radius: 50px; border: 1px solid #111; padding: 4px 15px; font-weight: 500; font-size: 0.85rem;">
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label class="col-4 col-form-label text-end pe-2"
                                style="color: #043622; font-weight: 500; font-size: 0.85rem;">Divisi :</label>
                            <div class="col-8 ps-2">
                                <select name="divisi" class="form-select text-dark" disabled
                                    style="border-radius: 50px; border: 1px solid #111; padding: 4px 15px; font-weight: 500; font-size: 0.85rem; background-color: #fff; cursor: not-allowed; background-image: none;">
                                    <option value="Rekam Medis" <?= ($userRole == 'Rekam Medis') ? 'selected' : '' ?>>Rekam
                                        Medis</option>
                                    <option value="Front Officer" <?= ($userRole == 'Front Officer') ? 'selected' : '' ?>>
                                        Front Officer</option>
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-center mb-4">
                            <label class="col-4 col-form-label text-end pe-2"
                                style="color: #043622; font-weight: 500; font-size: 0.85rem;">Shift :</label>
                            <div class="col-8 ps-2">
                                <?php $currentShift = $_SESSION['user']['shift'] ?? 'Shift 2'; ?>
                                <select name="shift" class="form-select text-dark" disabled
                                    style="border-radius: 50px; border: 1px solid #111; padding: 4px 15px; font-weight: 500; font-size: 0.85rem; background-color: #fff; cursor: not-allowed; background-image: none;">
                                    <option value="Shift 1" <?= ($currentShift == 'Shift 1') ? 'selected' : '' ?>>Shift 1
                                    </option>
                                    <option value="Shift 2" <?= ($currentShift == 'Shift 2') ? 'selected' : '' ?>>Shift 2
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-3 align-items-center mt-5 mb-2">
                            <button type="button" id="btnEditSave" class="btn"
                                style="background-color: #20c997; color: white; border: 1px solid #111; font-weight: 700; width: 65%; border-radius: 8px; padding: 8px; font-size: 0.85rem; letter-spacing: 0.5px;">EDIT</button>
                            <a href="<?= BASEURL; ?>/portal-staff/logout" class="btn"
                                style="background-color: #dc3545; color: white; border: 1px solid #111; font-weight: 700; width: 65%; border-radius: 8px; padding: 8px; font-size: 0.85rem; text-decoration: none; text-align: center; letter-spacing: 0.5px;">LOGOUT</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Informasi Data Pasien Baru -->
    <div class="modal fade" id="patientDetailModal" tabindex="-1" aria-labelledby="patientDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content"
                style="border-radius: 12px; border: 2px solid #20c997; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                <div class="modal-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="m-0" style="color: #111; font-weight: 700; font-size: 1.1rem;">INFORMASI PASIEN</h5>
                        <a href="#"
                            style="color: #111; text-decoration: none; font-weight: 500; font-size: 0.9rem;">Lihat
                            Detail &rarr;</a>
                    </div>

                    <!-- Bagian Informasi Pasien -->
                    <div style="border: 1px solid #111; border-radius: 12px; padding: 25px;">
                        <div class="row gx-5">
                            <div class="col-md-6">
                                <div class="row align-items-center mb-3">
                                    <label class="col-sm-5 col-form-label"
                                        style="color: #111; font-weight: 500; font-size: 0.95rem;">MRN :</label>
                                    <div class="col-sm-7">
                                        <input type="text" id="modalMrn" class="form-control" readonly
                                            style="border: 1px solid #111; border-radius: 0; background-color: transparent;">
                                    </div>
                                </div>
                                <div class="row align-items-center mb-3">
                                    <label class="col-sm-5 col-form-label"
                                        style="color: #111; font-weight: 500; font-size: 0.95rem;">Nama Lengkap
                                        :</label>
                                    <div class="col-sm-7">
                                        <input type="text" id="modalNamaLengkap" class="form-control" readonly
                                            style="border: 1px solid #111; border-radius: 0; background-color: transparent;">
                                    </div>
                                </div>
                                <div class="row align-items-center mb-3">
                                    <label class="col-sm-5 col-form-label"
                                        style="color: #111; font-weight: 500; font-size: 0.95rem;">NIK :</label>
                                    <div class="col-sm-7">
                                        <input type="text" id="modalNik" class="form-control" readonly
                                            style="border: 1px solid #111; border-radius: 0; background-color: transparent;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row align-items-center mb-3">
                                    <label class="col-sm-5 col-form-label"
                                        style="color: #111; font-weight: 500; font-size: 0.95rem;">Jenis Kelamin
                                        :</label>
                                    <div class="col-sm-7">
                                        <input type="text" id="modalJk" class="form-control" readonly
                                            style="border: 1px solid #111; border-radius: 0; background-color: transparent;">
                                    </div>
                                </div>
                                <div class="row align-items-center mb-3">
                                    <label class="col-sm-5 col-form-label"
                                        style="color: #111; font-weight: 500; font-size: 0.95rem;">Asal :</label>
                                    <div class="col-sm-7">
                                        <input type="text" id="modalAsal" class="form-control" readonly
                                            style="border: 1px solid #111; border-radius: 0; background-color: transparent;">
                                    </div>
                                </div>
                                <div class="row align-items-center mb-3">
                                    <label class="col-sm-5 col-form-label"
                                        style="color: #111; font-weight: 500; font-size: 0.95rem;">No.HP Keluarga
                                        :</label>
                                    <div class="col-sm-7">
                                        <input type="text" id="modalNoHp" class="form-control" readonly
                                            style="border: 1px solid #111; border-radius: 0; background-color: transparent;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 mb-2">
                        <h6 style="color: #111; font-weight: 700; font-size: 1rem;">JUMLAH TOTAL KUNJUNGAN : 2</h6>
                    </div>

                    <!-- Bagian Riwayat Kunjungan -->
                    <div style="border: 1px solid #111; border-radius: 12px; padding: 25px;">

                        <!-- Item Kunjungan 1 -->
                        <div style="border: 1px solid #111; border-radius: 8px; padding: 15px 30px; margin-bottom: 15px;"
                            class="d-flex justify-content-between align-items-center">
                            <div>
                                <div style="font-size: 0.9rem; color: #111; margin-bottom: 4px;">Tanggal Masuk :
                                    11-02-2026</div>
                                <div style="font-size: 0.9rem; color: #111;">Tanggal Keluar : 17-02-2026</div>
                            </div>
                            <div>
                                <div style="font-size: 0.9rem; color: #111; margin-bottom: 4px;">Diagnosa : Skizofrenia
                                </div>
                                <a href="#"
                                    style="font-size: 0.85rem; color: #111; font-weight: 700; text-decoration: none;">Lihat
                                    Detail Penanganan &rarr;</a>
                            </div>
                        </div>

                        <!-- Item Kunjungan 2 -->
                        <div style="border: 1px solid #111; border-radius: 8px; padding: 15px 30px; margin-bottom: 0;"
                            class="d-flex justify-content-between align-items-center">
                            <div>
                                <div style="font-size: 0.9rem; color: #111; margin-bottom: 4px;">Tanggal Masuk :
                                    11-02-2026</div>
                                <div style="font-size: 0.9rem; color: #111;">Tanggal Keluar : 17-02-2026</div>
                            </div>
                            <div>
                                <div style="font-size: 0.9rem; color: #111; margin-bottom: 4px;">Diagnosa : Skizofrenia
                                </div>
                                <a href="#"
                                    style="font-size: 0.85rem; color: #111; font-weight: 700; text-decoration: none;">Lihat
                                    Detail Penanganan &rarr;</a>
                            </div>
                        </div>

                    </div>

                    <div class="d-flex justify-content-center mt-5 mb-2">
                        <button type="button" class="btn" data-bs-dismiss="modal"
                            style="background-color: #dc3545; color: white; border: none; font-weight: 700; width: 140px; border-radius: 8px; padding: 10px 0; font-size: 0.95rem; letter-spacing: 0.5px;">KEMBALI</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Data Pasien -->
    <div class="modal fade" id="patientEditModal" tabindex="-1" aria-labelledby="patientEditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content"
                style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                <div class="modal-header border-0 pb-2 px-4 mt-3">
                    <h5 class="modal-title m-0" id="patientEditModalLabel"
                        style="color: #043622; font-weight: 800; font-size: 1.25rem;">EDIT DATA PASIEN</h5>
                </div>
                <div class="px-4">
                    <hr style="border-top: 3px solid #043622; margin: 0; opacity: 1;">
                </div>
                <div class="modal-body px-4 pt-4 pb-5">

                    <form id="editPasienForm" action="<?= BASEURL; ?>/perawat/update_pasien" method="POST">
                        <input type="hidden" name="id_rekam_medis" id="editIdRM">
                        <!-- Section 1 -->
                        <div class="mb-4">
                            <h6 style="color: #666; font-weight: 600; font-size: 0.95rem; margin-bottom: 8px;">AKUN
                                PENGGUNA</h6>
                            <hr style="border-top: 2px solid #aeb5b2; margin: 0 0 15px 0; opacity: 1;">
                            <div class="row mb-2">
                                <label class="col-sm-3 col-form-label text-end"
                                    style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Username:</label>
                                <div class="col-sm-8">
                                    <input type="text" id="editUsername" name="username" class="form-control form-control-sm"
                                        style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-3 col-form-label text-end"
                                    style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Password:</label>
                                <div class="col-sm-8">
                                    <input type="text" id="editPassword" name="password" class="form-control form-control-sm"
                                        style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;">
                                </div>
                            </div>
                        </div>

                        <!-- Section 2 -->
                        <div class="mb-4">
                            <h6 style="color: #666; font-weight: 600; font-size: 0.95rem; margin-bottom: 8px;">DATA DIRI
                                PASIEN</h6>
                            <hr style="border-top: 2px solid #aeb5b2; margin: 0 0 15px 0; opacity: 1;">
                            <div class="row mb-2">
                                <label class="col-sm-3 col-form-label text-end"
                                    style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">NIK
                                    :</label>
                                <div class="col-sm-8">
                                    <input type="text" id="editNik" name="nik" class="form-control form-control-sm"
                                        style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-3 col-form-label text-end"
                                    style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Nama
                                    Lengkap:</label>
                                <div class="col-sm-8">
                                    <input type="text" id="editNama" name="nama_pasien" class="form-control form-control-sm"
                                        style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-3 col-form-label text-end"
                                    style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Asal
                                    :</label>
                                <div class="col-sm-3">
                                    <input type="text" id="editAsal" name="asal" class="form-control form-control-sm"
                                        style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;">
                                </div>
                                <label class="col-sm-2 col-form-label text-end"
                                    style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">TGL.Lahir
                                    :</label>
                                <div class="col-sm-3">
                                    <input type="text" id="editTgllahir" name="tgl_lahir" class="form-control form-control-sm"
                                        style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;">
                                </div>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <label class="col-sm-3 col-form-label text-end"
                                    style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Jenis
                                    Kelamin :</label>
                                <div class="col-sm-8 d-flex align-items-center"
                                    style="font-family: 'Courier New', monospace; font-size: 0.9rem; color: #555;">
                                    <div class="form-check form-check-inline mb-0">
                                        <input class="form-check-input" type="radio" name="jk"
                                            id="editJkLActive" value="L" style="border-color: #555; opacity: 1;">
                                        <label class="form-check-label" for="editJkLActive"
                                            style="opacity: 1;">Laki-laki</label>
                                    </div>
                                    <div class="form-check form-check-inline mb-0 ms-3">
                                        <input class="form-check-input" type="radio" name="jk"
                                            id="editJkPActive" value="P" style="border-color: #555; opacity: 1;">
                                        <label class="form-check-label" for="editJkPActive"
                                            style="opacity: 1;">Perempuan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-3 col-form-label text-end"
                                    style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Agama
                                    :</label>
                                <div class="col-sm-8">
                                    <input type="text" id="editAgama" name="agama" class="form-control form-control-sm"
                                        style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-3 col-form-label text-end"
                                    style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Status
                                    Perkawinan :</label>
                                <div class="col-sm-8">
                                    <input type="text" id="editStatusKawin" name="status_perkawinan" class="form-control form-control-sm"
                                        style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-3 col-form-label text-end"
                                    style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Pekerjaan
                                    :</label>
                                <div class="col-sm-8">
                                    <input type="text" id="editPekerjaan" name="pekerjaan" class="form-control form-control-sm"
                                        style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-3 col-form-label text-end mt-1"
                                    style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Alamat
                                    :</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control form-control-sm" id="editAlamat" name="alamat" rows="3"
                                        style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; resize: none; color: #111;"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3 -->
                        <div class="mb-4">
                            <h6 style="color: #666; font-weight: 600; font-size: 0.95rem; margin-bottom: 8px;">DATA
                                TAMBAHAN PASIEN</h6>
                            <hr style="border-top: 2px solid #aeb5b2; margin: 0 0 15px 0; opacity: 1;">
                            <div class="row mb-2">
                                <label class="col-sm-3 col-form-label text-end"
                                    style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Nomor
                                    BPJS/Asuransi :</label>
                                <div class="col-sm-8">
                                    <input type="text" id="editBpjs" name="bpjs" class="form-control form-control-sm"
                                        style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-3 col-form-label text-end"
                                    style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Golongan
                                    Darah :</label>
                                <div class="col-sm-8">
                                    <input type="text" id="editGolDarah" name="gol_darah" class="form-control form-control-sm"
                                        style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-3 col-form-label text-end"
                                    style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Alergi
                                    :</label>
                                <div class="col-sm-8">
                                    <input type="text" id="editAlergi" name="alergi" class="form-control form-control-sm"
                                        style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-3 col-form-label text-end"
                                    style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Kewarganegaraan
                                    :</label>
                                <div class="col-sm-8">
                                    <input type="text" id="editKewarganegaraan" name="kewarganegaraan" class="form-control form-control-sm"
                                        style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;">
                                </div>
                            </div>
                        </div>

                        <!-- Section 4 -->
                        <div class="mb-4">
                            <h6 style="color: #666; font-weight: 600; font-size: 0.95rem; margin-bottom: 8px;">DATA DIRI
                                PENGANTAR / WALI</h6>
                            <hr style="border-top: 2px solid #aeb5b2; margin: 0 0 15px 0; opacity: 1;">
                            <div class="row mb-2">
                                <label class="col-sm-3 col-form-label text-end"
                                    style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Nama
                                    Lengkap Wali :</label>
                                <div class="col-sm-8">
                                    <input type="text" id="editNamaWali" name="nama_wali" class="form-control form-control-sm"
                                        style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-3 col-form-label text-end"
                                    style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Status
                                    Wali :</label>
                                <div class="col-sm-8">
                                    <input type="text" id="editStatusWali" name="status_wali" class="form-control form-control-sm"
                                        style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-3 col-form-label text-end"
                                    style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">NIK
                                    Wali :</label>
                                <div class="col-sm-8">
                                    <input type="text" id="editNikWali" name="nik_wali" class="form-control form-control-sm"
                                        style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-3 col-form-label text-end"
                                    style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">No.HP/Whatsapp
                                    aktif :</label>
                                <div class="col-sm-8">
                                    <input type="text" id="editNoHpWali" name="nohp_wali" class="form-control form-control-sm"
                                        style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-3 col-form-label text-end mt-1"
                                    style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Alamat
                                    Wali :</label>
                                <div class="col-sm-8">
                                    <textarea id="editAlamatWali" name="alamat_wali" class="form-control form-control-sm" rows="3"
                                        style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; resize: none; color: #111;"></textarea>
                                </div>
                            </div>

                            <div class="row mb-2 mt-4">
                                <label class="col-sm-3 col-form-label text-end"
                                    style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">TTD
                                    WALI :</label>
                                <div class="col-sm-8">
                                    <div class="d-flex align-items-center justify-content-center"
                                        style="border: 1px solid #555; border-radius: 6px; height: 120px; font-family: 'Courier New', monospace; color: #888; font-weight: 600;">
                                        Canvas Untuk TTD Digital
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center gap-3 mt-5 mb-3">
                            <button type="button" id="btnSimpanPerubahanAktif" class="btn"
                                style="background-color: #20c997; color: white; border: none; font-weight: 600; width: 160px; border-radius: 6px; padding: 6px 0; font-size: 0.85rem; letter-spacing: 0.5px;">SIMPAN
                                PERUBAHAN</button>
                            <button type="button" class="btn" data-bs-dismiss="modal"
                                style="background-color: #dc3545; color: white; border: none; font-weight: 600; width: 120px; border-radius: 6px; padding: 6px 0; font-size: 0.85rem; letter-spacing: 0.5px;">KEMBALI</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Rekam Medis Pasien -->
    <div class="modal fade" id="editRekamMedisModal" tabindex="-1" aria-labelledby="editRekamMedisModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 450px;">
            <div class="modal-content"
                style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                <div class="modal-header border-0 pb-2 px-4 mt-3 d-flex justify-content-between align-items-center">
                    <h5 class="modal-title m-0" id="editRekamMedisModalLabel"
                        style="color: #043622; font-weight: 800; font-size: 1.15rem;">EDIT REKAM MEDIS PASIEN</h5>
                    <span data-bs-dismiss="modal" aria-label="Close"
                        style="cursor: pointer; font-size: 1.25rem; font-weight: 800; color: #111;">X</span>
                </div>
                <div class="px-4">
                    <hr style="border-top: 1.5px solid #111; margin: 0; opacity: 1;">
                </div>
                <div class="modal-body px-4 py-4">
                    <form id="editRekamMedisForm">
                        <div class="row mb-3 align-items-center">
                            <label class="col-4 col-form-label text-end pe-2"
                                style="color: #043622; font-weight: 500; font-size: 0.85rem;">NO.BED :</label>
                            <div class="col-8">
                                <input type="text" id="rmNoBed" class="form-control form-control-sm"
                                    style="border-radius: 20px; border: 1px solid #111; padding: 6px 15px; font-weight: 500; font-size: 0.85rem; color: #111; background-color: transparent;">
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label class="col-4 col-form-label text-end pe-2"
                                style="color: #043622; font-weight: 500; font-size: 0.85rem;">Detak Jantung :</label>
                            <div class="col-8">
                                <input type="text" id="rmDetakJantung" class="form-control form-control-sm"
                                    style="border-radius: 20px; border: 1px solid #111; padding: 6px 15px; font-weight: 500; font-size: 0.85rem; color: #111; background-color: transparent;">
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label class="col-4 col-form-label text-end pe-2"
                                style="color: #043622; font-weight: 500; font-size: 0.85rem;">Oksigen :</label>
                            <div class="col-8">
                                <input type="text" id="rmOksigen" class="form-control form-control-sm"
                                    style="border-radius: 20px; border: 1px solid #111; padding: 6px 15px; font-weight: 500; font-size: 0.85rem; color: #111; background-color: transparent;">
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label class="col-4 col-form-label text-end pe-2"
                                style="color: #043622; font-weight: 500; font-size: 0.85rem;">Suhu Tubuh :</label>
                            <div class="col-8">
                                <input type="text" id="rmSuhuTubuh" class="form-control form-control-sm"
                                    style="border-radius: 20px; border: 1px solid #111; padding: 6px 15px; font-weight: 500; font-size: 0.85rem; color: #111; background-color: transparent;">
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label class="col-4 col-form-label text-end pe-2"
                                style="color: #043622; font-weight: 500; font-size: 0.85rem;">Tekanan Darah :</label>
                            <div class="col-8">
                                <input type="text" id="rmTekananDarah" class="form-control form-control-sm"
                                    style="border-radius: 20px; border: 1px solid #111; padding: 6px 15px; font-weight: 500; font-size: 0.85rem; color: #111; background-color: transparent;">
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label class="col-4 col-form-label text-end pe-2"
                                style="color: #043622; font-weight: 500; font-size: 0.85rem;">Status Pasien :</label>
                            <div class="col-8">
                                <input type="text" id="rmStatusPasien" class="form-control form-control-sm"
                                    style="border-radius: 20px; border: 1px solid #111; padding: 6px 15px; font-weight: 500; font-size: 0.85rem; color: #111; background-color: transparent;">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-4 col-form-label text-end pe-2 pt-1"
                                style="color: #043622; font-weight: 500; font-size: 0.85rem;">Detail Kondisi :</label>
                            <div class="col-8">
                                <textarea id="rmDetailKondisi" class="form-control form-control-sm" rows="4"
                                    style="border-radius: 12px; border: 1px solid #111; padding: 10px 15px; font-weight: 500; font-size: 0.85rem; resize: none; color: #111; background-color: transparent;"></textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mt-5 mb-2">
                            <button type="button" class="btn" data-bs-target="#confirmSaveRekamMedisModal" data-bs-toggle="modal"
                                style="background-color: #20c997; color: white; border: 1px solid #20c997; font-weight: 700; width: 180px; border-radius: 8px; padding: 8px 0; font-size: 0.9rem; letter-spacing: 0.5px;">EDIT</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirm Save Rekam Medis -->
    <div class="modal fade" id="confirmSaveRekamMedisModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
            <div class="modal-content" style="border-radius: 12px; border: none; padding: 25px 20px;">
                <div class="modal-body text-center">
                    <i class="bi bi-shield-check" style="font-size: 5rem; color: #20c997;"></i>
                    <h5 class="mt-2 mb-4" style="color: #111; font-weight: 700; font-size: 1.15rem;">Yakin Ingin Menyimpan Perubahan?</h5>
                    <div class="d-flex justify-content-center gap-4 mt-4">
                        <button type="button" class="btn" data-bs-target="#successSaveRekamMedisModal" data-bs-toggle="modal" style="background-color: #20c997; color: #111; border: 1px solid #111; font-weight: 600; width: 120px; border-radius: 8px; padding: 8px 0;">Ya, Simpan</button>
                        <button type="button" class="btn" data-bs-dismiss="modal" style="background-color: #dc3545; color: #111; border: 1px solid #111; font-weight: 600; width: 120px; border-radius: 8px; padding: 8px 0;">Tidak</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Success Save Rekam Medis -->
    <div class="modal fade" id="successSaveRekamMedisModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
            <div class="modal-content" style="border-radius: 12px; border: none; padding: 30px 20px;">
                <div class="modal-body text-center">
                    <i class="bi bi-check-circle" style="font-size: 5rem; color: #20c997;"></i>
                    <h5 class="mt-3 mb-4" style="color: #111; font-weight: 700; font-size: 1.25rem;">DAFTAR BERHASIL</h5>
                    <div class="mt-4">
                        <button type="button" class="btn" data-bs-dismiss="modal" style="background-color: #20c997; color: #111; border: none; font-weight: 600; width: 140px; border-radius: 8px; padding: 8px 0;">KEMBALI</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirm Exit Patient -->
    <div class="modal fade" id="confirmExitPatientModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
            <div class="modal-content" style="border-radius: 12px; border: none; padding: 25px 20px;">
                <div class="modal-body text-center">
                    <i class="bi bi-shield-check" style="font-size: 5rem; color: #20c997;"></i>
                    <h5 class="mt-2 mb-4" style="color: #111; font-weight: 700; font-size: 1.15rem;">Pasien Telah Keluar?</h5>
                    
                    <div style="border: 1px solid #111; padding: 15px; margin-bottom: 25px;">
                        <p style="margin: 0; font-size: 0.95rem; color: #111; line-height: 1.5;">Sebelum melanjutkan,<br>Pastikan anda telah memastikan bahwa<br>pasien benar benar telah keluar</p>
                    </div>

                    <form action="<?= BASEURL; ?>/perawat/keluar_pasien" method="POST">
                        <input type="hidden" name="id_rekam_medis" id="exitIdRekamMedis">
                        <div class="d-flex justify-content-center gap-4">
                            <button type="submit" class="btn" style="background-color: #20c997; color: #111; border: 1px solid #111; font-weight: 600; width: 130px; border-radius: 8px; padding: 8px 0;">Ya, teruskan</button>
                            <button type="button" class="btn" data-bs-dismiss="modal" style="background-color: #dc3545; color: #111; border: 1px solid #111; font-weight: 600; width: 130px; border-radius: 8px; padding: 8px 0;">Kembali</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const viewButtons = document.querySelectorAll('.btn-view-pasien');
            viewButtons.forEach(btn => {
                btn.addEventListener('click', function () {
                    const nama = this.getAttribute('data-nama');
                    const mrn = this.getAttribute('data-mrn');
                    const jk = this.getAttribute('data-jk');
                    const asal = this.getAttribute('data-asal');
                    const nohp = this.getAttribute('data-nohp');

                    if (document.getElementById('modalNamaLengkap')) document.getElementById('modalNamaLengkap').value = nama || '-';
                    if (document.getElementById('modalMrn')) document.getElementById('modalMrn').value = mrn || '-';
                    if (document.getElementById('modalJk')) document.getElementById('modalJk').value = (jk == 'L' ? 'Laki-laki' : (jk == 'P' ? 'Perempuan' : '-'));
                    if (document.getElementById('modalAsal')) document.getElementById('modalAsal').value = asal || '-';
                    if (document.getElementById('modalNoHp')) document.getElementById('modalNoHp').value = nohp || '-';
                    // NIK can be added similar if available in standard rows
                });
            });

            const editButtons = document.querySelectorAll('.btn-edit-pasien');
            editButtons.forEach(btn => {
                btn.addEventListener('click', function () {
                    const idrm = this.getAttribute('data-idrm');
                    const username = this.getAttribute('data-username');
                    const password = this.getAttribute('data-password');
                    const nik = this.getAttribute('data-nik');
                    const nama = this.getAttribute('data-nama');
                    const asal = this.getAttribute('data-asal');
                    const tgllahir = this.getAttribute('data-tgllahir');
                    const jk = this.getAttribute('data-jk');
                    const agama = this.getAttribute('data-agama');
                    const statuskawin = this.getAttribute('data-statuskawin');
                    const pekerjaan = this.getAttribute('data-pekerjaan');
                    const alamat = this.getAttribute('data-alamat');
                    
                    const bpjs = this.getAttribute('data-bpjs');
                    const goldarah = this.getAttribute('data-goldarah');
                    const alergi = this.getAttribute('data-alergi');
                    const kewarganegaraan = this.getAttribute('data-kewarganegaraan');
                    const namawali = this.getAttribute('data-namawali');
                    const statuswali = this.getAttribute('data-statuswali');
                    const nikwali = this.getAttribute('data-nikwali');
                    const nohpwali = this.getAttribute('data-nohpwali');
                    const alamatwali = this.getAttribute('data-alamatwali');

                    if (document.getElementById('editIdRM')) document.getElementById('editIdRM').value = idrm || '';
                    if (document.getElementById('editUsername')) document.getElementById('editUsername').value = username || '';
                    if (document.getElementById('editPassword')) document.getElementById('editPassword').value = password || '';
                    if (document.getElementById('editNik')) document.getElementById('editNik').value = nik || '';
                    if (document.getElementById('editNama')) document.getElementById('editNama').value = nama || '';
                    if (document.getElementById('editAsal')) document.getElementById('editAsal').value = asal || '';
                    if (document.getElementById('editTgllahir')) document.getElementById('editTgllahir').value = tgllahir || '';

                    if (jk === 'L') {
                        if (document.getElementById('editJkLActive')) document.getElementById('editJkLActive').checked = true;
                    } else if (jk === 'P') {
                        if (document.getElementById('editJkPActive')) document.getElementById('editJkPActive').checked = true;
                    }

                    if (document.getElementById('editAgama')) document.getElementById('editAgama').value = agama || '';
                    if (document.getElementById('editStatusKawin')) document.getElementById('editStatusKawin').value = statuskawin || '';
                    if (document.getElementById('editPekerjaan')) document.getElementById('editPekerjaan').value = pekerjaan || '';
                    if (document.getElementById('editAlamat')) document.getElementById('editAlamat').value = alamat || '';
                    
                    if (document.getElementById('editBpjs')) document.getElementById('editBpjs').value = bpjs || '';
                    if (document.getElementById('editGolDarah')) document.getElementById('editGolDarah').value = goldarah || '';
                    if (document.getElementById('editAlergi')) document.getElementById('editAlergi').value = alergi || '';
                    if (document.getElementById('editKewarganegaraan')) document.getElementById('editKewarganegaraan').value = kewarganegaraan || '';
                    if (document.getElementById('editNamaWali')) document.getElementById('editNamaWali').value = namawali || '';
                    if (document.getElementById('editStatusWali')) document.getElementById('editStatusWali').value = statuswali || '';
                    if (document.getElementById('editNikWali')) document.getElementById('editNikWali').value = nikwali || '';
                    if (document.getElementById('editNoHpWali')) document.getElementById('editNoHpWali').value = nohpwali || '';
                    if (document.getElementById('editAlamatWali')) document.getElementById('editAlamatWali').value = alamatwali || '';
                });
            });

            const btnEditRekamMedis = document.querySelectorAll('.btn-edit-rekammedis');
            btnEditRekamMedis.forEach(btn => {
                btn.addEventListener('click', function () {
                    const nobed = this.getAttribute('data-nobed');
                    if (document.getElementById('rmNoBed')) document.getElementById('rmNoBed').value = nobed || '';

                    // Reset form on open if necessary, or load data here via AJAX if needed
                    if (document.getElementById('rmDetakJantung')) document.getElementById('rmDetakJantung').value = '';
                    if (document.getElementById('rmOksigen')) document.getElementById('rmOksigen').value = '';
                    if (document.getElementById('rmSuhuTubuh')) document.getElementById('rmSuhuTubuh').value = '';
                    if (document.getElementById('rmTekananDarah')) document.getElementById('rmTekananDarah').value = '';
                    if (document.getElementById('rmStatusPasien')) document.getElementById('rmStatusPasien').value = '';
                    if (document.getElementById('rmDetailKondisi')) document.getElementById('rmDetailKondisi').value = '';
                });
            });

            const btnEditSave = document.getElementById('btnEditSave');
            const updateForm = document.getElementById('staffUpdateForm');
            const inputs = updateForm.querySelectorAll('input[type="text"], select');

            btnEditSave.addEventListener('click', function () {
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

            // Explicitly handle exit patient modal to avoid backdrop/click issues
            const btnExitPasien = document.querySelectorAll('.btn-exit-pasien');
            btnExitPasien.forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const idrm = this.getAttribute('data-idrm');
                    if (document.getElementById('exitIdRekamMedis')) document.getElementById('exitIdRekamMedis').value = idrm || '';
                    
                    const modalEl = document.getElementById('confirmExitPatientModal');
                    if (modalEl) {
                        const modal = new bootstrap.Modal(modalEl);
                        modal.show();
                    }
                });
            });

            // Handle Simpan Perubahan Edit Pasien
            const btnSimpanAktif = document.getElementById('btnSimpanPerubahanAktif');
            if (btnSimpanAktif) {
                btnSimpanAktif.addEventListener('click', function () {
                    const editModal = bootstrap.Modal.getInstance(document.getElementById('patientEditModal'));
                    if (editModal) editModal.hide();

                    const confirmEl = document.getElementById('confirmSimpanPasienModalAktif');
                    if (confirmEl) {
                        setTimeout(function() {
                            new bootstrap.Modal(confirmEl).show();
                        }, 300);
                    }
                });
            }

            const btnTidakSimpanAktif = document.getElementById('btnTidakSimpanAktif');
            if (btnTidakSimpanAktif) {
                btnTidakSimpanAktif.addEventListener('click', function () {
                    const confirmEl = document.getElementById('confirmSimpanPasienModalAktif');
                    const confirmModal = bootstrap.Modal.getInstance(confirmEl);
                    if (confirmModal) confirmModal.hide();

                    setTimeout(function() {
                        const editEl = document.getElementById('patientEditModal');
                        if (editEl) new bootstrap.Modal(editEl).show();
                    }, 300);
                });
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Modal Konfirmasi Simpan Perubahan Pasien -->
    <div class="modal fade" id="confirmSimpanPasienModalAktif" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
            <div class="modal-content" style="border-radius: 12px; border: none; padding: 30px 20px;">
                <div class="modal-body text-center">
                    <i class="bi bi-shield-check" style="font-size: 6rem; color: #20c997;"></i>
                    <h5 class="mt-3 mb-4" style="color: #111; font-weight: 700; font-size: 1.1rem;">Yakin Ingin Menyimpan Perubahan?</h5>
                    <div class="d-flex justify-content-center gap-4 mt-3">
                        <button type="button" id="btnConfirmSubmitEdit" class="btn" style="background-color: #20c997; color: #111; border: none; font-weight: 600; width: 130px; border-radius: 8px; padding: 8px 0;">Ya, Simpan</button>
                        <button type="button" id="btnTidakSimpanAktif" class="btn" style="background-color: #dc3545; color: white; border: none; font-weight: 600; width: 100px; border-radius: 8px; padding: 8px 0;">Tidak</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnConfirmSubmitEdit = document.getElementById('btnConfirmSubmitEdit');
            if (btnConfirmSubmitEdit) {
                btnConfirmSubmitEdit.addEventListener('click', function() {
                    document.getElementById('editPasienForm').submit();
                });
            }
        });
    </script>
</body>

</html>