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

create table status_rujukan (
	id_st_rujukan int auto_increment primary key,
    nama_status varchar(50)
);

create table rujukan (
	id_rujukan int auto_increment primary key,
    dokumen_rujukan varchar(255),
    detail_status text,
    id_pasien int,
    id_st_rujukan int,
    foreign key (id_pasien) references data_diri_pasien(id_pasien),
    foreign key (id_st_rujukan) references status_rujukan(id_st_rujukan)
);

create table urgensi (
	id_urgensi int auto_increment primary key,
    nama_urgensi varchar(50)
);

create table rekam_medis (
	id_rekam_medis int auto_increment primary key, 
    id_pasien int,
    tanggal_masuk date,
    tanggal_keluar date,
    id_urgensi int,
    foreign key (id_pasien) references data_diri_pasien(id_pasien),
    foreign key (id_urgensi) references urgensi(id_urgensi)
);

create table status_bed (
	id_st_bed int auto_increment primary key,
    nama_status varchar(50),
    detail_status text
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