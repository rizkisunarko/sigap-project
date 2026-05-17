<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="form-wrapper">
    <div class="form-card" data-aos="fade-up">
        
        <h2 class="form-main-title">Daftar Akun</h2>
        <div class="form-title-divider"></div>

        <form action="#" method="POST">
            
            <!-- AKUN PENGGUNA -->
            <div class="section-title">AKUN PENGGUNA</div>
            <div class="section-divider"></div>

            <div class="form-row">
                <div class="label-col"><label class="custom-label">Username :</label></div>
                <div class="input-col"><input type="text" class="custom-input" name="username"></div>
            </div>

            <div class="form-row">
                <div class="label-col"><label class="custom-label">Password :</label></div>
                <div class="input-col"><input type="password" class="custom-input" name="password"></div>
            </div>

            <!-- DATA DIRI PASIEN -->
            <div class="section-title">DATA DIRI PASIEN</div>
            <div class="section-divider"></div>

            <div class="form-row">
                <div class="label-col"><label class="custom-label">NIK :</label></div>
                <div class="input-col"><input type="text" class="custom-input" name="nik"></div>
            </div>

            <div class="form-row">
                <div class="label-col"><label class="custom-label">Nama Lengkap :</label></div>
                <div class="input-col"><input type="text" class="custom-input" name="nama_pasien"></div>
            </div>

            <div class="form-row">
                <div class="label-col"><label class="custom-label">Asal :</label></div>
                <div class="input-col multi-input-row">
                    <div class="multi-input-group">
                        <input type="text" class="custom-input" name="asal">
                    </div>
                    <div class="multi-input-group" style="flex: 0.8;">
                        <label class="multi-label">TGL.Lahir :</label>
                        <input type="date" class="custom-input" name="tgl_lahir">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="label-col"><label class="custom-label">Jenis Kelamin :</label></div>
                <div class="input-col radio-group">
                    <label class="radio-item"><input type="radio" name="jk" value="Laki-laki"> Laki-laki</label>
                    <label class="radio-item"><input type="radio" name="jk" value="Perempuan"> Perempuan</label>
                </div>
            </div>

            <div class="form-row">
                <div class="label-col"><label class="custom-label">Agama :</label></div>
                <div class="input-col"><input type="text" class="custom-input" name="agama"></div>
            </div>

            <div class="form-row">
                <div class="label-col"><label class="custom-label">Status Perkawinan :</label></div>
                <div class="input-col"><input type="text" class="custom-input" name="status_perkawinan"></div>
            </div>

            <div class="form-row">
                <div class="label-col"><label class="custom-label">Pekerjaan :</label></div>
                <div class="input-col"><input type="text" class="custom-input" name="pekerjaan"></div>
            </div>

            <div class="form-row">
                <div class="label-col"><label class="custom-label">Alamat :</label></div>
                <div class="input-col"><textarea class="custom-input" name="alamat"></textarea></div>
            </div>

            <!-- DATA TAMBAHAN PASIEN -->
            <div class="section-title">DATA TAMBAHAN PASIEN</div>
            <div class="section-divider"></div>

            <div class="form-row">
                <div class="label-col"><label class="custom-label">Nomor BPJS/Asuransi :</label></div>
                <div class="input-col"><input type="text" class="custom-input" name="bpjs"></div>
            </div>

            <div class="form-row">
                <div class="label-col"><label class="custom-label">Golongan Darah :</label></div>
                <div class="input-col"><input type="text" class="custom-input" name="gol_darah"></div>
            </div>

            <div class="form-row">
                <div class="label-col"><label class="custom-label">Alergi :</label></div>
                <div class="input-col"><input type="text" class="custom-input" name="alergi"></div>
            </div>

            <div class="form-row">
                <div class="label-col"><label class="custom-label">Kewarganegaraan :</label></div>
                <div class="input-col"><input type="text" class="custom-input" name="kewarganegaraan"></div>
            </div>

            <!-- DATA DIRI PENGANTAR / WALI -->
            <div class="section-title">DATA DIRI PENGANTAR / WALI</div>
            <div class="section-divider"></div>

            <div class="form-row">
                <div class="label-col"><label class="custom-label">Nama Lengkap Wali :</label></div>
                <div class="input-col"><input type="text" class="custom-input" name="nama_wali"></div>
            </div>

            <div class="form-row">
                <div class="label-col"><label class="custom-label">Status Wali :</label></div>
                <div class="input-col"><input type="text" class="custom-input" name="status_wali"></div>
            </div>

            <div class="form-row">
                <div class="label-col"><label class="custom-label">NIK Wali :</label></div>
                <div class="input-col"><input type="text" class="custom-input" name="nik_wali"></div>
            </div>

            <div class="form-row">
                <div class="label-col"><label class="custom-label">No.HP/Whatsapp aktif :</label></div>
                <div class="input-col"><input type="text" class="custom-input" name="nohp_wali"></div>
            </div>

            <div class="form-row">
                <div class="label-col"><label class="custom-label">Alamat Wali :</label></div>
                <div class="input-col"><textarea class="custom-input" name="alamat_wali"></textarea></div>
            </div>

            <div class="form-row">
                <div class="label-col"><label class="custom-label">TTD WALI :</label></div>
                <div class="input-col">
                    <div class="canvas-container">
                        Canvas Untuk TTD Digital
                    </div>
                </div>
            </div>

            <div class="terms-row">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms" class="terms-text">
                    Saya menyatakan bahwa data yang saya isi adalah benar dan saya menyetujui Syarat & Ketentuan serta Kebijakan<br>Privasi yang berlaku di Rumah Sakit ini.
                </label>
            </div>

            <button type="submit" class="btn-submit-form">SUBMIT</button>

        </form>

    </div>
</div>

<script>
    if (typeof AOS !== 'undefined') {
        AOS.init({ duration: 800, once: true });
    }
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
