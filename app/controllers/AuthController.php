<?php
require_once __DIR__ . '/../../core/Controller.php';
class AuthController extends Controller {
    public function index() {
        // Memanggil view
        echo 'Ini halaman index dari AuthController';
    }

    public function login() {
        $this->view('auth/login');
    }
}
