<?php defined('BASEURL') OR exit(header("HTTP/1.1 404 Not Found") . "<html><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL was not found on this server.</p></body></html>"); ?>
<?php
    $detailPasien = [];
    if (isset($pasienModel) && isset($patient['id_pasien'])) {
        $detailPasien = $pasienModel->ambilDataPasien($patient['id_pasien']);
    }
?>

<div class="modal fade" id="detailLengkapModal-<?= $patient['id_pasien'] ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 pb-2 px-4 mt-3">
                <h5 class="modal-title m-0" style="color: #043622; font-weight: 800; font-size: 1.25rem;">DETAIL LENGKAP PASIEN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="px-4">
                <hr style="border-top: 3px solid #043622; margin: 0; opacity: 1;">
            </div>
            <div class="modal-body px-4 pt-4 pb-5">

                <div class="mb-4">
                    <h6 style="color: #666; font-weight: 600; font-size: 0.95rem; margin-bottom: 8px;">AKUN PENGGUNA</h6>
                    <hr style="border-top: 2px solid #aeb5b2; margin: 0 0 15px 0; opacity: 1;">
                    <div class="row mb-2">
                        <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Username:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" readonly style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #111; background-color: transparent; border-radius: 0; color: #111;" value="<?= htmlspecialchars($detailPasien['username'] ?? '-') ?>">
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 style="color: #666; font-weight: 600; font-size: 0.95rem; margin-bottom: 8px;">DATA DIRI PASIEN</h6>
                    <hr style="border-top: 2px solid #aeb5b2; margin: 0 0 15px 0; opacity: 1;">
                    <div class="row mb-2">
                        <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">NIK :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" readonly style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #111; background-color: transparent; border-radius: 0; color: #111;" value="<?= htmlspecialchars($detailPasien['nik'] ?? '-') ?>">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Nama Lengkap:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" readonly style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #111; background-color: transparent; border-radius: 0; color: #111;" value="<?= htmlspecialchars($detailPasien['nama_lengkap'] ?? '-') ?>">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Asal :</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-sm" readonly style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #111; background-color: transparent; border-radius: 0; color: #111;" value="<?= htmlspecialchars($detailPasien['asal'] ?? '-') ?>">
                        </div>
                        <label class="col-sm-2 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">TGL.Lahir :</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-sm" readonly style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #111; background-color: transparent; border-radius: 0; color: #111;" value="<?= htmlspecialchars($detailPasien['tgl_lahir'] ?? '-') ?>">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Jenis Kelamin :</label>
                        <div class="col-sm-8">
                            <?php 
                                $jk = $detailPasien['jenis_kelamin'] ?? '';
                                $jkVal = ($jk == 'L') ? 'Laki-laki' : (($jk == 'P') ? 'Perempuan' : '-');
                            ?>
                            <input type="text" class="form-control form-control-sm" readonly style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #111; background-color: transparent; border-radius: 0; color: #111;" value="<?= $jkVal ?>">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Agama :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" readonly style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #111; background-color: transparent; border-radius: 0; color: #111;" value="<?= htmlspecialchars($detailPasien['agama'] ?? '-') ?>">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Status Perkawinan :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" readonly style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #111; background-color: transparent; border-radius: 0; color: #111;" value="<?= htmlspecialchars($detailPasien['status_perkawinan'] ?? '-') ?>">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Pekerjaan :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" readonly style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #111; background-color: transparent; border-radius: 0; color: #111;" value="<?= htmlspecialchars($detailPasien['pekerjaan'] ?? '-') ?>">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-sm-3 col-form-label text-end mt-1" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Alamat :</label>
                        <div class="col-sm-8">
                            <textarea class="form-control form-control-sm" readonly rows="3" style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #111; background-color: transparent; border-radius: 0; resize: none; color: #111;"><?= htmlspecialchars($detailPasien['alamat'] ?? '-') ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 style="color: #666; font-weight: 600; font-size: 0.95rem; margin-bottom: 8px;">DATA TAMBAHAN PASIEN</h6>
                    <hr style="border-top: 2px solid #aeb5b2; margin: 0 0 15px 0; opacity: 1;">
                    <div class="row mb-2">
                        <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Nomor BPJS/Asuransi :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" readonly style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #111; background-color: transparent; border-radius: 0; color: #111;" value="<?= htmlspecialchars($detailPasien['nomor_bpjs'] ?? '-') ?>">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Golongan Darah :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" readonly style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #111; background-color: transparent; border-radius: 0; color: #111;" value="<?= htmlspecialchars($detailPasien['golongan_darah'] ?? '-') ?>">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Kewarganegaraan :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" readonly style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #111; background-color: transparent; border-radius: 0; color: #111;" value="<?= htmlspecialchars($detailPasien['kewarganegaraan'] ?? '-') ?>">
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 style="color: #666; font-weight: 600; font-size: 0.95rem; margin-bottom: 8px;">DATA DIRI PENGANTAR / WALI</h6>
                    <hr style="border-top: 2px solid #aeb5b2; margin: 0 0 15px 0; opacity: 1;">
                    <div class="row mb-2">
                        <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Nama Lengkap Wali :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" readonly style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #111; background-color: transparent; border-radius: 0; color: #111;" value="<?= htmlspecialchars($detailPasien['nama_lengkap_wali'] ?? '-') ?>">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Status Wali :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" readonly style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #111; background-color: transparent; border-radius: 0; color: #111;" value="<?= htmlspecialchars($detailPasien['status_wali'] ?? '-') ?>">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">NIK Wali :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" readonly style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #111; background-color: transparent; border-radius: 0; color: #111;" value="<?= htmlspecialchars($detailPasien['nik_wali'] ?? '-') ?>">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">No.HP/Whatsapp aktif :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" readonly style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #111; background-color: transparent; border-radius: 0; color: #111;" value="<?= htmlspecialchars($detailPasien['no_hp_wali'] ?? '-') ?>">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-sm-3 col-form-label text-end mt-1" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Alamat Wali :</label>
                        <div class="col-sm-8">
                            <textarea class="form-control form-control-sm" readonly rows="3" style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #111; background-color: transparent; border-radius: 0; resize: none; color: #111;"><?= htmlspecialchars($detailPasien['alamat_wali'] ?? '-') ?></textarea>
                        </div>
                    </div>
                    <div class="row mb-2 mt-4">
                        <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">TTD WALI :</label>
                        <div class="col-sm-8">
                            <div style="border: 1px solid #111; border-radius: 0; height: 120px; background-color: transparent; display: flex; align-items: center; justify-content: center;">
                                <?php if (!empty($detailPasien['dokumen_ttd'])): ?>
                                    <img src="<?= BASEURL; ?>/assets/img/signatures/<?= htmlspecialchars($detailPasien['dokumen_ttd']) ?>" style="max-height: 100px;">
                                <?php else: ?>
                                    <span style="font-family: 'Courier New', monospace; color: #888; font-weight: 600;">Tidak ada tanda tangan</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center gap-3 mt-5 mb-3">
                    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#patientEditModal-<?= $patient['id_pasien'] ?>" data-bs-dismiss="modal" style="background-color: #20c997; color: white; border: none; font-weight: 600; width: 160px; border-radius: 6px; padding: 6px 0; font-size: 0.85rem; letter-spacing: 0.5px;">EDIT DATA</button>
                    <button type="button" class="btn" data-bs-dismiss="modal" style="background-color: #dc3545; color: white; border: none; font-weight: 600; width: 120px; border-radius: 6px; padding: 6px 0; font-size: 0.85rem; letter-spacing: 0.5px;">TUTUP</button>
                </div>

            </div>
        </div>
    </div>
</div>