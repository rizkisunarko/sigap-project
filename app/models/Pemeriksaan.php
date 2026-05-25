<?php 
    
    require_once __DIR__ . "/../../core/Model.php";

    class PemeriksaanModel extends Model {

        // isi data observasi pasien
        public function isiObservasiPasien(
            $detak_jantung, $suhu_tubuh,
            $tekanan_darah, $detail_kondisi, $kondisi,
            $waktu_catat, $tindakan, $sp02, $id_perawat,
            $id_rekam_medis, $id_bed, $diagnosa
        ) {
            $query = $this->db->prepare(
                "INSERT into observasi_pasien
                (detak_jantung, suhu_tubuh, tekanan_darah,
                detail_kondisi, kondisi, waktu_catat, tindakan, 
                sp02, id_perawat, id_rekam_medis, id_bed, diagnosa)
                values
                (:detak_jantung, :suhu_tubuh, :tekanan_darah,
                :detail_kondisi, :kondisi, :waktu_catat, :tindakan,
                :sp02, :id_perawat, :id_rekam_medis, :id_bed, :diagnosa)"
            );
            $query->bindParam(":detak_jantung", $detak_jantung);
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
            $detak_jantung, $suhu_tubuh,
            $tekanan_darah, $detail_kondisi, $kondisi,
            $waktu_catat, $tindakan, $sp02, $id_observasi,
            $id_rekam_medis, $id_bed, $diagnosa
        ) {
            $query = $this->db->prepare(
                "UPDATE observasi_pasien set
                detak_jantung = :detak_jantung, 
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

        // untuk isi hasil lab
        public function isiHasilLab(
            $id_observasi, 
            $ph, $hb, $gula
            ) {
            $query = $this->db->prepare(
                "INSERT into hasil_lab
                (ph_darah, hb, gula_darah, tgl_isi, id_observasi)
                values (:ph, :hb, :gula, now(), :id_observasi)"
            );
            $query->bindParam(":ph", $ph);
            $query->bindParam(":hb", $hb);
            $query->bindParam(":gula", $gula);
            $query->bindParam(":id_observasi", $id_observasi);
            $query->execute();
        }

        // untuk edit hasil lab
        public function editHasilLab(
            $id_hasil_lab, 
            $ph, $hb, $gula
            ) {
            $query = $this->db->prepare(
                "UPDATE hasil_lab set
                ph_darah = :ph, 
                hb = :hb, 
                gula_darah = :gula, 
                tgl_isi = now()
                where id_hasil_lab = :id_hasil_lab"
            );
            $query->bindParam(":ph", $ph);
            $query->bindParam(":hb", $hb);
            $query->bindParam(":gula", $gula);
            $query->bindParam(":id_hasil_lab", $id_hasil_lab);
            $query->execute();
        }

        // hapus hasil lab
        public function hapusHasilLab(
            $id_hasil_lab
            ) {
            $query = $this->db->prepare(
                "DELETE from hasil_lab
                where id_hasil_lab = :id_hasil_lab"
            );
            $query->bindParam(":id_hasil_lab", $id_hasil_lab);
            $query->execute();
        }

        // ambil informasi hasil lab (untuk edit)
        public function ambilHasilLab(
            $id_hasil_lab
            ) {
            $query = $this->db->prepare(
                "SELECT ph_darah, hb, gula_darah
                from hasil_lab
                where id_hasil_lab = :id_hasil_lab"
            );
            $query->bindParam(":id_hasil_lab", $id_hasil_lab);
            $query->execute();
            $hasil = $query->fetch(PDO::FETCH_ASSOC);
            return $hasil;
        }
    }
?>