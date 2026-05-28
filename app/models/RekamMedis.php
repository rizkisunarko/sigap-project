<?php 
    require_once __DIR__ . "/../../core/Model.php";

    class RekamMedis extends Model {

        // ambil status urgensi
        public function ambilStatusUrgensi() {
            $query = $this->db->prepare(
                "SELECT nama_urgensi
                from urgensi"
            );
            $query->execute();
            $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
            return $hasil;
        }

        // ambil rekam medis
        public function ambilRekamMedis($id_rekam_medis) {
            $query = $this->db->prepare(
                "SELECT rk.id_pasien, rk.tanggal_masuk, rk.tanggal_keluar, u.nama_urgensi urgensi
                from rekam_medis rk
                left join urgensi u on u.id_urgensi = rk.id_urgensi  
                where id_rekam_medis = :id_rekam_medis"
            );       
            $query->bindParam(":id_rekam_medis", $id_rekam_medis);
            $query->execute();
            $hasil = $query->fetch(PDO::FETCH_ASSOC);
            return $hasil;  
        }

        // memasukkan data pada tabel rekam medis pasien
        public function IsiRekamMedis(
            $id_pasien, $tanggal_masuk, $tanggal_keluar, $urgensi
            ) {
            $query = $this->db->prepare(
                "SELECT id_urgensi
                from urgensi
                where nama_urgensi = :nama_urgensi"
            );
            $query->bindParam(":nama_urgensi", $urgensi);
            $query->execute();
            $stat = $query->fetch(PDO::FETCH_ASSOC);
            $query = $this->db->prepare(
                "INSERT into rekam_medis (
                id_pasien, 
                tanggal_masuk, 
                tanggal_keluar,
                id_urgensi
                ) values (
                :id_pasien, 
                :tanggal_masuk,
                :tanggal_keluar, 
                :urgensi)"
            );
            $query->bindParam(":id_pasien", $id_pasien);
            $query->bindParam(":tanggal_masuk", $tanggal_masuk);
            $query->bindParam(":tanggal_keluar", $tanggal_keluar);
            $query->bindParam(":urgensi", $stat);
            $query->execute();
        }

        // edit data rekam medis
        public function editRekamMedis(
            $id_rekam_medis, $id_pasien, $tanggal_masuk,
            $tanggal_keluar, $urgensi
        ) {
            $query = $this->db->prepare(
                "SELECT id_urgensi
                from urgensi
                where nama_urgensi = :nama_urgensi"
            );
            $query->bindParam(":nama_urgensi", $urgensi);
            $query->execute();
            $query = $this->db->prepare(
                "UPDATE rekam_medis set 
                id_pasien = :id_pasien, 
                tanggal_masuk = :tanggal_masuk,
                tanggal_keluar = :tanggal_keluar, 
                id_urgensi = :urgensi
                where id_rekam_medis = :id_rekam_medis"
            );
            $query->bindParam(":id_pasien", $id_pasien);
            $query->bindParam(":tanggal_masuk", $tanggal_masuk);
            $query->bindParam(":tanggal_keluar", $tanggal_keluar);
            $query->bindParam(":urgensi", $stat);
            $query->bindParam(":id_rekam_medis", $id_rekam_medis);
            $query->execute();
        }

        // hapus record rekam medis
        public function hapusRekamMedis($id_rekam_medis) {
            $query = $this->db->prepare(
                "DELETE from rekam_medis 
                where id_rekam_medis = :id_rekam_medis"
            );
            $query->bindParam(":id_rekam_medis", $id_rekam_medis);
            $query->execute();
        }
    }
?>
