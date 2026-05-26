<?php
require_once __DIR__ . '/../../core/Controller.php';

// Memanggil alat Service WhatsApp
require_once __DIR__ . '/../Services/toWhatsApp.php';

class BotController extends Controller {

    // Fungsi ini menerima parameter dari controller lain
    public function prosesKirimWA($nomorTujuan, $pesanTeks) {
        
        // Langsung meneruskan ke Service toWhatsApp
        $hasil = toWhatsApp::kirimPesan($nomorTujuan, $pesanTeks);

        // Mengembalikan hasil ke controller yang memanggilnya
        return $hasil;
    }
}
?>