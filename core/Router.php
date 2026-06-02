<?php
class Router {
    private static $routes = [];

    public static function get($path, $handler) {
        self::add('GET', $path, $handler);
    }

    public static function post($path, $handler) {
        self::add('POST', $path, $handler);
    }

    public static function add($method, $path, $handler) {
        self::$routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public static function run() {
        require_once __DIR__ . '/../routes/web.php';

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        $scriptName = dirname($_SERVER['SCRIPT_NAME']); // e.g. /sigap-project/public atau /sigap-project
        
        $basePath = rtrim($scriptName, '/');
        if ($basePath !== '' && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }

        $projectDir = basename(dirname(__DIR__));
        if (strpos($uri, '/' . $projectDir) === 0) {
            $uri = substr($uri, strlen('/' . $projectDir));
        }
        
        $uri = '/' . trim($uri, '/');
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if ($uri === '/portal-staff/login') {
            http_response_code(404); 
            exit; 
        }

        foreach (self::$routes as $route) {
            $routePath = '/' . trim($route['path'], '/');
            if ($route['method'] === $requestMethod && $routePath === $uri) {
                self::dispatch($route['handler']);
                return;
            }
        }

        if ($uri === '/' || $uri === '/index.php') {
            self::dispatch('HomeController@index');
            return;
        }

        http_response_code(404);
        $errorView = __DIR__ . '/../app/views/errors/404.php';
        if (file_exists($errorView)) {
            require_once $errorView;
        } else {
            echo 'Router Berjalan: Halaman tidak ditemukan (404)';
        }
    }

    private static function dispatch($handler) {
        list($controllerName, $method) = explode('@', $handler);
        
        $controllerFile = __DIR__ . '/../app/controllers/' . $controllerName . '.php';
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            if (class_exists($controllerName)) {
                $controller = new $controllerName();
                if (method_exists($controller, $method)) {
                    $controller->$method();
                    return;
                }
            }
        }
        
        http_response_code(500);
        echo "Error: Handler $handler tidak dapat diproses. Pastikan file Controller dan Method sudah ada.";
    }
}