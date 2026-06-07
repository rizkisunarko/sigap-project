<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../Services/toWhatsApp.php';

class BotController extends Controller {
    public function tampilkanViewBot() {

        $this->view('perawat/testBot'); 
    }
    public function prosesKirimWA($nomorTujuan, $pesanTeks) {
        
        $hasil = toWhatsApp::kirimPesan($nomorTujuan, $pesanTeks);
        return $hasil;
    }

        public function prosesSimpanDanKirim() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nomor = $_POST['nomor'] ?? '';
                $nama  = $_POST['nama_pasien'] ?? '';
                $kondisi = $_POST['status_kondisi'] ?? '';

                $dataPesan = [
                    'judul' => 'UPDATE KONDISI PASIEN',
                    'nama'  => $nama,
                    'info'  => $kondisi,
                    'waktu' => date('d-m-Y H:i:s')
                ];

                $pesanTeks = "*{$dataPesan['judul']}*\n\n" .
                            "Nama: {$dataPesan['nama']}\n" .
                            "Kondisi: {$dataPesan['info']}\n" .
                            "Waktu: {$dataPesan['waktu']}";


                $hasil = $this->prosesKirimWA($nomor, $pesanTeks);

                echo "Status Pengiriman: " . (is_array($hasil) ? json_encode($hasil) : $hasil);
            }
        }
}
?>