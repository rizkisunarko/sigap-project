<?php 
    
    require_once "../../core/Model.php";

    class RekamMedis extends Model {
        
        // memasukkan data pada tabel rekam medis pasien
        public function IsiRekamMedis(
            $id_pasien, $tangal_masuk, $tanggal_keluar, $urgensi
            ) {
            $query = $this->db->prepare(
                "INSERT into rekam_medis (
                id_pasien, 
                tanggal_masuk, 
                tanggal_keluar,
                urgensi
                ) values (
                :id_pasien, 
                :tanggal_masuk,
                :tanggal_keluar, 
                :urgensi)"
            );
            $query->bindParam(":id_pasien", $id_pasien);
            $query->bindParam(":tanggal_masuk", $tanggal_masuk);
            $query->bindParam(":tanggal_keluar", $tanggal_keluar);
            $query->bindParam(":urgensi", $urgensi);
        }

        // edit data rekam medis
        public function editRekamMedis(
            $id_rekam_medis, $id_pasien, $tanggal_masuk,
            $tanggal_keluar, $urgensi
        ) {
            $query = $this->db->prepare(
                "UPDATE rekam_medis set 
                id_pasien = :id_pasien, 
                tanggal_masuk = :tanggal_masuk,
                tanggal_keluar = :tanggal_keluar, 
                urgensi = :urgensi
                where id_rekam_medis = :id_rekam_medis"
            );
            $query->bindParam(":id_pasien", $id_pasien);
            $query->bindParam(":tanggal_masuk", $tanggal_masuk);
            $query->bindParam(":tanggal_keluar", $tanggal_keluar);
            $query->bindParam(":urgensi", $urgensi);
            $query->bindParam(":id_rekam_medis", $id_rekam_medis);
        }

        // hapus record rekam medis
        public function hapusRekamMedis($id_rekam_medis) {
            $query = $this->db->prepare(
                "DELETE from rekam_medis where id_rekam_medis = :id_rekam_medis"
            );
            $query->bindParam(":id_rekam_medis", $id_rekam_medis);
        }
    }
?>