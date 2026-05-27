<?php 
    require_once __DIR__ . "/../../core/Model.php";

    class KeluargaPasienModel extends Model {

        // ambil status wali
        public function ambilStatusWali() {
            $query = $this->db->prepare(
                "SELECT nama_status status_wali
                from status_wali"
            );
            $query->execute();
            $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
            return $hasil;
        }

        // isi data diri pengantar
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
            $query->bindParam(":status_wali", $stat);
            $query->bindParam(":nik_wali", $nik_wali);
            $query->bindParam(":no_hp", $no_hp);
            $query->bindParam(":alamat", $alamat);
            $query->bindParam(":dokumen_ttd", $dokumen_ttd);
            $query->bindParam(":id_pasien", $id_pasien);
            $query->execute();
        }

        // edit data diri pengantar
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
            $query->bindParam(":status_wali", $stat);
            $query->bindParam(":nik_wali", $nik_wali);
            $query->bindParam(":no_hp", $no_hp);
            $query->bindParam(":alamat", $alamat);
            $query->bindParam(":dokumen_ttd", $dokumen_ttd);
            $query->bindParam(":id_pengantar", $id_pengantar);
            $query->execute();
        }

        // akses data diri pengantar (untuk merubah barangkali buth ditampilkan)
        public function ambilDataDiriPengantar(
            $id_pengantar
        ) {
            $query = $this->db->prepare(
                "SELECT 
                nama_lengkap, 
                status_wali, 
                nik_wali,
                no_hp, 
                alamat, 
                dokumen_ttd
                from data_diri_pegantar
                where id_pengantar = :id_pengantar"
            );
            $query->bindParam(":id_pengantar", $id_pengantar);
            $query->execute();
            $hasil = $query->fetch(PDO::FETCH_ASSOC);
            return $hasil;
        }
    }
?>