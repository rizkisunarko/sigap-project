<?php 
    require_once __DIR__ . '/../../core/Controller.php';
    require_once __DIR__ . '/../models/Pendaftaran.php';
    require_once __DIR__ . '/../models/RekamMedis.php'; // Ditambahkan untuk memicu antrean perawat

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

        public function submit() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $sumber = $_POST['sumber_halaman'] ?? 'publik';

            if ($sumber === 'dasbor_perawat') {
                $ruteGagal  = '/perawat/tambah_pasien';
                $ruteSukses = '/perawat/input_data_pasien'; 
            } else {
                $ruteGagal  = '/pendaftaran/form';
                $ruteSukses = '/auth/login?success=1';
            }

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location: ' . BASEURL . $ruteGagal);
                exit;
            }

            $ttd = $_POST['ttd_wali'] ?? '';

            $hasilValidasi = $this->validasiPendaftaran($_POST, $ttd);

            if (!$hasilValidasi['sukses']) {
                $_SESSION['error'] = $hasilValidasi['pesan'];
                $_SESSION['errors'] = $hasilValidasi['data_errors'] ?? [];
                $_SESSION['old'] = $_POST;

                session_write_close();
                
                header('Location: ' . BASEURL . $ruteGagal);
                exit;
            }

            $signDir = __DIR__ . '/../../public/assets/img/signatures';
            if (!is_dir($signDir)) {
                mkdir($signDir, 0755, true);
            }

            if (preg_match('/^data:image\/([a-zA-Z]+);base64,(.+)$/', $ttd, $matches)) {
                $decoded = base64_decode($matches[2]);
                
                if ($decoded === false) {
                    $_SESSION['error'] = "Gagal mendekode tanda tangan.";
                    $_SESSION['old'] = $_POST;
                    
                    header('Location: ' . BASEURL . $ruteGagal);
                    exit;
                }
                
                $filename = 'ttd_wali_' . time() . '.' . $matches[1];
                file_put_contents($signDir . '/' . $filename, $decoded);

                $modelPendaftaran = new PendaftaranModel(); 
                $pesanModel = "";
                
                $modelPendaftaran->daftarAkun($_POST['username'], $_POST['password'], $_POST, $filename, $pesanModel);

                if ($pesanModel === "Berhasil") {
                    
                    $db = new Database();
                    $conn = $db->connect();
                    $stmt = $conn->prepare("SELECT id_pasien FROM data_diri_pasien WHERE nik = :nik");
                    $stmt->execute(['nik' => $_POST['nik']]);
                    $resPasien = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if ($resPasien) {
                        $id_pasien = $resPasien['id_pasien'];
                        $rekamMedisModel = new RekamMedis();
                        $rekamMedisModel->IsiRekamMedis($id_pasien, date('Y-m-d'), null, null);
                    }

                    unset($_SESSION['old'], $_SESSION['error'], $_SESSION['errors']);
                    
                    header('Location: ' . BASEURL . $ruteSukses);
                    exit;
                } 
                
                $_SESSION['error'] = $pesanModel;
                $_SESSION['old'] = $_POST;
                
                header('Location: ' . BASEURL . $ruteGagal);
                exit;

            } 
            
            $_SESSION['error'] = "Format tanda tangan tidak valid.";
            $_SESSION['old'] = $_POST;
            
            header('Location: ' . BASEURL . $ruteGagal);
            exit;
        }

        private function validasiPendaftaran($dataPost, $dataTtd) {
            $errors = [];

            $username = $dataPost['username'] ?? '';
            if ($err = $this->cekWajib($username, 'Username')) {
                $errors['username'] = $err;
            } elseif ($err = $this->cekMinKarakter($username, 5, 'Username')) {
                $errors['username'] = $err;
            } elseif ($err = $this->cekHurufAngka($username, 'Username')) {
                $errors['username'] = $err;
            }

            $password = $dataPost['password'] ?? '';
            if ($err = $this->cekWajib($password, 'Password')) {
                $errors['password'] = $err;
            } elseif ($err = $this->cekMinKarakter($password, 8, 'Password')) {
                $errors['password'] = $err;
            } elseif ($err = $this->cekMengandungHurufBesar($password, 'Password')) {
                $errors['password'] = $err;
            } elseif ($err = $this->cekMengandungAngka($password, 'Password')) {
                $errors['password'] = $err;
            }

            $nik = $dataPost['nik'] ?? '';
            if ($err = $this->cekWajib($nik, 'NIK Pasien')) {
                $errors['nik'] = $err;
            } elseif ($err = $this->cekMinKarakter($nik, 14, 'NIK Pasien')) {
                $errors['nik'] = $err;
            } elseif ($err = $this->cekHanyaAngka($nik, 'NIK Pasien')) {
                $errors['nik'] = $err;
            }

            $namaPasien = $dataPost['nama_pasien'] ?? '';
            if ($err = $this->cekWajib($namaPasien, 'Nama pasien')) {
                $errors['nama_pasien'] = $err;
            } elseif ($err = $this->cekMinKarakter($namaPasien, 4, 'Nama pasien')) {
                $errors['nama_pasien'] = $err;
            } elseif ($err = $this->cekHanyaHurufSpasiPetik($namaPasien, 'Nama pasien')) {
                $errors['nama_pasien'] = $err;
            }

            if ($err = $this->cekWajib($dataPost['jk'] ?? '', 'Jenis Kelamin')) {
                $errors['jk'] = $err;
            }

            if ($err = $this->cekWajib($dataPost['tgl_lahir'] ?? '', 'Tanggal Lahir')) {
                $errors['tgl_lahir'] = $err;
            }

            $asal = $dataPost['asal'] ?? '';
            if ($err = $this->cekWajib($asal, 'Asal daerah')) {
                $errors['asal'] = $err;
            } elseif ($err = $this->cekMinKarakter($asal, 4, 'Asal daerah')) {
                $errors['asal'] = $err;
            } elseif ($err = $this->cekHanyaHurufSpasi($asal, 'Asal daerah')) {
                $errors['asal'] = $err;
            }

            $agama = $dataPost['agama'] ?? '';
            if ($err = $this->cekWajib($agama, 'Agama')) {
                $errors['agama'] = $err;
            } elseif ($err = $this->cekMinKarakter($agama, 4, 'Agama')) {
                $errors['agama'] = $err;
            } elseif ($err = $this->cekHanyaHurufSpasi($agama, 'Agama')) {
                $errors['agama'] = $err;
            }

            $statusKawin = $dataPost['status_perkawinan'] ?? '';
            $opsiStatus = ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'];
            if ($err = $this->cekWajib($statusKawin, 'Status perkawinan')) {
                $errors['status_perkawinan'] = $err;
            } elseif ($err = $this->cekPilihan($statusKawin, $opsiStatus, 'Status perkawinan')) {
                $errors['status_perkawinan'] = $err;
            }

            $pekerjaan = $dataPost['pekerjaan'] ?? '';
            if ($err = $this->cekWajib($pekerjaan, 'Pekerjaan')) {
                $errors['pekerjaan'] = $err;
            } elseif ($err = $this->cekMinKarakter($pekerjaan, 4, 'Pekerjaan')) {
                $errors['pekerjaan'] = $err;
            } elseif ($err = $this->cekHanyaHurufSpasi($pekerjaan, 'Pekerjaan')) {
                $errors['pekerjaan'] = $err;
            }

            $alamat = $dataPost['alamat'] ?? '';
            if ($err = $this->cekWajib($alamat, 'Alamat')) {
                $errors['alamat'] = $err;
            } elseif ($err = $this->cekMinKarakter($alamat, 10, 'Alamat')) {
                $errors['alamat'] = $err;
            } elseif ($err = $this->cekMengandungHuruf($alamat, 'Alamat')) {
                $errors['alamat'] = '*Alamat minimal 10 karakter dan wajib mengandung huruf (tidak boleh hanya angka).';
            }


            $bpjs = $dataPost['bpjs'] ?? '';
            if (!empty(trim($bpjs))) {
                if ($err = $this->cekMinKarakter($bpjs, 13, 'Nomor BPJS')) {
                    $errors['bpjs'] = $err;
                } elseif ($err = $this->cekHanyaAngka($bpjs, 'Nomor BPJS')) {
                    $errors['bpjs'] = $err;
                }
            }

            $golDarah = strtoupper(trim($dataPost['gol_darah'] ?? ''));
            if (!empty($golDarah)) {
                $opsiGolongan = ['A', 'B', 'AB', 'O', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
                if ($err = $this->cekPilihan($golDarah, $opsiGolongan, 'Golongan darah')) {
                    $errors['gol_darah'] = $err;
                }
            }

            $alergi = $dataPost['alergi'] ?? '';
            if (!empty(trim($alergi))) {
                if ($err = $this->cekMinKarakter($alergi, 3, 'Alergi')) {
                    $errors['alergi'] = $err;
                } elseif ($err = $this->cekHanyaHurufSpasi($alergi, 'Alergi')) {
                    $errors['alergi'] = $err;
                }
            }

            $warga = $dataPost['kewarganegaraan'] ?? '';
            if ($err = $this->cekWajib($warga, 'Kewarganegaraan')) {
                $errors['kewarganegaraan'] = $err;
            } elseif ($err = $this->cekMinKarakter($warga, 3, 'Kewarganegaraan')) {
                $errors['kewarganegaraan'] = $err;
            } elseif ($err = $this->cekHanyaHurufSpasi($warga, 'Kewarganegaraan')) {
                $errors['kewarganegaraan'] = $err;
            }


            $namaWali = $dataPost['nama_wali'] ?? '';
            if ($err = $this->cekWajib($namaWali, 'Nama wali')) {
                $errors['nama_wali'] = $err;
            } elseif ($err = $this->cekMinKarakter($namaWali, 4, 'Nama wali')) {
                $errors['nama_wali'] = $err;
            } elseif ($err = $this->cekHanyaHurufSpasiPetik($namaWali, 'Nama wali')) {
                $errors['nama_wali'] = $err;
            }

            $statusWali = $dataPost['status_wali'] ?? '';
            $opsiWali = ['Orang Tua', 'Suami/Istri', 'Anak', 'Saudara Kandung', 'Keluarga Lain', 'Pengantar/Lainnya'];
            if ($err = $this->cekWajib($statusWali, 'Status wali')) {
                $errors['status_wali'] = $err;
            } elseif ($err = $this->cekPilihan($statusWali, $opsiWali, 'Status wali')) {
                $errors['status_wali'] = $err;
            }

            $nikWali = $dataPost['nik_wali'] ?? '';
            if ($err = $this->cekWajib($nikWali, 'NIK Wali')) {
                $errors['nik_wali'] = $err;
            } elseif ($err = $this->cekMinKarakter($nikWali, 14, 'NIK Wali')) {
                $errors['nik_wali'] = $err;
            } elseif ($err = $this->cekHanyaAngka($nikWali, 'NIK Wali')) {
                $errors['nik_wali'] = $err;
            }

            $hpWali = $dataPost['nohp_wali'] ?? '';
            if ($err = $this->cekWajib($hpWali, 'No HP Wali')) {
                $errors['nohp_wali'] = $err;
            } elseif ($err = $this->cekMinKarakter($hpWali, 10, 'No HP Wali')) {
                $errors['nohp_wali'] = $err;
            } elseif ($err = $this->cekHanyaAngka($hpWali, 'No HP Wali')) {
                $errors['nohp_wali'] = $err;
            }

            $alamatWali = $dataPost['alamat_wali'] ?? '';
            if ($err = $this->cekWajib($alamatWali, 'Alamat wali')) {
                $errors['alamat_wali'] = $err;
            } elseif ($err = $this->cekMinKarakter($alamatWali, 10, 'Alamat wali')) {
                $errors['alamat_wali'] = $err;
            } elseif ($err = $this->cekMengandungHuruf($alamatWali, 'Alamat wali')) {
                $errors['alamat_wali'] = '*Alamat minimal 10 karakter dan wajib mengandung huruf (tidak boleh hanya angka).';
            }

            if ($err = $this->cekWajib($dataTtd, 'Tanda tangan wali')) {
                $errors['ttd_wali'] = $err;
            }

            if ($err = $this->cekWajib($dataPost['terms'] ?? '', 'Syarat & ketentuan')) {
                $errors['terms'] = $err;
            }

            if (count($errors) > 0) {
                return ['sukses' => false, 'pesan' => 'Mohon periksa kembali isian Anda.', 'data_errors' => $errors];
            } else {
                return ['sukses' => true];
            }
        }
    }
?>