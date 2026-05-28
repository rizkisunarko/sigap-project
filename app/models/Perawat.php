<?php 
    require_once __DIR__ . "/../../core/Model.php";

    class PerawatModel extends Model {

        // Fungsi pendaftaran otomatis dan login
        public function prosesCheckInPerawat($nama_asli, $divisi, $shift) {
            
            // LANGKAH 1: Memeriksa apakah perawat tersebut sudah terdaftar
            $queryPerawat = $this->db->prepare(
                "SELECT id_perawat FROM data_perawat WHERE nama_lengkap = :nama"
            );
            $queryPerawat->bindParam(":nama", $nama_asli);
            $queryPerawat->execute();
            $data_perawat = $queryPerawat->fetch(PDO::FETCH_ASSOC);

            // Jika perawat sudah ada di database, langsung kembalikan ID-nya
            if ($data_perawat) {
                return [
                    'id_perawat' => $data_perawat['id_perawat'],
                    'nama_lengkap' => $nama_asli
                ];
            }

            // ==========================================================
            // JIKA PERAWAT BELUM ADA, LAKUKAN INSERT OTOMATIS
            // ==========================================================

            // LANGKAH 2: Memeriksa atau membuat Tugas Shift
            $queryShift = $this->db->prepare("SELECT id_shift FROM tugas_shift WHERE nomor_shift = :shift");
            $queryShift->bindParam(":shift", $shift);
            $queryShift->execute();
            $data_shift = $queryShift->fetch(PDO::FETCH_ASSOC);
            
            // Jika shift belum ada, buat baru
            if (!$data_shift) {
                // Catatan: id_detail_s diisi NULL sementara karena kita tidak mendapatkannya dari formulir
                $insertShift = $this->db->prepare("INSERT INTO tugas_shift (nomor_shift, id_detail_s) VALUES (:shift, NULL)");
                $insertShift->bindParam(":shift", $shift);
                $insertShift->execute();
                $id_shift_baru = $this->db->lastInsertId();
            } else {
                $id_shift_baru = $data_shift['id_shift'];
            }

            // LANGKAH 3: Memeriksa atau membuat Divisi Perawat
            $queryDivisi = $this->db->prepare("SELECT id_divisi FROM divisi_perawat WHERE nama_divisi = :divisi AND id_shift = :id_shift");
            $queryDivisi->bindParam(":divisi", $divisi);
            $queryDivisi->bindParam(":id_shift", $id_shift_baru);
            $queryDivisi->execute();
            $data_divisi = $queryDivisi->fetch(PDO::FETCH_ASSOC);

            // Jika divisi dengan shift tersebut belum ada, buat baru
            if (!$data_divisi) {
                $insertDivisi = $this->db->prepare("INSERT INTO divisi_perawat (nama_divisi, id_shift) VALUES (:divisi, :id_shift)");
                $insertDivisi->bindParam(":divisi", $divisi);
                $insertDivisi->bindParam(":id_shift", $id_shift_baru);
                $insertDivisi->execute();
                $id_divisi_baru = $this->db->lastInsertId();
            } else {
                $id_divisi_baru = $data_divisi['id_divisi'];
            }

            // LANGKAH 4: Mendaftarkan Perawat Baru
            $insertPerawat = $this->db->prepare("INSERT INTO data_perawat (nama_lengkap, id_divisi) VALUES (:nama, :id_divisi)");
            $insertPerawat->bindParam(":nama", $nama_asli);
            $insertPerawat->bindParam(":id_divisi", $id_divisi_baru);
            $insertPerawat->execute();
            
            // Mengambil ID perawat yang baru saja didaftarkan
            $id_perawat_baru = $this->db->lastInsertId();

            // Mengembalikan data untuk dijadikan Sesi
            return [
                'id_perawat' => $id_perawat_baru,
                'nama_lengkap' => $nama_asli
            ];
        }
    }
?>