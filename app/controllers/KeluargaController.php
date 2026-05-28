<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../models/Pasien.php';
require_once __DIR__ . '/../models/Pemeriksaan.php';

class KeluargaController extends Controller {
    public function index() {
        $this->dashboard();
    }

    public function dashboard() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verifikasi login keluarga
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }

        $id_pengguna = $_SESSION['user_id'];
        
        $db = new Database();
        $conn = $db->connect();

        // 1. Ambil data diri pasien terkait id_pengguna
        $stmtPasien = $conn->prepare("SELECT * FROM data_diri_pasien WHERE id_pengguna = :id_pengguna LIMIT 1");
        $stmtPasien->execute(['id_pengguna' => $id_pengguna]);
        $patient = $stmtPasien->fetch(PDO::FETCH_ASSOC);

        $data = [
            'patient' => $patient,
            'latest_obs' => null,
            'developments' => [],
            'lab_results' => null
        ];

        if ($patient) {
            $id_pasien = $patient['id_pasien'];

            // 2. Dapatkan rekam medis aktif terbaru untuk pasien ini
            $stmtRM = $conn->prepare("SELECT * FROM rekam_medis WHERE id_pasien = :id_pasien ORDER BY tanggal_masuk DESC LIMIT 1");
            $stmtRM->execute(['id_pasien' => $id_pasien]);
            $activeRM = $stmtRM->fetch(PDO::FETCH_ASSOC);

            if ($activeRM) {
                $id_rekam_medis = $activeRM['id_rekam_medis'];
                $data['rekam_medis'] = $activeRM;

                // 3. Dapatkan riwayat perkembangan pasien (seluruh observasi)
                $pasienModel = new PasienModel();
                $developments = $pasienModel->riwayatPerkembanganPasien($id_rekam_medis);
                $data['developments'] = $developments;

                // 4. Jika ada observasi, ambil observasi terbaru sebagai status klinis saat ini
                if (!empty($developments)) {
                    // Yang paling akhir di list adalah observasi terbaru
                    $latestObs = $developments[count($developments) - 1];
                    $data['latest_obs'] = $latestObs;

                    // Dapatkan ID observasi terbaru dari DB untuk menarik hasil laboratorium
                    $stmtLatestObsId = $conn->prepare("SELECT id_observasi FROM observasi_pasien WHERE id_rekam_medis = :id_rekam_medis ORDER BY waktu_catat DESC LIMIT 1");
                    $stmtLatestObsId->execute(['id_rekam_medis' => $id_rekam_medis]);
                    $latestObsRow = $stmtLatestObsId->fetch(PDO::FETCH_ASSOC);

                    if ($latestObsRow) {
                        $id_observasi = $latestObsRow['id_observasi'];

                        // Dapatkan hasil lab terbaru untuk observasi tersebut
                        $stmtLab = $conn->prepare("SELECT * FROM hasil_lab WHERE id_observasi = :id_observasi ORDER BY tgl_isi DESC LIMIT 1");
                        $stmtLab->execute(['id_observasi' => $id_observasi]);
                        $labResult = $stmtLab->fetch(PDO::FETCH_ASSOC);
                        if ($labResult) {
                            $data['lab_results'] = $labResult;
                        }
                    }
                }
            }
        }

        // Render view dashboard keluarga dengan data
        $this->view('keluarga/dashboard', $data);
    }
}
