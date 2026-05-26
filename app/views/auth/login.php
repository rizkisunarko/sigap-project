<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/../layouts/header.php'; 
?>

<style>
/* CSS khusus untuk halaman Login */
body {
    background-color: #f8f9fa; /* Latar belakang abu muda */
}

.login-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: calc(100vh - 76px); /* Mengurangi tinggi navbar */
    padding: 60px 20px;
}

.login-card {
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
    width: 100%;
    max-width: 500px;
    padding: 25px 0 50px 0;
    text-align: center;
}

.login-title {
    color: #043622;
    font-size: 1.8rem;
    font-weight: 500;
    margin-bottom: 12px;
    letter-spacing: 0.5px;
}

.login-divider {
    height: 1px;
    background-color: #043622;
    width: 100%;
    margin-bottom: 25px; /* Sedikit disesuaikan untuk ruang pesan eror */
}

.login-form-group {
    margin-bottom: 25px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.login-label {
    font-size: 0.75rem;
    color: #333;
    margin-bottom: 8px;
    display: block;
}

.login-input {
    width: 100%;
    max-width: 280px;
    border: 1px solid #13c898; /* Border hijau toska seperti digambar */
    border-radius: 50px;
    padding: 8px 15px;
    text-align: center;
    font-size: 0.9rem;
    color: #495057;
    outline: none;
    transition: box-shadow 0.3s;
}

.login-input:focus {
    box-shadow: 0 0 0 0.15rem rgba(19, 200, 152, 0.25);
}

.btn-login {
    background-color: #043622; /* Tombol hijau tua bulat */
    color: #ffffff;
    border: none;
    border-radius: 50px;
    padding: 8px 40px;
    font-size: 0.85rem;
    margin-top: 15px;
    margin-bottom: 25px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn-login:hover {
    background-color: #032a1a;
    color: #ffffff;
}

.login-link {
    display: block;
    color: #13c898;
    font-size: 0.75rem;
    text-decoration: none;
}

.login-link:hover {
    text-decoration: underline;
    color: #0fa17a;
}
</style>

<div class="login-wrapper">
    <div class="login-card" data-aos="fade-up">
        
        <h2 class="login-title">Login</h2>
        <div class="login-divider"></div>

        <?php if (isset($_SESSION['error'])): ?>
            <div style="color: #cc0000; font-size: 9px; font-weight: bold; margin-bottom: 20px;">
                <?= $_SESSION['error']; ?>
            </div>
            <?php unset($_SESSION['error']); ?> <?php endif; ?>

        <form action="<?= BASEURL; ?>/auth/proses-login" method="POST">
            
            <div class="login-form-group">
                <label class="login-label">Username:</label>
                <input type="text" class="login-input" name="username" required>
            </div>

            <div class="login-form-group">
                <label class="login-label">Password:</label>
                <input type="password" class="login-input" name="password" required>
            </div>

            <button type="submit" class="btn-login">Login</button>
            
            <a href="<?= BASEURL; ?>/pendaftaran/form" class="login-link">Daftar akun disini</a>
            
        </form>
    </div>
</div>

<script>
    if (typeof AOS !== 'undefined') {
        AOS.init({ duration: 800, once: true });
    }
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>