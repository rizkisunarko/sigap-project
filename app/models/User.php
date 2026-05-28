<?php 
    require_once __DIR__ . "/../../core/Model.php";

    class UserModel extends Model {

        // reset password
        public function gantiPasswordUser($password_baru, $id) {
            $query = $this->db->prepare(
                "UPDATE akun_pengguna
                 SET password = :password
                 WHERE id_pengguna = :id_pengguna"
            );
            // Memastikan yang di-bind adalah password_baru, bukan username
            $query->bindParam(":password", $password_baru);
            $query->bindParam(":id_pengguna", $id);
            $query->execute();
        }

        // ambil informasi akun
        public function ambilDetailDataUser($id) {
            $query = $this->db->prepare(
                "SELECT id_pengguna, username FROM akun_pengguna
                 WHERE id_pengguna = :id_pengguna"
            );
            $query->bindParam(":id_pengguna", $id);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        }

        // verifikasi user (Menerima 4 argumen sesuai permintaan Controller)
        public function verifikasiUser($username, $password, &$msg, &$dataUser) {
            // Ambil ID dan Password sekaligus untuk disimpan ke sesi nanti
            $query = $this->db->prepare(
                "SELECT id_pengguna, username, password FROM akun_pengguna
                 WHERE username = :username"
            );
            $query->bindParam(":username", $username);
            $query->execute();
            $hasil = $query->fetch(PDO::FETCH_ASSOC);
            
            // Verifikasi kecocokan hash password
            if($hasil && password_verify($password, $hasil['password'])) {
                $msg = "Berhasil";
                // Isi array $dataUser agar bisa ditangkap oleh Controller
                $dataUser = [
                    'id_pengguna' => $hasil['id_pengguna'],
                    'username' => $hasil['username']
                ];
            } else {
                $msg = "Username atau Password salah";
                $dataUser = [];
            }
        }

        // edit informasi user
        public function EditInfoUser($id, $username_baru, &$msg) {
            // Cek apakah username baru sudah dipakai oleh orang lain
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
    }
?>