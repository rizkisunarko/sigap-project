<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../models/User.php';

class AuthController extends Controller {
    
    public function index() {
        $this->login();
    }

    // Pindah ke halaman login
    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Jika sudah login, langsung dialihkan ke dashboard keluarga (Bypass Form)
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/keluarga/dashboard');
            exit;
        }

        $this->view('auth/login'); 
    }

    // Nama method disesuaikan dengan rute web.php milik tim
    public function loginProcess() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Tangkap data dari form (Logika pengecekan milikmu)
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                $_SESSION['error'] = 'Username dan password wajib diisi!';
                header("Location: " . BASEURL . "/auth/login");
                exit;
            } 
            
            $userModel = new UserModel();
            $pesanModel = "";
            $dataUser = []; 
            
            // Meminta Model untuk melakukan verifikasi sesuai dengan fungsi di UserModel-mu
            $userModel->verifikasiUser($username, $password, $pesanModel, $dataUser);

            // Jika pesan berhasil, sesi akan aktif
            if ($pesanModel === "Berhasil") {
                $_SESSION['user_id'] = $dataUser['id_pengguna'];
                $_SESSION['username'] = $dataUser['username'];
                
                header("Location: " . BASEURL . "/keluarga/dashboard");
                exit;
            } else {
                // Tangkap pesan eror dan simpan ke sesi untuk halaman login
                $_SESSION['error'] = $pesanModel;
                header("Location: " . BASEURL . "/auth/login");
                exit;
            }
        } else {
            header("Location: " . BASEURL . "/auth/login");
            exit;
        }
    }

    // Menggunakan mekanisme logout milikmu yang sangat aman
    public function logout() {
        // 1. Pastikan mesin sesi berjalan agar kita bisa menghancurkannya
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // 2. Kosongkan semua data di dalam sesi
        $_SESSION = [];

        // 3. Hancurkan sesinya secara total dari server
        session_destroy();

        // 4. Arahkan pengguna kembali ke halaman login
        header("Location: " . BASEURL . "/auth/login");
        exit;
    }
}