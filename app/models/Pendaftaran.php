<?php 
    require_once __DIR__ . '/../../core/Model.php';

    class PendaftaranModel extends Model {
        
        
        public function daftarAkun($username, $password, $data, $filename, &$msg) {
            
            $query = $this->db->prepare(
                "SELECT username from akun_pengguna where username = :username"
            );
            $query->bindParam(":username", $username);
            $query->execute();
            $hasil = $query->fetch(PDO::FETCH_ASSOC);

            if(!empty($hasil)) {
                $msg = "Username anda sudah terdaftar";
                return;
            }

            $queryNik = $this->db->prepare(
                "SELECT nik FROM data_diri_pasien WHERE nik = :nik"
            );
            $queryNik->bindParam(":nik", $data['nik']);
            $queryNik->execute();
            $hasilNik = $queryNik->fetch(PDO::FETCH_ASSOC);

            if(!empty($hasilNik)) {
                $msg = "NIK Pasien sudah terdaftar di dalam sistem";
                return;
            }

            $this->db->beginTransaction();

            try {
                $data_password = password_hash($password, PASSWORD_BCRYPT);
    
                $queryAkun = $this->db->prepare(
                    "INSERT into akun_pengguna (username, password) values (:username, :password)"
                );
                $queryAkun->bindParam(":username", $username);
                $queryAkun->bindParam(":password", $data_password);
                $queryAkun->execute();

                $id_pengguna = $this->db->lastInsertId();

                $queryKawin = $this->db->prepare(
                    "SELECT id_st_perkawinan FROM status_perkawinan WHERE nama_status = :status"
                );
                $queryKawin->bindParam(":status", $data['status_perkawinan']);
                $queryKawin->execute();
                $resKawin = $queryKawin->fetch(PDO::FETCH_ASSOC);
                $id_st_perkawinan = $resKawin ? $resKawin['id_st_perkawinan'] : null;

                $jk_enum = ($data['jk'] === 'Laki-laki') ? 'L' : 'P';

                $queryPasien = $this->db->prepare(
                    "INSERT INTO data_diri_pasien (
                        nama_lengkap, nik, asal, tgl_lahir, jenis_kelamin, 
                        agama, id_st_perkawinan, alamat, nomor_bpjs, 
                        golongan_darah, kewarganegaraan, pekerjaan, id_pengguna
                    ) VALUES (
                        :nama_lengkap, :nik, :asal, :tgl_lahir, :jenis_kelamin, 
                        :agama, :id_st_perkawinan, :alamat, :nomor_bpjs, 
                        :golongan_darah, :kewarganegaraan, :pekerjaan, :id_pengguna
                    )"
                );

                $queryPasien->bindParam(":nama_lengkap", $data['nama_pasien']);
                $queryPasien->bindParam(":nik", $data['nik']);
                $queryPasien->bindParam(":asal", $data['asal']);
                $queryPasien->bindParam(":tgl_lahir", $data['tgl_lahir']);
                $queryPasien->bindParam(":jenis_kelamin", $jk_enum);
                $queryPasien->bindParam(":agama", $data['agama']);
                $queryPasien->bindParam(":id_st_perkawinan", $id_st_perkawinan);
                $queryPasien->bindParam(":alamat", $data['alamat']);
                $queryPasien->bindParam(":nomor_bpjs", $data['bpjs']);
                $queryPasien->bindParam(":golongan_darah", $data['gol_darah']);
                $queryPasien->bindParam(":kewarganegaraan", $data['kewarganegaraan']);
                $queryPasien->bindParam(":pekerjaan", $data['pekerjaan']);
                $queryPasien->bindParam(":id_pengguna", $id_pengguna);
                $queryPasien->execute();

                $id_pasien = $this->db->lastInsertId();

                $queryStatusWali = $this->db->prepare(
                    "SELECT id_st_wali FROM status_wali WHERE nama_status = :status_wali"
                );
                $queryStatusWali->bindParam(":status_wali", $data['status_wali']);
                $queryStatusWali->execute();
                $resWaliStatus = $queryStatusWali->fetch(PDO::FETCH_ASSOC);
                $id_st_wali = $resWaliStatus ? $resWaliStatus['id_st_wali'] : null;

                $queryWali = $this->db->prepare(
                    "INSERT INTO data_diri_pengantar (
                        nama_lengkap, id_st_wali, nik_wali, no_hp, alamat, dokumen_ttd, id_pasien
                    ) VALUES (
                        :nama_lengkap, :id_st_wali, :nik_wali, :no_hp, :alamat, :dokumen_ttd, :id_pasien
                    )"
                );

                $queryWali->bindParam(":nama_lengkap", $data['nama_wali']);
                $queryWali->bindParam(":id_st_wali", $id_st_wali);
                $queryWali->bindParam(":nik_wali", $data['nik_wali']);
                $queryWali->bindParam(":no_hp", $data['nohp_wali']);
                $queryWali->bindParam(":alamat", $data['alamat_wali']);
                $queryWali->bindParam(":dokumen_ttd", $filename);
                $queryWali->bindParam(":id_pasien", $id_pasien);
                $queryWali->execute();

                $alergi_input = trim($data['alergi'] ?? '');
                if (!empty($alergi_input)) {
                    
                    $queryCekAlergi = $this->db->prepare(
                        "SELECT id_alergi FROM data_alergi WHERE nama_alergi = :nama_alergi"
                    );
                    $queryCekAlergi->bindParam(":nama_alergi", $alergi_input);
                    $queryCekAlergi->execute();
                    $resAlergi = $queryCekAlergi->fetch(PDO::FETCH_ASSOC);

                    if ($resAlergi) {
                        $id_alergi = $resAlergi['id_alergi'];
                    } else {
                        $queryInsAlergi = $this->db->prepare(
                            "INSERT INTO data_alergi (nama_alergi) VALUES (:nama_alergi)"
                        );
                        $queryInsAlergi->bindParam(":nama_alergi", $alergi_input);
                        $queryInsAlergi->execute();
                        $id_alergi = $this->db->lastInsertId();
                    }

                    $queryAlergiPasien = $this->db->prepare(
                        "INSERT INTO alergi_pasien (id_alergi, id_pasien) VALUES (:id_alergi, :id_pasien)"
                    );
                    $queryAlergiPasien->bindParam(":id_alergi", $id_alergi);
                    $queryAlergiPasien->bindParam(":id_pasien", $id_pasien);
                    $queryAlergiPasien->execute();
                }

                $this->db->commit();
                $msg = "Berhasil";

            } catch (PDOException $e) {
                $this->db->rollBack();
                $msg = "Gagal menyimpan data pendaftaran: " . $e->getMessage();
            }
        }
    }
?>