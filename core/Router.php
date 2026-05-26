<?php
class Router {
    // Simple router: use controllers to serve views
    public static function run() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = rtrim($uri, '/');

        // project folder name
        $projectDir = basename(dirname(__DIR__));
        $isRoot = $uri === '' || $uri === '/' || $uri === "/$projectDir" || $uri === "/$projectDir/" || basename($uri) === 'public' || basename($uri) === 'index.php';


        // 0. HOME / BERANDA
        if ($isRoot) {
            require_once __DIR__ . '/../app/controllers/HomeController.php';
            $controller = new HomeController();
            $controller->index();
            return;
        }
        
        // 1. PENDAFTARAN CONTROLLER
        if (strpos($uri, '/pendaftaran/pilih-jalur') !== false) {
            require_once __DIR__ . '/../app/controllers/PendaftaranController.php';
            $controller = new PendaftaranController();
            $controller->pilihJalur();
            return;
        }
        
        if (strpos($uri, '/pendaftaran/form') !== false) {
            require_once __DIR__ . '/../app/controllers/PendaftaranController.php';
            $controller = new PendaftaranController();
            $controller->form();
            return;
        }
        
        // Handle form submission (signature upload)
        if (strpos($uri, '/pendaftaran/submit') !== false) {
            require_once __DIR__ . '/../app/controllers/PendaftaranController.php';
            $controller = new PendaftaranController();
            $controller->submit();
            return;
        }
        
        // 2. AUTHENTICATION CONTROLLER (LOGIN)
        if (strpos($uri, '/auth/login') !== false) {
            require_once __DIR__ . '/../app/controllers/AuthController.php';
            $controller = new AuthController();
            $controller->login();
            return;
        }

        // RUTE BARU: Menangani proses submit login
        if (strpos($uri, '/auth/proses-login') !== false) {
            require_once __DIR__ . '/../app/controllers/AuthController.php';
            $controller = new AuthController();
            $controller->prosesLogin();
            return;
        }

        // 3. KELUARGA CONTROLLER (DASHBOARD PASIEN)
        if (strpos($uri, '/keluarga/dashboard') !== false) {
            require_once __DIR__ . '/../app/controllers/KeluargaController.php';
            $controller = new KeluargaController();
            $controller->dashboard();
            return;
        }

        // 4. PORTAL STAFF / PERAWAT (DIRECT VIEW BYPASS)
        // Hidden route for Perawat/Staff
        if (strpos($uri, '/portal-staff/login') !== false) {
            $view = __DIR__ . '/../app/views/portal-staff/login.php';
            if (file_exists($view)) {
                require $view;
                return;
            }
        }

        if (strpos($uri, '/perawat/dashboard') !== false) {
            $view = __DIR__ . '/../app/views/perawat/dashboard.php';
            if (file_exists($view)) {
                require $view;
                return;
            }
        }

        if (strpos($uri, '/perawat/input_data_pasien') !== false) {
            $view = __DIR__ . '/../app/views/perawat/input_data_pasien.php';
            if (file_exists($view)) {
                require $view;
                return;
            }
        }

        if (strpos($uri, '/perawat/tambah_pasien') !== false) {
            $view = __DIR__ . '/../app/views/perawat/tambah_pasien.php';
            if (file_exists($view)) {
                require $view;
                return;
            }
        }

        if (strpos($uri, '/perawat/direktori_pengguna') !== false) {
            $view = __DIR__ . '/../app/views/perawat/direktori_pengguna.php';
            if (file_exists($view)) {
                require $view;
                return;
            }
        }

        // Rute untuk menampilkan form (testBot.php)
        if (strpos($uri, '/perawat/testbot') !== false) {
            $view = __DIR__ . '/../app/views/perawat/testBot.php';
            if (file_exists($view)) {
                require $view;
                return;
            }
        }

        // 5. REKAM MEDIS CONTROLLER
        // Rute untuk memproses data dari form (Submit)
        if (strpos($uri, '/rekammedis/simpan') !== false) {
            require_once __DIR__ . '/../app/controllers/RekamMedisController.php';
            $controller = new RekamMedisController();
            $controller->simpanRekamMedis();
            return;
        }


        // DEFAULT: 404 NOT FOUND
        echo 'Router Berjalan: Halaman tidak ditemukan (404)';
    }
}