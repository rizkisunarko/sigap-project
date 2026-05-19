<?php 
    
    require_once "../../core/Model.php";

    class PemeriksaanModel extends Model {

        // isi data observasi pasien
        public function isiObservasiPasien(
            $detak_jantung, $oksigen, $suhu_tubuh,
            $tekanan_darah, $detail_kondisi, $kondisi,
            $waktu_catat, $tindakan, $sp02, $id_perawat,
            $id_rekam_medis, $id_bed, $diagnosa
        ) {
            $query = $this->db->prepare(
                "INSERT into observasi_pasien
                (detak_jantung, oksigen, suhu_tubuh, tekanan_darah,
                detail_kondisi, kondisi, waktu_catat, tindakan, 
                sp02, id_perawat, id_rekam_medis, id_bed, diagnosa)
                values
                (:detak_jantung, :oksigen, :suhu_tubuh, :tekanan_darah,
                :detail_kondisi, :kondisi, :waktu_catat, :tindakan,
                :sp02, :id_perawat, :id_rekam_medis, :id_bed, :diagnosa)"
            );
            $query->bindParam(":detak_jantung", $detak_jantung);
            $query->bindParam(":oksigen", $oksigen);
            $query->bindParam(":suhu_tubuh", $suhu_tubuh);
            $query->bindParam(":tekanan_darah", $tekanan_darah);
            $query->bindParam(":detail_kondisi", $detail_kondisi);
            $query->bindParam(":kondisi", $kondisi);
            $query->bindParam(":waktu_catat", $waktu_catat);
            $query->bindParam(":tindakan", $tindakan);
            $query->bindParam(":sp02", $sp02);
            $query->bindParam(":id_perawat", $id_perawat);
            $query->bindParam(":id_rekam_medis", $id_rekam_medis);
            $query->bindParam(":id_bed", $id_bed);
            $query->bindParam(":diagnosa", $diagnosa);
            $query->execute();
        }

        // edit data observasi
        public function editObservasiPasien(
            $detak_jantung, $oksigen, $suhu_tubuh,
            $tekanan_darah, $detail_kondisi, $kondisi,
            $waktu_catat, $tindakan, $sp02, $id_observasi,
            $id_rekam_medis, $id_bed, $diagnosa
        ) {
            $query = $this->db->prepare(
                "UPDATE observasi_pasien set
                detak_jantung = :detak_jantung, 
                oksigen = :oksigen, 
                suhu_tubuh = :suhu_tubuh, 
                tekanan_darah = :tekanan_darah,
                detail_kondisi = :detail_kondisi, 
                kondisi = :kondisi, 
                waktu_catat = :waktu_catat, 
                tindakan = :tindakan, 
                sp02 = :sp02,  
                id_rekam_medis = :id_rekam_medis, 
                id_bed = :id_bed, 
                diagnosa = :diagnosa
                where id_observasi = :id_observasi"
            );
            $query->bindParam(":detak_jantung", $detak_jantung);
            $query->bindParam(":oksigen", $oksigen);
            $query->bindParam(":suhu_tubuh", $suhu_tubuh);
            $query->bindParam(":tekanan_darah", $tekanan_darah);
            $query->bindParam(":detail_kondisi", $detail_kondisi);
            $query->bindParam(":kondisi", $kondisi);
            $query->bindParam(":waktu_catat", $waktu_catat);
            $query->bindParam(":tindakan", $tindakan);
            $query->bindParam(":sp02", $sp02);
            $query->bindParam(":id_observasi", $id_observasi);
            $query->bindParam(":id_rekam_medis", $id_rekam_medis);
            $query->bindParam(":id_bed", $id_bed);
            $query->bindParam(":diagnosa", $diagnosa);
            $query->execute();
        }

        // untuk hapus 1 record observasi pasien
        public function hapusObservasiPasien($id_observasi) {
            $query = $this->db->prepare(
                "DELETE from observasi_pasien
                where id_observasi = :id_observasi"
            );
            $query->bindParam(":id_observasi", $id_observasi);
            $query->execute();
        }
    }
?>