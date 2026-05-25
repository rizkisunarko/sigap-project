<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../models/Perawat.php';
require_once __DIR__ . '/../models/Pasien.php';
require_once __DIR__ . '/../models/RekamMedis.php';
require_once __DIR__ . '/../models/KeluargaPasien.php';

class PerawatController extends Controller {

    public function portalLogin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user']['nama'])) {
            header('Location: ' . BASEURL . '/perawat/dashboard');
            exit;
        }
        $this->view('portal-staff/login');
    }

    public function portalLoginProcess() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $nama = isset($_POST['namaLengkap']) ? trim($_POST['namaLengkap']) : 'FIRMANSYAH';
        $divisi = isset($_POST['divisi']) ? $_POST['divisi'] : 'FRONT OFFICER';
        $shift = isset($_POST['shift']) ? $_POST['shift'] : 'Shift 2';

        $_SESSION['user'] = [
            'nama' => $nama,
            'role' => $divisi,
            'shift' => $shift
        ];

        header('Location: ' . BASEURL . '/perawat/dashboard');
        exit;
    }

    public function portalLogout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['user']);
        header('Location: ' . BASEURL . '/portal-staff/login');
        exit;
    }

    public function dashboard() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']['nama'])) {
            header('Location: ' . BASEURL . '/portal-staff/login');
            exit;
        }

        $perawatModel = new PerawatModel();
        
        // 1. Ambil statistik pasien & kapasitas bed
        $rawStats = $perawatModel->pasienAktif_kapasitasBed_pasienKritis();
        $pasien_aktif = isset($rawStats[0][0]['pasien_aktif']) ? $rawStats[0][0]['pasien_aktif'] : 0;
        $kapasitas = isset($rawStats[1][0]['kapasitas']) ? $rawStats[1][0]['kapasitas'] : 12;
        $pasien_kritis = isset($rawStats[2]['pasien_kritis']) ? $rawStats[2]['pasien_kritis'] : 0;

        // 2. Ketersediaan Bed
        $beds = $perawatModel->ketersediaanBed();

        // 3. Antrean Masuk
        $queue = $perawatModel->antreanMasuk();

        // 4. Tugas Shift (Ambil tugas dari shift saat ini)
        $tasks = [];
        $role = $_SESSION['user']['role'];
        $shiftData = $perawatModel->ambilShift($role);
        if ($shiftData) {
            foreach ($shiftData as $shiftItem) {
                if (isset($shiftItem['id_detail_s'])) {
                    $shiftTasks = $perawatModel->ambilTugasShift($shiftItem['id_detail_s']);
                    if ($shiftTasks) {
                        $tasks = array_merge($tasks, $shiftTasks);
                    }
                }
            }
        }

        // Fallback tugas jika database kosong
        if (empty($tasks)) {
            $tasks = [
                ['tugas_shift' => 'MEMERIKSA KONDISI PASIEN DI AWAL SHIFT', 'tenggat' => '10:00:00', 'status_dilakukan' => 'belum'],
                ['tugas_shift' => 'Cek AGD Bed 01', 'tenggat' => '12:00:00', 'status_dilakukan' => 'belum'],
                ['tugas_shift' => 'Miring Kanan All Bed', 'tenggat' => '13:00:00', 'status_dilakukan' => 'belum']
            ];
        }

        $data = [
            'pasien_aktif' => $pasien_aktif,
            'kapasitas' => $kapasitas,
            'pasien_kritis' => $pasien_kritis,
            'beds' => $beds,
            'queue' => $queue,
            'tasks' => $tasks
        ];

        $this->view('perawat/dashboard', $data);
    }

    public function updateStaffAccount() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_POST['update_staff'])) {
            $_SESSION['user']['nama'] = $_POST['namaLengkap'];
            $_SESSION['user']['role'] = $_POST['divisi'];
            $_SESSION['user']['shift'] = $_POST['shift'];
        }

        header('Location: ' . BASEURL . '/perawat/dashboard');
        exit;
    }

    public function inputDataPasien() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']['nama'])) {
            header('Location: ' . BASEURL . '/portal-staff/login');
            exit;
        }

        $db = new Database();
        $conn = $db->connect();

        // Ambil data detail seluruh pasien aktif
        $stmt = $conn->prepare("
            SELECT 
                rk.id_rekam_medis,
                rk.urgensi,
                ddp.id_pasien,
                ddp.nama_lengkap,
                ddp.nik,
                ddp.asal,
                ddp.tgl_lahir,
                ddp.jenis_kelamin,
                ddp.agama,
                ddp.status_perkawinan,
                ddp.pekerjaan,
                ddp.alamat,
                ddp.nomor_bpjs,
                ddp.golongan_darah,
                ddp.kewarganegaraan,
                ap.id_pengguna,
                ap.username,
                -- Ambil password plaintext/raw jika ada
                ddpr.id_pengantar,
                ddpr.nama_lengkap AS nama_wali,
                ddpr.status_wali,
                ddpr.nik_wali,
                ddpr.no_hp AS no_hp_wali,
                ddpr.alamat AS alamat_wali,
                (SELECT kondisi FROM observasi_pasien WHERE id_rekam_medis = rk.id_rekam_medis ORDER BY waktu_catat DESC LIMIT 1) AS status_klinis,
                (SELECT b.nomor_bed FROM observasi_pasien op JOIN bed b ON b.id_bed = op.id_bed WHERE op.id_rekam_medis = rk.id_rekam_medis ORDER BY op.waktu_catat DESC LIMIT 1) AS nomor_bed
            FROM rekam_medis rk
            JOIN data_diri_pasien ddp ON ddp.id_pasien = rk.id_pasien
            LEFT JOIN akun_pengguna ap ON ap.id_pengguna = ddp.id_pengguna
            LEFT JOIN data_diri_pegantar ddpr ON ddpr.id_pasien = ddp.id_pasien
            WHERE rk.tanggal_keluar IS NULL
            ORDER BY rk.id_rekam_medis DESC
        ");
        $stmt->execute();
        $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = ['patients' => $patients];
        $this->view('perawat/input_data_pasien', $data);
    }

    public function tambahPasien() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']['nama'])) {
            header('Location: ' . BASEURL . '/portal-staff/login');
            exit;
        }

        $this->view('perawat/tambah_pasien');
    }

    public function simpanPasien() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASEURL . '/perawat/tambah_pasien');
            exit;
        }

        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';

        if (empty($username) || empty($password)) {
            echo 'Username dan Password wajib diisi.';
            return;
        }

        // 1. Daftarkan Akun Pengguna
        $db = new Database();
        $conn = $db->connect();

        $stmtCheck = $conn->prepare("SELECT id_pengguna FROM akun_pengguna WHERE username = :username LIMIT 1");
        $stmtCheck->execute(['username' => $username]);
        if ($stmtCheck->fetch(PDO::FETCH_ASSOC)) {
            echo 'Username sudah terdaftar.';
            return;
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmtUser = $conn->prepare("INSERT INTO akun_pengguna (username, password) VALUES (:username, :password)");
        $stmtUser->execute(['username' => $username, 'password' => $hashedPassword]);
        $id_pengguna = $conn->lastInsertId();

        // 2. Simpan Data Diri Pasien
        $nik = isset($_POST['nik']) ? trim($_POST['nik']) : '';
        $nama_lengkap = isset($_POST['nama_lengkap']) ? trim($_POST['nama_lengkap']) : '';
        $asal = isset($_POST['asal']) ? trim($_POST['asal']) : '';
        $tgl_lahir = isset($_POST['tgl_lahir']) ? $_POST['tgl_lahir'] : '';
        $jenis_kelamin = isset($_POST['jenis_kelamin']) ? $_POST['jenis_kelamin'] : 'L';
        $agama = isset($_POST['agama']) ? trim($_POST['agama']) : '';
        $status_perkawinan = isset($_POST['status_perkawinan']) ? trim($_POST['status_perkawinan']) : '';
        $pekerjaan = isset($_POST['pekerjaan']) ? trim($_POST['pekerjaan']) : '';
        $alamat = isset($_POST['alamat']) ? trim($_POST['alamat']) : '';
        $no_bpjs = isset($_POST['no_bpjs']) ? trim($_POST['no_bpjs']) : '';
        $golongan_darah = isset($_POST['golongan_darah']) ? trim($_POST['golongan_darah']) : '';
        $kewarganegaraan = isset($_POST['kewarganegaraan']) ? trim($_POST['kewarganegaraan']) : '';
        $alergi = isset($_POST['alergi']) ? trim($_POST['alergi']) : '';

        $pasienModel = new PasienModel();
        $pasienModel->isiDataDiriPasien(
            $nama_lengkap, $nik, $asal, $tgl_lahir, $jenis_kelamin,
            $agama, $status_perkawinan, $alamat, $no_bpjs, $golongan_darah,
            $kewarganegaraan, $pekerjaan, $id_pengguna
        );

        $stmtPasienId = $conn->prepare("SELECT id_pasien FROM data_diri_pasien WHERE id_pengguna = :id LIMIT 1");
        $stmtPasienId->execute(['id' => $id_pengguna]);
        $resPasien = $stmtPasienId->fetch(PDO::FETCH_ASSOC);
        $id_pasien = $resPasien ? $resPasien['id_pasien'] : null;

        if (!$id_pasien) {
            echo 'Gagal menyimpan data pasien.';
            return;
        }

        // Alergi
        if (!empty($alergi)) {
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
            $pasienModel->tambahAlergiPasien($id_pasien, $id_alergi);
        }

        // 3. Simpan Wali
        $nama_wali = isset($_POST['nama_wali']) ? trim($_POST['nama_wali']) : '';
        $status_wali = isset($_POST['status_wali']) ? trim($_POST['status_wali']) : '';
        $nik_wali = isset($_POST['nik_wali']) ? trim($_POST['nik_wali']) : '';
        $no_hp_wali = isset($_POST['no_hp_wali']) ? trim($_POST['no_hp_wali']) : '';
        $alamat_wali = isset($_POST['alamat_wali']) ? trim($_POST['alamat_wali']) : '';
        $ttd = isset($_POST['ttd_wali_base64']) ? $_POST['ttd_wali_base64'] : '';

        $filename = 'ttd_wali_default.png';

        if (!empty($ttd)) {
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

        $keluargaModel = new KeluargaPasienModel();
        $keluargaModel->isiDataDiriPengantar(
            $nama_wali, $status_wali, $nik_wali, $no_hp_wali,
            $alamat_wali, $filename, $id_pasien
        );

        // 4. Rekam Medis
        $rekamMedisModel = new RekamMedis();
        $rekamMedisModel->IsiRekamMedis($id_pasien, date('Y-m-d'), null, 'Tingkat 2');

        // Redirect back with Success Modal display triggered by session/GET
        header('Location: ' . BASEURL . '/perawat/input_data_pasien?success=1');
        exit;
    }

    public function updatePasien() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASEURL . '/perawat/input_data_pasien');
            exit;
        }

        $id_rekam_medis = isset($_POST['id_rekam_medis']) ? $_POST['id_rekam_medis'] : '';
        
        $db = new Database();
        $conn = $db->connect();

        // Dapatkan data pasien terkait RM ini
        $stmtPas = $conn->prepare("SELECT id_pasien, id_pengguna FROM rekam_medis rk JOIN data_diri_pasien ddp ON ddp.id_pasien = rk.id_pasien WHERE rk.id_rekam_medis = :id_rm");
        $stmtPas->execute(['id_rm' => $id_rekam_medis]);
        $pasData = $stmtPas->fetch(PDO::FETCH_ASSOC);

        if ($pasData) {
            $id_pasien = $pasData['id_pasien'];
            $id_pengguna = $pasData['id_pengguna'];

            // 1. Update Akun
            $username = isset($_POST['username']) ? trim($_POST['username']) : '';
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';
            if (!empty($username) && $id_pengguna) {
                if (!empty($password)) {
                    $hashed = password_hash($password, PASSWORD_BCRYPT);
                    $stmtUser = $conn->prepare("UPDATE akun_pengguna SET username = :username, password = :password WHERE id_pengguna = :id");
                    $stmtUser->execute(['username' => $username, 'password' => $hashed, 'id' => $id_pengguna]);
                } else {
                    $stmtUser = $conn->prepare("UPDATE akun_pengguna SET username = :username WHERE id_pengguna = :id");
                    $stmtUser->execute(['username' => $username, 'id' => $id_pengguna]);
                }
            }

            // 2. Update Pasien
            $nik = isset($_POST['nik']) ? trim($_POST['nik']) : '';
            $nama = isset($_POST['nama_pasien']) ? trim($_POST['nama_pasien']) : '';
            $asal = isset($_POST['asal']) ? trim($_POST['asal']) : '';
            $tgl_lahir = isset($_POST['tgl_lahir']) ? $_POST['tgl_lahir'] : '';
            $jenis_kelamin = isset($_POST['jk']) ? $_POST['jk'] : 'L';
            $agama = isset($_POST['agama']) ? trim($_POST['agama']) : '';
            $status_perkawinan = isset($_POST['status_perkawinan']) ? trim($_POST['status_perkawinan']) : '';
            $pekerjaan = isset($_POST['pekerjaan']) ? trim($_POST['pekerjaan']) : '';
            $alamat = isset($_POST['alamat']) ? trim($_POST['alamat']) : '';
            $no_bpjs = isset($_POST['bpjs']) ? trim($_POST['bpjs']) : '';
            $golongan_darah = isset($_POST['gol_darah']) ? trim($_POST['gol_darah']) : '';
            $kewarganegaraan = isset($_POST['kewarganegaraan']) ? trim($_POST['kewarganegaraan']) : '';

            $pasienModel = new PasienModel();
            $pasienModel->editDataDiriPasien(
                $id_pasien, $nama, $nik, $asal, $tgl_lahir, $jenis_kelamin,
                $agama, $status_perkawinan, $alamat, $no_bpjs, $golongan_darah,
                $kewarganegaraan, $pekerjaan, $id_pengguna
            );

            // 3. Update Wali
            $nama_wali = isset($_POST['nama_wali']) ? trim($_POST['nama_wali']) : '';
            $status_wali = isset($_POST['status_wali']) ? trim($_POST['status_wali']) : '';
            $nik_wali = isset($_POST['nik_wali']) ? trim($_POST['nik_wali']) : '';
            $no_hp_wali = isset($_POST['nohp_wali']) ? trim($_POST['nohp_wali']) : '';
            $alamat_wali = isset($_POST['alamat_wali']) ? trim($_POST['alamat_wali']) : '';

            $stmtWali = $conn->prepare("UPDATE data_diri_pegantar SET nama_lengkap = :nama, status_wali = :status, nik_wali = :nik, no_hp = :no_hp, alamat = :alamat WHERE id_pasien = :id_pasien");
            $stmtWali->execute([
                'nama' => $nama_wali,
                'status' => $status_wali,
                'nik' => $nik_wali,
                'no_hp' => $no_hp_wali,
                'alamat' => $alamat_wali,
                'id_pasien' => $id_pasien
            ]);
        }

        header('Location: ' . BASEURL . '/perawat/input_data_pasien?updated=1');
        exit;
    }

    public function keluarPasien() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $id_rekam_medis = isset($_POST['id_rekam_medis']) ? $_POST['id_rekam_medis'] : '';

        if (!empty($id_rekam_medis)) {
            $db = new Database();
            $conn = $db->connect();
            $stmt = $conn->prepare("UPDATE rekam_medis SET tanggal_keluar = CURRENT_DATE() WHERE id_rekam_medis = :id");
            $stmt->execute(['id' => $id_rekam_medis]);
        }

        header('Location: ' . BASEURL . '/perawat/input_data_pasien?discharged=1');
        exit;
    }

    public function direktoriPengguna() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']['nama'])) {
            header('Location: ' . BASEURL . '/portal-staff/login');
            exit;
        }

        $db = new Database();
        $conn = $db->connect();

        // Direktori menampilkan seluruh pasien yang pernah terdaftar (baik aktif maupun discharged)
        $stmt = $conn->prepare("
            SELECT 
                rk.id_rekam_medis,
                rk.urgensi,
                ddp.id_pasien,
                ddp.nama_lengkap,
                ddp.nik,
                ddp.asal,
                ddp.tgl_lahir,
                ddp.jenis_kelamin,
                ddp.agama,
                ddp.status_perkawinan,
                ddp.pekerjaan,
                ddp.alamat,
                ddp.nomor_bpjs,
                ddp.golongan_darah,
                ddp.kewarganegaraan,
                ap.id_pengguna,
                ap.username,
                ddpr.id_pengantar,
                ddpr.nama_lengkap AS nama_wali,
                ddpr.status_wali,
                ddpr.nik_wali,
                ddpr.no_hp AS no_hp_wali,
                ddpr.alamat AS alamat_wali,
                (SELECT kondisi FROM observasi_pasien WHERE id_rekam_medis = rk.id_rekam_medis ORDER BY waktu_catat DESC LIMIT 1) AS status_klinis,
                (SELECT b.nomor_bed FROM observasi_pasien op JOIN bed b ON b.id_bed = op.id_bed WHERE op.id_rekam_medis = rk.id_rekam_medis ORDER BY op.waktu_catat DESC LIMIT 1) AS nomor_bed
            FROM rekam_medis rk
            JOIN data_diri_pasien ddp ON ddp.id_pasien = rk.id_pasien
            LEFT JOIN akun_pengguna ap ON ap.id_pengguna = ddp.id_pengguna
            LEFT JOIN data_diri_pegantar ddpr ON ddpr.id_pasien = ddp.id_pasien
            ORDER BY rk.id_rekam_medis DESC
        ");
        $stmt->execute();
        $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = ['patients' => $patients];
        $this->view('perawat/direktori_pengguna', $data);
    }
}
