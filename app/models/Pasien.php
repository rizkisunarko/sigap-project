<?php 
    require_once "../../core/Model.php";

    class PasienModel extends Model {

        //isi data diri pasien
        public function isiDataDiriPasien(
            $nama_lengkap, $nik, $asal,
            $tgl_lahir, $jenis_kelamin,
            $agama, $status_perkawinan,
            $alamat, $nomor_bpjs,
            $golongan_darah, $kewarganegaraan,
            $pekerjaan, $id_pengguna) {
            $query = $this->db->prepare(
                "INSERT into data_diri_pasien (nama_lengkap, nik, asal, tgl_lahir, jenis_kelamin,
                    agama, status_perkawinan, alamat, nomor_bpjs, golongan_darah,
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
            $query->bindParam(":status_perkawinan", $status_perkawinan);
            $query->bindParam(":alamat", $alamat);
            $query->bindParam(":nomor_bpjs", $nomor_bpjs);
            $query->bindParam(":golongan_darah", $golongan_darah);
            $query->bindParam(":kewarganegaraan", $kewarganegaraan);
            $query->bindParam(":pekerjaan", $pekerjaan);
            $query->bindParam(":id_pengguna", $id_pengguna);
            $query->execute();
        }

        // ambil semua data alergi
        public function ambilDataAlergi() {
            $query = $this->db->prepare(
                "SELECT id_alergi, nama_alergi from data_alergi"
            );
            $query->execute();
            $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
            return $hasil;
        }

        // menambahkan data pada tabel alergi pasien, 
        // bisa saja pada 1 pasien mempunyai lebih dari 1 alergi
        public function alergiPasien($id_pasien, $id_alergi) {
            $query = $this->db->prepare(
                "INSERT into alergi_pasien
                (id_alergi, id_pasien) 
                values (:id_alergi, :id_pasien)"
            );
            $query->bindParam(":id_alergi", $id_alergi);
            $query->bindParam(":id_pasien", $id_pasien);
            $query->execute();
        }
    }
?>