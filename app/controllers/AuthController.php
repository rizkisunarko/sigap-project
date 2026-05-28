<?php
require_once __DIR__ . '/../../core/Controller.php';

class AuthController extends Controller {
    
    // pipndah ke halaman login
    public function login() {
        $this->view('auth/login'); 
    }

    public function prosesLogin() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Tangkap data dari form
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                $_SESSION['error'] = 'Username dan password wajib diisi!';
                header("Location: " . BASEURL . "/auth/login");
                exit;
            } 
            
            
            // MEMANGGIL MODEL (Menggunakan UserModel)
            require_once __DIR__ . '/../models/User.php';
            $userModel = new UserModel();
            
            $pesanModel = "";
            $dataUser = []; 
            // Variabel kosong untuk menampung data dari Model
            
            // Controller meminta Model untuk melakukan verifikasi
            $userModel->verifikasiUser($username, $password, $pesanModel, $dataUser);

            // jika pesan berhasil, sessi akan aktif
            if ($pesanModel === "Berhasil") {
                // Pasang memori sesi dari array $dataUser yang diisi oleh Model
                $_SESSION['user_id'] = $dataUser['id_pengguna'];
                $_SESSION['username'] = $dataUser['username'];
                
                header("Location: " . BASEURL . "/keluarga/dashboard");
                exit;
            } else {
                // Tangkap pesan eror (Username atau Password salah)
                $_SESSION['error'] = $pesanModel;
                header("Location: " . BASEURL . "/auth/login");
                exit;
            }
        } else {
            header("Location: " . BASEURL . "/auth/login");
            exit;
        }
    }

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