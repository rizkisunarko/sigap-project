<?php
// Kalkulasi untuk Total Bed Terpakai
$terpakai = $data['pasien_aktif'];
$kapasitas = $data['kapasitas']; 
$persentaseBed = ($kapasitas > 0) ? round(($terpakai / $kapasitas) * 100) : 0;
?>

<div class="mb-4">
    <h1 class="header-title">Shift <?= htmlspecialchars($userShift) ?> <?= htmlspecialchars($userRole) ?></h1>
    <p class="mb-0" style="font-size: 0.85rem; color: #444;"><?= date('l, d M Y') ?></p>
</div>

<div class="row g-4 mb-5" style="max-width: 900px;">
    <div class="col-md-4">
        <div class="card stat-card h-100 p-4">
            <div class="text-uppercase mb-2" style="font-size: 0.7rem; font-weight: 700; color: #111;">TOTAL PASIEN AKTIF</div>
            <div class="value-huge mb-4"><?= str_pad($terpakai, 2, '0', STR_PAD_LEFT) ?></div>
            <div class="mt-auto" style="font-size: 0.65rem; font-weight: 700; color: #555;">KAPASITAS : <?= htmlspecialchars($kapasitas) ?> BED</div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card stat-card h-100 p-4">
            <div class="text-uppercase mb-2" style="font-size: 0.7rem; font-weight: 700; color: #111;">KONDISI PASIEN BURUK</div>
            <div class="value-huge text-danger mb-4"><?= str_pad($data['pasien_kritis'] ?? 0, 2, '0', STR_PAD_LEFT) ?></div>
            <div class="mt-auto" style="font-size: 0.65rem; font-weight: 700; color: #555;">LIHAT PASIEN &rarr;</div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card stat-card h-100 p-4">
            <div class="text-uppercase mb-2" style="font-size: 0.7rem; font-weight: 700; color: #111;">TOTAL BED TERPAKAI</div>
            <div class="value-huge mb-3"><?= $terpakai ?> / <?= $kapasitas ?></div>
            <div class="mt-auto">
                <div class="progress-bar-custom" style="background-color: #eaeaea; border-radius: 4px; height: 8px; width: 100%;">
                    <div class="progress-bar-fill" style="width: <?= $persentaseBed ?>%; background-color: #dc3545; height: 100%; border-radius: 4px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<h6 class="section-title">KETERSEDIAAN BED</h6>
<div class="card stat-card p-0 mb-5 overflow-hidden" style="max-width: 1000px; border-radius: 6px;">
    <div style="max-height: 350px; overflow-y: auto;">
        <table class="table table-custom mb-0">
            <thead style="position: sticky; top: 0; z-index: 1; background-color: #f8f9fa;">
                <tr>
                    <th class="ps-4" style="width: 50%; padding: 15px;">NO.RANJANG</th>
                    <th class="pe-4" style="width: 50%; padding: 15px;">STATUS</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data['beds'])): ?>
                    <?php foreach ($data['beds'] as $bed): ?>
                        <tr>
                            <td class="ps-4" style="padding: 12px 15px; border-bottom: 1px solid #eaeaea;">
                                <?= htmlspecialchars($bed['nomor_bed']) ?>
                            </td>
                            <td class="pe-4" style="padding: 12px 15px; border-bottom: 1px solid #eaeaea;">
                                <?php 
                                    $statusBed = strtoupper($bed['status_bed'] ?? 'TERSEDIA');
                                    // Memberi indikator warna agar lebih jelas
                                    $warnaStatus = ($statusBed === 'TERPAKAI') ? '#dc3545' : '#198754';
                                ?>
                                <span style="color: <?= $warnaStatus ?>; font-weight: 700;">
                                    <?= $statusBed ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td class="ps-4" colspan="2" style="padding: 20px;">Tidak ada data bed.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<h6 class="section-title">ANTREAN MASUK</h6>
<div class="card stat-card p-0 mb-5 overflow-hidden" style="max-width: 750px; border-radius: 6px;">
    <div style="max-height: 250px; overflow-y: auto;">
        <table class="table table-custom mb-0">
            <thead style="position: sticky; top: 0; z-index: 1; background-color: #f8f9fa;">
                <tr>
                    <th class="ps-4" style="width: 30%; padding: 15px;">NO.PASIEN</th>
                    <th style="width: 70%; padding: 15px;">NAMA PASIEN</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data['queue'])): ?>
                    <?php $idx = 1; foreach ($data['queue'] as $q): ?>
                        <tr>
                            <td class="ps-4" style="padding: 12px 15px; border-bottom: 1px solid #eaeaea;">
                                <?= str_pad($idx++, 3, '0', STR_PAD_LEFT) ?>
                            </td>
                            <td style="padding: 12px 15px; border-bottom: 1px solid #eaeaea;">
                                <?= htmlspecialchars($q['nama_lengkap']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td class="ps-4" colspan="2" style="padding: 20px;">Tidak ada antrean hari ini.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<h6 class="section-title">TUGAS SHIFT</h6>
<div class="card stat-card p-0 mb-5 overflow-hidden" style="max-width: 850px; border-radius: 6px;">
    <div style="max-height: 300px; overflow-y: auto;">
        <table class="table table-custom mb-0">
            <thead style="position: sticky; top: 0; z-index: 1; background-color: #f8f9fa;">
                <tr>
                    <th class="ps-4" style="width: 60%; padding: 15px;">DESKRIPSI TUGAS</th>
                    <th style="width: 20%; padding: 15px; text-align: center;">TENGGAT</th>
                    <th class="pe-4" style="width: 20%; padding: 15px; text-align: center;">STATUS</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data['tasks'])): ?>
                    <?php foreach ($data['tasks'] as $task): ?>
                        <?php 
                            $id_tugas = $task['id_detail_s'] ?? ''; 
                            $isChecked = ($task['status_dilakukan'] === 'sudah') ? 'checked' : '';
                            // Tambahkan class opacity-50 dari Tailwind jika sudah selesai agar terlihat redup
                            $textClass = ($task['status_dilakukan'] === 'sudah') ? 'line-through opacity-50' : '';
                        ?>
                        <tr>
                            <td class="ps-4 task-text <?= $textClass ?> transition-all duration-300" style="padding: 12px 15px; border-bottom: 1px solid #eaeaea;">
                                <?= htmlspecialchars($task['tugas_shift'] ?? '') ?>
                            </td>
                            <td style="padding: 12px 15px; border-bottom: 1px solid #eaeaea; text-align: center; font-weight: 600;">
                                <?= isset($task['tenggat']) ? date('H.i', strtotime($task['tenggat'])) . ' WIB' : '-' ?>
                            </td>
                            <td class="pe-4" style="padding: 12px 15px; border-bottom: 1px solid #eaeaea;">
                                <div class="d-flex justify-content-center align-items-center h-100">
                                    <input type="checkbox" class="task-checkbox cursor-pointer" data-idtugas="<?= htmlspecialchars($id_tugas) ?>" style="width: 18px; height: 18px; accent-color: #20c997;" <?= $isChecked ?>>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td class="ps-4" colspan="3" style="padding: 20px;">Tidak ada tugas untuk shift ini.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const taskCheckboxes = document.querySelectorAll('.task-checkbox');
        
        taskCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const row = this.closest('tr');
                const taskText = row.querySelector('.task-text');
                const idTugas = this.getAttribute('data-idtugas');
                const isChecked = this.checked;
                
                // Efek visual langsung
                if (isChecked) {
                    taskText.classList.add('line-through', 'opacity-50');
                } else {
                    taskText.classList.remove('line-through', 'opacity-50');
                }

                // Kirim update ke server
                if(idTugas) {
                    fetch('<?= BASEURL; ?>/perawat/TugasShift', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `id_tugas=${idTugas}&status=${isChecked ? 'Selesai' : 'Belum Selesai'}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(!data.sukses) {
                            // Jika database gagal, batalkan centang
                            this.checked = !isChecked;
                            taskText.classList.toggle('line-through');
                            taskText.classList.toggle('opacity-50');
                        }
                    })
                    .catch(error => {
                        this.checked = !isChecked;
                        taskText.classList.toggle('line-through');
                        taskText.classList.toggle('opacity-50');
                    });
                }
            });
        });
    });
</script>