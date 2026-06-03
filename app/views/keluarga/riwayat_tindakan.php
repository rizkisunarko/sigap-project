<div class="perkembangan-card mt-3">
    <h4 class="perkembangan-title">PERKEMBANGAN PASIEN</h4>
    
    <div class="timeline-scroll-box">
        <div class="timeline">
            
            <?php if (!empty($riwayat)): ?>
                <?php foreach ($riwayat as $row): ?>
                    <div class="timeline-item">
                        <div class="timeline-content-left">
                            <p>DETAK JANTUNG : <span><?= htmlspecialchars($row['detak_jantung'] ?? '-') ?> BPM</span></p>
                            <p>OKSIGEN (SPO2) : <span><?= htmlspecialchars($row['sp02'] ?? '-') ?> %</span></p>
                            <p>SUHU TUBUH : <span><?= htmlspecialchars($row['suhu_tubuh'] ?? '-') ?> °C</span></p>
                            <p>TEKANAN DARAH : <span><?= htmlspecialchars($row['tekanan_darah'] ?? '-') ?> mmHg</span></p>
                        </div>
                        <div class="timeline-content-right text-end">
                            <p>JAM : <span><?= date('H:i', strtotime($row['waktu_catat'])) ?> WIB</span></p>
                            <p>STATUS PASIEN : 
                                <?php 
                                    // 1. Ambil statusnya dan jadikan huruf kecil semua agar mudah dicek
                                    $status_pasien = strtolower(trim($row['kondisi'] ?? ''));
                                    
                                    // 2. Tentukan warna background berdasarkan kondisinya
                                    if (in_array($status_pasien, ['kritis', 'menurun'])) {
                                        $warna_bg = '#dc3545'; // Merah (Bahaya)
                                    } elseif (in_array($status_pasien, ['stabil', 'meningkat'])) {
                                        $warna_bg = '#13c898'; // Hijau (Aman - menyesuaikan warna tema yang ada)
                                    } else {
                                        $warna_bg = '#6c757d'; // Abu-abu (Default jika kosong/tidak diketahui)
                                    }
                                ?>
                                <span class="badge-status-small text-white" style="background-color: <?= $warna_bg ?>;">
                                    <?= strtoupper(htmlspecialchars($row['kondisi'] ?? '-')) ?>
                                </span>
                            </p>
                            <p>PETUGAS : <span><?= strtoupper(htmlspecialchars($row['nama_perawat'] ?? 'TIDAK DIKETAHUI')) ?></span></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center text-muted" style="font-size: 0.9rem; font-weight: 500;">
                    Belum ada riwayat perkembangan pasien saat ini.
                </div>
            <?php endif; ?>
            
        </div>
    </div>
</div>