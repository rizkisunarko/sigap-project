<?php defined('BASEURL') OR exit(header("HTTP/1.1 404 Not Found") . "<html><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL was not found on this server.</p></body></html>"); ?>
<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $mainError = $_SESSION['error'] ?? '';
    $errors = $_SESSION['errors'] ?? [];
    $old = $_SESSION['old'] ?? [];

    unset($_SESSION['error'], $_SESSION['errors'], $_SESSION['old']);
?>
    <div class="form-card">
        <div class="form-header">PENDAFTARAN PASIEN BARU</div>
        <div class="form-subtitle">Lengkapi formulir pendaftaran di bawah ini untuk memperoleh akses layanan.</div>
        <div class="form-divider-top"></div>

        <?php if (!empty($mainError)): ?>
            <div class="alert-error">
                <?= htmlspecialchars($mainError) ?>
            </div>
        <?php endif; ?>

        <form action="<?= BASEURL; ?>/pendaftaran/submit" method="POST" id="pasienForm">
        <input type="hidden" name="sumber_halaman" value="dasbor_perawat">
            
            <div class="section-title">AKUN PENGGUNA</div>
            <div class="section-divider"></div>

            <div class="form-row">
                <div class="label-col"><label class="custom-label">Username :</label></div>
                <div class="input-col">
                    <input type="text" class="custom-input" name="username" 
                           value="<?= isset($old['username']) ? htmlspecialchars($old['username']) : ''; ?>"
                           required>
                    
                    <?php if (isset($errors['username'])): ?>
                        <div style="color: #cc0000; font-size: 11px; margin-top: 5px; line-height: 1.2;">
                            <?= $errors['username']; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-row">
                <div class="label-col"><label class="custom-label">Password :</label></div>
                <div class="input-col">
                    <input type="password" class="custom-input" name="password" required>
                    
                    <?php if (isset($errors['password'])): ?>
                        <div style="color: #cc0000; font-size: 11px; margin-top: 5px; line-height: 1.2;">
                            <?= $errors['password']; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="section-title">DATA DIRI PASIEN</div>
            <div class="section-divider"></div>

            <div class="form-row">
                <div class="label-col"><label class="custom-label">NIK :</label></div>
                <div class="input-col">
                    <input type="text" class="custom-input" name="nik" value="<?= isset($old['nik']) ? htmlspecialchars($old['nik']) : ''; ?>" required>
                    <?php if (isset($errors['nik'])): ?>
                        <div style="color: #cc0000; font-size: 11px; margin-top: 5px; line-height: 1.2;">
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
                        <div style="color: #cc0000; font-size: 11px; margin-top: 5px; line-height: 1.2;">
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
                            <div style="color: #cc0000; font-size: 11px; margin-top: 5px; line-height: 1.2;">
                                <?= $errors['asal']; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="multi-input-group" style="flex: 0.8; flex-direction: row; align-items: center; gap: 10px;">
                        <label class="multi-label" style="margin-bottom:0;">TGL.Lahir :</label>
                        <div style="flex:1; width:100%;">
                            <input type="date" class="custom-input" name="tgl_lahir" value="<?= isset($old['tgl_lahir']) ? htmlspecialchars($old['tgl_lahir']) : ''; ?>" required>
                            <?php if (isset($errors['tgl_lahir'])): ?>
                                <div style="color: #cc0000; font-size: 11px; margin-top: 5px; line-height: 1.2;">
                                    <?= $errors['tgl_lahir']; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="label-col"><label class="custom-label">Jenis Kelamin :</label></div>
                <div class="input-col radio-group">
                    <label class="radio-item"><input type="radio" name="jk" value="L" <?= (isset($old['jk']) && $old['jk'] == 'L') ? 'checked' : ''; ?> required> Laki-laki</label>
                    <label class="radio-item"><input type="radio" name="jk" value="P" <?= (isset($old['jk']) && $old['jk'] == 'P') ? 'checked' : ''; ?> required> Perempuan</label>
                    <?php if (isset($errors['jk'])): ?>
                        <div style="color: #cc0000; font-size: 11px; margin-top: 5px; line-height: 1.2; width: 100%;">
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
                        <div style="color: #cc0000; font-size: 11px; margin-top: 5px; line-height: 1.2;">
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
                        <div style="color: #cc0000; font-size: 11px; margin-top: 5px; line-height: 1.2;">
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
                        <div style="color: #cc0000; font-size: 11px; margin-top: 5px; line-height: 1.2;">
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
                        <div style="color: #cc0000; font-size: 11px; margin-top: 5px; line-height: 1.2;">
                            <?= $errors['alamat']; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="section-title">DATA TAMBAHAN PASIEN</div>
            <div class="section-divider"></div>

            <div class="form-row">
                <div class="label-col"><label class="custom-label">Nomor BPJS/Asuransi :</label></div>
                <div class="input-col">
                    <input type="text" class="custom-input" name="bpjs" value="<?= isset($old['bpjs']) ? htmlspecialchars($old['bpjs']) : ''; ?>">
                    <?php if (isset($errors['bpjs'])): ?>
                        <div style="color: #cc0000; font-size: 11px; margin-top: 5px; line-height: 1.2;">
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
                        <div style="color: #cc0000; font-size: 11px; margin-top: 5px; line-height: 1.2;">
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
                        <div style="color: #cc0000; font-size: 11px; margin-top: 5px; line-height: 1.2;">
                            <?= $errors['alergi']; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-row">
                <div class="label-col"><label class="custom-label">Kewarganegaraan :</label></div>
                <div class="input-col">
                    <input type="text" class="custom-input" name="kewarganegaraan" value="<?= isset($old['kewarganegaraan']) ? htmlspecialchars($old['kewarganegaraan']) : 'Indonesia'; ?>" required>
                    <?php if (isset($errors['kewarganegaraan'])): ?>
                        <div style="color: #cc0000; font-size: 11px; margin-top: 5px; line-height: 1.2;">
                            <?= $errors['kewarganegaraan']; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="section-title">DATA DIRI PENGANTAR / WALI</div>
            <div class="section-divider"></div>

            <div class="form-row">
                <div class="label-col"><label class="custom-label">Nama Lengkap Wali :</label></div>
                <div class="input-col">
                    <input type="text" class="custom-input" name="nama_wali" value="<?= isset($old['nama_wali']) ? htmlspecialchars($old['nama_wali']) : ''; ?>" required>
                    <?php if (isset($errors['nama_wali'])): ?>
                        <div style="color: #cc0000; font-size: 11px; margin-top: 5px; line-height: 1.2;">
                            <?= $errors['nama_wali']; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-row">
                <div class="label-col"><label class="custom-label">Status Wali :</label></div>
                <div class="input-col">
                    <select class="custom-input" name="status_wali" required>
                        <?php $stWali = $old['status_wali'] ?? ''; ?>
                        <option value="" disabled <?= empty($stWali) ? 'selected' : ''; ?>>-- Pilih Hubungan --</option>
                        <option value="Orang Tua" <?= ($stWali == 'Orang Tua') ? 'selected' : ''; ?>>Orang Tua (Ayah/Ibu)</option>
                        <option value="Suami/Istri" <?= ($stWali == 'Suami/Istri') ? 'selected' : ''; ?>>Suami / Istri</option>
                        <option value="Anak" <?= ($stWali == 'Anak') ? 'selected' : ''; ?>>Anak</option>
                        <option value="Saudara Kandung" <?= ($stWali == 'Saudara Kandung') ? 'selected' : ''; ?>>Saudara Kandung</option>
                        <option value="Keluarga Lain" <?= ($stWali == 'Keluarga Lain') ? 'selected' : ''; ?>>Keluarga Lain (Paman/Bibi/dll)</option>
                        <option value="Pengantar/Lainnya" <?= ($stWali == 'Pengantar/Lainnya') ? 'selected' : ''; ?>>Pengantar / Teman / Lainnya</option>
                    </select>
                    <?php if (isset($errors['status_wali'])): ?>
                        <div style="color: #cc0000; font-size: 11px; margin-top: 5px; line-height: 1.2;">
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
                        <div style="color: #cc0000; font-size: 11px; margin-top: 5px; line-height: 1.2;">
                            <?= $errors['nik_wali']; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-row">
                <div class="label-col"><label class="custom-label">No.HP/WA aktif :</label></div>
                <div class="input-col">
                    <input type="text" class="custom-input" name="nohp_wali" value="<?= isset($old['nohp_wali']) ? htmlspecialchars($old['nohp_wali']) : ''; ?>" required>
                    <?php if (isset($errors['nohp_wali'])): ?>
                        <div style="color: #cc0000; font-size: 11px; margin-top: 5px; line-height: 1.2;">
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
                        <div style="color: #cc0000; font-size: 11px; margin-top: 5px; line-height: 1.2;">
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
                        <input type="hidden" name="ttd_wali" id="ttd_wali" value="<?= htmlspecialchars($old['ttd_wali'] ?? '') ?>">
                    </div>
                    <?php if (isset($errors['ttd_wali'])): ?>
                        <div style="color: #cc0000; font-size: 9px; margin-top: 5px; line-height: 1.2;">
                            <?= $errors['ttd_wali']; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="terms-row">
                <input type="checkbox" id="terms" name="terms" value="1" <?= isset($old['terms']) ? 'checked' : ''; ?> required>
                <div>
                    <label for="terms" class="terms-text">
                        Saya menyatakan bahwa data yang saya isi adalah benar dan saya menyetujui Syarat & Ketentuan serta Kebijakan Privasi yang berlaku di Rumah Sakit ini.
                    </label>
                    <?php if (isset($errors['terms'])): ?>
                        <div style="color: #cc0000; font-size: 11px; margin-top: 5px; line-height: 1.2;">
                            <?= $errors['terms']; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="btn-wrapper">
                <button type="submit" class="btn-submit">SUBMIT PENDAFTARAN</button>
                <a href="<?= BASEURL; ?>/pendaftaran/pilih_jalur" class="btn-back">KEMBALI</a>
            </div>

        </form>
    </div>

    <script>
        (function(){
            const canvas = document.getElementById('signature-pad');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            let drawing = false;
            let lastX = 0;
            let lastY = 0;

            function resizeCanvas() {
                const parent = canvas.parentElement;
                const w = parent.clientWidth;
                const h = parent.clientHeight;
                canvas.width = w;
                canvas.height = h;
                ctx.lineWidth = 2.5;
                ctx.lineCap = 'round';
                ctx.strokeStyle = '#111';
            }
            resizeCanvas();
            window.addEventListener('resize', resizeCanvas);

            const ttdInput = document.getElementById('ttd_wali');
            const placeholder = document.getElementById('signature-placeholder');
            const clearSignature = document.getElementById('clear-signature');

            if (ttdInput && ttdInput.value) {
                const img = new Image();
                img.onload = function() {
                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                    if (placeholder) placeholder.style.display = 'none';
                };
                img.src = ttdInput.value;
            }

            function pointerDown(e) {
                drawing = true;
                if (placeholder) placeholder.style.display = 'none';
                const rect = canvas.getBoundingClientRect();
                lastX = (e.clientX || (e.touches && e.touches[0].clientX)) - rect.left;
                lastY = (e.clientY || (e.touches && e.touches[0].clientY)) - rect.top;
            }
            
            function pointerMove(e) {
                if (!drawing) return;
                const rect = canvas.getBoundingClientRect();
                const clientX = e.clientX || (e.touches && e.touches[0].clientX);
                const clientY = e.clientY || (e.touches && e.touches[0].clientY);
                const x = (clientX - rect.left);
                const y = (clientY - rect.top);
                ctx.beginPath();
                ctx.moveTo(lastX, lastY);
                ctx.lineTo(x, y);
                ctx.stroke();
                lastX = x;
                lastY = y;
            }
            
            function pointerUp(e) {
                drawing = false;
            }

            canvas.addEventListener('pointerdown', pointerDown);
            canvas.addEventListener('pointermove', pointerMove);
            canvas.addEventListener('pointerup', pointerUp);
            canvas.addEventListener('pointercancel', pointerUp);
            
            canvas.addEventListener('touchstart', function(e){ e.preventDefault(); pointerDown(e); }, { passive: false });
            canvas.addEventListener('touchmove', function(e){ e.preventDefault(); pointerMove(e); }, { passive: false });
            canvas.addEventListener('touchend', function(e){ e.preventDefault(); pointerUp(e); });

            if (clearSignature) {
                clearSignature.addEventListener('click', function(e){
                    e.preventDefault();
                    ctx.clearRect(0,0,canvas.width,canvas.height);
                    ctx.setTransform(1,0,0,1,0,0);
                    resizeCanvas();
                    if (placeholder) placeholder.style.display = 'flex';
                    if (ttdInput) ttdInput.value = '';
                });
            }

            const form = canvas.closest('form');
            if (form) {
                form.addEventListener('submit', function(e){
                    const isBlank = isCanvasBlank(canvas);
                    if (isBlank) {
                        document.getElementById('ttd_wali').value = '';
                    } else {
                        document.getElementById('ttd_wali').value = canvas.toDataURL('image/png');
                    }
                });
            }

            function isCanvasBlank(cnv) {
                try {
                    const w = cnv.width;
                    const h = cnv.height;
                    const img = ctx.getImageData(0, 0, w, h).data;
                    for (let i = 0; i < img.length; i += 4) {
                        const r = img[i], g = img[i+1], b = img[i+2], a = img[i+3];
                        if (a !== 0 && !(r === 255 && g === 255 && b === 255)) {
                            return false;
                        }
                    }
                    return true;
                } catch (err) {
                    return false;
                }
            }

            window.addEventListener('resize', function(){
                const data = canvas.toDataURL();
                resizeCanvas();
                const img = new Image();
                img.onload = function(){
                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                };
                img.src = data;
            });
        })();
    </script>
