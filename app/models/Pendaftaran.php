<?php 
    require_once "../../core/Model.php";

    class PendaftaranModel extends Model {
        
        // daftar akun 
        public function daftarAkun($email, $password, &$msg) {
            $query = $this->db->prepare(
                "SELECT username from akun_pengguna where username = :username"
            );
            $query->bindParam(":username", $username);
            $query->execute();
            $hasil = $query->fetch(PDO::FETCH_ASSOC);

            if(empty($hasil)) {
                $data_password = password_hash($password, PASSWORD_BCRYPT);
    
                $query = $this->db->prepare(
                    "INSERT into akun_pengguna (username, password) 
                    values (:username, :password)"
                );
                $query->bindParam(":username", $username);
                $query->bindParam(":password", $data_password);
                $query->execute();
                $msg =  "Berhasil";
            } else {
                $msg = "Username anda sudah terdaftar";
            }
        }
    }
?>