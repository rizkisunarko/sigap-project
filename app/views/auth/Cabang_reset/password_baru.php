<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Password Baru - Sistem Manajemen Rumah Sakit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Courier+New&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f3f4f6; }
        .form-font { font-family: 'Courier New', Courier, monospace; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-extrabold text-[#043622] mb-2">BUAT PASSWORD BARU</h2>
            <p class="text-gray-500 text-sm form-font">
                Kode OTP berhasil diverifikasi. Silakan masukkan password baru untuk mengamankan akun Anda.
            </p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-6 text-sm font-semibold rounded form-font">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="<?= BASEURL; ?>/auth/prosesUbahPassword" method="POST">
            <div class="mb-5">
                <label class="block text-[#111] font-bold mb-2 form-font text-sm">Password Baru :</label>
                <input type="password" name="password" required minlength="6"
                       class="w-full px-4 py-3 border border-gray-400 rounded focus:outline-none focus:border-[#043622] focus:ring-1 focus:ring-[#043622] form-font"
                       placeholder="Ketik password baru...">
            </div>

            <div class="mb-8">
                <label class="block text-[#111] font-bold mb-2 form-font text-sm">Konfirmasi Password :</label>
                <input type="password" name="konfirmasi_password" required minlength="6"
                       class="w-full px-4 py-3 border border-gray-400 rounded focus:outline-none focus:border-[#043622] focus:ring-1 focus:ring-[#043622] form-font"
                       placeholder="Ketik ulang password baru...">
            </div>

            <button type="submit" class="w-full bg-[#20c997] hover:bg-[#1bb78a] text-[#111] font-bold py-3 px-4 rounded transition duration-200 uppercase tracking-wide">
                SIMPAN PASSWORD
            </button>
            
            <div class="text-center mt-6">
                <a href="<?= BASEURL; ?>/auth/login" class="text-sm text-gray-500 hover:text-[#043622] underline form-font font-bold">
                    Batal dan Kembali ke Login
                </a>
            </div>
        </form>
    </div>

</body>
</html>