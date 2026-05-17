<?php 
    require_once "../../core/Model.php";

    class PendaftaranModel extends Model {
        
        // daftar akun 
        public function daftarAkun($email, $password, &$msg) {
            $query = $this->db->prepare(
                "SELECT email from akun_pengguna where email = :email"
            );
            $query->bindParam(":email", $email);
            $query->execute();
            $hasil = $query->fetch(PDO::FETCH_ASSOC);

            if(empty($hasil)) {
                $data_password = password_hash($password, PASSWORD_BCRYPT);
    
                $query = $this->db->prepare(
                    "INSERT into akun_pengguna (email, password) 
                    values (:email, :password)"
                );
                $query->bindParam(":email", $email);
                $query->bindParam(":password", $data_password);
                $query->execute();
                $msg =  "Berhasil";
            } else {
                $msg = "Email anda sudah terdaftar";
            }
        }
    }
?>