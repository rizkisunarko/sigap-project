<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../models/Pendaftaran.php';
require_once __DIR__ . '/../models/Pasien.php';
require_once __DIR__ . '/../models/KeluargaPasien.php';
require_once __DIR__ . '/../models/RekamMedis.php';

class PendaftaranController extends Controller {
    public function index() {
        $this->pilihJalur();
    }

    public function pilihJalur() {
        $this->view('pendaftaran/pilih_jalur');
    }

    public function form() {
        $this->view('pendaftaran/form');
    }

    // Handle form submission, save accounts, patients, wali, and signature image
    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASEURL . '/pendaftaran/form');
            exit;
        }

        // 1. Ambil input Akun
        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';

        if (empty($username) || empty($password)) {
            echo 'Username dan Password wajib diisi.';
            return;
        }

        // 2. Daftarkan Akun via PendaftaranModel
        $pendaftaranModel = new PendaftaranModel();
        $msg = '';
        $id_pengguna = $pendaftaranModel->daftarAkun($username, $password, $msg);

        if (!$id_pengguna) {
            echo 'Gagal mendaftar akun: ' . htmlspecialchars($msg);
            return;
        }

        // 3. Ambil input Data Pasien
        $nik = isset($_POST['nik']) ? trim($_POST['nik']) : '';
        $nama_pasien = isset($_POST['nama_pasien']) ? trim($_POST['nama_pasien']) : '';
        $asal = isset($_POST['asal']) ? trim($_POST['asal']) : '';
        $tgl_lahir = isset($_POST['tgl_lahir']) ? $_POST['tgl_lahir'] : '';
        $jk_raw = isset($_POST['jk']) ? $_POST['jk'] : '';
        $jenis_kelamin = ($jk_raw === 'Perempuan' || $jk_raw === 'P') ? 'P' : 'L';
        $agama = isset($_POST['agama']) ? trim($_POST['agama']) : '';
        $status_perkawinan = isset($_POST['status_perkawinan']) ? trim($_POST['status_perkawinan']) : '';
        $pekerjaan = isset($_POST['pekerjaan']) ? trim($_POST['pekerjaan']) : '';
        $alamat = isset($_POST['alamat']) ? trim($_POST['alamat']) : '';
        $bpjs = isset($_POST['bpjs']) ? trim($_POST['bpjs']) : '';
        $gol_darah = isset($_POST['gol_darah']) ? trim($_POST['gol_darah']) : '';
        $kewarganegaraan = isset($_POST['kewarganegaraan']) ? trim($_POST['kewarganegaraan']) : '';
        $alergi = isset($_POST['alergi']) ? trim($_POST['alergi']) : '';

        // Simpan Data Pasien
        $pasienModel = new PasienModel();
        $pasienModel->isiDataDiriPasien(
            $nama_pasien, $nik, $asal, $tgl_lahir, $jenis_kelamin,
            $agama, $status_perkawinan, $alamat, $bpjs, $gol_darah,
            $kewarganegaraan, $pekerjaan, $id_pengguna
        );

        // Ambil ID Pasien yang baru saja dimasukkan
        // Karena PasienModel tidak langsung mereturn ID, kita dapatkan dari DB connection
        // Kita modifikasi database connection atau query untuk mencarinya.
        // Let's get it by query: SELECT id_pasien FROM data_diri_pasien WHERE id_pengguna = :id_pengguna
        $db = new Database();
        $conn = $db->connect();
        $stmt = $conn->prepare("SELECT id_pasien FROM data_diri_pasien WHERE id_pengguna = :id_pengguna LIMIT 1");
        $stmt->execute(['id_pengguna' => $id_pengguna]);
        $resPasien = $stmt->fetch(PDO::FETCH_ASSOC);
        $id_pasien = $resPasien ? $resPasien['id_pasien'] : null;

        if (!$id_pasien) {
            echo 'Gagal mendapatkan ID Pasien untuk wali.';
            return;
        }

        // Simpan alergi jika ada
        if (!empty($alergi)) {
            // Cek apakah alergi sudah terdaftar di data_alergi, jika belum tambahkan
            $stmtAlergi = $conn->prepare("SELECT id_alergi FROM data_alergi WHERE nama_alergi = :nama LIMIT 1");
            $stmtAlergi->execute(['nama' => $alergi]);
            $resAlergi = $stmtAlergi->fetch(PDO::FETCH_ASSOC);
            if ($resAlergi) {
                $id_alergi = $resAlergi['id_alergi'];
            } else {
                $insAlergi = $conn->prepare("INSERT INTO data_alergi (nama_alergi) VALUES (:nama)");
                $insAlergi->execute(['nama' => $alergi]);
                $id_alergi = $conn->lastInsertId();
            }
            // Kaitkan alergi dengan pasien
            $pasienModel->tambahAlergiPasien($id_pasien, $id_alergi);
        }

        // 4. Ambil input Data Wali / Pengantar
        $nama_wali = isset($_POST['nama_wali']) ? trim($_POST['nama_wali']) : '';
        $status_wali = isset($_POST['status_wali']) ? trim($_POST['status_wali']) : '';
        $nik_wali = isset($_POST['nik_wali']) ? trim($_POST['nik_wali']) : '';
        $nohp_wali = isset($_POST['nohp_wali']) ? trim($_POST['nohp_wali']) : '';
        $alamat_wali = isset($_POST['alamat_wali']) ? trim($_POST['alamat_wali']) : '';
        $ttd = isset($_POST['ttd_wali']) ? $_POST['ttd_wali'] : '';

        $filename = 'ttd_wali_default.png';

        if (!empty($ttd)) {
            // Save base64 signature
            $signDir = __DIR__ . '/../../public/assets/img/signatures';
            if (!is_dir($signDir)) {
                mkdir($signDir, 0755, true);
            }
            if (preg_match('/^data:image\/([a-zA-Z]+);base64,(.+)$/', $ttd, $matches)) {
                $ext = $matches[1];
                $data = $matches[2];
                $decoded = base64_decode($data);
                if ($decoded !== false) {
                    $filename = 'ttd_wali_' . $id_pasien . '_' . time() . '.' . $ext;
                    file_put_contents($signDir . '/' . $filename, $decoded);
                }
            }
        }

        // Simpan Data Pengantar / Wali
        $keluargaModel = new KeluargaPasienModel();
        $keluargaModel->isiDataDiriPengantar(
            $nama_wali, $status_wali, $nik_wali, $nohp_wali,
            $alamat_wali, $filename, $id_pasien
        );

        // 5. Buat Rekam Medis Awal untuk menempatkan pasien di antrean masuk perawat
        $rekamMedisModel = new RekamMedis();
        $rekamMedisModel->IsiRekamMedis($id_pasien, date('Y-m-d'), null, 'Tingkat 2');

        // Redirect ke login dengan penanda sukses
        header('Location: ' . BASEURL . '/auth/login?success=1');
        exit;
    }
}
