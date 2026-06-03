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
                            <p>STATUS PASIEN : <span class="badge-status-small"><?= strtoupper(htmlspecialchars($row['kondisi'] ?? '-')) ?></span></p>
                            <p>PETUGAS : <span>DR. <?= strtoupper(htmlspecialchars($row['nama_perawat'] ?? 'TIDAK DIKETAHUI')) ?></span></p>
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