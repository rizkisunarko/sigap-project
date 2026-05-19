<?php
require_once __DIR__ . '/../../core/Controller.php';
class DashboardController extends Controller {
    public function index() {
        // Memanggil view
        echo 'Ini halaman index dari DashboardController';
    }
}
