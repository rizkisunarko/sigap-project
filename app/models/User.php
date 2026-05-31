<?php 
    require_once __DIR__ . "/../../core/Model.php";

    class UserModel extends Model {

        public function gantiPasswordUser($password_baru, $id) {
            $query = $this->db->prepare(
                "UPDATE akun_pengguna
                 SET password = :password
                 WHERE id_pengguna = :id_pengguna"
            );
            $query->bindParam(":password", $password_baru);
            $query->bindParam(":id_pengguna", $id);
            $query->execute();
        }

        public function ambilDetailDataUser($id) {
            $query = $this->db->prepare(
                "SELECT id_pengguna, username FROM akun_pengguna
                 WHERE id_pengguna = :id_pengguna"
            );
            $query->bindParam(":id_pengguna", $id);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        }

        public function verifikasiUser($username, $password, &$msg, &$dataUser) {
            $query = $this->db->prepare(
                "SELECT id_pengguna, username, password FROM akun_pengguna
                 WHERE username = :username"
            );
            $query->bindParam(":username", $username);
            $query->execute();
            $hasil = $query->fetch(PDO::FETCH_ASSOC);
            
            if($hasil && password_verify($password, $hasil['password'])) {
                $msg = "Berhasil";
                $dataUser = [
                    'id_pengguna' => $hasil['id_pengguna'],
                    'username' => $hasil['username']
                ];
            } else {
                $msg = "Username atau Password salah";
                $dataUser = [];
            }
        }

        public function EditInfoUser($id, $username_baru, &$msg) {
            $query = $this->db->prepare(
                "SELECT COUNT(username) as jumlah FROM akun_pengguna
                 WHERE username = :username AND id_pengguna != :id"
            );
            $query->bindParam(":username", $username_baru);
            $query->bindParam(":id", $id);
            $query->execute();
            $hasil = $query->fetch(PDO::FETCH_ASSOC);
            
            if($hasil['jumlah'] > 0) {
                $msg = "Username sudah ada pada database";
            } else {
                $query = $this->db->prepare(
                    "UPDATE akun_pengguna
                     SET username = :username
                     WHERE id_pengguna = :id"
                );
                $query->bindParam(":username", $username_baru);
                $query->bindParam(":id", $id);
                $query->execute();
                $msg = "Berhasil diubah";
            }
        }

        public function verifikasiLogin($username, $password) {
            $query = $this->db->prepare(
                "SELECT * from akun_pengguna where username = :username"
            );
            $query->bindParam(":username", $username);
            $query->execute();
            $user = $query->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $dbPassword = $user['password'];
                if (is_resource($dbPassword)) {
                    $dbPassword = stream_get_contents($dbPassword);
                }
                
                if (password_verify($password, $dbPassword) || $password === $dbPassword) {
                    return $user;
                }
            }
            return false;
        }
    }
?>