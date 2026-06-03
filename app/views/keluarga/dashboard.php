<?php
// Menangkap data dari Controller
$pasien = $data['pasien'] ?? [];
$riwayat = $data['riwayat'] ?? [];
$lab = $data['lab'] ?? [];
// Mengambil observasi terbaru (index 0) untuk banner utama
$obs_terbaru = !empty($riwayat) ? $riwayat[0] : [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Keluarga - ICU Central Specialist Hospital</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/custom.css">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/landing.css">
    <style>
        body { background-color: #ffffff; font-family: 'Inter', 'Segoe UI', sans-serif; }
        .navbar-custom { background-color: #043622; }

        .welcome-banner {
            background-color: #1b5e3a; /* Warna hijau khas dashboard */
            border-radius: 8px;
            color: white;
            padding: 30px 40px;
            margin-top: 30px;
            margin-bottom: 40px;
            position: relative;
        }
        .welcome-title { font-size: 0.85rem; letter-spacing: 1px; border-bottom: 1px solid rgba(255,255,255,0.4); display: inline-block; padding-bottom: 5px; margin-bottom: 15px; }
        .patient-name { font-size: 2rem; font-weight: 800; margin-right: 15px; display: inline-block; }
        .badge-stabil { background-color: #13c898; color: white; padding: 5px 20px; border-radius: 20px; font-size: 0.9rem; vertical-align: super; }
        .patient-info { font-size: 1rem; margin-top: 8px; margin-bottom: 3px; color: #e9ecef; }
        
        .btn-laporan {
            background-color: #13c898;
            color: white; border: none; padding: 10px 25px; border-radius: 4px; font-weight: 600;
            position: absolute; right: 40px; top: 40%; transition: background-color 0.3s;
        }
        .btn-laporan:hover { background-color: #0fa17a; }
        
        @media (max-width: 768px) {
            .btn-laporan { position: relative; right: auto; top: auto; margin-top: 20px; width: 100%; }
        }
        
        .section-heading { font-weight: 800; font-size: 1.1rem; color: #111; border-bottom: 2px solid #555; padding-bottom: 10px; margin-bottom: 20px; text-transform: uppercase; }
        
        .status-card { border: 1px solid #a3cda6; border-radius: 8px; text-align: center; padding: 25px 15px; margin-bottom: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.02); }
        .status-icon { font-size: 1.8rem; color: #13c898; margin-bottom: 10px; }
        .status-title { font-size: 0.75rem; color: #666; font-weight: 700; text-transform: uppercase; margin-bottom: 8px; }
        .status-value { font-size: 1.7rem; font-weight: 800; color: #222; }
        .status-unit { font-size: 0.85rem; color: #888; font-weight: 500; }
        
        .perkembangan-card { border: 1px solid #a3cda6; border-radius: 8px; padding: 35px; margin-bottom: 40px; box-shadow: 0 4px 10px rgba(0,0,0,0.02); }
        .perkembangan-title { font-size: 1.1rem; font-weight: 800; margin-bottom: 30px; color: #111; }
        
        /* Timeline */
        .timeline { position: relative; padding-left: 25px; }
        .timeline::before { content: ''; position: absolute; left: 0; top: 10px; bottom: 10px; width: 2px; background-color: #13c898; }
        .timeline-item { position: relative; border: 1px solid #a3cda6; border-radius: 8px; padding: 20px 25px; margin-bottom: 25px; display: flex; justify-content: space-between; background: #fff; }
        .timeline-item::before { content: ''; position: absolute; left: -31px; top: 25px; width: 12px; height: 12px; border-radius: 50%; background-color: #13c898; }
        
        .timeline-content-left p, .timeline-content-right p { margin-bottom: 6px; font-size: 0.8rem; color: #555; font-weight: 600;}
        .timeline-content-left span, .timeline-content-right span { font-weight: 400; color: #333; }
        .badge-status-small { background-color: #13c898; color: white; padding: 3px 10px; border-radius: 12px; font-size: 0.65rem; margin-left: 8px; font-weight: 600 !important;}
        
        @media (max-width: 768px) {
            .timeline-item { flex-direction: column; }
            .timeline-content-right { text-align: left !important; margin-top: 15px; border-top: 1px solid #eee; padding-top: 10px; }
        }
        
        .lab-card-wrapper { border: 1px solid #a3cda6; border-radius: 8px; padding: 35px; margin-bottom: 60px; box-shadow: 0 4px 10px rgba(0,0,0,0.02); }
        .lab-header { display: flex; justify-content: space-between; margin-bottom: 25px; align-items: center; }
        .lab-title { font-size: 1.1rem; font-weight: 700; color: #222; margin: 0; }
        .lab-update { font-size: 0.85rem; color: #666; }
        
        .lab-item-box { border: 1px solid #ddd; border-radius: 8px; text-align: center; padding: 25px 15px; background-color: #fbfbfb;}
        .lab-item-title { font-size: 0.8rem; font-weight: 800; margin-bottom: 12px; color: #333;}
        .lab-item-val { font-size: 1.8rem; font-weight: 800; margin-bottom: 5px; color: #111;}
        .lab-item-status { font-size: 0.75rem; font-weight: 700; color: #13c898; letter-spacing: 0.5px;}

        .logout-confirm-modal .modal-dialog {
            max-width: 360px;
            margin: 1.5rem auto;
        }
        .logout-confirm-modal .modal-content {
            border: 0;
            border-radius: 16px !important;
            background: #fff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08) !important;
        }
        .logout-confirm-modal .modal-body {
            padding: 40px 24px 34px !important;
        }
        .logout-modal-icon {
            width: 90px;
            height: 90px;
            margin: 0 auto 16px;
            color: #10b981;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .logout-modal-icon svg {
            width: 100%;
            height: 100%;
            display: block;
        }
        .logout-modal-title {
            font-size: 1.35rem !important;
            line-height: 1.4;
            font-weight: 500 !important;
            color: #000000 !important;
            margin-bottom: 24px !important;
            letter-spacing: -0.01em;
        }
        .btn-logout-confirm {
            min-width: 100px;
            border-radius: 8px !important;
            font-weight: 500 !important;
            padding: 8px 24px !important;
            font-size: 0.95rem !important;
            line-height: 1.2 !important;
            font-family: 'Inter', 'Segoe UI', sans-serif;
            border: 1.5px solid #000000 !important;
            transition: background-color 0.15s ease-in-out;
            box-shadow: none !important;
        }
        .btn-logout-yes {
            background-color: #10b981 !important;
            color: #000000 !important;
        }
        .btn-logout-yes:hover,
        .btn-logout-yes:focus {
            background-color: #059669 !important;
            color: #000000 !important;
            border-color: #000000 !important;
        }
        .btn-logout-no {
            background-color: #ef4444 !important;
            color: #000000 !important;
        }
        .btn-logout-no:hover,
        .btn-logout-no:focus {
            background-color: #dc2626 !important;
            color: #000000 !important;
            border-color: #000000 !important;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="#">
      <img src="<?= BASEURL; ?>/assets/img/logo.png" width="34" height="34" alt="Logo">
      <span class="fw-bold" style="letter-spacing:0.6px;">HOSPITAL</span>
    </a>
    <ul class="navbar-nav ms-auto">
        <li class="nav-item">
            <a class="nav-link text-white" href="#" style="font-size: 0.9rem;" data-bs-toggle="modal" data-bs-target="#logoutConfirmModal">Log out</a>
        </li>
    </ul>
  </div>
</nav>

<div class="container">
    <div class="welcome-banner">
        <div class="welcome-title">WELCOME</div>
        <div style="margin-bottom: 5px;">
            <span class="patient-name"><?= htmlspecialchars(strtoupper($pasien['nama_lengkap'] ?? 'NAMA TIDAK ADA')) ?></span>
            <span class="badge-stabil"><?= htmlspecialchars(ucfirst($obs_terbaru['kondisi'] ?? 'Belum diobservasi')) ?></span>
        </div>
        <div class="patient-info"><?= htmlspecialchars($pasien['asal'] ?? '-') ?></div>
        <div class="patient-info">MRN &nbsp;&nbsp;&nbsp;&nbsp;: ICU-<?= str_pad($pasien['id_pasien'] ?? 0, 3, '0', STR_PAD_LEFT) ?></div>
        <div class="patient-info">Kamar : <?= htmlspecialchars($pasien['nomor_bed'] ?? 'Belum masuk bed') ?></div>
        <div class="patient-info">Kategori : <?= (!empty($pasien['nomor_bpjs']) && trim($pasien['nomor_bpjs']) !== '') ? 'BPJS' : 'UMUM' ?></div>
        
        <button type="button" class="btn-laporan" data-bs-toggle="modal" data-bs-target="#patientDetailModal-<?= $pasien['id_pasien'] ?>">Lihat Rekam Medis</button>
    </div>

    <?php include __DIR__ . '/kondisi_pasien.php'; ?>
    <?php include __DIR__ . '/riwayat_tindakan.php'; ?>
</div>

<div class="modal fade logout-confirm-modal" id="logoutConfirmModal" tabindex="-1" aria-labelledby="logoutConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-body text-center">
                <div class="logout-modal-icon">
                    <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                        <path d="M50 32.5c0 12.5-8.75 18.75-19.15 24.25a2.5 2.5 0 0 1-1.7 0C18.75 51.25 10 45 10 32.5V15a2.5 2.5 0 0 1 1.9-2.42l20-5a2.5 2.5 0 0 1 1.2 0l20 5A2.5 2.5 0 0 1 50 15z" stroke="currentColor" stroke-width="3.8" stroke-linejoin="round" stroke-linecap="round"/>
                        <path d="M22.5 30L27.5 35L37.5 25" stroke="currentColor" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="logout-modal-title" id="logoutConfirmModalLabel">Yakin Ingin Logout?</div>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="<?= BASEURL; ?>/auth/logout" class="btn btn-logout-confirm btn-logout-yes">Ya, teruskan</a>
                    <button type="button" class="btn btn-logout-confirm btn-logout-no" data-bs-dismiss="modal">Tidak</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
    if (!empty($pasien)) {
        $patient = $pasien; 
        
        // 1. Panggil Model
        require_once __DIR__ . '/../../models/RekamMedis.php';
        $rmModel = new RekamMedis();
        
        // 2. Ambil Riwayat Kunjungan di sini (agar bisa dipakai di kedua pop-up)
        $riwayatKunjungan = $rmModel->ambilRiwayatPasien($patient['id_pasien']);
        if (!is_array($riwayatKunjungan)) {
            $riwayatKunjungan = [];
        }
        $totalKunjungan = count($riwayatKunjungan);
        
        // 3. Baru include file-file pop-up nya
        include __DIR__ . '/pop-up/detail_pasien.php'; 
        include __DIR__ . '/pop-up/riwayat_pasien.php'; 
    }
?>



<?php include __DIR__ . '/../layouts/footer.php'; ?>