<?php
class Router {
    // Simple router: serve landing view for root, otherwise fallback text
    public static function run() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = rtrim($uri, '/');

        // project folder name
        $projectDir = basename(dirname(__DIR__));
        $isRoot = $uri === '' || $uri === '/' || $uri === "/$projectDir" || $uri === "/$projectDir/" || basename($uri) === 'public' || basename($uri) === 'index.php';

        if ($isRoot) {
            $view = __DIR__ . '/../app/views/landing.php';
            if (file_exists($view)) {
                require $view;
                return;
            }
            echo 'Landing page tidak ditemukan.';
            return;
        }
        if (strpos($uri, '/pendaftaran/pilih-jalur') !== false) {
            $view = __DIR__ . '/../app/views/pendaftaran/pilih_jalur.php';
            if (file_exists($view)) {
                require $view;
                return;
            }
        }
        
        if (strpos($uri, '/pendaftaran/form') !== false) {
            $view = __DIR__ . '/../app/views/pendaftaran/form.php';
            if (file_exists($view)) {
                require $view;
                return;
            }
        }
        if (strpos($uri, '/auth/login') !== false) {
            $view = __DIR__ . '/../app/views/auth/login.php';
            if (file_exists($view)) {
                require $view;
                return;
            }
        }

        if (strpos($uri, '/keluarga/dashboard') !== false) {
            $view = __DIR__ . '/../app/views/keluarga/dashboard.php';
            if (file_exists($view)) {
                require $view;
                return;
            }
        }

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

        // default
        echo 'Router Berjalan';
    }
}
