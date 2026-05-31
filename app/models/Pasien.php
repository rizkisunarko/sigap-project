<?php 
    require_once __DIR__ . "/../../core/Model.php";

    class PasienModel extends Model {

        public function ambilStatusPerkawinan() {
            $query = $this->db->prepare(
                "SELECT nama_status
                from status_perkawinan"
            );
            $query->execute();
            $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
            return $hasil;
        }

        public function isiDataDiriPasien(
            $nama_lengkap, $nik, $asal,
            $tgl_lahir, $jenis_kelamin,
            $agama, $status_perkawinan,
            $alamat, $nomor_bpjs,
            $golongan_darah, $kewarganegaraan,
            $pekerjaan, $id_pengguna) {
            $query = $this->db->prepare(
                "SELECT id_st_perkawinan
                from status_perkawinan
                where nama_status = :nama_status"
            );
            $query->bindParam(":nama_status". $status_perkawinan);
            $stat = $query->fetch(PDO::FETCH_ASSOC);
            $query = $this->db->prepare(
                "INSERT into data_diri_pasien (nama_lengkap, nik, asal, tgl_lahir, jenis_kelamin,
                    agama, id_st_perkawinan, alamat, nomor_bpjs, golongan_darah,
                    kewarganegaraan, pekerjaan, id_pengguna) values (
                    :nama_lengkap, :nik, :asal, :tgl_lahir, :jenis_kelamin,
                    :agama, :status_perkawinan, :alamat, :nomor_bpjs, :golongan_darah,
                    :kewarganegaraan, :pekerjaan, :id_pengguna)"
            );
            $query->bindParam(":nama_lengkap", $nama_lengkap);
            $query->bindParam(":nik", $nik);
            $query->bindParam(":asal", $asal);
            $query->bindParam(":tgl_lahir", $tgl_lahir);
            $query->bindParam(":jenis_kelamin", $jenis_kelamin);
            $query->bindParam(":agama", $agama);
            $query->bindParam(":status_perkawinan", $stat);
            $query->bindParam(":alamat", $alamat);
            $query->bindParam(":nomor_bpjs", $nomor_bpjs);
            $query->bindParam(":golongan_darah", $golongan_darah);
            $query->bindParam(":kewarganegaraan", $kewarganegaraan);
            $query->bindParam(":pekerjaan", $pekerjaan);
            $query->bindParam(":id_pengguna", $id_pengguna);
            $query->execute();
        }

        public function editDataDiriPasien(
            $id_pasien, $nama_lengkap, $nik, $asal,
            $tgl_lahir, $jenis_kelamin,
            $agama, $status_perkawinan,
            $alamat, $nomor_bpjs,
            $golongan_darah, $kewarganegaraan,
            $pekerjaan, $id_pengguna) {
            $query = $this->db->prepare(
                "SELECT id_st_perkawinan
                from status_perkawinan
                where nama_status = :nama_status"
            );
            $query->bindParam(":nama_status". $status_perkawinan);
            $stat = $query->fetch(PDO::FETCH_ASSOC);
            $query = $this->db->prepare(
                "UPDATE data_diri_pasien set
                nama_lengkap = :nama_lengkap, 
                nik = :nik, 
                asal = :asal, 
                tgl_lahir = :tgl_lahir, 
                jenis_kelamin = :jenis_kelamin,
                agama = :agama, 
                id_st_perkawinan = :status_perkawinan, 
                alamat = :alamat, 
                nomor_bpjs = :nomor_bpjs, 
                golongan_darah = :golongan_darah,
                kewarganegaraan = :kewarganegaraan, 
                pekerjaan = :pekerjaan
                where id_pasien = :id_pasien"
            );
            $query->bindParam(":nama_lengkap", $nama_lengkap);
            $query->bindParam(":nik", $nik);
            $query->bindParam(":asal", $asal);
            $query->bindParam(":tgl_lahir", $tgl_lahir);
            $query->bindParam(":jenis_kelamin", $jenis_kelamin);
            $query->bindParam(":agama", $agama);
            $query->bindParam(":status_perkawinan", $stat);
            $query->bindParam(":alamat", $alamat);
            $query->bindParam(":nomor_bpjs", $nomor_bpjs);
            $query->bindParam(":golongan_darah", $golongan_darah);
            $query->bindParam(":kewarganegaraan", $kewarganegaraan);
            $query->bindParam(":pekerjaan", $pekerjaan);
            $query->bindParam(":id_pasien", $id_pasien);
            $query->execute();
        }

        public function ambilDataPasien($id_pasien) {
            $query = $this->db->prepare(
                "SELECT 
                    ddp.id_pasien,
                    ap.username,
                    ddp.nik,
                    ddp.nama_lengkap,
                    ddp.asal,
                    ddp.tgl_lahir,
                    ddp.jenis_kelamin,
                    ddp.agama,
                    sp.nama_status as status_perkawinan,
                    ddp.pekerjaan,
                    ddp.alamat,
                    ddp.nomor_bpjs,
                    ddp.golongan_darah,
                    ddp.kewarganegaraan,
                    ddpr.nama_lengkap as nama_lengkap_wali,
                    sw.nama_status as status_wali,
                    ddpr.nik_wali,
                    ddpr.no_hp as no_hp_wali,
                    ddpr.alamat as alamat_wali,
                    ddpr.dokumen_ttd
                FROM data_diri_pasien ddp
                LEFT JOIN akun_pengguna ap ON ddp.id_pengguna = ap.id_pengguna
                LEFT JOIN status_perkawinan sp ON ddp.id_st_perkawinan = sp.id_st_perkawinan
                LEFT JOIN data_diri_pengantar ddpr ON ddp.id_pasien = ddpr.id_pasien
                LEFT JOIN status_wali sw ON ddpr.id_st_wali = sw.id_st_wali
                WHERE ddp.id_pasien = :id_pasien"
            );
            $query->bindParam(":id_pasien", $id_pasien, PDO::PARAM_INT);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        }

        public function ambilDataAlergi() {
            $query = $this->db->prepare(
                "SELECT id_alergi, nama_alergi from data_alergi"
            );
            $query->execute();
            $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
            return $hasil;
        }

        public function tambahAlergiPasien($id_pasien, $id_alergi) {
            $query = $this->db->prepare(
                "INSERT into 
                alergi_pasien
                (id_alergi, id_pasien) 
                values 
                (:id_alergi, :id_pasien)"
            );
            $query->bindParam(":id_alergi", $id_alergi);
            $query->bindParam(":id_pasien", $id_pasien);
            $query->execute();
        }

        public function tampilSemuaDataPasien() {
            $query = $this->db->prepare(
                "SELECT rk.id_rekam_medis, ddp.nama_lengkap, ddp.jenis_kelamin, ddp.asal, ddpr.no_hp
                from rekam_medis rk
                join data_diri_pasien ddp on ddp.id_pasien = rk.id_pasien
                left join data_diri_pegantar ddpr on ddpr.id_pasien = ddp.id_pasien;"
            );
            $query->execute();
            $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
            return $hasil;
        }

        public function riwayatPerkembanganPasien($id_rekam_medis) {
            $query = $this->db->prepare(
                 "SELECT op.detak_jantung, op.sp02 as oksigen, op.suhu_tubuh, op.tekanan_darah, op.waktu_catat, k.nama_kondisi kondisi, dp.nama_lengkap
                from observasi_pasien op
                join data_perawat dp on dp.id_perawat = op.id_perawat
                left join kondisi k on k.id_kondisi = op.id_kondisi
                where op.id_rekam_medis = :id_rekam_medis
                order by op.waktu_catat;"
            );
            $query->bindParam(":id_rekam_medis", $id_rekam_medis);
            $query->execute();
            $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
            return $hasil;
        }

        public function updateDataPasienLengkap($id_pasien, $data) {
            try {
                $this->db->beginTransaction();

                $qCari = $this->db->prepare("SELECT id_pengguna FROM data_diri_pasien WHERE id_pasien = :id_pasien");
                $qCari->bindParam(":id_pasien", $id_pasien);
                $qCari->execute();
                $id_pengguna = $qCari->fetchColumn();

                if (!empty($data['password'])) {
                    $qAkun = $this->db->prepare("UPDATE akun_pengguna SET username = :username, password = :password WHERE id_pengguna = :id_pengguna");
                    $qAkun->bindParam(":password", $data['password']); // Idealnya ini di-hash (MD5/Bcrypt) sesuai sistem pendaftaranmu
                } else {
                    $qAkun = $this->db->prepare("UPDATE akun_pengguna SET username = :username WHERE id_pengguna = :id_pengguna");
                }
                $qAkun->bindParam(":username", $data['username']);
                $qAkun->bindParam(":id_pengguna", $id_pengguna);
                $qAkun->execute();

                $qStat = $this->db->prepare("SELECT id_st_perkawinan FROM status_perkawinan WHERE nama_status = :nama_status");
                $qStat->bindParam(":nama_status", $data['status_perkawinan']);
                $qStat->execute();
                $id_st_perkawinan = $qStat->fetchColumn() ?: null;

                $qPasien = $this->db->prepare(
                    "UPDATE data_diri_pasien SET 
                        nama_lengkap = :nama_lengkap, nik = :nik, asal = :asal, 
                        tgl_lahir = :tgl_lahir, jenis_kelamin = :jenis_kelamin, agama = :agama, 
                        id_st_perkawinan = :id_st_perkawinan, alamat = :alamat, nomor_bpjs = :nomor_bpjs, 
                        golongan_darah = :golongan_darah, kewarganegaraan = :kewarganegaraan, pekerjaan = :pekerjaan
                    WHERE id_pasien = :id_pasien"
                );
                $qPasien->bindParam(":nama_lengkap", $data['nama_pasien']);
                $qPasien->bindParam(":nik", $data['nik']);
                $qPasien->bindParam(":asal", $data['asal']);
                $qPasien->bindParam(":tgl_lahir", $data['tgl_lahir']);
                $qPasien->bindParam(":jenis_kelamin", $data['jk']);
                $qPasien->bindParam(":agama", $data['agama']);
                $qPasien->bindParam(":id_st_perkawinan", $id_st_perkawinan);
                $qPasien->bindParam(":alamat", $data['alamat']);
                $qPasien->bindParam(":nomor_bpjs", $data['bpjs']);
                $qPasien->bindParam(":golongan_darah", $data['gol_darah']);
                $qPasien->bindParam(":kewarganegaraan", $data['kewarganegaraan']);
                $qPasien->bindParam(":pekerjaan", $data['pekerjaan']);
                $qPasien->bindParam(":id_pasien", $id_pasien);
                $qPasien->execute();

                $qStatWali = $this->db->prepare("SELECT id_st_wali FROM status_wali WHERE nama_status = :nama_status");
                $qStatWali->bindParam(":nama_status", $data['status_wali']);
                $qStatWali->execute();
                $id_st_wali = $qStatWali->fetchColumn() ?: null;

                $qWali = $this->db->prepare(
                    "UPDATE data_diri_pengantar SET 
                        nama_lengkap = :nama_wali, nik_wali = :nik_wali, 
                        no_hp = :nohp_wali, alamat = :alamat_wali, id_st_wali = :id_st_wali
                    WHERE id_pasien = :id_pasien"
                );
                $qWali->bindParam(":nama_wali", $data['nama_wali']);
                $qWali->bindParam(":nik_wali", $data['nik_wali']);
                $qWali->bindParam(":nohp_wali", $data['nohp_wali']);
                $qWali->bindParam(":alamat_wali", $data['alamat_wali']);
                $qWali->bindParam(":id_st_wali", $id_st_wali);
                $qWali->bindParam(":id_pasien", $id_pasien);
                $qWali->execute();

                $this->db->commit();
                return true;

            } catch (PDOException $e) {
                $this->db->rollBack();
                return false;
            }
        }
    }
