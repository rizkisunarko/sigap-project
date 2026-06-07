<?php
    $riwayatKunjunganModal = [];
    if (isset($rmModel) && isset($patient['id_pasien'])) {
        $riwayatKunjunganModal = $rmModel->ambilRiwayatPasien($patient['id_pasien']);
    }
?>

<?php if (is_array($riwayatKunjunganModal) && count($riwayatKunjunganModal) > 0): ?>
    <?php foreach ($riwayatKunjunganModal as $riw): ?>
    
    <div class="modal fade" id="riwayatPasienModal-<?= $riw['id_rekam_medis'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 700px;">
            <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                
                <div class="modal-header border-0 pb-2 px-4 mt-3 d-flex justify-content-between align-items-center">
                    <h5 class="modal-title m-0" style="color: #111; font-weight: 800; font-size: 1.25rem; text-transform: uppercase;">RIWAYAT PERKEMBANGAN PASIEN</h5>
                </div>
                
                <div class="modal-body px-4 py-2">

                    <div class="position-relative ps-5 mt-3 mb-4" style="padding-left: 2.5rem !important;">
                        
                        <div class="position-absolute bg-[#20c997]" style="left: 14px; top: 20px; bottom: 20px; width: 4px; border-radius: 2px; background-color: #20c997;"></div>

                        <?php
                            $timelineObservasi = [];
                            if (isset($rmModel)) {
                                $timelineObservasi = $rmModel->ambilTimelineObservasi($riw['id_rekam_medis']);
                            }
                        ?>

                        <?php if (is_array($timelineObservasi) && count($timelineObservasi) > 0): ?>
                            <?php foreach ($timelineObservasi as $obs): ?>
                            
                            <div class="position-relative mb-4">
                                
                                <div class="position-absolute rounded-circle bg-[#20c997]" style="left: -2rem; top: 1.5rem; width: 16px; height: 16px; background-color: #20c997; border: 2px solid #fff; box-shadow: 0 0 0 1px #20c997;"></div>
                                
                                <div class="border rounded-4 bg-white" style="border-color: #20c997 !important; padding: 20px 25px;">
                                    <div class="row">
                                        
                                        <div class="col-6">
                                            <div class="text-secondary mb-2" style="font-size: 0.8rem; font-weight: 500;">
                                                DETAK JANTUNG : <?= htmlspecialchars($obs['detak_jantung'] ?? '-') ?> BPM
                                            </div>
                                            <div class="text-secondary mb-2" style="font-size: 0.8rem; font-weight: 500;">
                                                OKSIGEN (SPO2) : <?= htmlspecialchars($obs['sp02'] ?? '-') ?> %
                                            </div>
                                            <div class="text-secondary mb-2" style="font-size: 0.8rem; font-weight: 500;">
                                                SUHU TUBUH : <?= htmlspecialchars($obs['suhu_tubuh'] ?? '-') ?> &deg;C
                                            </div>
                                            <div class="text-secondary" style="font-size: 0.8rem; font-weight: 500;">
                                                TEKANAN DARAH : <?= htmlspecialchars($obs['tekanan_darah'] ?? '-') ?> mmhg
                                            </div>
                                        </div>
                                        
                                        <div class="col-6">
                                            <div class="text-secondary mb-2" style="font-size: 0.8rem; font-weight: 500;">
                                                <?php 
                                                    $jam = isset($obs['waktu_catat']) ? date('H:i', strtotime($obs['waktu_catat'])) : '00:00';
                                                ?>
                                                JAM : <?= $jam ?> WIB
                                            </div>
                                            <div class="text-secondary mb-2 d-flex align-items-center" style="font-size: 0.8rem; font-weight: 500;">
                                                <span class="me-2">STATUS PASIEN :</span>
                                                <?php 

                                                    $status_badge = strtolower(trim($obs['status_pasien'] ?? ''));
                                                    

                                                    if (in_array($status_badge, ['kritis', 'menurun'])) {
                                                        $warna_bg = '#dc3545';
                                                    } elseif (in_array($status_badge, ['stabil', 'meningkat'])) {
                                                        $warna_bg = '#20c997';
                                                    } else {
                                                        $warna_bg = '#6c757d';
                                                    }
                                                ?>
                                                <span class="badge rounded-pill text-white" style="background-color: <?= $warna_bg ?>; padding: 4px 12px; font-weight: 600; text-transform: uppercase;">
                                                    <?= htmlspecialchars($obs['status_pasien'] ?? 'TIDAK DIKETAHUI') ?>
                                                </span>
                                            </div>
                                            <div class="text-secondary" style="font-size: 0.8rem; font-weight: 500; text-transform: uppercase;">
                                                PETUGAS : <?= htmlspecialchars($obs['nama_perawat'] ?? '-') ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-secondary" style="font-size: 0.9rem;">Belum ada riwayat perkembangan yang dicatat.</div>
                        <?php endif; ?>

                    </div>

                    <div class="d-flex justify-content-center mt-5 mb-3">
                        <button type="button" class="btn" data-bs-dismiss="modal" style="background-color: #dc3545; color: white; border: none; font-weight: 700; width: 140px; border-radius: 8px; padding: 8px 0; font-size: 0.95rem; letter-spacing: 0.5px;">KEMBALI</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    <?php endforeach; ?>
<?php endif; ?>