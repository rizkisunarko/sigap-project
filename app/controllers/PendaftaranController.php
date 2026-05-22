<?php
require_once __DIR__ . '/../../core/Controller.php';
class PendaftaranController extends Controller {
    public function index() {
        // Memanggil view
        echo 'Ini halaman index dari PendaftaranController';
    }

    public function pilihJalur() {
        $this->view('pendaftaran/pilih_jalur');
    }

    public function form() {
        $this->view('pendaftaran/form');
    }

    // Handle form submission, save signature image
    public function submit() {
        // Only accept POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /pendaftaran/form');
            exit;
        }

        // Get signature base64 data
        $ttd = isset($_POST['ttd_wali']) ? $_POST['ttd_wali'] : '';

        if (empty($ttd)) {
            // No signature provided
            echo 'Tanda tangan tidak ditemukan. Silakan kembali dan tandatangani.';
            return;
        }

        // Create directory
        $signDir = __DIR__ . '/../../public/assets/img/signatures';
        if (!is_dir($signDir)) {
            mkdir($signDir, 0755, true);
        }

        // Extract base64 data (data:image/png;base64,...)
        if (preg_match('/^data:image\/([a-zA-Z]+);base64,(.+)$/', $ttd, $matches)) {
            $ext = $matches[1];
            $data = $matches[2];
            $decoded = base64_decode($data);
            if ($decoded === false) {
                echo 'Gagal mendekode tanda tangan.';
                return;
            }
            $filename = 'ttd_wali_' . time() . '.' . $ext;
            $filePath = $signDir . '/' . $filename;
            file_put_contents($filePath, $decoded);

            // Optionally: save other form fields to DB here

            // Redirect back to form with success message (could be improved)
            header('Location: /pendaftaran/form?success=1');
            exit;
        } else {
            echo 'Format tanda tangan tidak valid.';
            return;
        }
    }
}
