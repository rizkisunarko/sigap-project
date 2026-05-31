<?php
require_once __DIR__ . '/../../core/Controller.php';

class KeluargaController extends Controller {
    
    public function index() {
        header('Location: ' . BASEURL . '/keluarga/dashboard');
        exit;
    }

    public function dashboard() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }

        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        $id_pengguna_aktif = $_SESSION['user_id'];

        require_once __DIR__ . '/../models/KeluargaPasien.php';
        $model = new KeluargaPasienModel();

        $data = [];
        $data['judul'] = 'Dashboard Keluarga - ICU Central Specialist Hospital';

        $data['pasien'] = $model->getDataPasienAktif($id_pengguna_aktif);

        if ($data['pasien'] && !empty($data['pasien']['id_rekam_medis'])) {
            $data['riwayat'] = $model->getRiwayatObservasi($data['pasien']['id_rekam_medis']);
            
            if (!empty($data['riwayat'])) {
                $id_observasi_terakhir = $data['riwayat'][0]['id_observasi'];
                $data['lab'] = $model->getHasilLabTerbaru($id_observasi_terakhir);
            } else {
                $data['lab'] = null;
            }
        } else {
            $data['riwayat'] = [];
            $data['lab'] = null;
        }

        $this->view('keluarga/dashboard', $data);
    }

    public function simpanPengantar() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once __DIR__ . '/../models/KeluargaPasien.php';
            $model = new KeluargaPasienModel();

            $nama_lengkap = trim($_POST['nama_lengkap'] ?? '');
            $status_wali  = trim($_POST['status_wali'] ?? '');
            $nik_wali     = trim($_POST['nik_wali'] ?? '');
            $no_hp        = trim($_POST['no_hp'] ?? '');
            $alamat       = trim($_POST['alamat'] ?? '');
            $dokumen_ttd  = trim($_POST['dokumen_ttd'] ?? '');
            $id_pasien    = trim($_POST['id_pasien'] ?? '');

            $model->isiDataDiriPengantar(
                $nama_lengkap, 
                $status_wali, 
                $nik_wali,
                $no_hp, 
                $alamat, 
                $dokumen_ttd, 
                $id_pasien
            );

            header('Location: ' . BASEURL . '/keluarga/dashboard?success=1');
            exit;
        }
    }

    public function updatePengantar() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once __DIR__ . '/../models/KeluargaPasien.php';
            $model = new KeluargaPasienModel();

            $id_pengantar = trim($_POST['id_pengantar'] ?? '');
            $nama_lengkap = trim($_POST['nama_lengkap'] ?? '');
            $status_wali  = trim($_POST['status_wali'] ?? '');
            $nik_wali     = trim($_POST['nik_wali'] ?? '');
            $no_hp        = trim($_POST['no_hp'] ?? '');
            $alamat       = trim($_POST['alamat'] ?? '');
            $dokumen_ttd  = trim($_POST['dokumen_ttd'] ?? '');
            $id_pasien    = trim($_POST['id_pasien'] ?? '');

            $model->editDataDiriPengantar(
                $id_pengantar,
                $nama_lengkap, 
                $status_wali, 
                $nik_wali,
                $no_hp, 
                $alamat, 
                $dokumen_ttd, 
                $id_pasien
            );

            header('Location: ' . BASEURL . '/keluarga/dashboard?updated=1');
            exit;
        }
    }
}
