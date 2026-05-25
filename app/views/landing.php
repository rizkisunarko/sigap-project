<?php include __DIR__ . '/layouts/header.php'; ?>

<!-- ===================== HERO SECTION ===================== -->
<section id="beranda" class="hero-section d-flex align-items-center"
    style="background-image: url('<?= BASEURL; ?>/assets/img/Bg_LandingPage.png');">
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <div class="row">
            <div class="col-lg-7 col-md-9">
                <p class="hero-eyebrow text-uppercase mb-2"
                   data-aos="fade-down" data-aos-delay="0">
                    ICU Central Specialist Hospital
                </p>
                <h1 class="hero-title text-white fw-bold"
                    data-aos="fade-right" data-aos-delay="100">
                    Dedikasi Medis<br>Tertinggi
                </h1>
                <h2 class="hero-subtitle fw-bold"
                    data-aos="fade-right" data-aos-delay="220">
                    Di Titik Paling Kritis.
                </h2>
                <p class="hero-desc text-white mt-3"
                   data-aos="fade-up" data-aos-delay="370">
                    Memberikan akurasi klinis mutlak melalui integrasi teknologi life-support
                    mutakhir dan kesiagaan penuh tim dokter spesialis Intensivist selama
                    24 jam.
                </p>
                <a href="<?= BASEURL; ?>/auth/login" class="btn btn-hero mt-4"
                   data-aos="fade-up" data-aos-delay="520">
                    <i class="bi bi-lock-fill me-2"></i>Masuk Portal Pasien
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ===================== LAYANAN SPESIALISASI ===================== -->
<section id="layanan" class="section-layanan">
    <div class="container layanan-container">

        <!-- Header -->
        <div class="layanan-header"
             data-aos="fade-up" data-aos-delay="0">
            <h2 class="layanan-title fw-bold">LAYANAN SPESIALISASI<br>INTENSIF</h2>
            <p class="layanan-desc">
                Kami mengintegrasikan keahlian medis spesifik
                ke dalam unit-unit ICU terpisah untuk efektivitas
                perawatan yang lebih akurat.
            </p>
        </div>

        <!-- Cards -->
        <div class="layanan-cards-row">
            <div class="card-layanan-item"
                 data-aos="fade-up" data-aos-delay="0">
                <div class="layanan-icon-wrap">
                    <i class="bi bi-heart-pulse"></i>
                </div>
                <p class="layanan-card-desc">
                    Penanganan intensif untuk
                    kasus serangan jantung,
                    gagal jantung akut, dan
                    pasca-bedah toraks.
                </p>
            </div>

            <div class="card-layanan-item"
                 data-aos="fade-up" data-aos-delay="100">
                <div class="layanan-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M9 4.5 Q12 2.5 15 4.5"/>
                        <circle cx="9.5" cy="11" r="0.75" fill="currentColor" stroke="none"/>
                        <circle cx="14.5" cy="11" r="0.75" fill="currentColor" stroke="none"/>
                        <path d="M9.5 14.5 Q12 16.5 14.5 14.5"/>
                    </svg>
                </div>
                <p class="layanan-card-desc">
                    Fasilitas perawatan kritis
                    bagi bayi prematur dan
                    anak dengan kondisi
                    medis yang mengancam jiwa.
                </p>
            </div>

            <div class="card-layanan-item"
                 data-aos="fade-up" data-aos-delay="200">
                <div class="layanan-icon-wrap">
                    <i class="bi bi-clock"></i>
                </div>
                <p class="layanan-card-desc">
                    Layanan pengawasan
                    ketat bagi pasien yang
                    baru melewati masa kritis
                    sebelum dipindah ke rawat inap.
                </p>
            </div>

            <div class="card-layanan-item"
                 data-aos="fade-up" data-aos-delay="300">
                <div class="layanan-icon-wrap">
                    <i class="bi bi-activity"></i>
                </div>
                <p class="layanan-card-desc">
                    Fokus pada penanganan
                    stroke akut, trauma
                    kepala, dan gangguan
                    sistem saraf pusat yang kritis.
                </p>
            </div>
        </div>

    </div>
</section>

<!-- ===================== FASILITAS & LAYANAN MEDIS ===================== -->
<section id="fasilitas" class="section-fasilitas">
    <div class="fasilitas-header text-center"
         data-aos="fade-up" data-aos-delay="0">
        <h2 class="fasilitas-main-title fw-bold">Fasilitas & Layanan Medis</h2>
        <div class="section-divider mx-auto mt-3"></div>
    </div>

    <!-- Slider Wrapper -->
    <div class="fasilitas-slider-wrapper"
         data-aos="fade-up" data-aos-delay="150">
        <button class="fasilitas-nav fasilitas-prev" id="fasilitasPrev" aria-label="Previous">&#8249;</button>

        <div class="fasilitas-track" id="fasilitasTrack">

            <!-- Slide 1 -->
            <div class="fasilitas-slide active">
                <div class="fasilitas-slide-content">
                    <div class="fasilitas-text-side">
                        <div class="fasilitas-icon-box">
                            <i class="bi bi-hospital"></i>
                        </div>
                        <h3 class="fasilitas-slide-title">Smart ICU Beds</h3>
                        <p class="fasilitas-slide-desc">
                            Tempat tidur kinetik otomatis dengan sistem sensor berat badan terintegrasi.
                            Dirancang khusus untuk mencegah komplikasi dekubitus pada pasien kritis
                            dan memudahkan mobilisasi lateral otomatis tanpa mengganggu stabilitas
                            life-support.
                        </p>
                    </div>
                    <div class="fasilitas-img-side">
                        <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=700&q=80"
                            alt="Smart ICU Beds" class="fasilitas-slide-img">
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="fasilitas-slide">
                <div class="fasilitas-slide-content">
                    <div class="fasilitas-text-side">
                        <div class="fasilitas-icon-box">
                            <i class="bi bi-display"></i>
                        </div>
                        <h3 class="fasilitas-slide-title">Central Command Center</h3>
                        <p class="fasilitas-slide-desc">
                            Pusat observasi terpadu di mana tim 
                            Intensivist memantau setiap denyut jantung, saturasi oksigen,
                             dan parameter klinis lainnya dari seluruh bed secara real-time
                            . Memungkinkan respon cepat di bawah sepuluh detik
                        </p>
                    </div>
                    <div class="fasilitas-img-side">
                        <img src="https://images.unsplash.com/photo-1579154204601-01588f351e67?w=700&q=80"
                            alt="Sistem Monitoring" class="fasilitas-slide-img">
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="fasilitas-slide">
                <div class="fasilitas-slide-content">
                    <div class="fasilitas-text-side">
                        <div class="fasilitas-icon-box">
                            <i class="bi bi-lungs"></i>
                        </div>
                        <h3 class="fasilitas-slide-title">On-Site Stat Laboratory</h3>
                        <p class="fasilitas-slide-desc">
                            Fasilitas laboratorium patalogi klinik yang
                            berada tepat di dalam unit ICU. Dilengkapi 
                            dengan teknologi Point-of-Care Testing (POCT)
                            untuk memberikan hasil analisis gas darah dan
                            elektrolit dalam waktu singkat.
                        </p>
                    </div>
                    <div class="fasilitas-img-side">
                        <img src="https://images.unsplash.com/photo-1584515933487-779824d29309?w=700&q=80"
                            alt="Ventilator" class="fasilitas-slide-img">
                    </div>
                </div>
            </div>

            <!-- Slide 4 -->
            <div class="fasilitas-slide">
                <div class="fasilitas-slide-content">
                    <div class="fasilitas-text-side">
                        <div class="fasilitas-icon-box">
                            <i class="bi bi-lungs"></i>
                        </div>
                        <h3 class="fasilitas-slide-title">Mobile Bedside Imaging</h3>
                        <p class="fasilitas-slide-desc">
                            Unit radiologi portabel yang meliputi X-Ray
                            digital dan USG Doppler yang dapat dilakukan 
                            langsung di samping tempat tidur pasien. Mengeliminasi 
                            risiko mobilisasi pasien kritis. 
                        </p>
                    </div>
                    <div class="fasilitas-img-side">
                        <img src="https://images.unsplash.com/photo-1584515933487-779824d29309?w=700&q=80"
                            alt="Ventilator" class="fasilitas-slide-img">
                    </div>
                </div>
            </div>

        </div>

        <button class="fasilitas-nav fasilitas-next" id="fasilitasNext" aria-label="Next">&#8250;</button>
    </div>

    <!-- Dots -->
    <div class="fasilitas-dots" id="fasilitasDots">
        <button class="fasilitas-dot active" data-index="0"></button>
        <button class="fasilitas-dot" data-index="1"></button>
        <button class="fasilitas-dot" data-index="2"></button>
        <button class="fasilitas-dot" data-index="3"></button>
    </div>
</section>

<script>
(function() {
    const slides = document.querySelectorAll('.fasilitas-slide');
    const dots   = document.querySelectorAll('.fasilitas-dot');
    let current  = 0;

    function goTo(n) {
        slides[current].classList.remove('active');
        dots[current].classList.remove('active');
        current = (n + slides.length) % slides.length;
        slides[current].classList.add('active');
        dots[current].classList.add('active');
    }

    document.getElementById('fasilitasPrev').addEventListener('click', () => goTo(current - 1));
    document.getElementById('fasilitasNext').addEventListener('click', () => goTo(current + 1));
    dots.forEach(d => d.addEventListener('click', () => goTo(+d.dataset.index)));
})();
</script>

<!-- ===================== PANDUAN ADMINISTRASI ===================== -->
<section id="panduan" class="section-panduan">
    <div class="container panduan-container">
        <div class="panduan-row">

            <!-- Kiri: teks -->
            <div class="panduan-text-col"
                 data-aos="fade-right" data-aos-delay="0">
                <h2 class="panduan-title-main">PANDUAN RESMI</h2>
                <h2 class="panduan-title-sub">ADMINISTRASI ICU</h2>
                <p class="panduan-desc">
                    Kami memahami bahwa proses perawatan kritis dapat
                    menjadi momen yang penuh tekanan. Untuk membantu
                    Anda, kami menyediakan sistem panduan langkah-
                    demi-langkah yang transparan mengenai proses
                    pendaftaran, berkas yang diperlukan, hingga otorisasi
                    medis.
                </p>
                <ul class="panduan-list list-unstyled">
                    <li data-aos="fade-right" data-aos-delay="150">
                        <i class="bi bi-check-circle-fill panduan-check-icon"></i>
                        Informasi dokumen wajib dan alur birokrasi.
                    </li>
                    <li data-aos="fade-right" data-aos-delay="250">
                        <i class="bi bi-check-circle-fill panduan-check-icon"></i>
                        Panduan aktivasi portal monitoring keluarga.
                    </li>
                </ul>
                <a href="<?= BASEURL; ?>/pendaftaran/pilih-jalur" class="btn btn-panduan mt-3"
                   data-aos="fade-up" data-aos-delay="350">
                    Lihat Langkah Pendaftaran &gt;
                </a>
            </div>

            <!-- Kanan: gambar -->
            <div class="panduan-img-col"
                 data-aos="fade-left" data-aos-delay="150">
                <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=700&q=80"
                    alt="Panduan Administrasi ICU" class="panduan-img">
            </div>

        </div>
    </div>
</section>

<?php include __DIR__ . '/layouts/footer.php'; ?>