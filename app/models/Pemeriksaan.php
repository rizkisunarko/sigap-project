<?php 
    
    require_once __DIR__ . "/../../core/Model.php";

    class PemeriksaanModel extends Model {

        public function ambilStatusKondisi() {
            $query = $this->db->prepare(
                "SELECT nama_kondisi kondisi
                from kondisi"
            );
            $query->execute();
            $hasil = $query->fetch(PDO::FETCH_ASSOC);
            return $hasil;
        }

        public function isiObservasiPasien(
            $detak_jantung, $suhu_tubuh,
            $tekanan_darah, $detail_kondisi, $kondisi,
            $waktu_catat, $tindakan, $sp02, $id_perawat,
            $id_rekam_medis, $id_bed, $diagnosa
        ) {
            $query = $this->db->prepare(
                "SELECT id_kondisi
                from kondisi
                where nama_kondsi = :nama_kondisi"
            );
            $query->bindParam(":nama_kondisi", $kondisi);
            $stat = $query->fetch(PDO::FETCH_ASSOC);
            $query = $this->db->prepare(
                "INSERT into observasi_pasien
                (detak_jantung, suhu_tubuh, tekanan_darah,
                detail_kondisi, id_kondisi, waktu_catat, tindakan, 
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
            $query->bindParam(":kondisi", $stat);
            $query->bindParam(":waktu_catat", $waktu_catat);
            $query->bindParam(":tindakan", $tindakan);
            $query->bindParam(":sp02", $sp02);
            $query->bindParam(":id_perawat", $id_perawat);
            $query->bindParam(":id_rekam_medis", $id_rekam_medis);
            $query->bindParam(":id_bed", $id_bed);
            $query->bindParam(":diagnosa", $diagnosa);
            $query->execute();
        }

        public function editObservasiPasien(
            $detak_jantung, $suhu_tubuh,
            $tekanan_darah, $detail_kondisi, $kondisi,
            $waktu_catat, $tindakan, $sp02, $id_observasi,
            $id_rekam_medis, $id_bed, $diagnosa
        ) {
            $query = $this->db->prepare(
                "SELECT id_kondisi
                from kondisi
                where nama_kondsi = :nama_kondisi"
            );
            $query->bindParam(":nama_kondisi", $kondisi);
            $stat = $query->fetch(PDO::FETCH_ASSOC);
            $query = $this->db->prepare(
                "UPDATE observasi_pasien set
                detak_jantung = :detak_jantung, 
                suhu_tubuh = :suhu_tubuh, 
                tekanan_darah = :tekanan_darah,
                detail_kondisi = :detail_kondisi, 
                id_kondisi = :kondisi, 
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
            $query->bindParam(":kondisi", $stat);
            $query->bindParam(":waktu_catat", $waktu_catat);
            $query->bindParam(":tindakan", $tindakan);
            $query->bindParam(":sp02", $sp02);
            $query->bindParam(":id_observasi", $id_observasi);
            $query->bindParam(":id_rekam_medis", $id_rekam_medis);
            $query->bindParam(":id_bed", $id_bed);
            $query->bindParam(":diagnosa", $diagnosa);
            $query->execute();
        }

        public function ambilObservasi(
            $id_observasi
        ) {
            $query = $this->db->prepare(
                "SELECT detak_jantung, suhu_tubuh, tekanan_darah,
                detail_kondisi, kondisi, waktu_catat, tindakan, 
                sp02, id_perawat, id_rekam_medis, id_bed, diagnosa
                from observasi_pasien
                where id_observasi = :id_observasi"
            );
            $query->bindParam(":id_observasi", $id_observasi);
            $query->execute();
            $hasil = $query->fetch(PDO::FETCH_ASSOC);
            return $hasil;
        }

        public function hapusObservasiPasien($id_observasi) {
            $query = $this->db->prepare(
                "DELETE from observasi_pasien
                where id_observasi = :id_observasi"
            );
            $query->bindParam(":id_observasi", $id_observasi);
            $query->execute();
        }

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

        public function ambilHasilLabTerbaru($id_rekam_medis) {
            $query = $this->db->prepare(
                "SELECT hl.id_hasil_lab, hl.ph_darah, hl.hb, hl.gula_darah 
                FROM hasil_lab hl
                JOIN observasi_pasien op ON hl.id_observasi = op.id_observasi
                WHERE op.id_rekam_medis = :id_rekam_medis
                ORDER BY hl.tgl_isi DESC
                LIMIT 1"
            );
            $query->execute([':id_rekam_medis' => $id_rekam_medis]);
            return $query->fetch(PDO::FETCH_ASSOC);
        }

        public function ambilObservasiTerbaru($id_rekam_medis) {
            $query = $this->db->prepare(
                "SELECT id_observasi 
                FROM observasi_pasien 
                WHERE id_rekam_medis = :id_rekam_medis 
                ORDER BY waktu_catat DESC 
                LIMIT 1"
            );
            $query->bindParam(":id_rekam_medis", $id_rekam_medis);
            $query->execute();
            $hasil = $query->fetch(PDO::FETCH_ASSOC);
            
            return $hasil ? $hasil['id_observasi'] : null;
        }
    }
