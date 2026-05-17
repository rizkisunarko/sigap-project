<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICU Central Specialist Hospital</title>
    
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/custom.css">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/landing.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center fw-bold text-primary-icu" href="<?= BASEURL; ?>">
            <img src="<?= BASEURL; ?>/assets/img/logo.png" alt="Logo" width="40" class="d-inline-block align-text-top me-2">
            HOSPITAL
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link active fw-medium px-3" href="#">Beranda</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#layanan">Layanan</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#panduan">Panduan Admisi</a></li>
                <li class="nav-item ms-2">
                    <a class="btn btn-icu-primary px-4 rounded-pill" href="<?= BASEURL; ?>/auth/login">Sign In</a>
                </li>
            </ul>
        </div>
    </div>
</nav>