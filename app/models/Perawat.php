<?php 
    require_once __DIR__ . "/../../core/Model.php";

    class PerawatModel extends Model {

        public function prosesCheckInPerawat($nama_asli, $divisi, $shift) {

            $queryDivisi = $this->db->prepare("SELECT id_divisi FROM divisi_perawat WHERE nama_divisi = :divisi");
            $queryDivisi->bindParam(":divisi", $divisi);
            $queryDivisi->execute();
            $data_divisi = $queryDivisi->fetch(PDO::FETCH_ASSOC);

            if (!$data_divisi) {
                return false; 
            }
            
            $id_divisi_target = $data_divisi['id_divisi'];


            $queryPerawat = $this->db->prepare(
                "SELECT id_perawat, id_divisi FROM data_perawat WHERE nama_lengkap = :nama"
            );
            $queryPerawat->bindParam(":nama", $nama_asli);
            $queryPerawat->execute();
            $data_perawat = $queryPerawat->fetch(PDO::FETCH_ASSOC);

            if ($data_perawat) {
                if ($data_perawat['id_divisi'] != $id_divisi_target) {
                    $updatePerawat = $this->db->prepare(
                        "UPDATE data_perawat SET id_divisi = :id_divisi WHERE id_perawat = :id_perawat"
                    );
                    $updatePerawat->bindParam(":id_divisi", $id_divisi_target);
                    $updatePerawat->bindParam(":id_perawat", $data_perawat['id_perawat']);
                    $updatePerawat->execute();
                }
                
                return [
                    'id_perawat' => $data_perawat['id_perawat'],
                    'nama_lengkap' => $nama_asli
                ];
            }


            $insertPerawat = $this->db->prepare(
                "INSERT INTO data_perawat (nama_lengkap, id_divisi) VALUES (:nama, :id_divisi)"
            );
            $insertPerawat->bindParam(":nama", $nama_asli);
            $insertPerawat->bindParam(":id_divisi", $id_divisi_target);
            $insertPerawat->execute();
            
            $id_perawat_baru = $this->db->lastInsertId();

            return [
                'id_perawat' => $id_perawat_baru,
                'nama_lengkap' => $nama_asli
            ];
        }

        public function ambilPerawat() {
            $query = $this->db->prepare("SELECT nama_lengkap from data_perawat");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
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
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function pasienAktif_kapasitasBed_pasienKritis() {

            $query = $this->db->prepare("SELECT count(id_bed) as kapasitas from bed");
            $query->execute();
            $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
            

            $query = $this->db->prepare("SELECT count(id_rekam_medis) as pasien_aktif from rekam_medis where tanggal_keluar is null");
            $query->execute();
            $hasil2 = $query->fetchAll(PDO::FETCH_ASSOC);
            

            $query = $this->db->prepare(
                "SELECT COUNT(DISTINCT rk.id_pasien) as pasien_kritis
                FROM rekam_medis rk
                WHERE rk.tanggal_keluar IS NULL
                AND (
                    SELECT k.nama_kondisi
                    FROM observasi_pasien op
                    JOIN kondisi k ON k.id_kondisi = op.id_kondisi
                    WHERE op.id_rekam_medis = rk.id_rekam_medis
                    ORDER BY op.waktu_catat DESC
                    LIMIT 1
                ) = 'kritis'"
            );
            $query->execute();
            $hasil3 = $query->fetch(PDO::FETCH_ASSOC);
            
            return [$hasil2, $hasil, $hasil3];
        }

        public function ketersediaanBed() {
            $query = $this->db->prepare(
                "SELECT b.nomor_bed, sb.nama_status status_bed
                from bed b
                join status_bed sb on sb.id_st_bed = b.id_st_bed"
            );
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function antreanMasuk() {
            $query = $this->db->prepare(
                "SELECT 
                    ddp.nama_lengkap, 
                    u.nama_urgensi AS urgensi
                FROM rekam_medis rk
                JOIN data_diri_pasien ddp ON ddp.id_pasien = rk.id_pasien
                LEFT JOIN urgensi u ON u.id_urgensi = rk.id_urgensi
                WHERE rk.tanggal_keluar IS NULL 
                AND NOT EXISTS (
                    SELECT 1 
                    FROM observasi_pasien op 
                    WHERE op.id_rekam_medis = rk.id_rekam_medis 
                    AND op.id_bed IS NOT NULL
                )
                ORDER BY u.nama_urgensi ASC"
            );
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function ambilTugasShift($nama_divisi, $shift_teks, $id_perawat) {
            $shift_ke = (int) preg_replace('/[^0-9]/', '', $shift_teks);

            $query = $this->db->prepare(
                "SELECT 
                    dts.id_detail_s,
                    dts.tugas_shift,
                    dts.tenggat,
                    COALESCE(CASE WHEN sl.nama_status = 'Selesai' THEN 'sudah' ELSE 'belum' END, 'belum') AS status_dilakukan
                FROM detail_tugas_shift dts
                JOIN tugas_divisi td ON td.id_detail_s = dts.id_detail_s
                JOIN divisi_perawat dp ON dp.id_divisi = td.id_divisi
                LEFT JOIN (
                    SELECT l1.id_detail_s, l1.id_st_log, l1.id_perawat
                    FROM log_tugas_shift l1
                    JOIN (
                        SELECT id_detail_s, MAX(tgl_dan_waktu) as max_waktu
                        FROM log_tugas_shift
                        WHERE id_perawat = :id_perawat 
                        AND DATE(DATE_SUB(tgl_dan_waktu, INTERVAL 8 HOUR)) = DATE(DATE_SUB(NOW(), INTERVAL 8 HOUR))
                        GROUP BY id_detail_s
                    ) l2 ON l1.id_detail_s = l2.id_detail_s AND l1.tgl_dan_waktu = l2.max_waktu
                    WHERE l1.id_perawat = :id_perawat
                ) log_terbaru ON log_terbaru.id_detail_s = dts.id_detail_s
                LEFT JOIN status_log sl ON sl.id_st_log = log_terbaru.id_st_log
                WHERE dp.nama_divisi = :nama_divisi 
                AND dts.shift_ke = :shift_ke
                ORDER BY dts.tenggat ASC"
            );
            
            $query->bindParam(":nama_divisi", $nama_divisi);
            $query->bindParam(":shift_ke", $shift_ke, PDO::PARAM_INT);
            $query->bindParam(":id_perawat", $id_perawat, PDO::PARAM_INT);
            $query->execute();
            
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function perbaruiStatusLogTugas($id_detail_s, $id_perawat, $status_teks) {
            try {
                $qStatus = $this->db->prepare("SELECT id_st_log FROM status_log WHERE LOWER(nama_status) = LOWER(:status_teks)");
                $qStatus->execute([':status_teks' => $status_teks]);
                $id_st_log = $qStatus->fetchColumn();

                if (!$id_st_log) return false;

                $qInsert = $this->db->prepare(
                    "INSERT INTO log_tugas_shift (tgl_dan_waktu, id_detail_s, id_st_log, id_perawat) 
                     VALUES (NOW(), :id_detail_s, :id_st_log, :id_perawat)"
                );
                return $qInsert->execute([
                    ':id_detail_s' => $id_detail_s,
                    ':id_st_log' => $id_st_log,
                    ':id_perawat' => $id_perawat
                ]);
            } catch (PDOException $e) {
                error_log("Gagal update tugas shift: " . $e->getMessage());
                return false;
            }
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
            return $query->fetchAll(PDO::FETCH_ASSOC);
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
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>