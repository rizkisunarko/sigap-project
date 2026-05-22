<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="form-wrapper">
    <div class="form-card" data-aos="fade-up">
        
        <h2 class="form-main-title">Daftar Akun</h2>
        <div class="form-title-divider"></div>

        <form action="/pendaftaran/submit" method="POST">
            
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
                    <div class="canvas-container" style="position:relative;">
                        <canvas id="signature-pad" style="touch-action: none;display:block;background:transparent;"></canvas>
                        <div id="signature-placeholder" style="position:absolute;left:0;right:0;top:0;bottom:0;display:flex;align-items:center;justify-content:center;pointer-events:none;color:#999;font-size:16px;">Canvas Untuk TTD Digital</div>
                        <div style="margin-top:8px;display:flex;align-items:center;gap:8px;">
                            <span style="font-size:12px;color:#666;">(Tanda tangan dengan mouse atau layar sentuh)</span>
                            <a href="#" id="clear-signature" style="font-size:12px;color:#007bff;text-decoration:underline;">Bersihkan</a>
                        </div>
                        <!-- Hidden input to submit signature as base64 PNG -->
                        <input type="hidden" name="ttd_wali" id="ttd_wali">
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

<script>
    (function(){
        const canvas = document.getElementById('signature-pad');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        let drawing = false;
        let lastX = 0;
        let lastY = 0;

        // Resize canvas to fit its container (handles mobile properly)
        function resizeCanvas() {
            const parent = canvas.parentElement;
            const w = parent.clientWidth;
            const h = parent.clientHeight;
            // set actual drawing surface size
            canvas.width = w;
            canvas.height = h;
            // set display size via CSS (already 100% by stylesheet)
            ctx.lineWidth = 2;
            ctx.lineCap = 'round';
            ctx.strokeStyle = '#111';
        }
        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);

        const placeholder = document.getElementById('signature-placeholder');
        const clearSignature = document.getElementById('clear-signature');

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

        // pointer events (works for mouse/touch)
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
                // reset transform if any
                ctx.setTransform(1,0,0,1,0,0);
                // resize to ensure correct DPI/scale
                resizeCanvas();
                if (placeholder) placeholder.style.display = 'flex';
                const ttdInput = document.getElementById('ttd_wali');
                if (ttdInput) ttdInput.value = '';
            });
        }

        // On submit, save signature to hidden input as data URL
        const form = canvas.closest('form');
        if (form) {
            form.addEventListener('submit', function(e){
                // Convert canvas to dataURL
                const dataUrl = canvas.toDataURL('image/png');
                // Check if canvas is blank (all pixels transparent)
                const isBlank = isCanvasBlank(canvas);
                if (isBlank) {
                    // If blank, prevent submit and alert
                    e.preventDefault();
                    alert('Mohon tanda tangan wali ditandatangani sebelum submit.');
                    return false;
                }
                document.getElementById('ttd_wali').value = dataUrl;
                // let the form submit normally
            });
        }

        function isCanvasBlank(cnv) {
            // Check if all pixels are white (no drawing)
            try {
                const w = cnv.width;
                const h = cnv.height;
                const img = ctx.getImageData(0, 0, w, h).data;
                for (let i = 0; i < img.length; i += 4) {
                    const r = img[i], g = img[i+1], b = img[i+2], a = img[i+3];
                    // if any pixel is not white (255,255,255) and not fully transparent, consider canvas non-blank
                    if (a !== 0 && !(r === 255 && g === 255 && b === 255)) {
                        return false;
                    }
                }
                return true;
            } catch (err) {
                return false;
            }
        }

        // Re-resize if window changed (to keep DPI scaling)
        window.addEventListener('resize', function(){
            // save existing image
            const data = canvas.toDataURL();
            resizeCanvas();
            const img = new Image();
            img.onload = function(){
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
            };
            img.src = data;
        });

        // Show placeholder if canvas is blank on load
        try {
            if (placeholder && isCanvasBlank(canvas)) {
                placeholder.style.display = 'flex';
            }
        } catch (err) {
            // ignore
        }
    })();
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
