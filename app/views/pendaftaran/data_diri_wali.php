<div class="section-title">DATA DIRI PENGANTAR / WALI</div>
<div class="section-divider"></div>

<div class="form-row">
    <div class="label-col"><label class="custom-label">Nama Lengkap Wali :</label></div>
    <div class="input-col">
        <input type="text" class="custom-input" name="nama_wali" value="<?= isset($old['nama_wali']) ? htmlspecialchars($old['nama_wali']) : ''; ?>" required>
        <?php if (isset($errors['nama_wali'])): ?>
            <div style="color: #cc0000; font-size: 12px; margin-top: 5px; line-height: 1.2;">
                <?= $errors['nama_wali']; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="form-row">
    <div class="label-col"><label class="custom-label">Status Wali :</label></div>
    <div class="input-col">
        <select class="custom-input" name="status_wali" required>
            <option value="" disabled <?= empty($old['status_wali']) ? 'selected' : ''; ?>>-- Pilih Hubungan dengan Pasien --</option>
            <option value="Orang Tua" <?= (isset($old['status_wali']) && $old['status_wali'] == 'Orang Tua') ? 'selected' : ''; ?>>Orang Tua (Ayah/Ibu)</option>
            <option value="Suami/Istri" <?= (isset($old['status_wali']) && $old['status_wali'] == 'Suami/Istri') ? 'selected' : ''; ?>>Suami / Istri</option>
            <option value="Anak" <?= (isset($old['status_wali']) && $old['status_wali'] == 'Anak') ? 'selected' : ''; ?>>Anak</option>
            <option value="Saudara Kandung" <?= (isset($old['status_wali']) && $old['status_wali'] == 'Saudara Kandung') ? 'selected' : ''; ?>>Saudara Kandung</option>
            <option value="Keluarga Lain" <?= (isset($old['status_wali']) && $old['status_wali'] == 'Keluarga Lain') ? 'selected' : ''; ?>>Keluarga Lain (Paman/Bibi/dll)</option>
            <option value="Pengantar/Lainnya" <?= (isset($old['status_wali']) && $old['status_wali'] == 'Pengantar/Lainnya') ? 'selected' : ''; ?>>Pengantar / Teman / Lainnya</option>
        </select>
        <?php if (isset($errors['status_wali'])): ?>
            <div style="color: #cc0000; font-size: 9px; margin-top: 5px; line-height: 1.2;">
                <?= $errors['status_wali']; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="form-row">
    <div class="label-col"><label class="custom-label">NIK Wali :</label></div>
    <div class="input-col">
        <input type="text" class="custom-input" name="nik_wali" value="<?= isset($old['nik_wali']) ? htmlspecialchars($old['nik_wali']) : ''; ?>" required>
        <?php if (isset($errors['nik_wali'])): ?>
            <div style="color: #cc0000; font-size: 9px; margin-top: 5px; line-height: 1.2;">
                <?= $errors['nik_wali']; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="form-row">
    <div class="label-col"><label class="custom-label">No.HP/Whatsapp aktif :</label></div>
    <div class="input-col">
        <input type="text" class="custom-input" name="nohp_wali" value="<?= isset($old['nohp_wali']) ? htmlspecialchars($old['nohp_wali']) : ''; ?>" required>
        <?php if (isset($errors['nohp_wali'])): ?>
            <div style="color: #cc0000; font-size: 9px; margin-top: 5px; line-height: 1.2;">
                <?= $errors['nohp_wali']; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="form-row">
    <div class="label-col"><label class="custom-label">Alamat Wali :</label></div>
    <div class="input-col">
        <textarea class="custom-input" name="alamat_wali" required><?= isset($old['alamat_wali']) ? htmlspecialchars($old['alamat_wali']) : ''; ?></textarea>
        <?php if (isset($errors['alamat_wali'])): ?>
            <div style="color: #cc0000; font-size: 9px; margin-top: 5px; line-height: 1.2;">
                <?= $errors['alamat_wali']; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="form-row">
    <div class="label-col"><label class="custom-label">TTD WALI :</label></div>
    <div class="input-col">
        <div class="canvas-container" style="position:relative;">
            <canvas id="signature-pad" style="touch-action: none;display:block;background:transparent;"></canvas>
            <div id="signature-placeholder" style="position:absolute;left:0;right:0;top:0;bottom:0;display:flex;align-items:center;justify-content:center;pointer-events:none;color:#999;font-size:16px;">Canvas Untuk TTD Digital</div>
            <div style="margin-top:8px;display:flex;align-items:center;gap:8px;">
                <span style="font-size:12px;color:#666;">(Tanda tangan dengan mouse atau layar sentuh)</span>
                <a href="#" id="clear-signature" style="font-size:12px;color:#007bff;text-decoration:underline;">Bersihkan</a>
            </div>
            <input type="hidden" name="ttd_wali" id="ttd_wali">
        </div>
        <?php if (isset($errors['ttd_wali'])): ?>
            <div style="color: #cc0000; font-size: 9px; margin-top: 5px; line-height: 1.2;">
                <?= $errors['ttd_wali']; ?>
            </div>
        <?php endif; ?>
    </div>
</div>