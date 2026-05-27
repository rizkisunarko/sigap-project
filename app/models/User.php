<?php 
    require_once __DIR__ . "/../../core/Model.php";

    class UserModel extends Model {

        // reset password
        public function gantiPasswordUser($password, $id) {
            $query = $this->db->prepare("UPDATE akun_pengguna
                                        set password = :password
                                        where id_pengguna = :id_pengguna");
            $query->bindParam(":password", $password);
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

        // verifikasi login dengan password_verify (dengan fallback teks biasa untuk data manual)
        public function verifikasiLogin($username, $password) {
            $query = $this->db->prepare(
                "SELECT * from akun_pengguna where username = :username"
            );
            $query->bindParam(":username", $username);
            $query->execute();
            $user = $query->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $dbPassword = $user['password'];
                // Jika bertipe resource/stream (karena varbinary di beberapa DB driver)
                if (is_resource($dbPassword)) {
                    $dbPassword = stream_get_contents($dbPassword);
                }
                
                // Mendukung password_verify jika hash BCRYPT valid, atau fallback ke teks biasa
                if (password_verify($password, $dbPassword) || $password === $dbPassword) {
                    return $user;
                }
            }
            return false;
        }
    }
?>