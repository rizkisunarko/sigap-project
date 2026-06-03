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
                "SELECT 
                    ddp.*, 
                    rm.id_rekam_medis, 
                    b.nomor_bed,
                    pengantar.no_hp AS no_hp_wali   -- INI YANG DITAMBAHKAN
                FROM data_diri_pasien ddp
                LEFT JOIN rekam_medis rm ON rm.id_pasien = ddp.id_pasien AND rm.tanggal_keluar IS NULL
                LEFT JOIN observasi_pasien op ON op.id_rekam_medis = rm.id_rekam_medis
                LEFT JOIN bed b ON b.id_bed = op.id_bed
                -- INI JUGA DITAMBAHKAN:
                LEFT JOIN data_diri_pengantar pengantar ON pengantar.id_pasien = ddp.id_pasien 
                WHERE ddp.id_pengguna = :id_pengguna
                ORDER BY op.waktu_catat DESC LIMIT 1"
            );
            $query->execute([':id_pengguna' => $id_pengguna]);
            return $query->fetch(PDO::FETCH_ASSOC);
        }

        public function getRiwayatObservasi($id_rekam_medis) {
            $query = $this->db->prepare(
                "SELECT 
                    op.id_observasi,
                    op.detak_jantung, 
                    op.sp02, 
                    op.suhu_tubuh, 
                    op.tekanan_darah, 
                    op.waktu_catat, 
                    k.nama_kondisi AS kondisi, 
                    dp.nama_lengkap AS nama_perawat
                FROM observasi_pasien op
                LEFT JOIN kondisi k ON op.id_kondisi = k.id_kondisi
                LEFT JOIN data_perawat dp ON op.id_perawat = dp.id_perawat
                WHERE op.id_rekam_medis = :id_rm
                ORDER BY op.waktu_catat DESC"
            );
            $query->execute([':id_rm' => $id_rekam_medis]);
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