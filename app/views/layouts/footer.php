<footer style="background-color: #0a1512 !important;" class="text-white pt-5 pb-3">
    <div class="container">
        <div class="row g-4 mb-4">

            <!-- Info Kontak -->
            <div class="col-lg-5">
                <div class="d-flex align-items-center mb-3 gap-2">
                    <img src="<?= BASEURL; ?>/assets/img/logo.png" alt="Logo" width="28">
                    <span style="font-weight:700; font-size:1rem; letter-spacing:0.5px;">HOSPITAL</span>
                </div>
                <p class="small text-white-50 mb-4" style="max-width:300px; line-height:1.6;">
                    ICU Central Specialist Hospital — Pusat layanan perawatan intensif terpadu
                    dengan teknologi life support terkini.
                </p>
                <h6 class="fw-bold text-secondary-icu mb-3 text-uppercase" style="font-size:0.7rem; letter-spacing:2px;">LOKASI & KONTAK</h6>
                <p class="d-flex align-items-start text-white-50 small mb-2">
                    <i class="bi bi-geo-alt-fill text-secondary-icu me-3 mt-1 fs-6 flex-shrink-0"></i>
                    <span>Jl. Rungkut Industri I No.1, Kendangsari, Kec. Tenggilis Mejoyo, Surabaya, Jawa Timur 60292</span>
                </p>
                <p class="d-flex align-items-center text-white-50 small mb-2">
                    <i class="bi bi-telephone-fill text-secondary-icu me-3 fs-6"></i>
                    <span>08123456789</span>
                </p>
                <p class="d-flex align-items-center text-white-50 small mb-2">
                    <i class="bi bi-envelope-fill text-secondary-icu me-3 fs-6"></i>
                    <span>Hospital@domain.com</span>
                </p>
                <p class="d-flex align-items-center text-white-50 small">
                    <i class="bi bi-instagram text-secondary-icu me-3 fs-6"></i>
                    <span>@ICUHOSPITAL</span>
                </p>
            </div>

            <!-- Quick Links -->
            <div class="col-6 col-lg-3">
                <h6 class="fw-bold text-secondary-icu mb-3 text-uppercase" style="font-size:0.7rem; letter-spacing:2px;">Navigasi</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="#beranda" class="text-white-50 text-decoration-none footer-link">Beranda</a></li>
                    <li class="mb-2"><a href="#layanan" class="text-white-50 text-decoration-none footer-link">Layanan Intensif</a></li>
                    <li class="mb-2"><a href="#fasilitas" class="text-white-50 text-decoration-none footer-link">Fasilitas Medis</a></li>
                    <li class="mb-2"><a href="#panduan" class="text-white-50 text-decoration-none footer-link">Panduan Admisi</a></li>
                    <li class="mb-2"><a href="<?= BASEURL; ?>/pendaftaran/pilih-jalur" class="text-white-50 text-decoration-none footer-link">Portal Pendaftaran</a></li>
                </ul>
            </div>

            <!-- Peta -->
            <div class="col-lg-4">
                <h6 class="fw-bold text-secondary-icu mb-3 text-uppercase" style="font-size:0.7rem; letter-spacing:2px;">Lokasi Kami</h6>
                <div class="rounded-3 overflow-hidden" style="height:200px;">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.8!2d112.7585!3d-7.3233!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fb1f0a8d1a8d%3A0x0!2sJl.+Rungkut+Industri+I+No.1%2C+Kendangsari%2C+Surabaya!5e0!3m2!1sid!2sid!4v1699999999999!5m2!1sid!2sid"
                        width="100%"
                        height="200"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Lokasi ICU Central Specialist Hospital">
                    </iframe>
                </div>
            </div>

        </div>

        <hr class="border-secondary opacity-25">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="small text-white-50 mb-0">&copy; 24-181 Rizki Pratama S, 24-00 Sucipto Budiono, 24-00 Abdi, 24-00 Dyaul Haq.</p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                <a href="<?= BASEURL; ?>/auth/login" class="small text-white-50 text-decoration-none footer-link me-3">Sign In</a>
                <a href="#" class="small text-white-50 text-decoration-none footer-link me-3">Kebijakan Privasi</a>
                <a href="#" class="small text-white-50 text-decoration-none footer-link">Syarat & Ketentuan</a>
            </div>
        </div>
    </div>
</footer>

<script src="<?= BASEURL; ?>/js/jquery.min.js"></script>
<script src="<?= BASEURL; ?>/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASEURL; ?>/js/custom.js"></script>

<!-- Smooth scroll + navbar active -->
<script>
document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
    anchor.addEventListener('click', function(e) {
        var target = document.querySelector(this.getAttribute('href'));
        if (target) {
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});

// Navbar shrink on scroll
window.addEventListener('scroll', function() {
    var navbar = document.querySelector('.navbar');
    if (window.scrollY > 60) {
        navbar.style.boxShadow = '0 2px 20px rgba(0,0,0,0.35)';
    } else {
        navbar.style.boxShadow = 'none';
    }
});
</script>

<style>
.footer-link:hover { color: #14b8a6 !important; transition: color 0.2s; }
</style>

</body>
</html>