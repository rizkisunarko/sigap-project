<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../models/Perawat.php';
require_once __DIR__ . '/../models/Pasien.php';
require_once __DIR__ . '/../models/Pemeriksaan.php';
require_once __DIR__ . '/../models/RekamMedis.php';
require_once __DIR__ . '/../models/KeluargaPasien.php';

class PerawatController extends Controller {

    public function view($name, $data = []) {
        extract($data);
        $view_content = __DIR__ . '/../views/' . $name . '.php';
        require_once __DIR__ . '/../views/perawat/Halutama.php';
    }
    
    public function login() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['perawat_id']) || isset($_SESSION['user']['nama'])) {
            header('Location: ' . BASEURL . '/perawat/dashboard');
            exit;
        }

        require_once __DIR__ . '/../views/portal-staff/login.php';
    }

    public function prosesLogin() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama_input = trim($_POST['namaLengkap'] ?? '');
            $divisi     = trim($_POST['divisi'] ?? '');
            $shift      = trim($_POST['shift'] ?? '');

            if (!str_ends_with(strtolower($nama_input), '-staff')) {
                $_SESSION['error_staff'] = '*Data yang anda masukkan tidak sesuai.';
                header("Location: " . BASEURL . "/divisionRMFO-255");
                exit;
            }

            $nama_asli = trim(str_ireplace('-staff', '', $nama_input));

            $model = new PerawatModel();
            $dataPerawat = $model->prosesCheckInPerawat($nama_asli, $divisi, $shift);

            if ($dataPerawat) {
                $_SESSION['perawat_id']   = $dataPerawat['id_perawat'];
                $_SESSION['perawat_nama'] = $dataPerawat['nama_lengkap'];
                
                $_SESSION['user'] = [
                    'nama' => $dataPerawat['nama_lengkap'],
                    'role' => $divisi,
                    'shift' => $shift
                ];
                
                header("Location: " . BASEURL . "/perawat/dashboard");
                exit;
            } else {
                $_SESSION['error_staff'] = '*Data yang anda masukkan tidak sesuai.';
                header("Location: " . BASEURL . "/divisionRMFO-255");
                exit;
            }
        }
    }

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


    public function portalLogout() {
        if (session_status() === PHP_SESSION_NONE) {
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

        header('Location: ' . BASEURL . '/divisionRMFO-255');
        exit;
    }

    public function dashboard() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']['nama'])) {
            header('Location: ' . BASEURL . '/divisionRMFO-255');
            exit;
        }

        $perawatModel = new PerawatModel();
        

        $rawStats = $perawatModel->pasienAktif_kapasitasBed_pasienKritis();
        
        $pasien_aktif = isset($rawStats[0][0]['pasien_aktif']) ? $rawStats[0][0]['pasien_aktif'] : 0;
        $kapasitas = isset($rawStats[1][0]['kapasitas']) ? $rawStats[1][0]['kapasitas'] : 40;
        


        $pasien_kritis = isset($rawStats[2]['pasien_kritis']) ? $rawStats[2]['pasien_kritis'] : 0;


        $beds = $perawatModel->ketersediaanBed();
        $queue = $perawatModel->antreanMasuk();


        $role = $_SESSION['user']['role'];
        $shift_aktif = $_SESSION['user']['shift'];
        $id_perawat = $_SESSION['perawat_id'] ?? 0;
        

        $tasks = $perawatModel->ambilTugasShift($role, $shift_aktif, $id_perawat);


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

        $ambilSPA = new PerawatModel();
        $patients = $ambilSPA->ambilSeluruhDataPasienAktif();

        $daftar_semua_bed = $ambilSPA->ketersediaanBed(); 

        $rmModel = new PemeriksaanModel();
        $lab_terbaru = [];

        if (!empty($patients)) {
            foreach ($patients as $p) {

                if (!empty($p['id_rekam_medis'])) {
                    $lab_terbaru[$p['id_rekam_medis']] = $rmModel->ambilHasilLabTerbaru($p['id_rekam_medis']);
                }
            }
        }

        $data = [
            'patients' => $patients,
            'lab_terbaru' => $lab_terbaru,
            'daftar_semua_bed' => $daftar_semua_bed 
        ];
        
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

        $rekamMedisModel = new RekamMedis();
        $rekamMedisModel->IsiRekamMedis($id_pasien, date('Y-m-d'), null, 'Tingkat 2');

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

        $stmtPas = $conn->prepare("SELECT id_pasien, id_pengguna FROM rekam_medis rk JOIN data_diri_pasien ddp ON ddp.id_pasien = rk.id_pasien WHERE rk.id_rekam_medis = :id_rm");
        $stmtPas->execute(['id_rm' => $id_rekam_medis]);
        $pasData = $stmtPas->fetch(PDO::FETCH_ASSOC);

        if ($pasData) {
            $id_pasien = $pasData['id_pasien'];
            $id_pengguna = $pasData['id_pengguna'];

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

            $nama_wali = isset($_POST['nama_wali']) ? trim($_POST['nama_wali']) : '';
            $status_wali = isset($_POST['status_wali']) ? trim($_POST['status_wali']) : '';
            $nik_wali = isset($_POST['nik_wali']) ? trim($_POST['nik_wali']) : '';
            $no_hp_wali = isset($_POST['nohp_wali']) ? trim($_POST['nohp_wali']) : '';
            $alamat_wali = isset($_POST['alamat_wali']) ? trim($_POST['alamat_wali']) : '';

            $stmtWali = $conn->prepare("UPDATE data_diri_pengantar SET nama_lengkap = :nama, status_wali = :status, nik_wali = :nik, no_hp = :no_hp, alamat = :alamat WHERE id_pasien = :id_pasien");
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

    public function masukPasien() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $id_pasien = isset($_POST['id_pasien']) ? $_POST['id_pasien'] : '';

        if (!empty($id_pasien)) {
            $db = new Database();
            $conn = $db->connect();
            
            $stmtCheck = $conn->prepare("SELECT id_rekam_medis FROM rekam_medis WHERE id_pasien = :id AND tanggal_keluar IS NULL LIMIT 1");
            $stmtCheck->execute(['id' => $id_pasien]);
            $isAktif = $stmtCheck->fetch(PDO::FETCH_ASSOC);

            if ($isAktif) {
                $_SESSION['error'] = "Gagal! Pasien ini sudah berstatus AKTIF dan masih dalam perawatan.";
                header('Location: ' . BASEURL . '/perawat/direktori_pengguna');
                exit;
            }

            $rekamMedisModel = new RekamMedis();
            $rekamMedisModel->IsiRekamMedis($id_pasien, date('Y-m-d'), null, 'Tingkat 2');
            
            header('Location: ' . BASEURL . '/perawat/input_data_pasien?activated=1');
            exit;
        }

        header('Location: ' . BASEURL . '/perawat/direktori_pengguna');
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

        $tampilSPT = new PerawatModel();
        $patients = $tampilSPT->tampilSeluruhPasienTerdaftar();

        $data = ['patients' => $patients];
        $this->view('perawat/direktori_pengguna', $data);
    }

    public function getDetailPasienAjax() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_pasien'])) {
            $id_pasien = $_POST['id_pasien'];
            
            $pasienModel = new PasienModel();
            $dataPasien = $pasienModel->ambilDataPasien($id_pasien); 

            $rmModel = new RekamMedis();
            $riwayat = $rmModel->ambilRiwayatPasien($id_pasien);

            echo json_encode([
                'status' => 'success',
                'pasien' => $dataPasien,
                'riwayat' => $riwayat
            ]);
            exit;
        }
    }

        public function updateTugasShift() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }


        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_tugas'], $_POST['status'])) {
            $id_tugas = $_POST['id_tugas'];
            $status = $_POST['status'];
            

            $id_perawat = $_SESSION['perawat_id'] ?? null;

            if (!$id_perawat) {
                header('Content-Type: application/json');
                echo json_encode(['sukses' => false, 'pesan' => 'Sesi tidak ditemukan']);
                exit;
            }

            $perawatModel = new PerawatModel();
            $sukses = $perawatModel->perbaruiStatusLogTugas($id_tugas, $id_perawat, $status);

            header('Content-Type: application/json');
            echo json_encode(['sukses' => $sukses]);
            exit;
        }
    }
}