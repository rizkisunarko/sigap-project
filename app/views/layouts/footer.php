<footer class="site-footer">
    <div class="footer-main">
        <div class="container">
            <div class="footer-grid">

                <!-- Kolom kiri: Lokasi + peta -->
                <div class="footer-col-lokasi">
                    <h5 class="footer-col-title">LOKASI</h5>
                    <div class="footer-title-underline"></div>
                    <div class="footer-map-wrap">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.8!2d112.7585!3d-7.3233!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fb1f0a8d1a8d%3A0x0!2sJl.+Rungkut+Industri+I+No.1%2C+Kendangsari%2C+Surabaya!5e0!3m2!1sid!2sid!4v1699999999999!5m2!1sid!2sid"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Lokasi ICU Central Specialist Hospital">
                        </iframe>
                    </div>
                </div>

                <!-- Kolom kanan: Hubungi Kami -->
                <div class="footer-col-kontak">
                    <h5 class="footer-col-title">Hubungi Kami</h5>
                    <div class="footer-title-underline"></div>
                    <ul class="footer-contact-list list-unstyled">
                        <li>
                            <span class="footer-contact-icon"><i class="bi bi-geo-alt-fill"></i></span>
                            <span>Jl. Rungkut Industri I No.1, Kendangsari, Kec. Tenggilis Mejoyo, Surabaya, Jawa Timur 60292</span>
                        </li>
                        <li>
                            <span class="footer-contact-icon"><i class="bi bi-telephone-fill"></i></span>
                            <span>08123456789</span>
                        </li>
                        <li>
                            <span class="footer-contact-icon"><i class="bi bi-envelope-fill"></i></span>
                            <span>Hospital@domain.com</span>
                        </li>
                        <li>
                            <span class="footer-contact-icon"><i class="bi bi-instagram"></i></span>
                            <span>@ICUHOSPITAL</span>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <!-- Copyright bar -->
    <div class="footer-copyright">
        <p>&copy; 2026 ICU Central Specialist Hospital.</p>
    </div>
</footer>

<script src="<?= BASEURL; ?>/js/jquery.min.js"></script>
<!-- Use Bootstrap JS from CDN because local bootstrap.bundle is empty/missing -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ duration: 700, once: true, offset: 80, easing: 'ease-out-quart' });
</script>

</body>
</html>

