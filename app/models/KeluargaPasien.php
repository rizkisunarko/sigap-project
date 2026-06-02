<?php 
    require_once __DIR__ . '/../../core/Model.php';

    class KeluargaPasienModel extends Model {

        public function ambilStatusWali() {
            $query = $this->db->prepare(
                "SELECT nama_status status_wali
                from status_wali"
            );
            $query->execute();
            $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
            return $hasil;
        }

        public function isiDataDiriPengantar(
            $nama_lengkap, $status_wali, $nik_wali,
            $no_hp, $alamat, $dokumen_ttd, $id_pasien 
        ) {
            $query = $this->db->prepare(
                "SELECT id_st_wali
                from status_wali
                where nama_status = :nama_status"
            );
            $query->bindParam(":nama_status", $status_wali);
            $query->execute();
            $stat = $query->fetch(PDO::FETCH_ASSOC);
            
            $query = $this->db->prepare(
                "INSERT into data_diri_pengantar
                (nama_lengkap, id_st_wali, nik_wali,
                no_hp, alamat, dokumen_ttd, id_pasien)
                values (:nama_lengkap, :status_wali,
                :nik_wali, :no_hp, :alamat, :dokumen_ttd,
                :id_pasien)"
            );
            $query->bindParam(":nama_lengkap", $nama_lengkap);
            $id_st = $stat ? $stat['id_st_wali'] : null;
            $query->bindParam(":status_wali", $id_st);
            $query->bindParam(":nik_wali", $nik_wali);
            $query->bindParam(":no_hp", $no_hp);
            $query->bindParam(":alamat", $alamat);
            $query->bindParam(":dokumen_ttd", $dokumen_ttd);
            $query->bindParam(":id_pasien", $id_pasien);
            $query->execute();
        }

        public function editDataDiriPengantar(
            $id_pengantar, $nama_lengkap, $status_wali, $nik_wali,
            $no_hp, $alamat, $dokumen_ttd, $id_pasien 
        ) {
            $query = $this->db->prepare(
                "SELECT id_st_wali
                from status_wali
                where nama_status = :nama_status"
            );
            $query->bindParam(":nama_status", $status_wali);
            $query->execute();
            $stat = $query->fetch(PDO::FETCH_ASSOC);
            
            $query = $this->db->prepare(
                "UPDATE data_diri_pengantar set
                nama_lengkap = :nama_lengkap, 
                id_st_wali = :status_wali, 
                nik_wali = :nik_wali,
                no_hp = :no_hp, 
                alamat = :alamat, 
                dokumen_ttd = :dokumen_ttd
                where id_pengantar = :id_pengantar
                "
            );
            $query->bindParam(":nama_lengkap", $nama_lengkap);
            $id_st = $stat ? $stat['id_st_wali'] : null;
            $query->bindParam(":status_wali", $id_st);
            $query->bindParam(":nik_wali", $nik_wali);
            $query->bindParam(":no_hp", $no_hp);
            $query->bindParam(":alamat", $alamat);
            $query->bindParam(":dokumen_ttd", $dokumen_ttd);
            $query->bindParam(":id_pengantar", $id_pengantar);
            $query->execute();
        }


        public function getDataPasienAktif($id_pengguna) {
            $query = $this->db->prepare(
                "SELECT dp.*, rm.id_rekam_medis, b.nomor_bed 
                 FROM data_diri_pasien dp
                 LEFT JOIN rekam_medis rm ON dp.id_pasien = rm.id_pasien
                 LEFT JOIN observasi_pasien op ON rm.id_rekam_medis = op.id_rekam_medis
                 LEFT JOIN bed b ON op.id_bed = b.id_bed
                 WHERE dp.id_pengguna = :id_pengguna 
                 ORDER BY rm.tanggal_masuk DESC LIMIT 1"
            );
            $query->bindParam(":id_pengguna", $id_pengguna);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        }

        public function getRiwayatObservasi($id_rekam_medis) {
            $query = $this->db->prepare(
                "SELECT op.*, p.nama_lengkap as nama_perawat 
                 FROM observasi_pasien op
                 LEFT JOIN data_perawat p ON op.id_perawat = p.id_perawat
                 WHERE op.id_rekam_medis = :id_rekam_medis 
                 ORDER BY op.waktu_catat DESC"
            );
            $query->bindParam(":id_rekam_medis", $id_rekam_medis);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC); 
        }

        public function getHasilLabTerbaru($id_observasi) {
            $query = $this->db->prepare(
                "SELECT * FROM hasil_lab WHERE id_observasi = :id_observasi ORDER BY tgl_isi DESC LIMIT 1"
            );
            $query->bindParam(":id_observasi", $id_observasi);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        }

        
        public function ambilDataDiriPengantar($id_pengantar) {
            $query = $this->db->prepare(
                "SELECT 
                nama_lengkap, 
                id_st_wali as status_wali, 
                nik_wali,
                no_hp, 
                alamat, 
                dokumen_ttd
                from data_diri_pengantar
                where id_pengantar = :id_pengantar"
            );
            $query->bindParam(":id_pengantar", $id_pengantar);
            $query->execute();
            $hasil = $query->fetch(PDO::FETCH_ASSOC);
            return $hasil;
        }
    }
?>