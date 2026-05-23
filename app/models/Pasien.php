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

        // edit data diri pasien
        public function editDataDiriPasien(
            $id_pasien, $nama_lengkap, $nik, $asal,
            $tgl_lahir, $jenis_kelamin,
            $agama, $status_perkawinan,
            $alamat, $nomor_bpjs,
            $golongan_darah, $kewarganegaraan,
            $pekerjaan, $id_pengguna) {
            $query = $this->db->prepare(
                "UPDATE data_diri_pasien set
                nama_lengkap = :nama_lengkap, 
                nik = :nik, 
                asal = :asal, 
                tgl_lahir = :tgl_lahir, 
                jenis_kelamin = :jenis_kelamin,
                agama = :agama, 
                status_perkawinan = :status_perkawinan, 
                alamat = :alamat, 
                nomor_bpjs = :nomor_bpjs, 
                golongan_darah = :golongan_darah,
                kewarganegaraan = :kewarganegaraan, 
                pekerjaan = :pekerjaan
                where id_pasien = :id_pasien)"
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
            $query->bindParam(":id_pasien", $id_pasien);
            $query->execute();
        }

        // ambil data pasien
        public function ambilDataPasien($id_pasien) {
            $query = $this->db->prepare(
                "SELECT 
                nama_lengkap, 
                nik, 
                asal, 
                tgl_lahir, 
                jenis_kelamin,
                agama, 
                status_perkawinan, 
                alamat, 
                nomor_bpjs, 
                golongan_darah,
                kewarganegaraan, 
                pekerjaan 
                from data_diri_pasien where id_pasien = :id_pasien"
            );
            $query->bindParam(":id_pasien", $id_pasien);
            $query->execute();
            $hasil = $query->fetch(PDO::FETCH_ASSOC);
            return $hasil;
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

        // untuk tampilan kumpulan data pasien
        public function tampilSemuaDataPasien() {
            $query = $this->db->prepare(
                "SELECT rk.id_rekam_medis, ddp.nama_lengkap, ddp.jenis_kelamin, ddp.asal, ddpr.no_hp
                from rekam_medis rk
                join data_diri_pasien ddp on ddp.id_pasien = rk.id_pasien
                left join data_diri_pengantar ddpr on ddpr.id_pasien = ddp.id_pasien;"
            );
            $query->execute();
            $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
            return $hasil;
        }

        // riwayat perkembangan pasien
        public function riwayatPerkembanganPasien($id_rekam_medis) {
            $query = $this->db->prepare(
                "SELECT op.detak_jantung, op.oksigen, op.suhu_tubuh, op.tekanan_darah, op.waktu_catat, op.kondisi, dp.nama_lengkap
                from observasi_pasien op
                join data_perawat dp on dp.id_perawat = op.id_perawat
                where op.id_rekam_medis = :id_rekam_medis
                order by op.waktu_catat;"
            );
            $query->bindParam(":id_rekam_medis", $id_rekam_medis);
            $query->execute();
            $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
            return $hasil;
        }
    }
?>