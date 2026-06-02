<?php
class Controller {
    // Base class untuk semua controller
    public function view($name, $data = []) { 
        require_once __DIR__ . '/../app/views/' . $name . '.php'; 
    }

    // ========================================================
    // ALAT BANTU VALIDASI UMUM & PENCETAK PESAN EROR
    // ========================================================
    
    protected function cekWajib($nilai, $namaKolom) {
        return empty(trim($nilai ?? '')) ? "*$namaKolom wajib diisi." : false;
    }

    protected function cekMinKarakter($nilai, $minimal, $namaKolom) {
        return strlen(trim($nilai ?? '')) < $minimal ? "*$namaKolom minimal $minimal karakter." : false;
    }

    protected function cekHanyaHurufSpasi($nilai, $namaKolom) {
        return !preg_match('/^[a-zA-Z\s]+$/', trim($nilai ?? '')) ? "*$namaKolom hanya boleh berisi huruf dan spasi." : false;
    }

    protected function cekHanyaHurufSpasiPetik($nilai, $namaKolom) {
        return !preg_match('/^[a-zA-Z\s\']+$/', trim($nilai ?? '')) ? "*$namaKolom hanya boleh berisi huruf, spasi, dan tanda petik." : false;
    }

    protected function cekHanyaAngka($nilai, $namaKolom) {
        return !preg_match('/^[0-9]+$/', trim($nilai ?? '')) ? "*$namaKolom harus berupa angka murni." : false;
    }

    protected function cekHurufAngka($nilai, $namaKolom) {
        return !preg_match('/^[a-zA-Z0-9]+$/', trim($nilai ?? '')) ? "*$namaKolom hanya boleh berisi huruf dan angka tanpa spasi." : false;
    }

    protected function cekMengandungHurufBesar($nilai, $namaKolom) {
        return !preg_match('/[A-Z]/', $nilai) ? "*$namaKolom wajib mengandung huruf besar." : false;
    }

    protected function cekMengandungAngka($nilai, $namaKolom) {
        return !preg_match('/[0-9]/', $nilai) ? "*$namaKolom wajib mengandung angka." : false;
    }

    protected function cekMengandungHuruf($nilai, $namaKolom) {
        return !preg_match('/[a-zA-Z]/', trim($nilai ?? '')) ? "*$namaKolom wajib mengandung huruf." : false;
    }

    protected function cekPilihan($nilai, $arrayPilihan, $namaKolom) {
        return !in_array(trim($nilai ?? ''), $arrayPilihan) ? "*Pilihan $namaKolom tidak valid." : false;
    }
}