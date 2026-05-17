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

        // default
        echo 'Router Berjalan';
    }
}
