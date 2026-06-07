<?php
    $id_rekam_medis = $patient['id_rekam_medis'] ?? null;
    $labDb = [];
    

    if ($id_rekam_medis && isset($lab_terbaru[$id_rekam_medis]) && is_array($lab_terbaru[$id_rekam_medis])) {
        $labDb = $lab_terbaru[$id_rekam_medis];
    }


    $adaDataLab = !empty($labDb['id_hasil_lab']);


    $isLabErrorActive = (isset($_SESSION['lab_errors']) && isset($_SESSION['lab_old']['id_pasien']) && $_SESSION['lab_old']['id_pasien'] == $patient['id_pasien']);
    

    $labErrors = $isLabErrorActive ? $_SESSION['lab_errors'] : [];
    $labOld = $isLabErrorActive ? $_SESSION['lab_old'] : [];
    

    $valLab = function($key_form) use ($labOld, $labDb) {
        if (isset($labOld[$key_form])) return htmlspecialchars($labOld[$key_form]);
        if (isset($labDb[$key_form])) return htmlspecialchars($labDb[$key_form]);
        return '';
    };


    $readOnlyAttr = ($adaDataLab && !$isLabErrorActive) ? 'readonly' : '';
    $bgInput = ($adaDataLab && !$isLabErrorActive) ? 'background-color: #f1f5f9;' : 'background-color: #ffffff;';
?>

<div class="modal fade" id="hasilLabModal-<?= $patient['id_pasien'] ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow" style="border-radius: 12px; border: none;">
            
            <div class="modal-header text-white" style="background-color: #043622; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                <h5 class="modal-title font-weight-bold" style="font-size: 1.1rem; text-transform: uppercase;">
                    <i class="bi bi-prescription2 me-2"></i> Input Hasil Laboratorium
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="<?= BASEURL; ?>/perawat/HasilLab" method="POST" id="formHasilLab-<?= $patient['id_pasien'] ?>">
                
                <div class="modal-body p-4" style="background-color: #f8f9fa;">
                    
                    <div class="d-flex justify-content-between align-items-center mb-4" style="border-bottom: 2px solid #eaeaea; padding-bottom: 15px;">
                        <div>
                            <span style="font-size: 0.75rem; color: #777; font-weight: 600; text-transform: uppercase;">Nama Pasien</span><br>
                            <span style="font-size: 1.05rem; color: #111; font-weight: 800;">
                                <?= htmlspecialchars($patient['nama_lengkap']) ?>
                            </span>
                        </div>
                        <div class="text-end">
                            <span style="font-size: 0.75rem; color: #777; font-weight: 600; text-transform: uppercase;">No. MRN</span><br>
                            <span style="font-size: 1.05rem; color: #111; font-weight: 800;">
                                ICU-2026-<?= str_pad($patient['id_pasien'], 3, '0', STR_PAD_LEFT) ?>
                            </span>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded shadow-sm border border-light">
                        
                        <input type="hidden" name="id_pasien" value="<?= htmlspecialchars($patient['id_pasien']) ?>">
                        <input type="hidden" name="id_rekam_medis" value="<?= htmlspecialchars($id_rekam_medis) ?>">
                        
                        <input type="hidden" name="id_hasil_lab" value="<?= htmlspecialchars($labDb['id_hasil_lab'] ?? '') ?>">

                        <div class="mb-3">
                            <label class="form-label text-dark" style="font-size: 0.85rem; font-weight: 700;">Tingkat pH Darah</label>
                            <input type="text" name="ph_darah" class="form-control input-lab-<?= $patient['id_pasien'] ?> <?= isset($labErrors['ph_darah']) ? 'is-invalid' : '' ?>" 
                                   placeholder="Contoh: 7.35" value="<?= $valLab('ph_darah') ?>" <?= $readOnlyAttr ?> style="<?= $bgInput ?> font-size: 0.9rem; border-radius: 6px;">
                            <?php if (isset($labErrors['ph_darah'])): ?>
                                <div class="text-danger mt-1" style="font-size: 0.8rem; line-height: 1.2; font-weight: 600;">
                                    <?= $labErrors['ph_darah']; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-dark" style="font-size: 0.85rem; font-weight: 700;">Hemoglobin (Hb)</label>
                            <div class="input-group has-validation">
                                <input type="text" name="hb" class="form-control input-lab-<?= $patient['id_pasien'] ?> <?= isset($labErrors['hb']) ? 'is-invalid' : '' ?>" 
                                       placeholder="Contoh: 13.5" value="<?= $valLab('hb') ?>" <?= $readOnlyAttr ?> style="<?= $bgInput ?> font-size: 0.9rem;">
                                <span class="input-group-text" style="font-size: 0.85rem; background-color: #f1f1f1; font-weight: 600;">g/dL</span>
                                <?php if (isset($labErrors['hb'])): ?>
                                    <div class="invalid-feedback" style="font-size: 0.8rem; line-height: 1.2; font-weight: 600;">
                                        <?= $labErrors['hb']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label text-dark" style="font-size: 0.85rem; font-weight: 700;">Gula Darah (Sewaktu)</label>
                            <div class="input-group has-validation">
                                <input type="text" name="gula_darah" class="form-control input-lab-<?= $patient['id_pasien'] ?> <?= isset($labErrors['gula_darah']) ? 'is-invalid' : '' ?>" 
                                       placeholder="Contoh: 110" value="<?= $valLab('gula_darah') ?>" <?= $readOnlyAttr ?> style="<?= $bgInput ?> font-size: 0.9rem;">
                                <span class="input-group-text" style="font-size: 0.85rem; background-color: #f1f1f1; font-weight: 600;">mg/dL</span>
                                <?php if (isset($labErrors['gula_darah'])): ?>
                                    <div class="invalid-feedback" style="font-size: 0.8rem; line-height: 1.2; font-weight: 600;">
                                        <?= $labErrors['gula_darah']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>
                
                <div class="modal-footer" style="border-top: 1px solid #eaeaea; background-color: #fff; padding: 15px 25px;">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal" style="font-weight: 600; font-size: 0.85rem;">Batal</button>
                    
                    <?php if ($adaDataLab && !$isLabErrorActive): ?>
                        <button type="button" class="btn text-dark shadow-sm" id="btnEditLab-<?= $patient['id_pasien'] ?>" onclick="bukaKunciLab(<?= $patient['id_pasien'] ?>)" style="background-color: #ffc107; font-weight: 700; font-size: 0.85rem;">
                            <i class="bi bi-pencil-square me-1"></i> Edit Data
                        </button>
                    <?php endif; ?>

                    <button type="submit" class="btn text-dark shadow-sm <?= ($adaDataLab && !$isLabErrorActive) ? 'd-none' : '' ?>" id="btnSimpanLab-<?= $patient['id_pasien'] ?>" style="background-color: #20c997; font-weight: 700; font-size: 0.85rem;">
                        <i class="bi bi-save-fill me-1"></i> <?= $adaDataLab ? 'Update Data Lab' : 'Simpan Data Lab' ?>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    function bukaKunciLab(idPasien) {
        let inputs = document.querySelectorAll('.input-lab-' + idPasien);
        inputs.forEach(function(input) {
            input.removeAttribute('readonly');
            input.style.backgroundColor = '#ffffff';
        });

        document.getElementById('btnEditLab-' + idPasien).classList.add('d-none');
        document.getElementById('btnSimpanLab-' + idPasien).classList.remove('d-none');
    }
</script>