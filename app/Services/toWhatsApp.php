<?php

class toWhatsApp {
    public static function kirimPesan($nomorTujuan, $pesanMedis) {
        $url = 'http://202.10.48.238:1917/api/send-status';
        $apiKey = 'RAHASIA_MEDIS_123';

        $data = [
            'nomor' => $nomorTujuan,
            'pesan' => $pesanMedis
        ];
        $payload = json_encode($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload),
            'x-api-key: ' . $apiKey
        ]);

        $response = curl_exec($ch);
        
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        return [
            'http_code' => $httpCode,
            'response' => json_decode($response, true)
        ];
    }
}

?>