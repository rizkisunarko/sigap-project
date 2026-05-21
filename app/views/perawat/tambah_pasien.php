<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pasien - Hospital</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { font-family: 'Inter', 'Segoe UI', sans-serif; background-color: #f2f4f7; margin: 0; }
        
        /* Sidebar Styling */
        .sidebar { background-color: #043622; color: #fff; width: 240px; min-height: 100vh; font-size: 0.95rem; }
        .sidebar a { color: rgba(255,255,255,0.9); text-decoration: none; display: block; padding: 15px 24px; }
        .sidebar a:hover, .sidebar a.active { background-color: rgba(255,255,255,0.1); color: #fff; }
        .sidebar-bottom { background-color: #20c997; padding: 16px 24px; color: #fff; }

        /* Form Card */
        .main-wrapper { padding: 40px; height: 100vh; overflow-y: auto; }
        .form-card { background: #fff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 40px 50px; max-width: 900px; margin: 0 auto; }
        .form-header { font-size: 1.25rem; font-weight: 800; color: #043622; margin-bottom: 20px; text-transform: uppercase; }
        .form-divider-top { border-top: 3px solid #043622; margin-bottom: 30px; }

        /* Form Elements & Monospace style */
        .section-header { font-family: 'Courier New', Courier, monospace; font-size: 1.05rem; font-weight: bold; color: #333; border-bottom: 1px solid #a8b0a9; padding-bottom: 6px; margin-top: 30px; margin-bottom: 20px; }
        
        .form-custom-row { display: flex; align-items: baseline; margin-bottom: 12px; }
        .form-custom-row label { flex: 0 0 200px; font-family: 'Courier New', Courier, monospace; font-size: 0.95rem; font-weight: 600; color: #222; }
        .form-custom-row .form-control-custom { flex-grow: 1; border: 1px solid #777; border-radius: 0; padding: 6px 12px; font-size: 0.9rem; outline: none; }
        .form-custom-row .form-control-custom:focus { border-color: #043622; box-shadow: 0 0 4px rgba(4, 54, 34, 0.3); }
        
        .form-custom-row textarea.form-control-custom { min-height: 80px; resize: vertical; }

        /* Inline group for specific fields like Asal and TGL Lahir */
        .inline-group { display: flex; gap: 20px; flex-grow: 1; }
        .inline-group .half-field { display: flex; align-items: baseline; flex: 1; }
        .inline-group .half-field label { flex: 0 0 auto; margin-right: 10px; width: auto; }

        /* Radio Buttons */
        .radio-group { font-family: 'Courier New', Courier, monospace; font-size: 0.9rem; display: flex; gap: 20px; align-items: center; }
        .radio-group label { width: auto; font-weight: normal; cursor: pointer; }
        
        /* Canvas */
        .canvas-container { flex-grow: 1; border: 1px solid #777; border-radius: 8px; position: relative; height: 150px; background: #fafafa; overflow: hidden; }
        .canvas-container canvas { width: 100%; height: 100%; cursor: crosshair; }
        .canvas-placeholder { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #aaa; font-family: 'Courier New', Courier, monospace; pointer-events: none; }
        .btn-clear { position: absolute; right: 8px; top: 8px; font-size: 0.7rem; padding: 2px 8px; border-radius: 4px; background: #e0e0e0; border: 1px solid #ccc; cursor: pointer; z-index: 10; }
        .btn-clear:hover { background: #d0d0d0; }

        /* Agreement Checkbox */
        .agreement-box { display: flex; gap: 10px; align-items: flex-start; margin-top: 30px; }
        .agreement-box input[type="checkbox"] { margin-top: 4px; }
        .agreement-box label { font-size: 0.7rem; color: #333; line-height: 1.4; }

        .btn-submit { background-color: #20c997; border: none; color: #111; font-weight: bold; padding: 10px 40px; border-radius: 4px; font-size: 0.9rem; transition: background 0.2s; }
        .btn-submit:hover { background-color: #1bb78a; color: #000; }
        .btn-submit-wrapper { display: flex; justify-content: center; margin-top: 30px; }
    </style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column flex-shrink-0">
        <div class="p-4 d-flex align-items-center gap-2 mb-2">
            <img src="<?= BASEURL; ?>/assets/img/logo.png" width="34" height="34" alt="Logo" class="d-inline-block align-text-top">
            <span class="fs-5 fw-bold" style="letter-spacing: 1px;">HOSPITAL</span>
        </div>
        <div class="flex-grow-1">
            <a href="<?= BASEURL; ?>/perawat/dashboard">Dashboard</a>
            <a href="<?= BASEURL; ?>/perawat/input_data_pasien">Lihat Pasien Aktif</a>
            <a href="<?= BASEURL; ?>/perawat/tambah_pasien" class="active">Tambah Pasien</a>
            <a href="<?= BASEURL; ?>/perawat/direktori_pengguna">Direktori Pengguna</a>
        </div>
        <div class="sidebar-bottom d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle bg-dark text-white d-flex justify-content-center align-items-center" style="width: 32px; height: 32px; font-weight: bold; font-size: 0.9rem;">F</div>
                <div style="line-height: 1.2;">
                    <div class="fw-bold" style="font-size: 0.75rem;">FIRMANSYAH</div>
                    <div style="font-size: 0.65rem;">FRONT OFFICER</div>
                </div>
            </div>
            <i class="bi bi-gear-fill fs-6" style="cursor: pointer; color: black;"></i>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 main-wrapper">
        <div class="form-card">
            
            <div class="form-header">TAMBAH PASIEN</div>
            <div class="form-divider-top"></div>

            <form action="<?= BASEURL; ?>/perawat/simpan_pasien" method="POST" id="pasienForm">
                
                <!-- AKUN PENGGUNA -->
                <div class="section-header">AKUN PENGGUNA</div>
                <div class="form-custom-row">
                    <label>Username:</label>
                    <input type="text" name="username" class="form-control-custom" required>
                </div>
                <div class="form-custom-row">
                    <label>Password:</label>
                    <input type="password" name="password" class="form-control-custom" required>
                </div>

                <!-- DATA DIRI PASIEN -->
                <div class="section-header">DATA DIRI PASIEN</div>
                <div class="form-custom-row">
                    <label>NIK :</label>
                    <input type="text" name="nik" class="form-control-custom" required>
                </div>
                <div class="form-custom-row">
                    <label>Nama Lengkap:</label>
                    <input type="text" name="nama_lengkap" class="form-control-custom" required>
                </div>
                <div class="form-custom-row">
                    <label>Asal :</label>
                    <div class="inline-group">
                        <input type="text" name="asal" class="form-control-custom" required style="width: 40%">
                        <div class="half-field">
                            <label style="padding-left:15px;">TGL.Lahir :</label>
                            <input type="date" name="tgl_lahir" class="form-control-custom" required>
                        </div>
                    </div>
                </div>
                <div class="form-custom-row">
                    <label>Jenis Kelamin :</label>
                    <div class="radio-group">
                        <label><input type="radio" name="jenis_kelamin" value="L" required> Laki-laki</label>
                        <label><input type="radio" name="jenis_kelamin" value="P" required> Perempuan</label>
                    </div>
                </div>
                <div class="form-custom-row">
                    <label>Agama :</label>
                    <input type="text" name="agama" class="form-control-custom" required>
                </div>
                <div class="form-custom-row">
                    <label>Status Perkawinan :</label>
                    <input type="text" name="status_perkawinan" class="form-control-custom">
                </div>
                <div class="form-custom-row">
                    <label>Pekerjaan :</label>
                    <input type="text" name="pekerjaan" class="form-control-custom">
                </div>
                <div class="form-custom-row">
                    <label>Alamat :</label>
                    <textarea name="alamat" class="form-control-custom" required></textarea>
                </div>

                <!-- DATA TAMBAHAN PASIEN -->
                <div class="section-header">DATA TAMBAHAN PASIEN</div>
                <div class="form-custom-row">
                    <label>Nomor BPJS/Asuransi :</label>
                    <input type="text" name="no_bpjs" class="form-control-custom">
                </div>
                <div class="form-custom-row">
                    <label>Golongan Darah :</label>
                    <input type="text" name="golongan_darah" class="form-control-custom">
                </div>
                <div class="form-custom-row">
                    <label>Alergi :</label>
                    <input type="text" name="alergi" class="form-control-custom">
                </div>
                <div class="form-custom-row">
                    <label>Kewarganegaraan :</label>
                    <input type="text" name="kewarganegaraan" class="form-control-custom">
                </div>

                <!-- DATA DIRI PENGANTAR / WALI -->
                <div class="section-header">DATA DIRI PENGANTAR / WALI</div>
                <div class="form-custom-row">
                    <label>Nama Lengkap Wali :</label>
                    <input type="text" name="nama_wali" class="form-control-custom" required>
                </div>
                <div class="form-custom-row">
                    <label>Status Wali :</label>
                    <input type="text" name="status_wali" class="form-control-custom" required>
                </div>
                <div class="form-custom-row">
                    <label>NIK Wali :</label>
                    <input type="text" name="nik_wali" class="form-control-custom" required>
                </div>
                <div class="form-custom-row">
                    <label>No.HP/Whatsapp aktif :</label>
                    <input type="text" name="no_hp_wali" class="form-control-custom" required>
                </div>
                <div class="form-custom-row">
                    <label>Alamat Wali :</label>
                    <textarea name="alamat_wali" class="form-control-custom" required></textarea>
                </div>
                
                <div class="form-custom-row align-items-start mt-3">
                    <label style="margin-top: 8px;">TTD WALI :</label>
                    <div class="canvas-container">
                        <button type="button" class="btn-clear" id="clearBtn">Bersihkan</button>
                        <div class="canvas-placeholder" id="canvasPlaceholder">Canvas Untuk TTD Digital</div>
                        <canvas id="signatureCanvas"></canvas>
                        <!-- Hidden input to store base64 image data -->
                        <input type="hidden" name="ttd_wali_base64" id="ttdInput">
                    </div>
                </div>

                <div class="agreement-box">
                    <input type="checkbox" id="agreement" required>
                    <label for="agreement">Saya menyatakan bahwa data yang saya isi adalah benar dan saya menyetujui Syarat & Ketentuan serta Kebijakan Privasi yang berlaku di Rumah Sakit ini.</label>
                </div>

                <div class="btn-submit-wrapper">
                    <button type="submit" class="btn-submit">SUBMIT</button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Javascript for Signature Canvas -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const canvas = document.getElementById('signatureCanvas');
        const ctx = canvas.getContext('2d');
        const placeholder = document.getElementById('canvasPlaceholder');
        const clearBtn = document.getElementById('clearBtn');
        const form = document.getElementById('pasienForm');
        const ttdInput = document.getElementById('ttdInput');

        let isDrawing = false;
        let hasDrawn = false;

        // Resize canvas to fit container
        function resizeCanvas() {
            canvas.width = canvas.parentElement.clientWidth;
            canvas.height = canvas.parentElement.clientHeight;
        }
        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);

        ctx.strokeStyle = '#000';
        ctx.lineWidth = 2;
        ctx.lineJoin = 'round';
        ctx.lineCap = 'round';

        function startPosition(e) {
            isDrawing = true;
            hasDrawn = true;
            placeholder.style.display = 'none'; // Hide text when drawing starts
            draw(e);
        }

        function endPosition() {
            isDrawing = false;
            ctx.beginPath();
        }

        function draw(e) {
            if (!isDrawing) return;
            const rect = canvas.getBoundingClientRect();
            let x, y;

            if (e.type.includes('mouse')) {
                x = e.clientX - rect.left;
                y = e.clientY - rect.top;
            } else { // touch support
                x = e.touches[0].clientX - rect.left;
                y = e.touches[0].clientY - rect.top;
            }

            ctx.lineTo(x, y);
            ctx.stroke();
            ctx.beginPath();
            ctx.moveTo(x, y);
        }

        // Mouse events
        canvas.addEventListener('mousedown', startPosition);
        canvas.addEventListener('mouseup', endPosition);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseout', endPosition);

        // Touch events
        canvas.addEventListener('touchstart', startPosition, { passive: false });
        canvas.addEventListener('touchend', endPosition);
        canvas.addEventListener('touchmove', function(e) {
            e.preventDefault(); // Prevent scrolling while signing
            draw(e);
        }, { passive: false });

        // Clear canvas
        clearBtn.addEventListener('click', function() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            placeholder.style.display = 'block';
            hasDrawn = false;
            ttdInput.value = '';
        });

        // Save canvas to base64 before form submit
        form.addEventListener('submit', function(e) {
            if (hasDrawn) {
                ttdInput.value = canvas.toDataURL('image/png');
            } else {
                e.preventDefault();
                alert("Mohon isi tanda tangan wali terlebih dahulu.");
            }
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>