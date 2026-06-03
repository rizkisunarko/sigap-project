<div class="section-title">DATA DIRI PASIEN</div>
<div class="section-divider"></div>

<div class="form-row">
    <div class="label-col"><label class="custom-label">NIK :</label></div>
    <div class="input-col">
        <input type="text" class="custom-input" name="nik" value="<?= isset($old['nik']) ? htmlspecialchars($old['nik']) : ''; ?>" required>
        <?php if (isset($errors['nik'])): ?>
            <div style="color: #cc0000; font-size: 9px; margin-top: 5px; line-height: 1.2;">
                <?= $errors['nik']; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="form-row">
    <div class="label-col"><label class="custom-label">Nama Lengkap :</label></div>
    <div class="input-col">
        <input type="text" class="custom-input" name="nama_pasien" value="<?= isset($old['nama_pasien']) ? htmlspecialchars($old['nama_pasien']) : ''; ?>" required>
        <?php if (isset($errors['nama_pasien'])): ?>
            <div style="color: #cc0000; font-size: 9px; margin-top: 5px; line-height: 1.2;">
                <?= $errors['nama_pasien']; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="form-row">
    <div class="label-col"><label class="custom-label">Asal :</label></div>
    <div class="input-col multi-input-row">
        <div class="multi-input-group">
            <input type="text" class="custom-input" name="asal" value="<?= isset($old['asal']) ? htmlspecialchars($old['asal']) : ''; ?>" required>
            <?php if (isset($errors['asal'])): ?>
                <div style="color: #cc0000; font-size: 9px; margin-top: 5px; line-height: 1.2;">
                    <?= $errors['asal']; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="multi-input-group" style="flex: 0.8;">
            <label class="multi-label">TGL.Lahir :</label>
            <input type="date" class="custom-input" name="tgl_lahir" value="<?= isset($old['tgl_lahir']) ? htmlspecialchars($old['tgl_lahir']) : ''; ?>" required>
            <?php if (isset($errors['tgl_lahir'])): ?>
                <div style="color: #cc0000; font-size: 9px; margin-top: 5px; line-height: 1.2;">
                    <?= $errors['tgl_lahir']; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="label-col"><label class="custom-label">Jenis Kelamin :</label></div>
    <div class="input-col radio-group">
        <label class="radio-item"><input type="radio" name="jk" value="Laki-laki" <?= (isset($old['jk']) && $old['jk'] == 'Laki-laki') ? 'checked' : ''; ?> required> Laki-laki</label>
        <label class="radio-item"><input type="radio" name="jk" value="Perempuan" <?= (isset($old['jk']) && $old['jk'] == 'Perempuan') ? 'checked' : ''; ?> required> Perempuan</label>
        <?php if (isset($errors['jk'])): ?>
            <div style="color: #cc0000; font-size: 9px; margin-top: 5px; line-height: 1.2; width: 100%;">
                <?= $errors['jk']; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="form-row">
    <div class="label-col"><label class="custom-label">Agama :</label></div>
    <div class="input-col">
        <input type="text" class="custom-input" name="agama" value="<?= isset($old['agama']) ? htmlspecialchars($old['agama']) : ''; ?>" required>
        <?php if (isset($errors['agama'])): ?>
            <div style="color: #cc0000; font-size: 9px; margin-top: 5px; line-height: 1.2;">
                <?= $errors['agama']; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="form-row">
    <div class="label-col"><label class="custom-label">Status Perkawinan :</label></div>
    <div class="input-col">
        <select class="custom-input" name="status_perkawinan" required>
            <option value="" disabled <?= empty($old['status_perkawinan']) ? 'selected' : ''; ?>>-- Pilih Status --</option>
            <option value="Belum Kawin" <?= (isset($old['status_perkawinan']) && $old['status_perkawinan'] == 'Belum Kawin') ? 'selected' : ''; ?>>Belum Kawin</option>
            <option value="Kawin" <?= (isset($old['status_perkawinan']) && $old['status_perkawinan'] == 'Kawin') ? 'selected' : ''; ?>>Kawin</option>
            <option value="Cerai Hidup" <?= (isset($old['status_perkawinan']) && $old['status_perkawinan'] == 'Cerai Hidup') ? 'selected' : ''; ?>>Cerai Hidup</option>
            <option value="Cerai Mati" <?= (isset($old['status_perkawinan']) && $old['status_perkawinan'] == 'Cerai Mati') ? 'selected' : ''; ?>>Cerai Mati</option>
        </select>
        <?php if (isset($errors['status_perkawinan'])): ?>
            <div style="color: #cc0000; font-size: 9px; margin-top: 5px; line-height: 1.2;">
                <?= $errors['status_perkawinan']; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="form-row">
    <div class="label-col"><label class="custom-label">Pekerjaan :</label></div>
    <div class="input-col">
        <input type="text" class="custom-input" name="pekerjaan" value="<?= isset($old['pekerjaan']) ? htmlspecialchars($old['pekerjaan']) : ''; ?>" required>
        <?php if (isset($errors['pekerjaan'])): ?>
            <div style="color: #cc0000; font-size: 9px; margin-top: 5px; line-height: 1.2;">
                <?= $errors['pekerjaan']; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="form-row">
    <div class="label-col"><label class="custom-label">Alamat :</label></div>
    <div class="input-col">
        <textarea class="custom-input" name="alamat" required><?= isset($old['alamat']) ? htmlspecialchars($old['alamat']) : ''; ?></textarea>
        <?php if (isset($errors['alamat'])): ?>
            <div style="color: #cc0000; font-size: 9px; margin-top: 5px; line-height: 1.2;">
                <?= $errors['alamat']; ?>
            </div>
        <?php endif; ?>
    </div>
</div>