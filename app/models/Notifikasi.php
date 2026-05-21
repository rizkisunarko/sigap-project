<?php 
    require_once "../../core/Model.php";

    class NotifikasiModel {

        // notifikasi wa
        public function kirimWA($no_hp, $msg) {
            
            if(preg_match("/^0/", $no_hp)) {
                $no_hp_baru = "62".substr($no_hp, 1, strlen($no_hp));
            } elseif (preg_match("/^\+/", $no_hp)) {
                $no_hp_baru = substr($no_hp, 1, strlen($no_hp));
            } else {
                $no_hp_baru = $no_hp;
            }

            $data = [
                "number" => $no_hp_baru,
                "message" => $msg
            ];

            // kirim pesan (jalankan node index.js)
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "http://127.0.0.1:8000/send-message",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($data),

                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json"
                ]
            ]);
            $response = curl_exec($curl);
            curl_close($curl);
            return $response;
        }
    }
?>