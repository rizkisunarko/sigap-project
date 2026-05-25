<?php 
    require_once __DIR__ . "/../../core/Model.php";

    class PerawatModel extends Model {
        
        // masuk akun perawat
        // ------------------------------------
        public function ambilPerawat() {
            $query = $this->db->prepare(
                "SELECT nama_lengkap
                from data_perawat"
            );
            $query->execute();
            $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
            return $hasil;
        }

        // ambil divisi dari nama perawat
        public function ambilDivisi($nama_perawat) {
            $query = $this->db->prepare(
                "SELECT nama_divisi
                from divisi_perawat dpr
                join data_perawat dp on dp.id_divisi = dpr.id_divisi
                where dp.nama_lengkap = :nama_perawat"
            );
            $query->bindParam(":nama_perawat", $nama_perawat);
            $query->execute();
            $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
            return $hasil;
        }

        // ambil shift dari divisi perawat
        public function ambilShift($divisi) {
            $query = $this->db->prepare(
                "SELECT ts.nomor_shift, dts.id_detail_s
                from tugas_shift ts
                join divisi_perawat dp on dp.id_divisi = ts.id_divisi
                join detail_tugas_shift dts on dts.id_shift = ts.id_shift
                where dp.nama_divisi = :divisi;"
            );
            $query->bindParam(":divisi", $divisi);
            $query->execute();
            $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
            return $hasil;
        }
        // -----------------------

        // dashboard
        // --------------------------------------
        // pasien aktif dan kapasitas bed
        public function pasienAktif_kapasitasBed_pasienKritis() {
            $query = $this->db->prepare(
                "SELECT count(id_bed) as kapasitas
                from bed"
                );
            $query->execute();
            $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
            $query = $this->db->prepare(
                "SELECT count(id_rekam_medis) as pasien_aktif
                from rekam_medis
                where tanggal_keluar is null"
            );
            $query->execute();
            $hasil2 = $query->fetchAll(PDO::FETCH_ASSOC);
            $query = $this->db->prepare(
                "SELECT count(id_observasi) as pasien_kritis
                from observasi_pasien
                where kondisi = 'kritis'"
            );
            $query->execute();
            $hasil3 = $query->fetch(PDO::FETCH_ASSOC);
            $akhir = [$hasil2, $hasil, $hasil3];
            return $akhir;
        }

        // ketersediaan bed
        public function ketersediaanBed() {
            $query = $this->db->prepare(
                "SELECT b.nomor_bed, sb.detail_status, sb.status_bed
                from bed b
                join status_bed sb on sb.id_status = b.id_status"
            );
            $query->execute();
            $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
            return $hasil;
        }

        // antrean masuk (diperoleh dari pasien yang pada hari tersebut tidak ada hasil observasinya)
        public function antreanMasuk() {
            $query = $this->db->prepare(
                "SELECT ddp.nama_lengkap, rk.urgensi 
                from rekam_medis rk
                join data_diri_pasien ddp on ddp.id_pasien = rk.id_pasien
                left join observasi_pasien op on op.id_rekam_medis = rk.id_rekam_medis
                where rk.tanggal_masuk = current_date() and op.id_observasi is null
                order by urgensi"
            );
            $query->execute();
            $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
            return $hasil;
        }

        // tugas shift
        public function ambilTugasShift($detail_s) {
            $query = $this->db->prepare(
                "SELECT dts.tugas_shift, dts.tenggat, lts.status_dilakukan
                from detail_tugas_shift dts
                left join log_tugas_shift lts on lts.id_detail_s = dts.id_detail_s
                where dts.id_detail_s = :id_detail_s;"
            );
            $query->bindParam(":id_detail_s", $detail_s);
            $query->execute();
            $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
            return $hasil;
        }
    }
?>