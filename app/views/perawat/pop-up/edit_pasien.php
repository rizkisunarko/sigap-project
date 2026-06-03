<?php defined('BASEURL') OR exit(header("HTTP/1.1 404 Not Found") . "<html><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL was not found on this server.</p></body></html>"); ?>
<?php
    $detailEdit = [];
    if (isset($pasienModel) && isset($patient['id_pasien'])) {
        $detailEdit = $pasienModel->ambilDataPasien($patient['id_pasien']);
    }

    $isErrorActive = (isset($_SESSION['errors']) && isset($_SESSION['old']['id_pasien']) && $_SESSION['old']['id_pasien'] == $patient['id_pasien']);
    
    $errors = $isErrorActive ? $_SESSION['errors'] : [];
    $old = $isErrorActive ? $_SESSION['old'] : [];
    
    $val = function($key_form, $key_db) use ($old, $detailEdit) {
        return isset($old[$key_form]) ? htmlspecialchars($old[$key_form]) : htmlspecialchars($detailEdit[$key_db] ?? '');
    };
?>

<div class="modal fade" id="patientEditModal-<?= $patient['id_pasien'] ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 pb-2 px-4 mt-3">
                <h5 class="modal-title m-0" style="color: #043622; font-weight: 800; font-size: 1.25rem;">EDIT DATA PASIEN</h5>
            </div>
            <div class="px-4">
                <hr style="border-top: 3px solid #043622; margin: 0; opacity: 1;">
            </div>
            <div class="modal-body px-4 pt-4 pb-5">

                <form id="editPasienForm-<?= $patient['id_pasien'] ?>" action="<?= BASEURL; ?>/pasien/update" method="POST">
                    
                    <input type="hidden" name="id_pasien" value="<?= $patient['id_pasien'] ?>">
                    
                    <div class="mb-4">
                        <h6 style="color: #666; font-weight: 600; font-size: 0.95rem; margin-bottom: 8px;">AKUN PENGGUNA</h6>
                        <hr style="border-top: 2px solid #aeb5b2; margin: 0 0 15px 0; opacity: 1;">
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Username:</label>
                            <div class="col-sm-8">
                                <input type="text" name="username" class="form-control form-control-sm" style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;" value="<?= $val('username', 'username') ?>" required>
                                <?php if (isset($errors['username'])): ?>
                                    <div class="text-danger mt-1" style="font-size: 0.8rem; line-height: 1.2;"><?= $errors['username']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Password:</label>
                            <div class="col-sm-8">
                                <input type="text" name="password" class="form-control form-control-sm" style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;" placeholder="Kosongkan jika tidak diubah">
                                <?php if (isset($errors['password'])): ?>
                                    <div class="text-danger mt-1" style="font-size: 0.8rem; line-height: 1.2;"><?= $errors['password']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 style="color: #666; font-weight: 600; font-size: 0.95rem; margin-bottom: 8px;">DATA DIRI PASIEN</h6>
                        <hr style="border-top: 2px solid #aeb5b2; margin: 0 0 15px 0; opacity: 1;">
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">NIK :</label>
                            <div class="col-sm-8">
                                <input type="text" name="nik" class="form-control form-control-sm" style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;" value="<?= $val('nik', 'nik') ?>" required>
                                <?php if (isset($errors['nik'])): ?>
                                    <div class="text-danger mt-1" style="font-size: 0.8rem; line-height: 1.2;"><?= $errors['nik']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Nama Lengkap:</label>
                            <div class="col-sm-8">
                                <input type="text" name="nama_pasien" class="form-control form-control-sm" style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;" value="<?= $val('nama_pasien', 'nama_lengkap') ?>" required>
                                <?php if (isset($errors['nama_pasien'])): ?>
                                    <div class="text-danger mt-1" style="font-size: 0.8rem; line-height: 1.2;"><?= $errors['nama_pasien']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Asal :</label>
                            <div class="col-sm-3">
                                <input type="text" name="asal" class="form-control form-control-sm" style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;" value="<?= $val('asal', 'asal') ?>" required>
                                <?php if (isset($errors['asal'])): ?>
                                    <div class="text-danger mt-1" style="font-size: 0.8rem; line-height: 1.2;"><?= $errors['asal']; ?></div>
                                <?php endif; ?>
                            </div>
                            <label class="col-sm-2 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">TGL.Lahir :</label>
                            <div class="col-sm-3">
                                <input type="date" name="tgl_lahir" class="form-control form-control-sm" style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;" value="<?= $val('tgl_lahir', 'tgl_lahir') ?>" required>
                                <?php if (isset($errors['tgl_lahir'])): ?>
                                    <div class="text-danger mt-1" style="font-size: 0.8rem; line-height: 1.2;"><?= $errors['tgl_lahir']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row mb-2 align-items-center">
                            <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Jenis Kelamin :</label>
                            <div class="col-sm-8 d-flex align-items-center" style="font-family: 'Courier New', monospace; font-size: 0.9rem; color: #555;">
                                <?php $jkAwal = $old['jk'] ?? $detailEdit['jenis_kelamin'] ?? ''; ?>
                                <div class="form-check form-check-inline mb-0">
                                    <input class="form-check-input" type="radio" name="jk" id="editJkL-<?= $patient['id_pasien'] ?>" value="L" style="border-color: #555; opacity: 1;" <?= ($jkAwal == 'L') ? 'checked' : '' ?> required>
                                    <label class="form-check-label" for="editJkL-<?= $patient['id_pasien'] ?>" style="opacity: 1;">Laki-laki</label>
                                </div>
                                <div class="form-check form-check-inline mb-0 ms-3">
                                    <input class="form-check-input" type="radio" name="jk" id="editJkP-<?= $patient['id_pasien'] ?>" value="P" style="border-color: #555; opacity: 1;" <?= ($jkAwal == 'P') ? 'checked' : '' ?> required>
                                    <label class="form-check-label" for="editJkP-<?= $patient['id_pasien'] ?>" style="opacity: 1;">Perempuan</label>
                                </div>
                                <?php if (isset($errors['jk'])): ?>
                                    <div class="text-danger mt-1 w-100" style="font-size: 0.8rem; line-height: 1.2;"><?= $errors['jk']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Agama :</label>
                            <div class="col-sm-8">
                                <input type="text" name="agama" class="form-control form-control-sm" style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;" value="<?= $val('agama', 'agama') ?>" required>
                                <?php if (isset($errors['agama'])): ?>
                                    <div class="text-danger mt-1" style="font-size: 0.8rem; line-height: 1.2;"><?= $errors['agama']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Status Perkawinan :</label>
                            <div class="col-sm-8">
                                <select name="status_perkawinan" class="form-control form-control-sm" style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;" required>
                                    <?php $statusKawinDb = $old['status_perkawinan'] ?? $detailEdit['status_perkawinan'] ?? ''; ?>
                                    <option value="" disabled <?= empty($statusKawinDb) ? 'selected' : ''; ?>>-- Pilih Status --</option>
                                    <option value="Belum Kawin" <?= ($statusKawinDb == 'Belum Kawin') ? 'selected' : ''; ?>>Belum Kawin</option>
                                    <option value="Kawin" <?= ($statusKawinDb == 'Kawin') ? 'selected' : ''; ?>>Kawin</option>
                                    <option value="Cerai Hidup" <?= ($statusKawinDb == 'Cerai Hidup') ? 'selected' : ''; ?>>Cerai Hidup</option>
                                    <option value="Cerai Mati" <?= ($statusKawinDb == 'Cerai Mati') ? 'selected' : ''; ?>>Cerai Mati</option>
                                </select>
                                <?php if (isset($errors['status_perkawinan'])): ?>
                                    <div class="text-danger mt-1" style="font-size: 0.8rem; line-height: 1.2;"><?= $errors['status_perkawinan']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Pekerjaan :</label>
                            <div class="col-sm-8">
                                <input type="text" name="pekerjaan" class="form-control form-control-sm" style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;" value="<?= $val('pekerjaan', 'pekerjaan') ?>" required>
                                <?php if (isset($errors['pekerjaan'])): ?>
                                    <div class="text-danger mt-1" style="font-size: 0.8rem; line-height: 1.2;"><?= $errors['pekerjaan']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label text-end mt-1" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Alamat :</label>
                            <div class="col-sm-8">
                                <textarea class="form-control form-control-sm" name="alamat" rows="3" style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; resize: none; color: #111;" required><?= $val('alamat', 'alamat') ?></textarea>
                                <?php if (isset($errors['alamat'])): ?>
                                    <div class="text-danger mt-1" style="font-size: 0.8rem; line-height: 1.2;"><?= $errors['alamat']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 style="color: #666; font-weight: 600; font-size: 0.95rem; margin-bottom: 8px;">DATA TAMBAHAN PASIEN</h6>
                        <hr style="border-top: 2px solid #aeb5b2; margin: 0 0 15px 0; opacity: 1;">
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Nomor BPJS/Asuransi :</label>
                            <div class="col-sm-8">
                                <input type="text" name="bpjs" class="form-control form-control-sm" style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;" value="<?= $val('bpjs', 'nomor_bpjs') ?>">
                                <?php if (isset($errors['bpjs'])): ?>
                                    <div class="text-danger mt-1" style="font-size: 0.8rem; line-height: 1.2;"><?= $errors['bpjs']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Golongan Darah :</label>
                            <div class="col-sm-8">
                                <input type="text" name="gol_darah" class="form-control form-control-sm" style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;" value="<?= $val('gol_darah', 'golongan_darah') ?>">
                                <?php if (isset($errors['gol_darah'])): ?>
                                    <div class="text-danger mt-1" style="font-size: 0.8rem; line-height: 1.2;"><?= $errors['gol_darah']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Kewarganegaraan :</label>
                            <div class="col-sm-8">
                                <input type="text" name="kewarganegaraan" class="form-control form-control-sm" style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;" value="<?= $val('kewarganegaraan', 'kewarganegaraan') ?>" required>
                                <?php if (isset($errors['kewarganegaraan'])): ?>
                                    <div class="text-danger mt-1" style="font-size: 0.8rem; line-height: 1.2;"><?= $errors['kewarganegaraan']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 style="color: #666; font-weight: 600; font-size: 0.95rem; margin-bottom: 8px;">DATA DIRI PENGANTAR / WALI</h6>
                        <hr style="border-top: 2px solid #aeb5b2; margin: 0 0 15px 0; opacity: 1;">
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Nama Lengkap Wali :</label>
                            <div class="col-sm-8">
                                <input type="text" name="nama_wali" class="form-control form-control-sm" style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;" value="<?= $val('nama_wali', 'nama_lengkap_wali') ?>" required>
                                <?php if (isset($errors['nama_wali'])): ?>
                                    <div class="text-danger mt-1" style="font-size: 0.8rem; line-height: 1.2;"><?= $errors['nama_wali']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Status Wali :</label>
                            <div class="col-sm-8">
                                <select name="status_wali" class="form-control form-control-sm" style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;" required>
                                    <?php $statusWaliDb = $old['status_wali'] ?? $detailEdit['status_wali'] ?? ''; ?>
                                    <option value="" disabled <?= empty($statusWaliDb) ? 'selected' : ''; ?>>-- Pilih Hubungan --</option>
                                    <option value="Orang Tua" <?= ($statusWaliDb == 'Orang Tua') ? 'selected' : ''; ?>>Orang Tua (Ayah/Ibu)</option>
                                    <option value="Suami/Istri" <?= ($statusWaliDb == 'Suami/Istri') ? 'selected' : ''; ?>>Suami / Istri</option>
                                    <option value="Anak" <?= ($statusWaliDb == 'Anak') ? 'selected' : ''; ?>>Anak</option>
                                    <option value="Saudara Kandung" <?= ($statusWaliDb == 'Saudara Kandung') ? 'selected' : ''; ?>>Saudara Kandung</option>
                                    <option value="Keluarga Lain" <?= ($statusWaliDb == 'Keluarga Lain') ? 'selected' : ''; ?>>Keluarga Lain (Paman/Bibi/dll)</option>
                                    <option value="Pengantar/Lainnya" <?= ($statusWaliDb == 'Pengantar/Lainnya') ? 'selected' : ''; ?>>Pengantar / Teman / Lainnya</option>
                                </select>
                                <?php if (isset($errors['status_wali'])): ?>
                                    <div class="text-danger mt-1" style="font-size: 0.8rem; line-height: 1.2;"><?= $errors['status_wali']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">NIK Wali :</label>
                            <div class="col-sm-8">
                                <input type="text" name="nik_wali" class="form-control form-control-sm" style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;" value="<?= $val('nik_wali', 'nik_wali') ?>" required>
                                <?php if (isset($errors['nik_wali'])): ?>
                                    <div class="text-danger mt-1" style="font-size: 0.8rem; line-height: 1.2;"><?= $errors['nik_wali']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">No.HP/Whatsapp aktif :</label>
                            <div class="col-sm-8">
                                <input type="text" name="nohp_wali" class="form-control form-control-sm" style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; color: #111;" value="<?= $val('nohp_wali', 'no_hp_wali') ?>" required>
                                <?php if (isset($errors['nohp_wali'])): ?>
                                    <div class="text-danger mt-1" style="font-size: 0.8rem; line-height: 1.2;"><?= $errors['nohp_wali']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label text-end mt-1" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">Alamat Wali :</label>
                            <div class="col-sm-8">
                                <textarea name="alamat_wali" class="form-control form-control-sm" rows="3" style="font-family: 'Courier New', monospace; font-size: 0.9rem; border: 1px solid #555; background-color: transparent; border-radius: 0; resize: none; color: #111;" required><?= $val('alamat_wali', 'alamat_wali') ?></textarea>
                                <?php if (isset($errors['alamat_wali'])): ?>
                                    <div class="text-danger mt-1" style="font-size: 0.8rem; line-height: 1.2;"><?= $errors['alamat_wali']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row mb-2 mt-4">
                            <label class="col-sm-3 col-form-label text-end" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.95rem; color: #111;">TTD WALI :</label>
                            <div class="col-sm-8">
                                <div style="border: 1px solid #555; border-radius: 6px; height: 120px; background-color: #f9f9f9; display: flex; align-items: center; justify-content: center;">
                                    <?php if (!empty($detailEdit['dokumen_ttd'])): ?>
                                        <img src="<?= BASEURL; ?>/assets/img/signatures/<?= htmlspecialchars($detailEdit['dokumen_ttd']) ?>" style="max-height: 100px;">
                                    <?php else: ?>
                                        <span style="font-family: 'Courier New', monospace; color: #888; font-weight: 600;">Tidak ada tanda tangan</span>
                                    <?php endif; ?>
                                </div>
                                <small style="font-size: 0.75rem; color: #666; font-family: 'Courier New', monospace;">*Tanda tangan tidak dapat diubah melalui dasbor perawat.</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center gap-3 mt-5 mb-3">
                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#confirmSimpanPasienModalAktif-<?= $patient['id_pasien'] ?>" style="background-color: #20c997; color: white; border: none; font-weight: 600; width: 160px; border-radius: 6px; padding: 6px 0; font-size: 0.85rem; letter-spacing: 0.5px;">SIMPAN PERUBAHAN</button>
                        <button type="button" class="btn" data-bs-dismiss="modal" style="background-color: #dc3545; color: white; border: none; font-weight: 600; width: 120px; border-radius: 6px; padding: 6px 0; font-size: 0.85rem; letter-spacing: 0.5px;">KEMBALI</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmSimpanPasienModalAktif-<?= $patient['id_pasien'] ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
        <div class="modal-content" style="border-radius: 12px; border: none; padding: 30px 20px;">
            <div class="modal-body text-center">
                <i class="bi bi-shield-check" style="font-size: 6rem; color: #20c997;"></i>
                <h5 class="mt-3 mb-4" style="color: #111; font-weight: 700; font-size: 1.1rem;">Yakin Ingin Menyimpan Perubahan?</h5>
                <div class="d-flex justify-content-center gap-4 mt-3">
                    <button type="submit" form="editPasienForm-<?= $patient['id_pasien'] ?>" class="btn" style="background-color: #20c997; color: #111; border: none; font-weight: 600; width: 130px; border-radius: 8px; padding: 8px 0;">Ya, Simpan</button>
                    <button type="button" class="btn" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#patientEditModal-<?= $patient['id_pasien'] ?>" style="background-color: #dc3545; color: white; border: none; font-weight: 600; width: 100px; border-radius: 8px; padding: 8px 0;">Tidak</button>
                </div>
            </div>
        </div>
    </div>
</div>