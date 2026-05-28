<h3 class="section-heading">STATUS PASIEN</h3>
<div class="row">
    <div class="col-md-3 col-6">
        <div class="status-card">
            <div class="status-icon">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.42 4.58a5.4 5.4 0 0 0-7.65 0l-.77.78-.77-.78a5.4 5.4 0 0 0-7.65 0C1.46 6.7 1.33 10.28 4 13l8 8 8-8c2.67-2.72 2.54-6.3.42-8.42z"></path><polyline points="3 12 7 12 10 5 14 19 17 12 21 12"></polyline></svg>
            </div>
            <div class="status-title">DETAK JANTUNG</div>
            <div class="status-value"><?= htmlspecialchars($obs_terbaru['detak_jantung'] ?? '-') ?> <span class="status-unit">BPM</span></div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="status-card">
            <div class="status-icon">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"></path></svg>
            </div>
            <div class="status-title">OKSIGEN (SPO2)</div>
            <div class="status-value"><?= htmlspecialchars($obs_terbaru['sp02'] ?? '-') ?> <span class="status-unit">%</span></div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="status-card">
            <div class="status-icon">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 14.76V3.5a2.5 2.5 0 0 0-5 0v11.26a4.5 4.5 0 1 0 5 0z"></path></svg>
            </div>
            <div class="status-title">SUHU TUBUH</div>
            <div class="status-value"><?= htmlspecialchars($obs_terbaru['suhu_tubuh'] ?? '-') ?> <span class="status-unit">°C</span></div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="status-card">
            <div class="status-icon">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
            </div>
            <div class="status-title">TEKANAN DARAH</div>
            <div class="status-value"><?= htmlspecialchars($obs_terbaru['tekanan_darah'] ?? '-') ?> <span class="status-unit">mmHg</span></div>
        </div>
    </div>
</div>

<div class="lab-card-wrapper">
    <div class="lab-header">
        <h4 class="lab-title">HASIL LABORATORIUM</h4>
        <div class="lab-update">Update : <?= isset($lab['tgl_isi']) ? date('d M Y H:i', strtotime($lab['tgl_isi'])) : 'Belum ada data' ?></div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="lab-item-box">
                <div class="lab-item-title">PH DARAH</div>
                <div class="lab-item-val"><?= htmlspecialchars($lab['ph_darah'] ?? '-') ?></div>
                <div class="lab-item-status"><?= isset($lab['ph_darah']) ? 'TERCATAT' : '-' ?></div>
            </div>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="lab-item-box">
                <div class="lab-item-title">HB</div>
                <div class="lab-item-val"><?= htmlspecialchars($lab['hb'] ?? '-') ?></div>
                <div class="lab-item-status"><?= isset($lab['hb']) ? 'TERCATAT' : '-' ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="lab-item-box">
                <div class="lab-item-title">GULA DARAH</div>
                <div class="lab-item-val"><?= htmlspecialchars($lab['gula_darah'] ?? '-') ?></div>
                <div class="lab-item-status"><?= isset($lab['gula_darah']) ? 'TERCATAT' : '-' ?></div>
            </div>
        </div>
    </div>
</div>