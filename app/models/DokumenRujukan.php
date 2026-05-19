<?php 
    require_once "../../core/Model.php";

    class DokumenRujukanModel extends Model {
        
        // isi data rujukan
        public function isiDataRujukan(
            $dokumen_rujukan, $status_dokumen,
            $detail_status, $id_pasien
        ) {
            $query = $this->db->prepare(
                "INSERT into rujukan 
                (dokumen_rujukan, status_dokumen,
                detail_status, id_pasien)
                values (:dokumen_rujukan, :status_dokumen,
                :detail_status, :id_pasien)"
            );
            $query->bindParam(":dokumen_rujukan", $dokumen_rujukan);
            $query->bindParam(":status_dokumen", $status_dokumen);
            $query->bindParam(":detail_status", $detail_status);
            $query->bindParam(":id_pasien", $id_pasien);
            $query->execute();
        }
    }
?>