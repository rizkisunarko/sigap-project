<?php 
    require_once __DIR__ . "/../../core/Model.php";

    class PerawatModel extends Model {

        public function prosesCheckInPerawat($nama_asli, $divisi, $shift) {
    
            $queryPerawat = $this->db->prepare(
                "SELECT id_perawat FROM data_perawat WHERE nama_lengkap = :nama"
            );
            $queryPerawat->bindParam(":nama", $nama_asli);
            $queryPerawat->execute();
            $data_perawat = $queryPerawat->fetch(PDO::FETCH_ASSOC);

            if ($data_perawat) {
                return [
                    'id_perawat' => $data_perawat['id_perawat'],
                    'nama_lengkap' => $nama_asli
                ];
            }


            $queryDivisi = $this->db->prepare("SELECT id_divisi FROM divisi_perawat WHERE nama_divisi = :divisi");
            $queryDivisi->bindParam(":divisi", $divisi);
            $queryDivisi->execute();
            $data_divisi = $queryDivisi->fetch(PDO::FETCH_ASSOC);

            if (!$data_divisi) {
                $insertDivisi = $this->db->prepare("INSERT INTO divisi_perawat (nama_divisi) VALUES (:divisi)");
                $insertDivisi->bindParam(":divisi", $divisi);
                $insertDivisi->execute();
                $id_divisi_baru = $this->db->lastInsertId();
            } else {
                $id_divisi_baru = $data_divisi['id_divisi'];
            }

            $insertPerawat = $this->db->prepare("INSERT INTO data_perawat (nama_lengkap, id_divisi) VALUES (:nama, :id_divisi)");
            $insertPerawat->bindParam(":nama", $nama_asli);
            $insertPerawat->bindParam(":id_divisi", $id_divisi_baru);
            $insertPerawat->execute();
            
            $id_perawat_baru = $this->db->lastInsertId();

            return [
                'id_perawat' => $id_perawat_baru,
                'nama_lengkap' => $nama_asli
            ];
        }


        public function ambilPerawat() {
            $query = $this->db->prepare(
                "SELECT nama_lengkap
                from data_perawat"
            );
            $query->execute();
            $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
            return $hasil;
        }

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

        public function ambilTugasDivisi($divisi) {
            $query = $this->db->prepare(
                "SELECT
                dts.shift_ke,
                dts.id_detail_s
                from detail_tugas_shift dts
                join tugas_divisi ts on ts.id_detail_s = dts.id_detail_s
                join divisi_perawat dp on dp.id_divisi = ts.id_divisi
                where dp.nama_divisi = :divisi"
            );
            $query->bindParam(":divisi", $divisi);
            $query->execute();
            $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
            return $hasil;
        }

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
                "SELECT count(op.id_observasi) as pasien_kritis
                from observasi_pasien op
                join kondisi k on k.id_kondisi = op.id_kondisi
                where k.nama_kondisi = 'kritis'"
            );
            $query->execute();
            $hasil3 = $query->fetch(PDO::FETCH_ASSOC);
            
            $akhir = [$hasil2, $hasil, $hasil3];
            return $akhir;
        }

        public function ketersediaanBed() {
            $query = $this->db->prepare(
                "SELECT b.nomor_bed, sb.detail_status, sb.nama_status status_bed
                from bed b
                join status_bed sb on sb.id_st_bed = b.id_st_bed"
            );
            $query->execute();
            $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
            return $hasil;
        }

        public function antreanMasuk() {
            $query = $this->db->prepare(
                "SELECT ddp.nama_lengkap, u.nama_urgensi urgensi
                from rekam_medis rk
                join data_diri_pasien ddp on ddp.id_pasien = rk.id_pasien
                left join observasi_pasien op on op.id_rekam_medis = rk.id_rekam_medis
                left join urgensi u on u.id_urgensi = rk.id_urgensi
                where rk.tanggal_masuk = current_date() and op.id_observasi is null
                order by u.nama_urgensi"
            );
            $query->execute();
            $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
            return $hasil;
        }

        public function ambilTugasShift($detail_s, $id_perawat) {
            $query = $this->db->prepare(
                "SELECT
                dts.tugas_shift,
                dts.tenggat,
                COALESCE(sl.nama_status, 'Belum Dikerjakan') AS status_dilakukan
                from data_perawat dp
                join divisi_perawat dv on dv.id_divisi = dp.id_divisi
                join tugas_divisi td on td.id_divisi = dv.id_divisi
                join detail_tugas_shift dts on dts.id_detail_s = td.id_detail_s
                left join (
                    select l1.*
                    from log_tugas_shift l1
                    join (
                        select
                            id_detail_s,
                            id_perawat,
                            MAX(tgl_dan_waktu) waktu_terbaru
                        from log_tugas_shift
                        where date(tgl_dan_waktu) = CURDATE()
                        group by id_detail_s, id_perawat
                    ) latest on latest.id_detail_s = l1.id_detail_s
                    and latest.id_perawat = l1.id_perawat
                    and latest.waktu_terbaru = l1.tgl_dan_waktu

                ) lts on lts.id_detail_s = dts.id_detail_s
                and lts.id_perawat = dp.id_perawat
                left join status_log sl on sl.id_st_log = lts.id_st_log
                where 
                    dp.id_perawat = :id_perawat
                    and dts.id_detail_s = :id_detail_s
                order by dts.shift_ke, dts.tenggat"
            );
            $query->bindParam(":id_detail_s", $detail_s);
            $query->bindParam(":id_perawat", $id_perawat);
            $query->execute();
            $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
            return $hasil;
        }

        public function isiLogShift($id_detail_s, $nama_status) {
            $query = $this->db->prepare(
                "SELECT id_st_log
                from status_log
                where nama_status = :nama_status"
            );
            $query->bindParam(":nama_status", $nama_status);
            $query->execute();
            $stat = $query->fetch(PDO::FETCH_ASSOC);
            
            $query = $this->db->prepare(
                "INSERT into log_tugas_shift
                (tgl_dan_waktu, id_detail_s, id_st_log)
                values 
                (now(), :id_detail_s, :id_st_log)"
            );
            $query->bindParam(":id_detail_s", $id_detail_s);
            $id_st_log_val = $stat ? $stat['id_st_log'] : null;
            $query->bindParam(":id_st_log", $id_st_log_val);
            $query->execute();
        }

        public function ambilSeluruhDataPasienAktif() {
            $query = $this->db->prepare(
                "SELECT 
                rk.id_rekam_medis,
                u.nama_urgensi AS urgensi,
                ddp.id_pasien,
                ddp.nama_lengkap,
                ddp.nik,
                ddp.asal,
                ddp.tgl_lahir,
                ddp.jenis_kelamin,
                ddp.agama,
                sp.nama_status AS status_perkawinan,
                ddp.pekerjaan,
                ddp.alamat,
                ddp.nomor_bpjs,
                ddp.golongan_darah,
                ddp.kewarganegaraan,
                ap.id_pengguna,
                ap.username,
                ddpr.id_pengantar,
                ddpr.nama_lengkap AS nama_wali,
                sw.nama_status AS status_wali,
                ddpr.nik_wali,
                ddpr.no_hp AS no_hp_wali,
                ddpr.alamat AS alamat_wali,
                (
                    SELECT k.nama_kondisi
                    FROM observasi_pasien op
                    JOIN kondisi k ON k.id_kondisi = op.id_kondisi
                    WHERE op.id_rekam_medis = rk.id_rekam_medis
                    ORDER BY op.waktu_catat DESC
                    LIMIT 1
                ) AS status_klinis,
                (
                    SELECT b.nomor_bed
                    FROM observasi_pasien op
                    JOIN bed b ON b.id_bed = op.id_bed
                    WHERE op.id_rekam_medis = rk.id_rekam_medis
                    ORDER BY op.waktu_catat DESC
                    LIMIT 1
                ) AS nomor_bed
            FROM rekam_medis rk
            JOIN data_diri_pasien ddp ON ddp.id_pasien = rk.id_pasien
            LEFT JOIN akun_pengguna ap ON ap.id_pengguna = ddp.id_pengguna
            LEFT JOIN status_perkawinan sp ON sp.id_st_perkawinan = ddp.id_st_perkawinan
            LEFT JOIN data_diri_pengantar ddpr ON ddpr.id_pasien = ddp.id_pasien
            LEFT JOIN status_wali sw ON sw.id_st_wali = ddpr.id_st_wali
            LEFT JOIN urgensi u ON u.id_urgensi = rk.id_urgensi
            WHERE rk.tanggal_keluar IS NULL
            ORDER BY rk.id_rekam_medis DESC"
            );
            $query->execute();
            $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
            return $hasil;
        }

        public function tampilSeluruhPasienTerdaftar() {
            $query = $this->db->prepare(
                "SELECT 
                rk.id_rekam_medis,
                u.nama_urgensi,
                ddp.id_pasien,
                ddp.nama_lengkap,
                ddp.nik,
                ddp.asal,
                ddp.tgl_lahir,
                ddp.jenis_kelamin,
                ddp.agama,
                sp.nama_status AS status_perkawinan,
                ddp.pekerjaan,
                ddp.alamat,
                ddp.nomor_bpjs,
                ddp.golongan_darah,
                ddp.kewarganegaraan,
                ap.id_pengguna,
                ap.username,
                ddpr.id_pengantar,
                ddpr.nama_lengkap AS nama_wali,
                sw.nama_status AS status_wali,
                ddpr.nik_wali,
                ddpr.no_hp AS no_hp_wali,
                ddpr.alamat AS alamat_wali,
                (
                    SELECT k.nama_kondisi
                    FROM observasi_pasien op
                    JOIN kondisi k ON k.id_kondisi = op.id_kondisi
                    WHERE op.id_rekam_medis = rk.id_rekam_medis
                    ORDER BY op.waktu_catat DESC
                    LIMIT 1
                ) AS status_klinis,
                (
                    SELECT b.nomor_bed
                    FROM observasi_pasien op
                    JOIN bed b ON b.id_bed = op.id_bed
                    WHERE op.id_rekam_medis = rk.id_rekam_medis
                    ORDER BY op.waktu_catat DESC
                    LIMIT 1
                ) AS nomor_bed
                FROM rekam_medis rk
                JOIN data_diri_pasien ddp ON ddp.id_pasien = rk.id_pasien
                LEFT JOIN akun_pengguna ap ON ap.id_pengguna = ddp.id_pengguna
                LEFT JOIN status_perkawinan sp ON sp.id_st_perkawinan = ddp.id_st_perkawinan
                LEFT JOIN data_diri_pengantar ddpr ON ddpr.id_pasien = ddp.id_pasien
                LEFT JOIN status_wali sw ON sw.id_st_wali = ddpr.id_st_wali
                LEFT JOIN urgensi u ON u.id_urgensi = rk.id_urgensi
                ORDER BY rk.id_rekam_medis DESC;"
            );
            $query->execute();
            $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
            return $hasil;
        }
    }
?>