<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// 1. Tangkap data lama yang sudah diketik pengguna
$old = isset($_SESSION['old']) ? $_SESSION['old'] : []; 
// 2. Tangkap pesan kesalahan spesifik per kolom
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : []; 

// 3. HANCURKAN MEMORI SESI SAAT INI JUGA (Flash Session)
unset($_SESSION['old']);
unset($_SESSION['errors']);

include __DIR__ . '/../layouts/header.php'; 
?>

<div class="form-wrapper">
    <div class="form-card" data-aos="fade-up">
        
        <h2 class="form-main-title">Daftar Akun</h2>
        <div class="form-title-divider"></div>

        <?php if (isset($_SESSION['error'])): ?>
            <div style="background-color: #ffe6e6; color: #cc0000; padding: 10px; border-radius: 5px; margin-bottom: 20px; font-weight: bold; text-align: center;">
                <?= $_SESSION['error']; ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div style="background-color: #e6ffe6; color: #008000; padding: 10px; border-radius: 5px; margin-bottom: 20px; font-weight: bold; text-align: center;">
                Pendaftaran berhasil disimpan ke dalam sistem!
            </div>
        <?php endif; ?>

        <form action="<?= BASEURL; ?>/pendaftaran/submit" method="POST">
            
            <?php include __DIR__ . '/akun_pengguna.php'; ?>
            <?php include __DIR__ . '/data_diri_pasien.php'; ?>
            <?php include __DIR__ . '/data_tambahan_pasien.php'; ?>
            <?php include __DIR__ . '/data_diri_wali.php'; ?>
            <?php include __DIR__ . '/syarat_ketentuan.php'; ?>

            <button type="submit" class="btn-submit-form">SUBMIT</button>

        </form>

    </div>
</div>

<?php include __DIR__ . '/script_animasi_signature.php'; ?>

<?php include __DIR__ . '/../layouts/footer.php'; ?>