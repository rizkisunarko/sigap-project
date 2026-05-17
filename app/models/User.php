<?php 
    class Pendaftaran {
        function daftarAkun($nama, $password) {
            $data_nama = password_hash($nama, PASSWORD_BCRYPT);
            $data_password = password_hash($password, PASSWORD_BCRYPT);

            
        }


    }
?>