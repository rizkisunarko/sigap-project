<?php
$userName = !empty($_SESSION['user']['nama']) ? $_SESSION['user']['nama'] : 'FIRMANSYAH';
$userRole = !empty($_SESSION['user']['role']) ? $_SESSION['user']['role'] : 'FRONT OFFICER';
$userShift = !empty($_SESSION['user']['shift']) ? $_SESSION['user']['shift'] : 'Shift 2';
?>

<div class="mb-4">
    <h1 class="header-title">Shift <?= htmlspecialchars($userShift) ?> <?= htmlspecialchars($userRole) ?></h1>
    <p class="mb-0" style="font-size: 0.85rem; color: #444;"><?= date('l, d M Y') ?></p>
</div>

<div class="row g-4 mb-5" style="max-width: 900px;">
    <div class="col-md-4">
        <div class="card stat-card h-100 p-4">
            <div class="text-uppercase mb-2" style="font-size: 0.7rem; font-weight: 700; color: #111;">TOTAL PASIEN AKTIF</div>
            <div class="value-huge mb-4"><?= str_pad($data['pasien_aktif'] ?? 0, 2, '0', STR_PAD_LEFT) ?></div>
            <div class="mt-auto" style="font-size: 0.65rem; font-weight: 700; color: #555;">KAPASITAS : <?= htmlspecialchars($data['kapasitas'] ?? 0) ?> BED</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card h-100 p-4">
            <div class="text-uppercase mb-2" style="font-size: 0.7rem; font-weight: 700; color: #111;">KONDISI PASIEN KRITIS</div>
            <div class="value-huge text-danger mb-4"><?= str_pad($data['pasien_kritis'] ?? 0, 2, '0', STR_PAD_LEFT) ?></div>
            <div class="mt-auto" style="font-size: 0.65rem; font-weight: 700; color: #555;">LIHAT PASIEN &rarr;</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card h-100 p-4">
            <div class="text-uppercase mb-2" style="font-size: 0.7rem; font-weight: 700; color: #111;">STATUS LOGISTIK OKSIGEN</div>
            <div class="value-huge mb-3">92%</div>
            <div class="mt-auto">
                <div class="progress-bar-custom">
                    <div class="progress-bar-fill" style="width: 92%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<h6 class="section-title">KETERSEDIAAN BED</h6>
<div class="card stat-card p-0 mb-5 overflow-hidden" style="max-width: 1000px; border-radius: 6px;">
    <table class="table table-custom mb-0">
        <thead>
            <tr>
                <th class="ps-4" style="width: 15%;">NO.RANJANG</th>
                <th style="width: 60%;">DESKRIPSI</th>
                <th class="pe-4" style="width: 25%;">STATUS</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data['beds'])): ?>
                <?php foreach ($data['beds'] as $bed): ?>
                    <tr>
                        <td class="ps-4"><?= htmlspecialchars($bed['nomor_bed']) ?></td>
                        <td><span class="desk"><?= htmlspecialchars($bed['detail_status']) ?></span></td>
                        <td class="pe-4"><?= strtoupper($bed['status_bed']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td class="ps-4" colspan="3">Tidak ada data bed.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<h6 class="section-title">ANTREAN MASUK</h6>
<div class="card stat-card p-0 mb-5 overflow-hidden" style="max-width: 750px; border-radius: 6px;">
    <table class="table table-custom mb-0">
        <thead>
            <tr>
                <th class="ps-4" style="width: 20%;">NO.PASIEN</th>
                <th style="width: 50%;">NAMA PASIEN</th>
                <th class="pe-4" style="width: 30%;">URGENSI</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data['queue'])): ?>
                <?php $idx = 1; foreach ($data['queue'] as $q): ?>
                    <tr>
                        <td class="ps-4"><?= str_pad($idx++, 3, '0', STR_PAD_LEFT) ?></td>
                        <td><?= htmlspecialchars($q['nama_lengkap']) ?></td>
                        <td class="pe-4 text-urgensi"><?= strtoupper($q['urgensi']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td class="ps-4" colspan="3">Tidak ada antrean hari ini.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="card stat-card p-4" style="max-width: 650px; border-radius: 6px;">
    <h6 class="section-title mb-4">TUGAS SHIFT</h6>
    
    <div class="d-flex justify-content-between px-3" style="font-size: 0.7rem; font-weight: 700; color: #111; margin-bottom: 8px;">
        <div style="width: 50%;">TUGAS</div>
        <div style="width: 30%; text-align: center;">TENGGAT</div>
        <div style="width: 20%; text-align: center;">STATUS</div>
    </div>

    <?php if (!empty($data['tasks'])): ?>
        <?php foreach ($data['tasks'] as $task): ?>
            <div class="task-card">
                <div class="task-text <?= ($task['status_dilakukan'] === 'sudah') ? 'task-checked' : '' ?>" style="width: 50%; font-size: 0.8rem; font-weight: 600; transition: all 0.3s;"><?= htmlspecialchars($task['tugas_shift']) ?></div>
                <div style="width: 30%; text-align: center; font-size: 0.8rem; font-weight: 600;"><?= date('H.i', strtotime($task['tenggat'])) ?> WIB</div>
                <div style="width: 20%; display: flex; justify-content: center;">
                    <input type="checkbox" class="task-checkbox" style="width: 18px; height: 18px; cursor: pointer; border-radius: 4px;" <?= ($task['status_dilakukan'] === 'sudah') ? 'checked' : '' ?>>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const taskCheckboxes = document.querySelectorAll('.task-checkbox');
        taskCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const taskCard = this.closest('.task-card');
                const taskText = taskCard.querySelector('.task-text');
                if (this.checked) {
                    taskText.classList.add('task-checked');
                } else {
                    taskText.classList.remove('task-checked');
                }
            });
        });
    });
</script>