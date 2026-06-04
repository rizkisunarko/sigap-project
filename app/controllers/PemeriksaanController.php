<?php
require_once __DIR__ . '/../../core/Controller.php';
class PemeriksaanController extends Controller {
    public function index() {

        echo 'Ini halaman index dari PemeriksaanController';
    }




    private function validasiHasilLab($dataPost) {
        $errors = [];


        $ph = $dataPost['ph_darah'] ?? '';
        if ($err = $this->cekWajib($ph, 'Tingkat pH Darah')) {
            $errors['ph_darah'] = $err;
        } else {

            if (!preg_match('/^[0-9\.\s\-]+$/', trim($ph))) {
                $errors['ph_darah'] = '*Tingkat pH Darah hanya boleh berisi angka, titik desimal, dan tanda hubung (-).';
            }
        }


        $hb = $dataPost['hb'] ?? '';
        if ($err = $this->cekWajib($hb, 'Hemoglobin (Hb)')) {
            $errors['hb'] = $err;
        } else {
            if (!preg_match('/^[0-9\.]+$/', trim($hb))) {
                $errors['hb'] = '*Hemoglobin (Hb) harus berupa angka atau desimal (gunakan titik).';
            }
        }


        $gula = $dataPost['gula_darah'] ?? '';
        if ($err = $this->cekWajib($gula, 'Gula Darah')) {
            $errors['gula_darah'] = $err;
        } elseif ($err = $this->cekHanyaAngka($gula, 'Gula Darah')) {
            $errors['gula_darah'] = $err;
        }


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
            

            $hasilValidasi = $this->validasiHasilLab($_POST);


            if (!$hasilValidasi['sukses']) {

                $_SESSION['lab_errors'] = $hasilValidasi['data_errors'];
                $_SESSION['lab_old'] = $_POST;
                $_SESSION['error'] = $hasilValidasi['pesan'];
                
                header('Location: ' . BASEURL . '/perawat/input_data_pasien');
                exit;
            }


            require_once __DIR__ . '/../models/pemeriksaan.php';
            $pemeriksaanModel = new PemeriksaanModel();


            $id_rekam_medis = $_POST['id_rekam_medis'] ?? '';
            $ph_darah = $_POST['ph_darah'] ?? '';
            $hb = $_POST['hb'] ?? '';
            $gula_darah = $_POST['gula_darah'] ?? '';


            $id_observasi = $pemeriksaanModel->ambilObservasiTerbaru($id_rekam_medis);


            if (empty($id_observasi)) {
                $_SESSION['error'] = 'Gagal menyimpan: Pasien belum memiliki catatan observasi. Harap isi data tanda vital (observasi) terlebih dahulu.';
                header('Location: ' . BASEURL . '/perawat/input_data_pasien');
                exit;
            }


            $pemeriksaanModel->isiHasilLab($id_observasi, $ph_darah, $hb, $gula_darah);


            $_SESSION['success'] = 'Data hasil laboratorium berhasil disimpan ke dalam sistem.';
            header('Location: ' . BASEURL . '/perawat/input_data_pasien');
            exit;
        }
    }
}
