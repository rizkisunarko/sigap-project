<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/BotController.php';
require_once __DIR__ . '/../models/RekamMedis.php'; 

class RekamMedisController extends Controller {
    
    public function update() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $hasilValidasi = $this->validasiRekamMedis($_POST);

            if (!$hasilValidasi['sukses']) {
                $_SESSION['error'] = $hasilValidasi['pesan'];
                $_SESSION['rm_errors'] = $hasilValidasi['data_errors'];
                $_SESSION['rm_old'] = $_POST;
                
                header('Location: ' . BASEURL . '/perawat/input_data_pasien');
                exit;
            }

            $rekamMedisModel = new RekamMedis();

            $dataObservasi = $_POST;
            
            if (!isset($_SESSION['perawat_id'])) {
                $_SESSION['error'] = "Gagal menyimpan: Sesi login perawat tidak ditemukan. Silakan login ulang.";
                header('Location: ' . BASEURL . '/perawat/input_data_pasien');
                exit;
            }
            
            $dataObservasi['id_perawat'] = $_SESSION['perawat_id']; 
            
            $hasilSimpan = $rekamMedisModel->tambahObservasiPasien($_POST['id_pasien'], $dataObservasi);

            if (!$hasilSimpan) {
                $_SESSION['error'] = "Gagal menyimpan observasi. Pastikan pasien memiliki rekam medis yang aktif.";
                header('Location: ' . BASEURL . '/perawat/input_data_pasien');
                exit;
            }

            require_once __DIR__ . '/../models/Pasien.php';
            $pasienModel = new PasienModel();
            
            $dataPasien = $pasienModel->ambilDataPasien($_POST['id_pasien']);
            
            $namaPasien = $dataPasien['nama_lengkap']; 
            $nomorKeluarga = $dataPasien['no_hp_wali'];

            if (!empty($nomorKeluarga)) {
                
                $pesanWA = "*[SIGAP - UPDATE REKAM MEDIS ICU]*\n\n";
                $pesanWA .= "Berikut adalah laporan pemantauan kondisi terbaru untuk pasien:\n";
                $pesanWA .= "👤 *Nama Pasien:* " . $namaPasien . "\n";
                $pesanWA .= "🛏️ *Lokasi:* " . strtoupper($_POST['no_bed']) . "\n\n";
                
                $pesanWA .= "*--- HASIL OBSERVASI ---*\n";
                $pesanWA .= "❤️ *Detak Jantung:* " . $_POST['detak_jantung'] . " bpm\n";
                $pesanWA .= "💨 *SpO2 (Oksigen):* " . $_POST['oksigen'] . " %\n";
                $pesanWA .= "🌡️ *Suhu Tubuh:* " . $_POST['suhu_tubuh'] . " °C\n";
                $pesanWA .= "🩸 *Tekanan Darah:* " . $_POST['tekanan_darah'] . " mmHg\n";
                $pesanWA .= "📊 *Status Klinis:* " . strtoupper($_POST['status_klinis']) . "\n\n";
                
                $pesanWA .= "*--- TINDAKAN & DIAGNOSA ---*\n";
                $pesanWA .= "🩺 *Diagnosa:* " . $_POST['diagnosa'] . "\n";
                $pesanWA .= "💉 *Tindakan:* " . $_POST['tindakan'] . "\n";
                $pesanWA .= "📝 *Detail Kondisi:* " . $_POST['detail_kondisi'] . "\n\n";
                
                $pesanWA .= "_Pesan ini dikirim otomatis oleh sistem SIGAP. Mohon hubungi perawat bertugas untuk informasi lebih lanjut._";

                $bot = new BotController();
                $responBot = $bot->prosesKirimWA($nomorKeluarga, $pesanWA);

                if ($responBot['http_code'] == 200) {
                    $_SESSION['success'] = "Rekam medis berhasil disimpan dan notifikasi lengkap telah terkirim ke wali.";
                } else {
                    $_SESSION['success'] = "Rekam medis berhasil disimpan, namun sistem gagal mengirim notifikasi ke nomor wali.";
                }
            } else {
                $_SESSION['success'] = "Rekam medis berhasil disimpan. Notifikasi tidak dikirim karena nomor WA wali tidak terdaftar.";
            }

            header('Location: ' . BASEURL . '/perawat/input_data_pasien');
            exit;
        }
    }

    private function validasiRekamMedis($dataPost) {
        $errors = [];

        $id_pasien = $dataPost['id_pasien'] ?? ''; 

        $bed = $dataPost['no_bed'] ?? '';
        
        if ($err = $this->cekWajib($bed, 'Nomor Bed')) {
            $errors['no_bed'] = $err;
        }

        $detak = $dataPost['detak_jantung'] ?? '';
        if ($err = $this->cekWajib($detak, 'Detak Jantung')) {
            $errors['detak_jantung'] = $err;
        } elseif ($err = $this->cekHanyaAngka($detak, 'Detak Jantung')) {
            $errors['detak_jantung'] = $err;
        }

        $suhu = $dataPost['suhu_tubuh'] ?? '';
        if ($err = $this->cekWajib($suhu, 'Suhu Tubuh')) {
            $errors['suhu_tubuh'] = $err;
        } elseif (!is_numeric($suhu)) {
            $errors['suhu_tubuh'] = '*Suhu Tubuh harus berupa angka.';
        }

        $oksigen = $dataPost['oksigen'] ?? '';
        if ($err = $this->cekWajib($oksigen, 'Oksigen')) {
            $errors['oksigen'] = $err;
        } elseif (!is_numeric($oksigen)) {
            $errors['oksigen'] = '*Oksigen harus berupa angka.';
        }

        $tensi = $dataPost['tekanan_darah'] ?? '';
        if ($err = $this->cekWajib($tensi, 'Tekanan Darah')) {
            $errors['tekanan_darah'] = $err;
        } elseif (!preg_match('/^\d{2,3}\/\d{2,3}$/', $tensi)) {
            $errors['tekanan_darah'] = '*Format salah (contoh benar: 120/80).';
        }

        $status = $dataPost['status_klinis'] ?? '';
        $opsiStatus = ['stabil', 'kritis', 'meningkat', 'menurun'];
        if ($err = $this->cekWajib($status, 'Status Pasien')) {
            $errors['status_klinis'] = $err;
        } elseif ($err = $this->cekPilihan($status, $opsiStatus, 'Status Pasien')) {
            $errors['status_klinis'] = $err;
        }

        $detail = $dataPost['detail_kondisi'] ?? '';
        if ($err = $this->cekWajib($detail, 'Detail Kondisi')) {
            $errors['detail_kondisi'] = $err;
        }

        if (count($errors) > 0) {
            return ['sukses' => false, 'pesan' => 'Mohon periksa kembali isian form rekam medis.', 'data_errors' => $errors];
        } else {
            return ['sukses' => true];
        }
    }
}
?>