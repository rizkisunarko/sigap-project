<?php 
    require_once __DIR__ . "/../../core/Model.php";

    class RekamMedis extends Model {

        public function ambilStatusUrgensi() {
            $query = $this->db->prepare(
                "SELECT nama_urgensi
                from urgensi"
            );
            $query->execute();
            $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
            return $hasil;
        }

        public function ambilRekamMedis($id_rekam_medis) {
            $query = $this->db->prepare(
                "SELECT rk.id_pasien, rk.tanggal_masuk, rk.tanggal_keluar, u.nama_urgensi urgensi
                from rekam_medis rk
                left join urgensi u on u.id_urgensi = rk.id_urgensi  
                where id_rekam_medis = :id_rekam_medis"
            );       
            $query->bindParam(":id_rekam_medis", $id_rekam_medis);
            $query->execute();
            $hasil = $query->fetch(PDO::FETCH_ASSOC);
            return $hasil;  
        }

        public function IsiRekamMedis(
            $id_pasien, $tanggal_masuk, $tanggal_keluar, $urgensi
            ) {
            $query = $this->db->prepare(
                "SELECT id_urgensi
                from urgensi
                where nama_urgensi = :nama_urgensi"
            );
            $query->bindParam(":nama_urgensi", $urgensi);
            $query->execute();
            $stat = $query->fetch(PDO::FETCH_ASSOC);
            
            $id_urgensi = $stat ? $stat['id_urgensi'] : null;

            $query = $this->db->prepare(
                "INSERT into rekam_medis (
                id_pasien, 
                tanggal_masuk, 
                tanggal_keluar,
                id_urgensi
                ) values (
                :id_pasien, 
                :tanggal_masuk,
                :tanggal_keluar, 
                :urgensi)"
            );
            $query->bindParam(":id_pasien", $id_pasien);
            $query->bindParam(":tanggal_masuk", $tanggal_masuk);
            $query->bindParam(":tanggal_keluar", $tanggal_keluar);
            
            if ($id_urgensi === null) {
                $query->bindValue(":urgensi", null, PDO::PARAM_NULL);
            } else {
                $query->bindValue(":urgensi", $id_urgensi, PDO::PARAM_INT);
            }

            $query->execute();
        }

        public function editRekamMedis(
            $id_rekam_medis, $id_pasien, $tanggal_masuk,
            $tanggal_keluar, $urgensi
        ) {
            $query = $this->db->prepare(
                "SELECT id_urgensi
                from urgensi
                where nama_urgensi = :nama_urgensi"
            );
            $query->bindParam(":nama_urgensi", $urgensi);
            $query->execute();
            $stat = $query->fetch(PDO::FETCH_ASSOC);

            $id_urgensi = $stat ? $stat['id_urgensi'] : null;

            $query = $this->db->prepare(
                "UPDATE rekam_medis set 
                id_pasien = :id_pasien, 
                tanggal_masuk = :tanggal_masuk,
                tanggal_keluar = :tanggal_keluar, 
                id_urgensi = :urgensi
                where id_rekam_medis = :id_rekam_medis"
            );
            $query->bindParam(":id_pasien", $id_pasien);
            $query->bindParam(":tanggal_masuk", $tanggal_masuk);
            $query->bindParam(":tanggal_keluar", $tanggal_keluar);
            
            if ($id_urgensi === null) {
                $query->bindValue(":urgensi", null, PDO::PARAM_NULL);
            } else {
                $query->bindValue(":urgensi", $id_urgensi, PDO::PARAM_INT);
            }

            $query->bindParam(":id_rekam_medis", $id_rekam_medis);
            $query->execute();
        }

        public function hapusRekamMedis($id_rekam_medis) {
            $query = $this->db->prepare(
                "DELETE from rekam_medis 
                where id_rekam_medis = :id_rekam_medis"
            );
            $query->bindParam(":id_rekam_medis", $id_rekam_medis);
            $query->execute();
        }

        public function ambilRiwayatPasien($id_pasien) {
            $query = $this->db->prepare(
                "SELECT 
                    rm.id_rekam_medis,
                    rm.tanggal_masuk, 
                    rm.tanggal_keluar, 
                    (SELECT op.diagnosa FROM observasi_pasien op WHERE op.id_rekam_medis = rm.id_rekam_medis AND op.diagnosa IS NOT NULL AND op.diagnosa != '' ORDER BY op.waktu_catat DESC LIMIT 1) as diagnosa,
                    (SELECT op.detak_jantung FROM observasi_pasien op WHERE op.id_rekam_medis = rm.id_rekam_medis ORDER BY op.waktu_catat DESC LIMIT 1) as detak_jantung,
                    (SELECT op.sp02 FROM observasi_pasien op WHERE op.id_rekam_medis = rm.id_rekam_medis ORDER BY op.waktu_catat DESC LIMIT 1) as oksigen,
                    (SELECT op.suhu_tubuh FROM observasi_pasien op WHERE op.id_rekam_medis = rm.id_rekam_medis ORDER BY op.waktu_catat DESC LIMIT 1) as suhu_tubuh,
                    (SELECT op.tekanan_darah FROM observasi_pasien op WHERE op.id_rekam_medis = rm.id_rekam_medis ORDER BY op.waktu_catat DESC LIMIT 1) as tekanan_darah,
                    (SELECT op.waktu_catat FROM observasi_pasien op WHERE op.id_rekam_medis = rm.id_rekam_medis ORDER BY op.waktu_catat DESC LIMIT 1) as waktu_catat,
                    (SELECT op.tindakan FROM observasi_pasien op WHERE op.id_rekam_medis = rm.id_rekam_medis ORDER BY op.waktu_catat DESC LIMIT 1) as tindakan,
                    (SELECT op.detail_kondisi FROM observasi_pasien op WHERE op.id_rekam_medis = rm.id_rekam_medis ORDER BY op.waktu_catat DESC LIMIT 1) as detail_kondisi,
                    (SELECT k.nama_kondisi FROM observasi_pasien op JOIN kondisi k ON k.id_kondisi = op.id_kondisi WHERE op.id_rekam_medis = rm.id_rekam_medis ORDER BY op.waktu_catat DESC LIMIT 1) as status_pasien,
                    (SELECT dp.nama_lengkap FROM observasi_pasien op JOIN data_perawat dp ON dp.id_perawat = op.id_perawat WHERE op.id_rekam_medis = rm.id_rekam_medis ORDER BY op.waktu_catat DESC LIMIT 1) as nama_perawat
                FROM rekam_medis rm
                WHERE rm.id_pasien = :id_pasien 
                ORDER BY rm.tanggal_masuk DESC"
            );
            
            $query->bindParam(":id_pasien", $id_pasien, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function ambilTimelineObservasi($id_rekam_medis) {
            $query = $this->db->prepare(
                "SELECT 
                    op.*, 
                    dp.nama_lengkap AS nama_perawat, 
                    k.nama_kondisi AS status_pasien
                FROM observasi_pasien op
                LEFT JOIN data_perawat dp ON op.id_perawat = dp.id_perawat
                LEFT JOIN kondisi k ON op.id_kondisi = k.id_kondisi
                WHERE op.id_rekam_medis = :id_rm
                ORDER BY op.waktu_catat DESC"
            );
            $query->bindParam(":id_rm", $id_rekam_medis, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function tambahObservasiPasien($id_pasien, $data) {
            try {
                $this->db->beginTransaction();

                // 1. Ambil ID Rekam Medis
                $qRM = $this->db->prepare("SELECT id_rekam_medis FROM rekam_medis WHERE id_pasien = :id_pasien ORDER BY tanggal_masuk DESC LIMIT 1");
                $qRM->bindParam(":id_pasien", $id_pasien, PDO::PARAM_INT);
                $qRM->execute();
                $id_rekam_medis = $qRM->fetchColumn();

                if (!$id_rekam_medis) {
                    $this->db->rollBack();
                    return false;
                }

                // 2. Cocokkan Data Kasur (Karena sudah divalidasi sebelumnya, langsung tembak ke database)
                $nomor_bed_valid = $data['no_bed'];
                
                $qCekBed = $this->db->prepare("SELECT id_bed FROM bed WHERE nomor_bed = :nomor_bed");
                $qCekBed->execute([':nomor_bed' => $nomor_bed_valid]);
                $id_bed_valid = $qCekBed->fetchColumn();
                
                // Jaga-jaga jika entah bagaimana nomor kasur tidak ada di tabel master
                if (!$id_bed_valid) {
                    $this->db->rollBack();
                    return false; 
                }

                // 3. Ubah status kasur menjadi "Terpakai" (ID 2 di tabel status_bed)
                $qUpdateBed = $this->db->prepare("UPDATE bed SET id_st_bed = 2 WHERE id_bed = :id_bed");
                $qUpdateBed->execute([':id_bed' => $id_bed_valid]);

                // 4. Cari ID Kondisi
                $qKondisi = $this->db->prepare("SELECT id_kondisi FROM kondisi WHERE LOWER(nama_kondisi) = LOWER(:nama_kondisi)");
                $qKondisi->execute([':nama_kondisi' => $data['status_klinis']]);
                $id_kondisi = $qKondisi->fetchColumn();
                
                if (!$id_kondisi) {
                    $this->db->rollBack();
                    return false;
                }

                // 5. Masukkan data ke tabel observasi_pasien
                $qObs = $this->db->prepare(
                    "INSERT INTO observasi_pasien 
                    (id_rekam_medis, id_perawat, id_bed, detak_jantung, sp02, suhu_tubuh, tekanan_darah, id_kondisi, diagnosa, detail_kondisi, tindakan, waktu_catat) 
                    VALUES 
                    (:id_rm, :id_perawat, :id_bed, :detak, :spo2, :suhu, :tensi, :id_kondisi, :diagnosa, :detail_kondisi, :tindakan, NOW())"
                );
                
                $berhasil = $qObs->execute([
                    ":id_rm"          => $id_rekam_medis,
                    ":id_perawat"     => $data['id_perawat'],
                    ":id_bed"         => $id_bed_valid, 
                    ":detak"          => $data['detak_jantung'],
                    ":spo2"           => $data['oksigen'],
                    ":suhu"           => $data['suhu_tubuh'],
                    ":tensi"          => $data['tekanan_darah'],
                    ":id_kondisi"     => $id_kondisi,
                    ":diagnosa"       => $data['diagnosa'],
                    ":detail_kondisi" => $data['detail_kondisi'],
                    ":tindakan"       => $data['tindakan']
                ]);

                if (!$berhasil) {
                    $this->db->rollBack();
                    return false;
                }

                $this->db->commit();
                return true;

            } catch (PDOException $e) {
                $this->db->rollBack();
                error_log("Gagal tambah observasi: " . $e->getMessage());
                return false;
            }
        }

        public function obsAktif($id_pasien) {
            $query = $this->db->prepare(
                "SELECT 
                    op.detak_jantung, 
                    op.sp02, 
                    op.suhu_tubuh, 
                    op.tekanan_darah, 
                    op.waktu_catat, 
                    k.nama_kondisi AS kondisi, 
                    dp.nama_lengkap AS nama_perawat
                FROM rekam_medis rm
                JOIN observasi_pasien op ON op.id_rekam_medis = rm.id_rekam_medis
                LEFT JOIN kondisi k ON k.id_kondisi = op.id_kondisi
                LEFT JOIN data_perawat dp ON dp.id_perawat = op.id_perawat
                WHERE rm.id_pasien = :id_pasien 
                AND rm.tanggal_keluar IS NULL
                ORDER BY op.waktu_catat DESC"
            );
            $query->execute([':id_pasien' => $id_pasien]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
    }
