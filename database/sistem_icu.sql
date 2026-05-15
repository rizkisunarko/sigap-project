-- Struktur tabel awal database
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    role ENUM('perawat', 'keluarga')
);
