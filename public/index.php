<?php
// Ini adalah Entry Point. Semua request masuk dari sini.
// Pastikan konfigurasi dan konstanta (BASEURL) didefinisikan sebelum view diload
require_once __DIR__ . '/../config/app.php';
// Load core router
require_once __DIR__ . '/../core/Router.php';

// Jalankan aplikasi
Router::run();
