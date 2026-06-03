<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../models/User.php';

class AuthController extends Controller {
    
    public function index() {
        $this->login();
    }

    public function reset(){
        $this->view('auth/reset_password');
    }

    public function verif() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['reset_akun'])) {
            header("Location: " . BASEURL . "/auth/reset");
            exit;
        }

        $this->view('auth/Cabang_reset/verifikasi_otp');
    }

    public function prosesKirimOtp() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');

            if (empty($username)) {
                $_SESSION['error'] = 'Username wajib diisi!';
                header("Location: " . BASEURL . "/auth/reset");
                exit;
            }

            $db = new Database();
            $conn = $db->connect();

            $query = "SELECT ap.id_pengguna, ap.username, dp.id_pasien, wp.no_hp 
                      FROM akun_pengguna ap 
                      JOIN data_diri_pasien dp ON ap.id_pengguna = dp.id_pengguna 
                      JOIN data_diri_pengantar wp ON dp.id_pasien = wp.id_pasien 
                      WHERE ap.username = :username LIMIT 1";
            
            $stmt = $conn->prepare($query);
            $stmt->execute(['username' => $username]);
            $dataPengguna = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($dataPengguna && !empty($dataPengguna['no_hp'])) {
                $no_hp = $dataPengguna['no_hp'];
                $otp = random_int(1000, 9999);
                $waktu_kedaluwarsa = time() + 60; 
                
                $panjang_no = strlen($no_hp);
                $no_tersamar = str_repeat('x', $panjang_no - 4) . substr($no_hp, -4);

                $pesanWA = "*[SIGAP - RESET PASSWORD]*\n\n";
                $pesanWA .= "Kode OTP Anda adalah: *{$otp}*\n";
                $pesanWA .= "Kode ini berlaku selama 60 detik. Jangan berikan kode ini kepada siapa pun.";

                require_once __DIR__ . '/BotController.php'; 
                $bot = new BotController();
                $responBot = $bot->prosesKirimWA($no_hp, $pesanWA);

                if ($responBot['http_code'] == 200) {
                    $_SESSION['reset_akun'] = [
                        'username' => $username,
                        'id_pengguna' => $dataPengguna['id_pengguna'],
                        'no_tersamar' => $no_tersamar,
                        'otp' => $otp,
                        'expired_at' => $waktu_kedaluwarsa
                    ];
                    header("Location: " . BASEURL . "/reset/verif");
                    exit;
                } else {
                    $_SESSION['error'] = 'Sistem gagal mengirim kode OTP ke WhatsApp.';
                    header("Location: " . BASEURL . "/auth/reset");
                    exit;
                }
            } else {
                $_SESSION['error'] = 'Username tidak ditemukan atau nomor HP tidak terdaftar.';
                header("Location: " . BASEURL . "/auth/reset");
                exit;
            }
        }
    }

    public function verifikasiOtp() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['reset_akun'])) {
            header("Location: " . BASEURL . "/auth/reset");
            exit;
        }

        $this->view('auth/Cabang_reset/verifikasi_otp');
    }

    public function prosesVerifikasiOtp() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!isset($_SESSION['reset_akun'])) {
                header("Location: " . BASEURL . "/auth/reset");
                exit;
            }

            $otp_input = ($_POST['otp1'] ?? '') . ($_POST['otp2'] ?? '') . ($_POST['otp3'] ?? '') . ($_POST['otp4'] ?? '');
            
            $otp_asli = $_SESSION['reset_akun']['otp'];
            $expired_at = $_SESSION['reset_akun']['expired_at'];

            if (time() > $expired_at) {
                $_SESSION['error'] = 'Kode OTP sudah kedaluwarsa. Silakan minta ulang.';
                header("Location: " . BASEURL . "/reset/verif");
                exit;
            }

            if ($otp_input != $otp_asli) {
                $_SESSION['error'] = 'Kode OTP salah. Silakan periksa kembali.';
                header("Location: " . BASEURL . "/reset/verif");
                exit;
            }

            $_SESSION['reset_akun']['terverifikasi'] = true;

            header("Location: " . BASEURL . "/reset/password_baru");
            exit;
        }
    }

    public function passwordBaru() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['reset_akun']['terverifikasi']) || $_SESSION['reset_akun']['terverifikasi'] !== true) {
            header("Location: " . BASEURL . "/auth/reset");
            exit;
        }

        $this->view('auth/Cabang_reset/password_baru');
    }

    public function prosesUbahPassword() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['reset_akun']['terverifikasi']) || $_SESSION['reset_akun']['terverifikasi'] !== true) {
                header("Location: " . BASEURL . "/auth/reset");
                exit;
            }

            $password_baru = $_POST['password'] ?? '';
            $konfirmasi_password = $_POST['konfirmasi_password'] ?? '';
            $errors = [];

            if ($err = $this->cekWajib($password_baru, 'Password')) {
                $errors['password'] = $err;
            } elseif ($err = $this->cekMinKarakter($password_baru, 8, 'Password')) {
                $errors['password'] = $err;
            } elseif ($err = $this->cekMengandungHurufBesar($password_baru, 'Password')) {
                $errors['password'] = $err;
            } elseif ($err = $this->cekMengandungAngka($password_baru, 'Password')) {
                $errors['password'] = $err;
            }

            if (empty($errors['password']) && $password_baru !== $konfirmasi_password) {
                $errors['password'] = 'Konfirmasi password tidak cocok dengan password baru.';
            }

            if (!empty($errors)) {

                $_SESSION['error'] = $errors['password'];
                header("Location: " . BASEURL . "/reset/password_baru");
                exit;
            }

            $db = new Database();
            $conn = $db->connect();
            
            $id_pengguna = $_SESSION['reset_akun']['id_pengguna'];
            $hashed_password = password_hash($password_baru, PASSWORD_BCRYPT);

            $stmt = $conn->prepare("UPDATE akun_pengguna SET password = :password WHERE id_pengguna = :id");
            $stmt->execute(['password' => $hashed_password, 'id' => $id_pengguna]);

            unset($_SESSION['reset_akun']);

            $_SESSION['success'] = 'Password berhasil diperbarui! Silakan login.';
            header("Location: " . BASEURL . "/auth/login");
            exit;
        }
    }

    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/keluarga/dashboard');
            exit;
        }

        $this->view('auth/login'); 
    }


    public function loginProcess() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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

            $userModel->verifikasiUser($username, $password, $pesanModel, $dataUser);

            if ($pesanModel === "Berhasil") {
                $_SESSION['user_id'] = $dataUser['id_pengguna'];
                $_SESSION['username'] = $dataUser['username'];
                
                header("Location: " . BASEURL . "/keluarga/dashboard");
                exit;
            } else {
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
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
        header("Location: " . BASEURL . "/auth/login");
        exit;
    }
}