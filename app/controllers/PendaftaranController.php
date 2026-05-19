<?php
require_once __DIR__ . '/../../core/Controller.php';
class PendaftaranController extends Controller {
    public function index() {
        // Memanggil view
        echo 'Ini halaman index dari PendaftaranController';
    }

    public function pilihJalur() {
        $this->view('pendaftaran/pilih_jalur');
    }

    public function form() {
        $this->view('pendaftaran/form');
    }
}
