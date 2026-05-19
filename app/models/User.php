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
    }
?>