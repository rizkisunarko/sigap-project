<?php 
    require_once __DIR__ . "/../../core/Model.php";

    class DokumenRujukanModel extends Model {
            
        // status rujukan
        public function ambilStatusRujukan() {
            $query = $this->db->prepare(
                "SELECT nama_status status_dokumen
                from status_rujukan"
            );
            $query->execute();
            $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
            return $hasil;
        }

        // isi data rujukan
        public function isiDataRujukan(
            $dokumen_rujukan, $status_dokumen,
            $detail_status, $id_pasien
        ) {
            $query = $this->db->prepare(
                "SELECT id_st_rujukan 
                from status_rujukan
                where nama_status = :nama_status"
            );
            $query->bindParam(":nama_status", $status_dokumen);
            $query->execute();
            $stat = $query->fetch(PDO::FETCH_ASSOC);
            $query = $this->db->prepare(
                "INSERT into rujukan 
                (dokumen_rujukan, id_st_rujukan,
                detail_status, id_pasien)
                values (:dokumen_rujukan, :id_st_rujukan,
                :detail_status, :id_pasien)"
            );
            $query->bindParam(":dokumen_rujukan", $dokumen_rujukan);
            $query->bindParam(":id_st_rujukan", $stat);
            $query->bindParam(":detail_status", $detail_status);
            $query->bindParam(":id_pasien", $id_pasien);
            $query->execute();
        }

        // edit data rujukan
        public function editDataRujukan(
            $id_rujukan, $dokumen_rujukan, $status_dokumen,
            $detail_status, $id_pasien
        ) {
            $query = $this->db->prepare(
                "SELECT id_st_rujukan 
                from status_rujukan
                where nama_status = :nama_status"
            );
            $query->bindParam(":nama_status", $status_dokumen);
            $query->execute();
            $stat = $query->fetch(PDO::FETCH_ASSOC);
            $query = $this->db->prepare(
                "UPDATE rujukan set 
                dokumen_rujukan = :dokumen_rujukan, 
                id_st_rujukan = :status_dokumen,
                detail_status = :detail_status,
                where id_rujukan = :id_rujukan"
            );
            $query->bindParam(":dokumen_rujukan", $dokumen_rujukan);
            $query->bindParam(":status_dokumen", $stat);
            $query->bindParam(":detail_status", $detail_status);
            $query->bindParam(":id_pasien", $id_pasien);
            $query->bindParam(":id_rujukan", $id_rujukan);
            $query->execute();
        }

        // hapus data rujukan
        public function hapusDataRujukan(
            $id_rujukan
        ) {
            $query = $this->db->prepare(
                "DELETE from rujukan where id_rujukan = :id_rujukan"
            );
            $query->bindParam(":id_rujukan", $id_rujukan);
            $query->execute();
        }

        // ambil data rujukan suatu pasien
        public function tampilDataRujukan (
            $id_pasien
        ) {
            $query = $this->db->prepare(
                "SELECT r.id_rujukan, r.dokumen_rujukan, r.status_dokumen, r.detail_status 
                from rujukan r
                right join data_diri_pasien ddp on ddp.id_pasien = r.id_pasien
                where ddp.id_pasien = :id_pasien
                order by r.id_rujukan desc"
                );
            $query->bindParam(":id_pasien", $id_pasien);
            $query->execute();
            $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
            return $hasil;
        }

        // ambil semua data rujukan (barangkali untuk yang mneghandle data rujukan)
        public function ambilDataRujukan () {
            $query = $this->db->prepare(
                "SELECT r.id_rujukan, r.dokumen_rujukan, r.status_dokumen, r.detail_status, ddp.nama_lengkap 
                from rujukan r
                right join data_diri_pasien ddp on ddp.id_pasien = r.id_pasien
                order by r.id_rujukan desc"
                );
            $query->bindParam(":id_pasien", $id_pasien);
            $query->execute();
            $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
            return $hasil;
        }
    }
?>