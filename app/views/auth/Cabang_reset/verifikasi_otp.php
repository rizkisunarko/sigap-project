<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['reset_akun'])) {
    header('Location: ' . BASEURL . '/auth/reset');
    exit;
}

$no_tersamar = $_SESSION['reset_akun']['no_tersamar'];
$expired_at  = $_SESSION['reset_akun']['expired_at'];

$sisa_waktu = max(0, $expired_at - time());

$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - Sistem Manajemen Rumah Sakit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Courier+New&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f3f4f6; }
        .form-font { font-family: 'Courier New', Courier, monospace; }
        /* Menyembunyikan panah naik/turun pada input number */
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-extrabold text-[#043622] mb-2">VERIFIKASI OTP</h2>
            <p class="text-gray-500 text-sm form-font">
                Kode OTP 4 digit telah dikirimkan ke nomor WhatsApp<br>
                <strong class="text-[#111] text-base"><?= htmlspecialchars($no_tersamar) ?></strong>
            </p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-6 text-sm font-semibold rounded">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="<?= BASEURL; ?>/auth/prosesVerifikasiOtp" method="POST" id="otpForm">
            <div class="flex justify-center gap-3 mb-6">
                <input type="number" name="otp1" maxlength="1" required class="otp-input w-14 h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded focus:outline-none focus:border-[#043622] focus:ring-1 focus:ring-[#043622] form-font transition-colors">
                <input type="number" name="otp2" maxlength="1" required class="otp-input w-14 h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded focus:outline-none focus:border-[#043622] focus:ring-1 focus:ring-[#043622] form-font transition-colors">
                <input type="number" name="otp3" maxlength="1" required class="otp-input w-14 h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded focus:outline-none focus:border-[#043622] focus:ring-1 focus:ring-[#043622] form-font transition-colors">
                <input type="number" name="otp4" maxlength="1" required class="otp-input w-14 h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded focus:outline-none focus:border-[#043622] focus:ring-1 focus:ring-[#043622] form-font transition-colors">
            </div>

            <button type="submit" id="btnSubmit" class="w-full bg-[#20c997] hover:bg-[#1bb78a] text-[#111] font-bold py-3 px-4 rounded transition duration-200 uppercase tracking-wide mb-4">
                Verifikasi Kode
            </button>
        </form>

        <div class="text-center form-font text-sm">
            <div id="timerContainer" class="text-gray-500 font-bold mb-2">
                Kirim ulang kode dalam <span id="waktu" class="text-red-600">00:00</span>
            </div>
            
            <form action="<?= BASEURL; ?>/auth/validation" method="POST" id="resendForm" class="hidden">
                <input type="hidden" name="username" value="<?= htmlspecialchars($_SESSION['reset_akun']['username'] ?? '') ?>">
                
                <button type="submit" class="text-[#043622] font-bold underline hover:text-[#20c997] transition-colors">
                    Kirim Ulang Kode OTP
                </button>
            </form>
        </div>
        
        <div class="text-center mt-6">
            <a href="<?= BASEURL; ?>/auth/login" class="text-sm text-gray-500 hover:text-[#043622] underline form-font font-bold">
                Kembali ke Halaman Login
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.otp-input');
            
            inputs.forEach((input, index) => {
                input.addEventListener('input', function() {
                    if (this.value.length > 1) {
                        this.value = this.value.slice(0, 1);
                    }
                    if (this.value !== '' && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });

                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && this.value === '' && index > 0) {
                        inputs[index - 1].focus();
                    }
                });
            });

            if(inputs.length > 0) {
                inputs[0].focus();
            }

            let sisaDetik = <?= $sisa_waktu ?>;
            const waktuEl = document.getElementById('waktu');
            const timerContainer = document.getElementById('timerContainer');
            const resendForm = document.getElementById('resendForm');
            const btnSubmit = document.getElementById('btnSubmit');

            function perbaruiTampilanWaktu() {
                if (sisaDetik > 0) {
                    let menit = Math.floor(sisaDetik / 60);
                    let detik = sisaDetik % 60;
                    waktuEl.innerText = (menit < 10 ? "0" : "") + menit + ":" + (detik < 10 ? "0" : "") + detik;
                    sisaDetik--;
                } else {
                    clearInterval(intervalTimer);
                    timerContainer.classList.add('hidden');
                    resendForm.classList.remove('hidden');
                    
                    btnSubmit.disabled = true;
                    btnSubmit.classList.replace('bg-[#20c997]', 'bg-gray-400');
                    btnSubmit.classList.replace('hover:bg-[#1bb78a]', 'cursor-not-allowed');
                    btnSubmit.innerText = 'KODE KEDALUWARSA';
                }
            }

            perbaruiTampilanWaktu();
            const intervalTimer = setInterval(perbaruiTampilanWaktu, 1000);
        });
    </script>
</body>
</html>