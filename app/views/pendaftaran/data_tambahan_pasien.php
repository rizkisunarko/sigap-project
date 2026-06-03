<div class="section-title">DATA TAMBAHAN PASIEN</div>
<div class="section-divider"></div>

<div class="form-row">
    <div class="label-col"><label class="custom-label">Nomor BPJS/Asuransi :</label></div>
    <div class="input-col">
        <input type="text" class="custom-input" name="bpjs" value="<?= isset($old['bpjs']) ? htmlspecialchars($old['bpjs']) : ''; ?>">
        <?php if (isset($errors['bpjs'])): ?>
            <div style="color: #cc0000; font-size: 9px; margin-top: 5px; line-height: 1.2;">
                <?= $errors['bpjs']; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="form-row">
    <div class="label-col"><label class="custom-label">Golongan Darah :</label></div>
    <div class="input-col">
        <input type="text" class="custom-input" name="gol_darah" value="<?= isset($old['gol_darah']) ? htmlspecialchars($old['gol_darah']) : ''; ?>">
        <?php if (isset($errors['gol_darah'])): ?>
            <div style="color: #cc0000; font-size: 9px; margin-top: 5px; line-height: 1.2;">
                <?= $errors['gol_darah']; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="form-row">
    <div class="label-col"><label class="custom-label">Alergi :</label></div>
    <div class="input-col">
        <input type="text" class="custom-input" name="alergi" value="<?= isset($old['alergi']) ? htmlspecialchars($old['alergi']) : ''; ?>">
        <?php if (isset($errors['alergi'])): ?>
            <div style="color: #cc0000; font-size: 9px; margin-top: 5px; line-height: 1.2;">
                <?= $errors['alergi']; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="form-row">
    <div class="label-col"><label class="custom-label">Kewarganegaraan :</label></div>
    <div class="input-col">
        <input type="text" class="custom-input" name="kewarganegaraan" value="<?= isset($old['kewarganegaraan']) ? htmlspecialchars($old['kewarganegaraan']) : ''; ?>" required>
        <?php if (isset($errors['kewarganegaraan'])): ?>
            <div style="color: #cc0000; font-size: 9px; margin-top: 5px; line-height: 1.2;">
                <?= $errors['kewarganegaraan']; ?>
            </div>
        <?php endif; ?>
    </div>
</div>