<?php defined('BASEURL') OR exit(header("HTTP/1.1 404 Not Found") . "<html><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL was not found on this server.</p></body></html>"); ?>
<?php
    $isRmErrorActive = (isset($_SESSION['rm_errors']) && isset($_SESSION['rm_old']['id_pasien']) && $_SESSION['rm_old']['id_pasien'] == $patient['id_pasien']);
    
    $rmErrors = $isRmErrorActive ? $_SESSION['rm_errors'] : [];
    $rmOld = $isRmErrorActive ? $_SESSION['rm_old'] : [];
    
    $valRM = function($key_form) use ($rmOld) {
        return isset($rmOld[$key_form]) ? htmlspecialchars($rmOld[$key_form]) : '';
    };
?>

<div class="modal fade" id="editRekamMedisModal-<?= $patient['id_pasien'] ?>" tabindex="-1" aria-labelledby="editRekamMedisModalLabel-<?= $patient['id_pasien'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 450px;">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 pb-2 px-4 mt-3 d-flex justify-content-between align-items-center">
                <h5 class="modal-title m-0" id="editRekamMedisModalLabel-<?= $patient['id_pasien'] ?>" style="color: #043622; font-weight: 800; font-size: 1.15rem;">EDIT REKAM MEDIS PASIEN</h5>
                <span data-bs-dismiss="modal" aria-label="Close" style="cursor: pointer; font-size: 1.25rem; font-weight: 800; color: #111;">X</span>
            </div>
            <div class="px-4">
                <hr style="border-top: 1.5px solid #111; margin: 0; opacity: 1;">
            </div>
            <div class="modal-body px-4 py-4">
                
                
                <form id="editRekamMedisForm-<?= $patient['id_pasien'] ?>" action="<?= BASEURL; ?>/rekammedis/update" method="POST">
                    
                    <input type="hidden" name="id_pasien" value="<?= $patient['id_pasien'] ?>">

                    <div class="row mb-3 align-items-center">
                        <label class="col-4 col-form-label text-end pe-2" style="color: #043622; font-weight: 500; font-size: 0.85rem;">NO.BED :</label>
                        <div class="col-8">
                            <select name="no_bed" class="form-control form-control-sm" style="border-radius: 20px; border: 1px solid #111; padding: 6px 15px; font-weight: 500; font-size: 0.85rem; color: #111; background-color: transparent;" required>
                                
                                <?php 
                                    // 1. Tentukan nomor bed mana yang sedang dipakai (prioritas dari error/old form, lalu database)
                                    $bedAktif = htmlspecialchars($rmOld['no_bed'] ?? $patient['nomor_bed'] ?? '');
                                ?>
                                
                                <option value="" disabled <?= empty($bedAktif) ? 'selected' : ''; ?>>-- Pilih Bed --</option>
                                
                                <?php 
                                    // 2. Looping daftar bed dari Controller
                                    if (!empty($data['daftar_semua_bed'])):
                                        foreach ($data['daftar_semua_bed'] as $b): 
                                            $statusBed = strtoupper($b['status_bed'] ?? '');
                                            
                                            // TAMPILKAN JIKA: Bed tersebut TERSEDIA, ATAU bed tersebut adalah milik pasien ini
                                            if ($statusBed === 'TERSEDIA' || $b['nomor_bed'] === $bedAktif):
                                                
                                                // Tandai otomatis jika itu bed milik pasien ini
                                                $isSelected = ($b['nomor_bed'] === $bedAktif) ? 'selected' : '';
                                ?>
                                                <option value="<?= htmlspecialchars($b['nomor_bed']) ?>" <?= $isSelected ?>>
                                                    <?= htmlspecialchars($b['nomor_bed']) ?>
                                                </option>
                                <?php 
                                            endif;
                                        endforeach; 
                                    endif; 
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label class="col-4 col-form-label text-end pe-2" style="color: #043622; font-weight: 500; font-size: 0.85rem;">Detak Jantung :</label>
                        <div class="col-8">
                            <input type="text" name="detak_jantung" value="<?= htmlspecialchars($rmOld['detak_jantung'] ?? '') ?>" class="form-control form-control-sm" style="border-radius: 20px; border: 1px solid #111; padding: 6px 15px; font-weight: 500; font-size: 0.85rem; color: #111; background-color: transparent;" required pattern="\d+" title="Hanya angka (bpm)">
                            <?php if (isset($rmErrors['detak_jantung'])): ?>
                                <div class="text-danger mt-1" style="font-size: 0.75rem; line-height: 1.2;"><?= $rmErrors['detak_jantung']; ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label class="col-4 col-form-label text-end pe-2" style="color: #043622; font-weight: 500; font-size: 0.85rem;">Oksigen :</label>
                        <div class="col-8">
                            <input type="text" name="oksigen" value="<?= htmlspecialchars($rmOld['oksigen'] ?? '') ?>" class="form-control form-control-sm" style="border-radius: 20px; border: 1px solid #111; padding: 6px 15px; font-weight: 500; font-size: 0.85rem; color: #111; background-color: transparent;" required>
                            <?php if (isset($rmErrors['oksigen'])): ?>
                                <div class="text-danger mt-1" style="font-size: 0.75rem; line-height: 1.2;"><?= $rmErrors['oksigen']; ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label class="col-4 col-form-label text-end pe-2" style="color: #043622; font-weight: 500; font-size: 0.85rem;">Suhu Tubuh :</label>
                        <div class="col-8">
                            <input type="text" name="suhu_tubuh" value="<?= htmlspecialchars($rmOld['suhu_tubuh'] ?? '') ?>" class="form-control form-control-sm" style="border-radius: 20px; border: 1px solid #111; padding: 6px 15px; font-weight: 500; font-size: 0.85rem; color: #111; background-color: transparent;" required>
                            <?php if (isset($rmErrors['suhu_tubuh'])): ?>
                                <div class="text-danger mt-1" style="font-size: 0.75rem; line-height: 1.2;"><?= $rmErrors['suhu_tubuh']; ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label class="col-4 col-form-label text-end pe-2" style="color: #043622; font-weight: 500; font-size: 0.85rem;">Tekanan Darah :</label>
                        <div class="col-8">
                            <input type="text" name="tekanan_darah" value="<?= htmlspecialchars($rmOld['tekanan_darah'] ?? '') ?>" class="form-control form-control-sm" style="border-radius: 20px; border: 1px solid #111; padding: 6px 15px; font-weight: 500; font-size: 0.85rem; color: #111; background-color: transparent;" required placeholder="cth: 120/80">
                            <?php if (isset($rmErrors['tekanan_darah'])): ?>
                                <div class="text-danger mt-1" style="font-size: 0.75rem; line-height: 1.2;"><?= $rmErrors['tekanan_darah']; ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label class="col-4 col-form-label text-end pe-2" style="color: #043622; font-weight: 500; font-size: 0.85rem;">Status Pasien :</label>
                        <div class="col-8">
                            <select name="status_klinis" class="form-control form-control-sm" style="border-radius: 20px; border: 1px solid #111; padding: 6px 15px; font-weight: 500; font-size: 0.85rem; color: #111; background-color: transparent;" required>
                                <?php $statusAwal = $rmOld['status_klinis'] ?? $patient['status_klinis'] ?? ''; ?>
                                <option value="" disabled <?= empty($statusAwal) ? 'selected' : ''; ?>>-- Pilih Status --</option>
                                <option value="stabil" <?= (strtolower($statusAwal) == 'stabil') ? 'selected' : ''; ?>>Stabil</option>
                                <option value="kritis" <?= (strtolower($statusAwal) == 'kritis') ? 'selected' : ''; ?>>Kritis</option>
                                <option value="meningkat" <?= (strtolower($statusAwal) == 'meningkat') ? 'selected' : ''; ?>>Meningkat</option>
                                <option value="menurun" <?= (strtolower($statusAwal) == 'menurun') ? 'selected' : ''; ?>>Menurun</option>
                            </select>
                            <?php if (isset($rmErrors['status_klinis'])): ?>
                                <div class="text-danger mt-1" style="font-size: 0.75rem; line-height: 1.2;"><?= $rmErrors['status_klinis']; ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label class="col-4 col-form-label text-end pe-2" style="color: #043622; font-weight: 500; font-size: 0.85rem;">Diagnosa Medis :</label>
                        <div class="col-8">
                            <input type="text" name="diagnosa" value="<?= htmlspecialchars($rmOld['diagnosa'] ?? '') ?>" class="form-control form-control-sm" style="border-radius: 20px; border: 1px solid #111; padding: 6px 15px; font-weight: 500; font-size: 0.85rem; color: #111; background-color: transparent;" required>
                            <?php if (isset($rmErrors['diagnosa'])): ?>
                                <div class="text-danger mt-1" style="font-size: 0.75rem; line-height: 1.2;"><?= $rmErrors['diagnosa']; ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label class="col-4 col-form-label text-end pe-2 pt-1" style="color: #043622; font-weight: 500; font-size: 0.85rem;">Tindakan Perawat :</label>
                        <div class="col-8">
                            <textarea name="tindakan" class="form-control form-control-sm" rows="3" style="border-radius: 12px; border: 1px solid #111; padding: 10px 15px; font-weight: 500; font-size: 0.85rem; resize: none; color: #111; background-color: transparent;" required placeholder="Sebutkan tindakan yang dilakukan..."><?= htmlspecialchars($rmOld['tindakan'] ?? '') ?></textarea>
                            <?php if (isset($rmErrors['tindakan'])): ?>
                                <div class="text-danger mt-1" style="font-size: 0.75rem; line-height: 1.2;"><?= $rmErrors['tindakan']; ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label class="col-4 col-form-label text-end pe-2 pt-1" style="color: #043622; font-weight: 500; font-size: 0.85rem;">Detail Kondisi :</label>
                        <div class="col-8">
                            <textarea name="detail_kondisi" class="form-control form-control-sm" rows="4" style="border-radius: 12px; border: 1px solid #111; padding: 10px 15px; font-weight: 500; font-size: 0.85rem; resize: none; color: #111; background-color: transparent;" required><?= htmlspecialchars($rmOld['detail_kondisi'] ?? '') ?></textarea>
                            <?php if (isset($rmErrors['detail_kondisi'])): ?>
                                <div class="text-danger mt-1" style="font-size: 0.75rem; line-height: 1.2;"><?= $rmErrors['detail_kondisi']; ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center mt-5 mb-2">
                        <button type="button" class="btn btn-edit-trigger" data-id="<?= $patient['id_pasien'] ?>" style="background-color: #20c997; color: white; border: 1px solid #20c997; font-weight: 700; width: 180px; border-radius: 8px; padding: 8px 0; font-size: 0.9rem; letter-spacing: 0.5px;">EDIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmSaveRekamMedisModal-<?= $patient['id_pasien'] ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content" style="border-radius: 12px; border: none; padding: 25px 20px;">
            <div class="modal-body text-center">
                <i class="bi bi-shield-check" style="font-size: 5rem; color: #20c997;"></i>
                <h5 class="mt-2 mb-4" style="color: #111; font-weight: 700; font-size: 1.15rem;">Yakin Ingin Menyimpan Perubahan?</h5>
                <div class="d-flex justify-content-center gap-4 mt-4">
                    <button type="submit" form="editRekamMedisForm-<?= $patient['id_pasien'] ?>" class="btn" style="background-color: #20c997; color: #111; border: 1px solid #111; font-weight: 600; width: 120px; border-radius: 8px; padding: 8px 0;">Ya, Simpan</button>
                    
                    <button type="button" class="btn" data-bs-target="#editRekamMedisModal-<?= $patient['id_pasien'] ?>" data-bs-toggle="modal" style="background-color: #dc3545; color: #111; border: 1px solid #111; font-weight: 600; width: 120px; border-radius: 8px; padding: 8px 0;">Tidak</button>
                </div>
            </div>
        </div>
    </div>
</div>