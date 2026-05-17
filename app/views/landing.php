<?php include __DIR__ . '/layouts/header.php'; ?>

<!-- ===================== HERO SECTION ===================== -->
<section id="beranda" class="hero-section d-flex align-items-center"
    style="background-image: url('<?= BASEURL; ?>/assets/img/Bg_LandingPage.png');">
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <div class="row">
            <div class="col-lg-7 col-md-9">
                <p class="hero-eyebrow text-uppercase mb-2">ICU Central Specialist Hospital</p>
                <h1 class="hero-title text-white fw-bold">
                    Dedikasi Medis<br>Tertinggi
                </h1>
                <h2 class="hero-subtitle fw-bold">
                    Di Titik Paling Kritis.
                </h2>
                <p class="hero-desc text-white mt-3">
                    Memberikan akurasi klinis mutlak melalui integrasi teknologi life-support
                    mutakhir dan kesiagaan penuh tim dokter spesialis Intensivist selama
                    24 jam.
                </p>
                <a href="<?= BASEURL; ?>/auth/login" class="btn btn-hero mt-4">
                    <i class="bi bi-lock-fill me-2"></i>Masuk Portal Pasien
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ===================== LAYANAN SPESIALISASI ===================== -->
<section id="layanan" class="section-layanan py-5">
    <div class="container py-4">
        <div class="row align-items-start g-5">
            <div class="col-lg-5">
                <p class="section-label text-uppercase fw-bold mb-2">Keunggulan Kami</p>
                <h2 class="section-title fw-bold">LAYANAN SPESIALISASI<br>INTENSIF</h2>
                <div class="section-divider my-3"></div>
                <p class="text-muted">
                    Kami mengintegrasikan keahlian medis spesifik
                    ke dalam unit-unit ICU terpisah untuk efektivitas
                    perawatan yang lebih akurat.
                </p>
            </div>
            <div class="col-lg-7">
                <div class="row g-4 justify-content-between align-items-stretch">
                    <!-- Card 1 -->
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card-layanan-item h-100 p-4">
                            <div class="layanan-icon mb-3">
                                <i class="bi bi-heart-pulse-fill"></i>
                            </div>
                            <h6 class="fw-semibold layanan-card-title">ICU Kardiovaskular</h6>
                            <p class="small text-muted mb-0">
                                Penanganan intensif untuk kasus serangan jantung,
                                gagal jantung akut, dan pasca-bedah toraks.
                            </p>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card-layanan-item h-100 p-4">
                            <div class="layanan-icon mb-3">
                                <i class="bi bi-bandaid-fill"></i>
                            </div>
                            <h6 class="fw-semibold layanan-card-title">NICU & PICU</h6>
                            <p class="small text-muted mb-0">
                                Fasilitas perawatan kritis bagi bayi prematur dan
                                anak dengan kondisi medis yang mengancam jiwa.
                            </p>
                        </div>
                    </div>
                    <!-- Card 3 -->
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card-layanan-item h-100 p-4">
                            <div class="layanan-icon mb-3">
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <h6 class="fw-semibold layanan-card-title">High Dependency Unit</h6>
                            <p class="small text-muted mb-0">
                                Layanan pengawasan ketat bagi pasien yang baru
                                melewati masa kritis sebelum dipindah ke rawat inap.
                            </p>
                        </div>
                    </div>
                    <!-- Card 4 -->
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card-layanan-item h-100 p-4">
                            <div class="layanan-icon mb-3">
                                <i class="bi bi-activity"></i>
                            </div>
                            <h6 class="fw-semibold layanan-card-title">Neuro ICU</h6>
                            <p class="small text-muted mb-0">
                                Fokus pada penanganan stroke akut, trauma kepala,
                                dan gangguan sistem saraf pusat yang kritis.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===================== FASILITAS & LAYANAN MEDIS ===================== -->
<section id="fasilitas" class="section-fasilitas py-5">
    <div class="container py-4">
        <div class="text-center mb-5">
            <p class="section-label text-uppercase fw-bold mb-2">Teknologi Mutakhir</p>
            <h2 class="section-title fw-bold">Fasilitas &amp; Layanan Medis</h2>
            <div class="section-divider mx-auto mt-3"></div>
        </div>

        <!-- Fasilitas Item 1 -->
        <div class="row align-items-center g-5 mb-5 fasilitas-item">
            <div class="col-lg-6 order-lg-1 order-2">
                <div class="fasilitas-icon-badge mb-3">
                    <i class="bi bi-hospital-fill"></i>
                </div>
                <h3 class="fasilitas-item-title fw-bold">Smart ICU Beds</h3>
                <p class="text-muted">
                    Tempat tidur kinetik otomatis dengan sistem sensor berat badan terintegrasi.
                    Dirancang khusus untuk mencegah komplikasi dekubitus pada pasien kritis
                    dan memudahkan mobilisasi lateral otomatis tanpa mengganggu stabilitas
                    life support.
                </p>
                <ul class="fasilitas-features list-unstyled mt-3">
                    <li><i class="bi bi-check-circle-fill text-teal me-2"></i>Sensor berat badan real-time</li>
                    <li><i class="bi bi-check-circle-fill text-teal me-2"></i>Mobilisasi lateral otomatis</li>
                    <li><i class="bi bi-check-circle-fill text-teal me-2"></i>Integrasi sistem life support</li>
                </ul>
            </div>
            <div class="col-lg-6 order-lg-2 order-1">
                <div class="fasilitas-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=700&q=80"
                        alt="Smart ICU Beds" class="img-fluid rounded-4 fasilitas-img">
                    <div class="fasilitas-img-badge">
                        <i class="bi bi-patch-check-fill me-1"></i> Berstandar Internasional
                    </div>
                </div>
            </div>
        </div>

        <!-- Fasilitas Item 2 -->
        <div class="row align-items-center g-5 fasilitas-item">
            <div class="col-lg-6">
                <div class="fasilitas-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1579154204601-01588f351e67?w=700&q=80"
                        alt="Sistem Monitoring" class="img-fluid rounded-4 fasilitas-img">
                    <div class="fasilitas-img-badge">
                        <i class="bi bi-patch-check-fill me-1"></i> Pemantauan 24 Jam
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="fasilitas-icon-badge mb-3">
                    <i class="bi bi-display-fill"></i>
                </div>
                <h3 class="fasilitas-item-title fw-bold">Sistem Monitoring Terpusat</h3>
                <p class="text-muted">
                    Pusat kendali pemantauan pasien berbasis teknologi AI yang memungkinkan
                    tim medis memantau kondisi vital seluruh pasien ICU secara bersamaan
                    dengan notifikasi otomatis saat terjadi perubahan kondisi kritis.
                </p>
                <ul class="fasilitas-features list-unstyled mt-3">
                    <li><i class="bi bi-check-circle-fill text-teal me-2"></i>Dashboard real-time multi-pasien</li>
                    <li><i class="bi bi-check-circle-fill text-teal me-2"></i>Notifikasi otomatis berbasis AI</li>
                    <li><i class="bi bi-check-circle-fill text-teal me-2"></i>Rekam medis terintegrasi digital</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- ===================== PANDUAN ADMINISTRASI ===================== -->
<section id="panduan" class="section-panduan py-5">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <p class="section-label text-uppercase fw-bold mb-2">Proses Mudah</p>
                <h2 class="section-title fw-bold text-white">PANDUAN RESMI<br>
                    <span class="text-teal">ADMINISTRASI ICU</span>
                </h2>
                <div class="section-divider mt-3 mb-4"></div>
                <p class="text-white-75">
                    Kami memahami bahwa proses perawatan kritis dapat menjadi momen
                    yang penuh tekanan. Untuk membantu Anda, kami menyediakan sistem
                    panduan langkah-demi-langkah yang transparan mengenai proses
                    pendaftaran, berkas yang diperlukan, hingga otorisasi medis.
                </p>
                <ul class="panduan-list list-unstyled mt-4">
                    <li class="d-flex align-items-start mb-3">
                        <span class="panduan-check me-3"><i class="bi bi-check-lg"></i></span>
                        <span class="text-white-75">Informasi dokumen wajib dan alur birokrasi.</span>
                    </li>
                    <li class="d-flex align-items-start mb-3">
                        <span class="panduan-check me-3"><i class="bi bi-check-lg"></i></span>
                        <span class="text-white-75">Panduan aktivasi portal monitoring keluarga.</span>
                    </li>
                    <li class="d-flex align-items-start">
                        <span class="panduan-check me-3"><i class="bi bi-check-lg"></i></span>
                        <span class="text-white-75">Informasi layanan BPJS dan pembayaran umum.</span>
                    </li>
                </ul>
                <a href="<?= BASEURL; ?>/pendaftaran/pilih-jalur" class="btn btn-panduan mt-4">
                    Lihat Langkah Pendaftaran <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
            <div class="col-lg-6">
                <div class="panduan-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=700&q=80"
                        alt="Panduan Administrasi ICU" class="img-fluid rounded-4 panduan-img">
                    <!-- Stats floating -->
                    <div class="panduan-stat-card panduan-stat-1">
                        <div class="stat-icon"><i class="bi bi-file-earmark-check-fill"></i></div>
                        <div>
                            <p class="stat-num">3 Jalur</p>
                            <p class="stat-label">Pendaftaran Tersedia</p>
                        </div>
                    </div>
                    <div class="panduan-stat-card panduan-stat-2">
                        <div class="stat-icon"><i class="bi bi-clock-fill"></i></div>
                        <div>
                            <p class="stat-num">24 Jam</p>
                            <p class="stat-label">Layanan Admisi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===================== STATS STRIP ===================== -->
<section class="section-stats py-4">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-6 col-md-3">
                <p class="stat-big-num">98<span>%</span></p>
                <p class="stat-big-label">Tingkat Keselamatan Pasien</p>
            </div>
            <div class="col-6 col-md-3">
                <p class="stat-big-num">24<span>/7</span></p>
                <p class="stat-big-label">Kesiagaan Tim Medis</p>
            </div>
            <div class="col-6 col-md-3">
                <p class="stat-big-num">50<span>+</span></p>
                <p class="stat-big-label">Dokter Spesialis Intensivist</p>
            </div>
            <div class="col-6 col-md-3">
                <p class="stat-big-num">200<span>+</span></p>
                <p class="stat-big-label">Tempat Tidur ICU Berteknologi</p>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/layouts/footer.php'; ?>