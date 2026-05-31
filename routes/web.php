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

// rest
Router::get('auth/reset','AuthController@reset');
Router::post('auth/validation', 'AuthController@prosesKirimOtp');
Router::get('reset/verif','AuthController@verif');
Router::post('auth/prosesVerifikasiOtp', 'AuthController@prosesVerifikasiOtp');
Router::get('reset/password_baru', 'AuthController@passwordBaru');
Router::post('auth/prosesUbahPassword', 'AuthController@prosesUbahPassword');

// Dashboard Keluarga
Router::get('/keluarga/dashboard', 'KeluargaController@dashboard');

// Portal Staff & Perawat
Router::get('/divisionRMFO-255', 'PerawatController@login');
Router::post('/divisionRMFO-255', 'PerawatController@prosesLogin');
Router::get('/divisionRMFO-255/logout', 'PerawatController@portalLogout');
Router::get('/perawat/dashboard', 'PerawatController@dashboard');
Router::post('/perawat/dashboard', 'PerawatController@updateStaffAccount');
Router::get('/perawat/input_data_pasien', 'PerawatController@inputDataPasien');
Router::get('/perawat/tambah_pasien', 'PerawatController@tambahPasien');
Router::post('/perawat/simpan_pasien', 'PerawatController@simpanPasien');
Router::post('/pasien/update', 'PasienController@update');
Router::post('/perawat/keluar_pasien', 'PerawatController@keluarPasien');
Router::get('/perawat/direktori_pengguna', 'PerawatController@direktoriPengguna');
Router::post('/perawat/get_detail_pasien_ajax', 'PerawatController@getDetailPasienAjax');
Router::post('/rekammedis/update', 'RekamMedisController@update');
Router::post('/perawat/masuk_pasien', 'PerawatController@masukPasien');

//bot
Router::get('/perawat/test-bot', 'BotController@tampilkanViewBot');
Router::post('/perawat/simpan', 'BotController@prosesSimpanDanKirim');