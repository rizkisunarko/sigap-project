<?php include __DIR__ . '/../layouts/header.php'; ?>

<section class="langkah-section">
    <div class="container" style="max-width: 800px;">
        
        <!-- Header Judul -->
        <div class="langkah-header" data-aos="fade-down">
            <h1 class="langkah-title-dark text-uppercase">LANGKAH</h1>
            <h1 class="langkah-title-teal text-uppercase">PENDAFTARAN ONLINE</h1>
        </div>

        <!-- Timeline -->
        <div class="timeline-container">
            
            <!-- Langkah 1 -->
            <div class="timeline-item" data-aos="fade-up" data-aos-delay="50">
                <div class="timeline-card">
                    <span class="step-label">LANGKAH 1:</span>
                    <h3 class="step-title">Masuk ke Portal Pendaftaran</h3>
                    <p class="step-desc">
                        "Buka web HOSPITAL, lalu pilih menu 'Portal Pendaftaran'. Kemudian siapkan dokumen-dokumen yang dibutuhkan untuk pengisian formulir."
                    </p>
                </div>
            </div>

            <!-- Langkah 2 -->
            <div class="timeline-item" data-aos="fade-up" data-aos-delay="150">
                <div class="timeline-card">
                    <span class="step-label">LANGKAH 2:</span>
                    <h3 class="step-title">Lengkapi Data Sesuai Dengan Formulir Yang Ada</h3>
                    <p class="step-desc">
                        "Isi form digital mengenai identitas pasien, identitas pengantar, dan riwayat penyakit jika sebelumnya pasien punya riwayat penyakit. Pastikan data pengantar diisi dengan benar."
                    </p>
                </div>
            </div>

            <!-- Langkah 3 -->
            <div class="timeline-item" data-aos="fade-up" data-aos-delay="250">
                <div class="timeline-card">
                    <span class="step-label">LANGKAH 3:</span>
                    <h3 class="step-title">Pilih Penjamin & Verifikasi Data</h3>
                    <p class="step-desc">
                        "Pilih jenis penjamin (BPJS, Asuransi, atau Umum). Masukkan Nomor Kartu (JKN/Polis) atau NIK Pasien. Anda juga dapat mengunggah foto kartu untuk mempercepat proses verifikasi data dan pengecekan SEP otomatis."
                    </p>
                </div>
            </div>

            <!-- Langkah 4 -->
            <div class="timeline-item" data-aos="fade-up" data-aos-delay="350">
                <div class="timeline-card">
                    <span class="step-label">LANGKAH 4:</span>
                    <h3 class="step-title">E-Signature General Consent</h3>
                    <p class="step-desc">
                        "Baca dokumen Persetujuan Umum (General Consent) di layar Anda. Lakukan tanda tangan digital secara langsung sebagai bukti persetujuan tindakan medis dan biaya."
                    </p>
                </div>
            </div>

            <!-- Langkah 5 -->
            <div class="timeline-item" data-aos="fade-up" data-aos-delay="450">
                <div class="timeline-card">
                    <span class="step-label">LANGKAH 5:</span>
                    <h3 class="step-title">Klik "SUBMIT" Setelah Mendaftar</h3>
                    <p class="step-desc">
                        "Setelah melakukan pengisian pada portal pendaftaran, klik tombol submit dan lakukan login pada menu sign in. Setelah itu laporkan pada resepsionis untuk instruksi langkah setelahnya."
                    </p>
                </div>
            </div>

        </div>

        <!-- CTA Bawah -->
        <div class="cta-card" data-aos="fade-up" data-aos-delay="550">
            <h4 class="cta-title">LANJUT KE PORTAL PENDAFTARAN?</h4>
            <!-- Tautan ini bisa diubah ke rute form yang spesifik nanti -->
            <a href="<?= BASEURL; ?>/pendaftaran/form" class="btn-cta mt-2">KLIK DISINI</a>
        </div>

    </div>
</section>

<!-- AOS Animation Script -->
<script>
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            once: true
        });
    }
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
