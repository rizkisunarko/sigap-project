<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../models/Pendaftaran.php';
class AuthController extends Controller {
    public function index() {
        // Memanggil view
        echo 'Ini halaman index dari AuthController';
    }

    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            $pendaftaranModel = new PendaftaranModel();
            $user = call_user_func([$pendaftaranModel, 'verifikasiLoginKeluarga'], $username, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['id_pengguna'];
                $_SESSION['username'] = $user['username'];
                unset($_SESSION['login_error']);
                header('Location: ' . BASEURL . '/keluarga/dashboard');
                exit;
            }

            $_SESSION['login_error'] = 'Username atau Password salah atau tidak ditemukan!';
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }

        $this->view('auth/login');
    }
}
