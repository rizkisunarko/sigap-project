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

create table status_bed (
	id_status int auto_increment primary key,
    status_bed enum('sterilisasi', 'tersedia', 'maintenance', 'diorder', 'rusak'),
    detail_status text
);

create table data_perawat (
	id_perawat int auto_increment primary key,
    nama_lengkap varchar(100),
    id_divisi int,
    foreign key (id_divisi) references divisi_perawat(id_divisi)
);

create table divisi_perawat (
	id_divisi int auto_increment primary key,
    nama_divisi varchar(100),
    id_shift int,
    foreign key (id_shift) references tugas_shift(id_shift)
);

create table tugas_shift (
	id_shift int auto_increment primary key,
    nomor_shift int(1),
    id_detail_s int,
    foreign key (id_detail_s) references detail_tugas_shift(id_detail_s)
);

create table detail_tugas_shift (
	id_detail_s int auto_increment primary key,
    tugas_shift varchar(100),
    tenggat time
);

create table data_diri_pasien (
	id_pasien int auto_increment primary key,
    nama_lengkap varchar(255),
    nik varchar(16),
    asal varchar(255),
    tgl_lahir date,
    jenis_kelamin enum('L', 'P'),
    agama varchar(20),
    status_perkawinan varchar(20),
    alamat text,
    nomor_bpjs varchar(20),
    golongan_darah char(5),
    kewarganegaraan varchar(100),
    pekerjaan varchar(100),
    id_pengguna int,
    foreign key (id_pengguna) references akun_pengguna(id_pengguna)
);

create table alergi_pasien (
	id_ap int auto_increment primary key,
    id_alergi int,
    id_pasien int,
    foreign key (id_pasien) references data_diri_pasien(id_pasien),
    foreign key(id_alergi) references data_alergi(id_alergi)
);

create table data_diri_pengantar (
	id_pengantar int auto_increment primary key,
    nama_lengkap varchar(255),
    status_wali varchar(50),
    nik_wali varchar(16),
    no_hp varchar(15),
    alamat text,
    dokumen_ttd varchar(255),
    id_pasien int,
    foreign key (id_pasien) references data_diri_pasien(id_pasien)
);

create table rujukan (
	id_rujukan int auto_increment primary key,
    dokumen_rujukan varchar(255),
    status_dokumen enum('disetujui', 'ditolak', 'diproses'),
    detail_status text,
    id_pasien int,
    foreign key (id_pasien) references data_diri_pasien(id_pasien)
);

create table rekam_medis (
	id_rekam_medis int auto_increment primary key, 
    id_pasien int,
    tanggal_masuk date,
    tanggal_keluar date,
    urgensi enum('Tingkat 1', 'Tingkat 2', 'Tingkat 3'),
    foreign key (id_pasien) references data_diri_pasien(id_pasien)
);

create table bed (
	id_bed int auto_increment primary key,
    nomor_bed varchar(50),
    id_status int,
    foreign key (id_status) references status_bed(id_status)
);

create table observasi_pasien (
	id_observasi int auto_increment primary key,
    detak_jantung varchar(50),
    oksigen varchar(50),
    suhu_tubuh varchar(50),
    tekanan_darah varchar(50),
    detail_kondisi text,
    kondisi enum('kritis', 'stabil'),
    waktu_catat datetime,
    tindakan text,
    sp02 varchar(50),
    id_perawat int,
    id_rekam_medis int,
    id_bed int,
    diagnosa varchar(100),
    foreign key (id_rekam_medis) references rekam_medis(id_rekam_medis),
    foreign key (id_bed) references bed(id_bed),
    foreign key (id_perawat) references data_perawat(id_perawat)
);

create table log_tugas_shift (
	id_log int auto_increment primary key,
    status_dilakukan enum('sudah', 'belum'),
    tgl_dan_waktu datetime,
    id_detail_s int,
    foreign key (id_detail_s) references detail_tugas_shift(id_detail_s)
);
