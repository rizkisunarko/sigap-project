<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$old = isset($_SESSION['pendaftaran_old']) ? $_SESSION['pendaftaran_old'] : []; 
$errors = isset($_SESSION['pendaftaran_errors']) ? $_SESSION['pendaftaran_errors'] : []; 

unset($_SESSION['pendaftaran_old']);
unset($_SESSION['pendaftaran_errors']);

include __DIR__ . '/../layouts/header.php'; 
?>

<div class="form-wrapper">
    <div class="form-card" data-aos="fade-up">
        
        <h2 class="form-main-title">Daftar Akun</h2>
        <div class="form-title-divider"></div>

        <?php if (isset($_SESSION['pendaftaran_error'])): ?>
            <div style="background-color: #ffe6e6; color: #cc0000; padding: 10px; border-radius: 5px; margin-bottom: 20px; font-weight: bold; text-align: center;">
                <?= $_SESSION['pendaftaran_error']; ?>
            </div>
            <?php unset($_SESSION['pendaftaran_error']); ?>
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