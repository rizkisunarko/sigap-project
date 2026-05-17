<?php
class Router {
    // Mengatur rute URL aplikasi -- sangat sederhana: jika root diakses, tampilkan landing view
    public static function run() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = rtrim($uri, '/');
        // Jika pengguna membuka root situs, tampilkan landing page
        $projectDir = basename(dirname(__DIR__)); // e.g. 'sigap-project'
        $isRoot = $uri === '' || $uri === '/' || $uri === "/$projectDir" || $uri === "/$projectDir/" || basename($uri) === 'public' || basename($uri) === 'index.php';
        if ($isRoot) {
            // gunakan view MVC di app/views/landing.php
            $view = __DIR__ . '/../app/views/landing.php';
            if (file_exists($view)) {
                require $view;
                return;
            }
            echo "Landing page tidak ditemukan.";
            return;
        }

        // default fallback
        echo 'Router Berjalan';
    }
}
