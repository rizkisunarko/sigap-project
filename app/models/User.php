<?php 
    require_once "../../core/Model.php";

    class UserModel extends Model {

        // reset password
        public function gantiPasswordUser($username, $id) {
            $query = $this->db->prepare("UPDATE akun_pengguna
                                        set password = :password
                                        where id_pengguna = :id_pengguna");
            $query->bindParam(":username", $username);
            $query->bindParam(":id_pengguna", $id);
            $query->execute();
        }

        // ambil informasi akun
        public function ambilDetailDataUser($id) {
            $query = $this->db->prepare(
                "SELECT id_pengguna, username from akun_pengguna
                where id_pengguna = :id_pengguna"
            );
            $query->bindParam(":id_pengguna", $id);
            $query->execute();
            $hasil = $query->fetch(PDO::FETCH_ASSOC);
            return $hasil;
        }

        // verifikasi user
        public function verifikasiUser($nama, $password, &$msg) {
            $query = $this->db->prepare(
                "SELECT password from akun_pengguna
                where nama = :nama"
            );
            $query->bindParam(":nama", $nama);
            $query->bindParam(":password", $password);
            $query->execute();
            $hasil = $query->fetch(PDO::FETCH_ASSOC);
            if(password_verify($password, $hasil['password'])) {
                $msg = "Berhasil";
            } else {
                $msg = "Username atau Password salah";
            }
        }

        // edit informasi user
        public function EditInfoUser($id, $nama, &$msg) {
            $query = $this->db->prepare(
                "SELECT case
                            when count(nama) > 1
                                then 'True'
                            else 'False'
                        end as status_nama
                from akun_pengguna
                where nama = :nama"
            );
            $query->bindParam(":nama", $nama);
            $query->execute();
            $hasil = $query->fetch(PDO::FETCH_ASSOC);
            if($hasil['status_nama'] == 'True') {
                $msg = "Nama sudah ada pada database";
            } else {
                $query = $this->db->prepare(
                    "UPDATE akun_pengguna
                    set username = :nama
                    where id_pengguna = :id"
                );
                $query->bindParam(":nama", $nama);
                $query->bindParam(":id", $id);
                $query->execute();
                $msg = "Berhasil diubah";
            }
        }
    }
?>