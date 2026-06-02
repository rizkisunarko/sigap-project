<?php
$current_url = $_SERVER['REQUEST_URI'];
?>

<div class="sidebar d-flex flex-column flex-shrink-0">
    <div class="p-4 d-flex align-items-center gap-2 mb-2">
        <img src="<?= BASEURL; ?>/assets/img/logo.png" width="34" height="34" alt="Logo" class="d-inline-block align-text-top">
        <span class="fs-5 fw-bold" style="letter-spacing: 1px;">HOSPITAL</span>
    </div>
    
    <div class="flex-grow-1">
        <a href="<?= BASEURL; ?>/perawat/dashboard" 
           class="<?= strpos($current_url, '/perawat/dashboard') !== false ? 'active' : '' ?>">
           Dashboard
        </a>
        
        <a href="<?= BASEURL; ?>/perawat/input_data_pasien" 
           class="<?= strpos($current_url, '/perawat/input_data_pasien') !== false ? 'active' : '' ?>">
           Lihat Pasien Aktif
        </a>
        
        <a href="<?= BASEURL; ?>/perawat/tambah_pasien" 
           class="<?= strpos($current_url, '/perawat/tambah_pasien') !== false ? 'active' : '' ?>">
           Tambah Pasien
        </a>
        
        <a href="<?= BASEURL; ?>/perawat/direktori_pengguna" 
           class="<?= strpos($current_url, '/perawat/direktori_pengguna') !== false ? 'active' : '' ?>">
           Direktori Pengguna
        </a>
    </div>
    
    <div class="sidebar-bottom d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
            <div class="rounded-circle bg-dark text-white d-flex justify-content-center align-items-center" style="width: 32px; height: 32px; font-weight: bold; font-size: 0.9rem;">
                <?= htmlspecialchars($userInitial) ?>
            </div>
            <div style="line-height: 1.2;">
                <div class="fw-bold text-uppercase" style="font-size: 0.75rem; max-width: 140px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?= htmlspecialchars($userName) ?>">
                    <?= htmlspecialchars($userName) ?>
                </div>
                <div class="text-uppercase" style="font-size: 0.65rem; max-width: 140px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?= htmlspecialchars($userRole) ?>">
                    <?= htmlspecialchars($userRole) ?>
                </div>
            </div>
        </div>
        <i class="bi bi-gear-fill fs-6" style="cursor: pointer; color: black;" data-bs-toggle="modal" data-bs-target="#staffAccountModal"></i>
    </div>
</div>