<?php
require_once __DIR__ . '/../../core/Controller.php';
class AuthController extends Controller {
    public function index() {
        $this->login();
    }

    public function login() {
        $this->view('auth/login');
    }

    public function loginProcess() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';

        $userModel = new UserModel();
        $user = $userModel->verifikasiLogin($username, $password);

        if ($user) {
            $_SESSION['user_id'] = $user['id_pengguna'];
            $_SESSION['username'] = $user['username'];
            
            header('Location: ' . BASEURL . '/keluarga/dashboard');
            exit;
        } else {
            // Tampilkan kembali form login dengan pesan kesalahan
            $data = ['error' => 'Username atau Password salah!'];
            $this->view('auth/login', $data);
        }
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: ' . BASEURL . '/auth/login');
        exit;
    }
}
