<?php
$mainError = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>




<div class="d-flex">
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
                <input type="text" id="searchInput" placeholder="Cari Nama...">
            </div>
            <?php if (!empty($mainError)): ?>
                <div class="alert alert-danger mx-4 mt-4" role="alert" style="font-weight: 600; font-size: 0.9rem;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= htmlspecialchars($mainError) ?>
                </div>
            <?php endif; ?>

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
                        <?php if (!empty($data['patients'])): ?>
                            <?php foreach ($data['patients'] as $patient): ?>
                            <tr>
                                <td>ICU-2026-<?= str_pad($patient['id_pasien'], 3, '0', STR_PAD_LEFT) ?></td>
                                <td class="text-start"><?= htmlspecialchars($patient['nama_lengkap']) ?></td>
                                <td><?= htmlspecialchars($patient['jenis_kelamin']) ?></td>
                                <td><?= htmlspecialchars($patient['asal']) ?></td>
                                <td><?= htmlspecialchars($patient['no_hp_wali'] ?: '-') ?></td>
                                <td class="action-icons d-flex justify-content-center border-0" style="padding-top: 20px;">
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#patientDetailModal-<?= $patient['id_pasien'] ?>" class="text-dark" style="background: none; border: none; padding: 0;">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    <button type="button" data-bs-toggle="modal" data-bs-target="#patientEditModal-<?= $patient['id_pasien'] ?>" class="text-dark" style="background: none; border: none; padding: 0;">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <button type="button" data-bs-toggle="modal" data-bs-target="#masukPasienModal-<?= $patient['id_pasien'] ?>" title="Aktivasi Pasien" style="background: none; border: none; padding: 0;">
                                        <i class="bi bi-box-arrow-in-right" style="color: #20c997; font-size: 1.15rem;"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-muted py-4">Tidak ada data pasien terdaftar.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<?php if (!empty($data['patients'])): ?>
    <?php 
        try {
            if (!class_exists('RekamMedis')) {
                require_once __DIR__ . '/../../models/RekamMedis.php';
            }
            if (!class_exists('PasienModel')) require_once __DIR__ . '/../../models/Pasien.php';
            $rmModel = new RekamMedis(); 
            $pasienModel = new PasienModel();
            echo "<script>console.log('✅ Berhasil: Model RekamMedis siap digunakan.');</script>";
        } catch (\Throwable $e) {
            $errorPesan = json_encode($e->getMessage());
            echo "<script>console.error('❌ ERROR FATAL MODEL:', {$errorPesan});</script>";
        }
    ?>

    <?php foreach ($data['patients'] as $patient): ?>
        <?php 
            try {
                require __DIR__ . '/pop-up/detail_pasien.php';
                require __DIR__ . '/pop-up/edit_pasien.php';
                require __DIR__ . '/pop-up/edit_rekam_medis.php';
                require __DIR__ . '/pop-up/masuk_pasien.php';
                require __DIR__ . '/pop-up/detail_lengkap_pasien.php';
                require __DIR__ . '/pop-up/riwayat_pasien.php';
                
                echo "<script>console.log('✅ Berhasil: Pop-up dicetak untuk Pasien ID {$patient['id_pasien']}');</script>";
            } catch (\Throwable $e) {
                $errorDetail = json_encode($e->getMessage() . ' | Lokasi: ' . $e->getFile() . ' Baris ' . $e->getLine());
                echo "<script>console.error('❌ ERROR RENDER POP-UP (ID {$patient['id_pasien']}):', {$errorDetail});</script>";
            }
        ?>
    <?php endforeach; ?>
<?php endif; ?>

<?php if (isset($_SESSION['errors']) && isset($_SESSION['old']['id_pasien'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var errorModalId = 'patientEditModal-<?= $_SESSION['old']['id_pasien'] ?>';
            var errorModalEl = document.getElementById(errorModalId);
            if (errorModalEl) {
                var modal = new bootstrap.Modal(errorModalEl);
                modal.show();
            }
        });
    </script>
    <?php 
        unset($_SESSION['errors']); 
        unset($_SESSION['old']);
    ?>
<?php endif; ?>

<?php if (isset($_SESSION['rm_errors']) && isset($_SESSION['rm_old']['id_pasien'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var errorModalId = 'editRekamMedisModal-<?= $_SESSION['rm_old']['id_pasien'] ?>';
            var errorModalEl = document.getElementById(errorModalId);
            if (errorModalEl) {
                var modal = new bootstrap.Modal(errorModalEl);
                modal.show();
            }
        });
    </script>
    <?php 
        unset($_SESSION['rm_errors']); 
        unset($_SESSION['rm_old']);
    ?>
<?php endif; ?>

<?php require_once __DIR__ . '/pop-up/script_pasien_aktif.php'; ?>