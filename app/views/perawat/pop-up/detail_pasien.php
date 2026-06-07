<?php defined('BASEURL') OR exit(header("HTTP/1.1 404 Not Found") . "<html><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL was not found on this server.</p></body></html>"); ?>
<div class="modal fade" id="patientDetailModal-<?= $patient['id_pasien'] ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; border: 2px solid #20c997; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="m-0" style="color: #111; font-weight: 700; font-size: 1.1rem;">INFORMASI PASIEN</h5>
                    <a href="#" class="btn-detail-lengkap" data-id="<?= $patient['id_pasien'] ?>" style="color: #111; text-decoration: none; font-weight: 500; font-size: 0.9rem;">Lihat Detail &rarr;</a>
                </div>

                <div style="border: 1px solid #111; border-radius: 12px; padding: 25px;">
                    <div class="row gx-5">
                        <div class="col-md-6">
                            <div class="row align-items-center mb-3">
                                <label class="col-sm-5 col-form-label" style="color: #111; font-weight: 500; font-size: 0.95rem;">MRN :</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" readonly style="border: 1px solid #111; border-radius: 0; background-color: transparent;" value="ICU-2026-<?= str_pad($patient['id_pasien'], 3, '0', STR_PAD_LEFT) ?>">
                                </div>
                            </div>
                            <div class="row align-items-center mb-3">
                                <label class="col-sm-5 col-form-label" style="color: #111; font-weight: 500; font-size: 0.95rem;">Nama Lengkap :</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" readonly style="border: 1px solid #111; border-radius: 0; background-color: transparent;" value="<?= htmlspecialchars($patient['nama_lengkap']) ?>">
                                </div>
                            </div>
                            <div class="row align-items-center mb-3">
                                <label class="col-sm-5 col-form-label" style="color: #111; font-weight: 500; font-size: 0.95rem;">NIK :</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" readonly style="border: 1px solid #111; border-radius: 0; background-color: transparent;" value="<?= htmlspecialchars($patient['nik'] ?: '-') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row align-items-center mb-3">
                                <label class="col-sm-5 col-form-label" style="color: #111; font-weight: 500; font-size: 0.95rem;">Jenis Kelamin :</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" readonly style="border: 1px solid #111; border-radius: 0; background-color: transparent;" value="<?= $patient['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?>">
                                </div>
                            </div>
                            <div class="row align-items-center mb-3">
                                <label class="col-sm-5 col-form-label" style="color: #111; font-weight: 500; font-size: 0.95rem;">Asal :</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" readonly style="border: 1px solid #111; border-radius: 0; background-color: transparent;" value="<?= htmlspecialchars($patient['asal'] ?: '-') ?>">
                                </div>
                            </div>
                            <div class="row align-items-center mb-3">
                                <label class="col-sm-5 col-form-label" style="color: #111; font-weight: 500; font-size: 0.95rem;">No.HP Keluarga :</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" readonly style="border: 1px solid #111; border-radius: 0; background-color: transparent;" value="<?= htmlspecialchars($patient['no_hp_wali'] ?: '-') ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php 
                    $riwayatKunjungan = $rmModel->ambilRiwayatPasien($patient['id_pasien']); 
                    
                    if (!is_array($riwayatKunjungan)) {
                        $riwayatKunjungan = [];
                    }
                    
                    $totalKunjungan = count($riwayatKunjungan);
                ?>

                <div class="mt-4 mb-2">
                    <h6 style="color: #111; font-weight: 700; font-size: 1rem;">RIWAYAT KUNJUNGAN</h6>
                </div>
                
                <div class="mt-4 mb-2">
                    <h6 style="color: #111; font-weight: 700; font-size: 1rem;">JUMLAH TOTAL KUNJUNGAN : <?= $totalKunjungan ?></h6>
                </div>

                <div style="border: 1px solid #111; border-radius: 12px; padding: 25px;">
                    <?php if ($totalKunjungan > 0): ?>
                        <?php foreach ($riwayatKunjungan as $index => $riwayat): ?>
                            
                            <div style="border: 1px solid #111; border-radius: 8px; padding: 15px 30px; margin-bottom: <?= ($index === $totalKunjungan - 1) ? '0' : '15px' ?>;" class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div style="font-size: 0.9rem; color: #111; margin-bottom: 4px;">Tanggal Masuk : <?= date('d-m-Y', strtotime($riwayat['tanggal_masuk'])) ?></div>
                                    <div style="font-size: 0.9rem; color: #111;">Tanggal Keluar : <?= $riwayat['tanggal_keluar'] ? date('d-m-Y', strtotime($riwayat['tanggal_keluar'])) : 'Masih Dirawat' ?></div>
                                </div>
                                <div>
                                    <div style="font-size: 0.9rem; color: #111; margin-bottom: 4px;">Diagnosa : <?= htmlspecialchars($riwayat['diagnosa'] ?: 'Belum ada diagnosa') ?></div>
                                    <a href="#" class="btn-detail-riwayat" data-idpasien="<?= $patient['id_pasien'] ?>" data-idrm="<?= $riwayat['id_rekam_medis'] ?>" style="font-size: 0.85rem; color: #111; font-weight: 700; text-decoration: none;">Lihat Detail Penanganan &rarr;</a>
                                </div>
                            </div>
                            
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center">
                            <p style="font-size: 0.9rem; color: #666; margin: 0;">Belum ada riwayat kunjungan.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="d-flex justify-content-center mt-5 mb-2">
                    <button type="button" class="btn" data-bs-dismiss="modal" style="background-color: #dc3545; color: white; border: none; font-weight: 700; width: 140px; border-radius: 8px; padding: 10px 0; font-size: 0.95rem; letter-spacing: 0.5px;">KEMBALI</button>
                </div>
            </div>
        </div>
    </div>
</div>