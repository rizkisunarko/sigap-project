-- Struktur tabel awal database
create table data_alergi (
    id_alergi int auto_increment primary key,
    nama_alergi varchar(100)
);

create table akun_pengguna (
    id_pengguna int auto_increment primary key,
    username varchar(255),
    password varbinary(255)
);

create table divisi_perawat (
    id_divisi int auto_increment primary key,
    nama_divisi varchar(100)
);

create table data_perawat (
    id_perawat int auto_increment primary key,
    nama_lengkap varchar(100),
    id_divisi int,
    foreign key (id_divisi) references divisi_perawat(id_divisi)
);

create table detail_tugas_shift (
    id_detail_s int auto_increment primary key,
    tugas_shift varchar(100),
    tenggat time,
    shift_ke int
);

create table tugas_divisi (
    id_t_divisi int auto_increment primary key,
    id_detail_s int,
    id_divisi int,
    foreign key (id_detail_s) references detail_tugas_shift(id_detail_s),
    foreign key (id_divisi) references divisi_perawat(id_divisi)
);

create table status_perkawinan (
    id_st_perkawinan int auto_increment primary key,
    nama_status varchar(50)
);

create table data_diri_pasien (
    id_pasien int auto_increment primary key,
    nama_lengkap varchar(255),
    nik varchar(16),
    asal varchar(255),
    tgl_lahir date,
    jenis_kelamin enum('L', 'P'),
    agama varchar(20),
    alamat text,
    nomor_bpjs varchar(20),
    golongan_darah varchar(20),
    kewarganegaraan varchar(100),
    pekerjaan varchar(100),
    id_pengguna int,
    id_st_perkawinan int,
    foreign key (id_pengguna) references akun_pengguna(id_pengguna),
    foreign key (id_st_perkawinan) references status_perkawinan(id_st_perkawinan)
);

create table alergi_pasien (
    id_ap int auto_increment primary key,
    id_alergi int,
    id_pasien int,
    foreign key (id_pasien) references data_diri_pasien(id_pasien),
    foreign key(id_alergi) references data_alergi(id_alergi)
);

create table status_wali (
    id_st_wali int auto_increment primary key,
    nama_status varchar(50)
);

create table data_diri_pengantar (
    id_pengantar int auto_increment primary key,
    nama_lengkap varchar(255),
    nik_wali varchar(16),
    no_hp varchar(15),
    alamat text,
    dokumen_ttd varchar(255),
    id_pasien int,
    id_st_wali int,
    foreign key (id_pasien) references data_diri_pasien(id_pasien),
    foreign key (id_st_wali) references status_wali(id_st_wali)
);

create table rekam_medis (
    id_rekam_medis int auto_increment primary key, 
    id_pasien int,
    tanggal_masuk date,
    tanggal_keluar date,
    id_urgensi int,
    foreign key (id_pasien) references data_diri_pasien(id_pasien)
);

create table status_bed (
    id_st_bed int auto_increment primary key,
    nama_status varchar(50)
);

create table bed (
    id_bed int auto_increment primary key,
    nomor_bed varchar(50),
    id_st_bed int,
    foreign key (id_st_bed) references status_bed(id_st_bed)
);

create table kondisi (
    id_kondisi int auto_increment primary key,
    nama_kondisi varchar(50)
);

create table observasi_pasien (
    id_observasi int auto_increment primary key,
    detak_jantung varchar(50),
    suhu_tubuh varchar(50),
    tekanan_darah varchar(50),
    detail_kondisi text,
    waktu_catat datetime,
    tindakan text,
    sp02 varchar(50),
    id_perawat int,
    id_rekam_medis int,
    id_bed int,
    diagnosa varchar(100),
    id_kondisi int,
    foreign key (id_rekam_medis) references rekam_medis(id_rekam_medis),
    foreign key (id_bed) references bed(id_bed),
    foreign key (id_perawat) references data_perawat(id_perawat),
    foreign key (id_kondisi) references kondisi(id_kondisi)
);

create table hasil_lab (
    id_hasil_lab int auto_increment primary key,
    ph_darah varchar(50),
    hb varchar(50),
    gula_darah varchar(50),
    tgl_isi datetime,
    id_observasi int,
    foreign key (id_observasi) references observasi_pasien(id_observasi)
);

create table status_log (
    id_st_log int auto_increment primary key,
    nama_status varchar(50)
);

create table log_tugas_shift (
    id_log int auto_increment primary key,
    tgl_dan_waktu datetime,
    id_detail_s int,
    id_st_log int,
    id_perawat int,
    foreign key (id_detail_s) references detail_tugas_shift(id_detail_s),
    foreign key (id_st_log) references status_log(id_st_log),
    foreign key (id_perawat) references data_perawat(id_perawat)
);

INSERT INTO status_wali (nama_status) VALUES 
('Orang Tua'), 
('Suami/Istri'), 
('Anak'), 
('Saudara Kandung'), 
('Keluarga Lain'), 
('Pengantar/Lainnya');

INSERT INTO status_perkawinan (nama_status) VALUES 
('Belum Kawin'), 
('Kawin'), 
('Cerai Hidup'), 
('Cerai Mati');

INSERT INTO kondisi (nama_kondisi) VALUES ('stabil'), ('kritis'), ('meningkat'), ('menurun');
INSERT INTO divisi_perawat (nama_divisi) VALUES ('Rekam Medis'), ('Front Officer');


INSERT INTO detail_tugas_shift (tugas_shift, tenggat, shift_ke) VALUES 
('Memeriksa kelengkapan lembar observasi harian dan grafik tanda vital pasien', '14:00:00', 1),
('Mengumpulkan berkas persetujuan tindakan medis yang sudah ditandatangani keluarga', '16:00:00', 1),
('Menginput data penataan alat dan obat kritis pasien ICU ke dalam SIMRS', '18:00:00', 1),
('Melakukan scan dokumen rekam medis pasien kritis untuk backup digital', '22:00:00', 2),
('Mengecek ulang kesesuaian laporan diagnosa dokter dengan form tindakan ICU', '02:00:00', 2),
('Membuat laporan sensus harian mengenai jumlah pasien masuk, keluar, dan mortalitas', '06:00:00', 2),
('Mengurus dokumen masuk pasien baru ICU dan cek validasi BPJS atau asuransi', '14:00:00', 1),
('Mengupdate data ketersediaan bed ICU di sistem dan papan informasi', '16:00:00', 1),
('Menghubungi keluarga pasien untuk penyelesaian administrasi dan deposit awal', '18:00:00', 1),
('Menjaga meja depan ICU untuk mengarahkan keluarga pasien yang datang berkunjung', '22:00:00', 2),
('Merekap total biaya sementara pasien ICU untuk laporan harian', '02:00:00', 2),
('Standby pendaftaran admin jika ada pasien rujukan darurat masuk ICU tengah malam', '06:00:00', 2);

INSERT INTO tugas_divisi (id_detail_s, id_divisi) VALUES 
(1, 1), (2, 1), (3, 1), (4, 1), (5, 1), (6, 1),
(7, 2), (8, 2), (9, 2), (10, 2), (11, 2), (12, 2);

INSERT INTO status_bed (nama_status) VALUES 
('Tersedia'), 
('Terpakai');

INSERT INTO bed (nomor_bed, id_st_bed) VALUES 
('BED 01 -- ICU Isolasi Tekanan Negatif', 1), ('BED 02 -- ICU Isolasi Tekanan Negatif', 1), ('BED 03 -- ICU Isolasi Tekanan Negatif', 1), ('BED 04 -- ICU Isolasi Tekanan Negatif', 1), ('BED 05 -- ICU Isolasi Tekanan Negatif', 1),
('BED 06 -- ICU Isolasi Tekanan Positif', 1), ('BED 07 -- ICU Isolasi Tekanan Positif', 1), ('BED 08 -- ICU Isolasi Tekanan Positif', 1), ('BED 09 -- ICU Isolasi Tekanan Positif', 1), ('BED 10 -- ICU Isolasi Tekanan Positif', 1),
('BED 11 -- ICU Isolasi Tekanan Positif', 1), ('BED 12 -- ICU Isolasi Tekanan Positif', 1), ('BED 13 -- ICU Isolasi Tekanan Positif', 1), ('BED 14 -- ICU Isolasi Tekanan Positif', 1), ('BED 15 -- ICU Isolasi Tekanan Positif', 1),
('BED 16 -- ICU Utama', 1), ('BED 17 -- ICU Utama', 1), ('BED 18 -- ICU Utama', 1), ('BED 19 -- ICU Utama', 1), ('BED 20 -- ICU Utama', 1),
('BED 21 -- ICU Utama', 1), ('BED 22 -- ICU Utama', 1), ('BED 23 -- ICU Utama', 1), ('BED 24 -- ICU Utama', 1), ('BED 25 -- ICU Utama', 1),
('BED 26 -- HCU', 1), ('BED 27 -- HCU', 1), ('BED 28 -- HCU', 1), ('BED 29 -- HCU', 1), ('BED 30 -- HCU', 1),
('BED 31 -- HCU', 1), ('BED 32 -- HCU', 1), ('BED 33 -- HCU', 1), ('BED 34 -- HCU', 1), ('BED 35 -- HCU', 1),
('BED 36 -- HCU', 1), ('BED 37 -- HCU', 1), ('BED 38 -- HCU', 1), ('BED 39 -- HCU', 1), ('BED 40 -- HCU', 1);


INSERT INTO status_log (nama_status) VALUES ('Selesai'), ('Belum Selesai');