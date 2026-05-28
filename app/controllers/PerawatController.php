<?php
require_once __DIR__ . '/../../core/Controller.php';

class PerawatController extends Controller {
    
    public function login() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Jika perawat sudah punya KTP Sesi, langsung tendang ke dashboard (Bypass Form)
        if (isset($_SESSION['perawat_id'])) {
            header('Location: ' . BASEURL . '/perawat/dashboard');
            exit;
        }

        $this->view('portal-staff/login');
    }

    public function prosesLogin() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama_input = trim($_POST['namaLengkap'] ?? '');
            $divisi     = trim($_POST['divisi'] ?? '');
            $shift      = trim($_POST['shift'] ?? '');

            // -------------------------------------------------------------
            // VERIFIKASI 2 LANGKAH (IDE RAHASIAMU: CEK SUFFIX "-staff")
            // -------------------------------------------------------------
            // str_ends_with() akan mengecek apakah string diakhiri teks tertentu
            if (!str_ends_with(strtolower($nama_input), '-staff')) {
                $_SESSION['error_staff'] = '*Data yang anda masukkan tidak sesuai.';
                header("Location: " . BASEURL . "/division/FOR-255");
                exit;
            }

            // Jika lolos pengecekan suffix, kita harus membuang "-staff" tersebut 
            // agar bisa dicocokkan dengan nama asli di database.
            // Contoh: "Rolmed Medi-staff" diubah menjadi "Rolmed Medi"
            $nama_asli = trim(str_ireplace('-staff', '', $nama_input));

            // -------------------------------------------------------------
            // VALIDASI DATABASE
            // -------------------------------------------------------------
            require_once __DIR__ . '/../models/Perawat.php';
            $model = new PerawatModel();
            
            // Kita panggil fungsi Check-In yang baru saja kita buat
            $dataPerawat = $model->prosesCheckInPerawat($nama_asli, $divisi, $shift);

            if ($dataPerawat) {
                // BERHASIL! Cetak KTP Sesi
                $_SESSION['perawat_id']   = $dataPerawat['id_perawat'];
                $_SESSION['perawat_nama'] = $dataPerawat['nama_lengkap'];
                
                header("Location: " . BASEURL . "/perawat/dashboard");
                exit;
            } else {
                // GAGAL! Tetap gunakan pesan ambigu
                $_SESSION['error_staff'] = 'Data yang anda masukkan tidak sesuai.';
                header("Location: " . BASEURL . "/division/FOR-255");
                exit;
            }
        }
    }
}