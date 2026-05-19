<?php
require_once __DIR__ . '/../../core/Controller.php';
class KeluargaController extends Controller {
    public function index() {
        // Memanggil view
        echo 'Ini halaman index dari KeluargaController';
    }

    public function dashboard() {
        $this->view('keluarga/dashboard');
    }
}
