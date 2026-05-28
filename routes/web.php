<?php
// Mendefinisikan rute (URL) ke Controller yang sesuai
// Penggunaan: Router::get('/path', 'ControllerName@methodName') atau Router::post('/path', 'ControllerName@methodName')

Router::get('/', 'HomeController@index');

// Alur Pendaftaran Online
Router::get('/pendaftaran/pilih-jalur', 'PendaftaranController@pilihJalur');
Router::get('/pendaftaran/form', 'PendaftaranController@form');
Router::post('/pendaftaran/submit', 'PendaftaranController@submit');

// Autentikasi Keluarga Pasien
Router::get('/auth/login', 'AuthController@login');
Router::post('/auth/login', 'AuthController@loginProcess');
Router::get('/auth/logout', 'AuthController@logout');

// Dashboard Keluarga
Router::get('/keluarga/dashboard', 'KeluargaController@dashboard');

// Portal Staff & Perawat
Router::get('/portal-staff/login', 'PerawatController@portalLogin');
Router::post('/portal-staff/login', 'PerawatController@portalLoginProcess');
Router::get('/portal-staff/logout', 'PerawatController@portalLogout');
Router::get('/perawat/dashboard', 'PerawatController@dashboard');
Router::post('/perawat/dashboard', 'PerawatController@updateStaffAccount');
Router::get('/perawat/input_data_pasien', 'PerawatController@inputDataPasien');
Router::get('/perawat/tambah_pasien', 'PerawatController@tambahPasien');
Router::post('/perawat/simpan_pasien', 'PerawatController@simpanPasien');
Router::post('/perawat/update_pasien', 'PerawatController@updatePasien');
Router::post('/perawat/keluar_pasien', 'PerawatController@keluarPasien');
Router::get('/perawat/direktori_pengguna', 'PerawatController@direktoriPengguna');
