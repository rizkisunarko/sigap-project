                            
<div class="header-info" style="padding: 25px 40px 15px; border-bottom: 1px solid #eaeaea;">
    <div class="header-title-top" style="font-size: 1.05rem; color: #111; font-weight: 700; margin-bottom: 2px; text-transform: uppercase;">
        SESI AKTIF PERAWAT
    </div>
    <div class="header-subtitle" style="font-size: 0.75rem; font-weight: 600; color: #777; text-transform: uppercase;">
        UNIT PERAWATAN INSENTIF
    </div>
</div>

<div class="content-area" style="padding: 30px 40px;">
    <div class="d-flex justify-content-between align-items-center">
        <div class="section-title" style="font-size: 1.25rem; font-weight: 800; color: #111; text-transform: uppercase; margin: 0;">
            DATA PASIEN AKTIF
        </div>
        <div class="search-box" style="position: relative; width: 280px;">
            <i class="bi bi-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #aaa; font-size: 0.85rem;"></i>
            <input type="text" placeholder="Cari MRN atau Nama..." style="border-radius: 20px; padding: 8px 15px 8px 35px; border: 1px solid #ddd; font-size: 0.8rem; width: 100%; color: #555; outline: none;">
        </div>
    </div>

    <div class="table-container bg-white" style="border: 1px solid #52cba1; border-radius: 8px; overflow: hidden; margin-top: 25px;">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th style="background-color: #fafafa; font-weight: 700; color: #555; border-bottom: 1px solid #eaeaea; font-size: 0.7rem; padding: 14px 20px; width: 15%;">NO.BED</th>
                    <th style="background-color: #fafafa; font-weight: 700; color: #555; border-bottom: 1px solid #eaeaea; font-size: 0.7rem; padding: 14px 20px; width: 25%;">NAMA LENGKAP</th>
                    <th style="background-color: #fafafa; font-weight: 700; color: #555; border-bottom: 1px solid #eaeaea; font-size: 0.7rem; padding: 14px 20px; width: 25%;">MRN (REKAM MEDIS)</th>
                    <th style="background-color: #fafafa; font-weight: 700; color: #555; border-bottom: 1px solid #eaeaea; font-size: 0.7rem; padding: 14px 20px; width: 15%;">STATUS KLINIS</th>
                    <th style="background-color: #fafafa; font-weight: 700; color: #555; border-bottom: 1px solid #eaeaea; font-size: 0.7rem; padding: 14px 20px; width: 20%; text-align: center;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data['patients'])): ?>
                    <?php foreach ($data['patients'] as $patient): ?>
                        <tr>
                            <td class="ps-4" style="font-size: 0.8rem; vertical-align: middle; padding: 14px 20px; border-bottom: 1px solid #eaeaea; color: #111; font-weight: 700;">
                                <?= htmlspecialchars($patient['nomor_bed'] ?: 'TBA') ?>
                            </td>
                            <td style="font-size: 0.8rem; vertical-align: middle; padding: 14px 20px; border-bottom: 1px solid #eaeaea; color: #111; font-weight: 700;">
                                <?= htmlspecialchars($patient['nama_lengkap']) ?>
                            </td>
                            <td style="font-size: 0.8rem; vertical-align: middle; padding: 14px 20px; border-bottom: 1px solid #eaeaea; color: #111; font-weight: 700;">
                                ICU-<?= str_pad($patient['id_pasien'], 3, '0', STR_PAD_LEFT) ?>
                            </td>
                            <?php 

                                $status_klinis = strtolower(trim($patient['status_klinis'] ?? ''));
                                

                                if (in_array($status_klinis, ['kritis', 'menurun'])) {
                                    $warna_teks = '#dc3545';
                                } elseif (in_array($status_klinis, ['stabil', 'meningkat'])) {
                                    $warna_teks = '#198754';
                                } else {
                                    $warna_teks = '#6c757d';
                                }
                            ?>
                            <td style="font-size: 0.75rem; vertical-align: middle; padding: 14px 20px; border-bottom: 1px solid #eaeaea; font-weight: 800; text-transform: uppercase; color: <?= $warna_teks ?>;">
                                <?= htmlspecialchars(strtoupper($patient['status_klinis'] ?: '-')) ?>
                            </td>
                            <td style="border-bottom: none !important; display: flex; justify-content: center; gap: 16px; align-items: center; padding: 14px 20px;">
                                
                                <button type="button" data-bs-toggle="modal" data-bs-target="#patientDetailModal-<?= $patient['id_pasien'] ?>" class="text-dark" style="background: none; border: none; padding: 0;">
                                    <i class="bi bi-eye"></i>
                                </button>
                                
                                <button type="button" data-bs-toggle="modal" data-bs-target="#patientEditModal-<?= $patient['id_pasien'] ?>" class="text-dark" style="background: none; border: none; padding: 0;">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                
                                <button type="button" data-bs-toggle="modal" data-bs-target="#editRekamMedisModal-<?= $patient['id_pasien'] ?>" class="text-dark" style="background: none; border: none; padding: 0;">
                                    <i class="bi bi-gear-fill"></i>
                                </button>

                                <button type="button" class="btn-lab-pasien text-dark" data-bs-toggle="modal"  data-bs-target="#hasilLabModal-<?= $patient['id_pasien'] ?>"  data-nama="<?= htmlspecialchars($patient['nama_lengkap']) ?>"  style="background: none; border: none; padding: 0;">
                                    <i class="bi bi-prescription2" style="font-size: 2 rem;"></i>
                                </button>
                                
                                <button type="button" class="btn-exit-pasien text-dark" data-idrm="<?= $patient['id_rekam_medis'] ?>" style="background: none; border: none; padding: 0;">
                                    <i class="bi bi-box-arrow-right text-danger"></i>
                                </button>
                                
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
                require __DIR__ . '/pop-up/keluar_pasien.php';
                require __DIR__ . '/pop-up/detail_lengkap_pasien.php';
                require __DIR__ . '/pop-up/riwayat_pasien.php';
                require __DIR__ . '/pop-up/hasil_lab.php';
                
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
                errorModalEl.addEventListener('hidden.bs.modal', function () {
                    window.location.href = '<?= BASEURL ?>/perawat/input_data_pasien';
                });
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
                errorModalEl.addEventListener('hidden.bs.modal', function () {
                    window.location.href = '<?= BASEURL ?>/perawat/input_data_pasien';
                });
            }
        });
    </script>
    <?php 
        unset($_SESSION['rm_errors']); 
        unset($_SESSION['rm_old']);
    ?>
<?php endif; ?>

<?php if (isset($_SESSION['lab_errors']) && isset($_SESSION['lab_old']['id_pasien'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var errorModalId = 'hasilLabModal-<?= $_SESSION['lab_old']['id_pasien'] ?>';
            var errorModalEl = document.getElementById(errorModalId);
            if (errorModalEl) {
                var modal = new bootstrap.Modal(errorModalEl);
                modal.show();
                errorModalEl.addEventListener('hidden.bs.modal', function () {
                    window.location.href = '<?= BASEURL ?>/perawat/input_data_pasien';
                });
            }
        });
    </script>
    <?php 
        unset($_SESSION['lab_errors']); 
        unset($_SESSION['lab_old']);
    ?>
<?php endif; ?>

<?php require_once __DIR__ . '/pop-up/script_pasien_aktif.php'; ?>