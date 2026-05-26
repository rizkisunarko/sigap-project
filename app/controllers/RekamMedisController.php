<?php
require_once __DIR__ . '/../../core/Controller.php';

// Panggil BotController agar bisa kita suruh-suruh
require_once __DIR__ . '/BotController.php';

class RekamMedisController extends Controller {
    
    // Fungsi yang dipanggil saat tombol "Submit" di form ditekan
    public function simpanRekamMedis() {
        // 1. Anggaplah kita menangkap data dari form (tampilan testBot.php)
        $namaPasien = $_POST['nama_pasien'];
        $statusKondisi = $_POST['status_kondisi'];
        $nomor_keluarga = $_POST['nomor'];
        
        // (Logika simpan ke database ditaruh di sini)
        // ...

        // 2. Ambil nomor WA keluarga (Misal dari database, ini contoh statis)
        $nomorKeluarga = '082143738267'; 

        // 3. Susun pesan yang mau dikirim
        $pesanWA = "*[SIGAP - Update Rekam Medis]*\n\n";
        $pesanWA .= "Pasien: $namaPasien\n";
        $pesanWA .= "Kondisi: $statusKondisi\n\n";
        $pesanWA .= "_Pesan otomatis dari sistem._";

        // 4. Panggil BotController dan serahkan nomor beserta pesannya
        $bot = new BotController();
        $responBot = $bot->prosesKirimWA($nomor_keluarga, $pesanWA);

        // 5. Cek apakah bot berhasil mengirim
        if ($responBot['http_code'] == 200) {
            echo "Data rekam medis berhasil disimpan dan WA sudah terkirim ke keluarga!";
        } else {
            echo "Data disimpan, tapi gagal mengirim WA.";
        }
    }
}
?>