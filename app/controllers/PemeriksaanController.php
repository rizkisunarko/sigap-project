<?php
require_once __DIR__ . '/../../core/Controller.php';
class PemeriksaanController extends Controller {
    public function index() {
        // Memanggil view
        echo 'Ini halaman index dari PemeriksaanController';
    }

    // ==========================================
    // ALAT VALIDASI KHUSUS HASIL LABORATORIUM
    // ==========================================
    private function validasiHasilLab($dataPost) {
        $errors = [];

        // 1. Validasi pH Darah (Biasanya angka desimal seperti 7.35)
        $ph = $dataPost['ph_darah'] ?? '';
        if ($err = $this->cekWajib($ph, 'Tingkat pH Darah')) {
            $errors['ph_darah'] = $err;
        } else {
            // Kita pakai regex khusus karena pH bisa berbentuk desimal atau range (misal "7.35" atau "7.35 - 7.45")
            if (!preg_match('/^[0-9\.\s\-]+$/', trim($ph))) {
                $errors['ph_darah'] = '*Tingkat pH Darah hanya boleh berisi angka, titik desimal, dan tanda hubung (-).';
            }
        }

        // 2. Validasi Hemoglobin (Hb) (Biasanya desimal seperti 13.5)
        $hb = $dataPost['hb'] ?? '';
        if ($err = $this->cekWajib($hb, 'Hemoglobin (Hb)')) {
            $errors['hb'] = $err;
        } else {
            if (!preg_match('/^[0-9\.]+$/', trim($hb))) {
                $errors['hb'] = '*Hemoglobin (Hb) harus berupa angka atau desimal (gunakan titik).';
            }
        }

        // 3. Validasi Gula Darah (Biasanya angka bulat seperti 110)
        $gula = $dataPost['gula_darah'] ?? '';
        if ($err = $this->cekWajib($gula, 'Gula Darah')) {
            $errors['gula_darah'] = $err;
        } elseif ($err = $this->cekHanyaAngka($gula, 'Gula Darah')) {
            $errors['gula_darah'] = $err;
        }

        // Evaluasi Akhir
        if (count($errors) > 0) {
            return ['sukses' => false, 'pesan' => 'Terdapat kesalahan pada format pengisian data lab.', 'data_errors' => $errors];
        } else {
            return ['sukses' => true];
        }
    }

    public function simpanHasilLab() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // 1. Proses Validasi Input (Memanggil fungsi validasiHasilLab yang sudah dibuat)
            $hasilValidasi = $this->validasiHasilLab($_POST);

            // 2. Penanganan Jika Validasi Gagal
            if (!$hasilValidasi['sukses']) {
                // Simpan error dan input lama ke sesi untuk dipanggil kembali oleh pop-up
                $_SESSION['lab_errors'] = $hasilValidasi['data_errors'];
                $_SESSION['lab_old'] = $_POST;
                $_SESSION['error'] = $hasilValidasi['pesan'];
                
                header('Location: ' . BASEURL . '/perawat/input_data_pasien');
                exit;
            }

            // 3. Persiapan Model Database
            require_once __DIR__ . '/../models/pemeriksaan.php';
            $pemeriksaanModel = new PemeriksaanModel();

            // Tangkap id_rekam_medis dari form, bukan id_observasi
            $id_rekam_medis = $_POST['id_rekam_medis'] ?? '';
            $ph_darah = $_POST['ph_darah'] ?? '';
            $hb = $_POST['hb'] ?? '';
            $gula_darah = $_POST['gula_darah'] ?? '';

            // Mencari tiket observasi terbaru milik pasien ini
            $id_observasi = $pemeriksaanModel->ambilObservasiTerbaru($id_rekam_medis);

            // Pengamanan tambahan: Pastikan ID Observasi benar-benar ditemukan
            if (empty($id_observasi)) {
                $_SESSION['error'] = 'Gagal menyimpan: Pasien belum memiliki catatan observasi. Harap isi data tanda vital (observasi) terlebih dahulu.';
                header('Location: ' . BASEURL . '/perawat/input_data_pasien');
                exit;
            }

            // Eksekusi penyimpanan menggunakan fungsi isiHasilLab di model
            $pemeriksaanModel->isiHasilLab($id_observasi, $ph_darah, $hb, $gula_darah);

            // 4. Penanganan Sukses
            $_SESSION['success'] = 'Data hasil laboratorium berhasil disimpan ke dalam sistem.';
            header('Location: ' . BASEURL . '/perawat/input_data_pasien');
            exit;
        }
    }
}
