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
    }
?>