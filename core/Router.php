<?php
class Router {
    // Simple router: use controllers to serve views
    public static function run() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = rtrim($uri, '/');

        // project folder name
        $projectDir = basename(dirname(__DIR__));
        $isRoot = $uri === '' || $uri === '/' || $uri === "/$projectDir" || $uri === "/$projectDir/" || basename($uri) === 'public' || basename($uri) === 'index.php';

        if ($isRoot) {
            require_once __DIR__ . '/../app/controllers/HomeController.php';
            $controller = new HomeController();
            $controller->index();
            return;
        }
        
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
        
        if (strpos($uri, '/auth/login') !== false) {
            require_once __DIR__ . '/../app/controllers/AuthController.php';
            $controller = new AuthController();
            $controller->login();
            return;
        }

        if (strpos($uri, '/keluarga/dashboard') !== false) {
            require_once __DIR__ . '/../app/controllers/KeluargaController.php';
            $controller = new KeluargaController();
            $controller->dashboard();
            return;
        }

        // default
        echo 'Router Berjalan: Halaman tidak ditemukan (404)';
    }
}
