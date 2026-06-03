<?php

$scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$scriptDir = str_replace('\\', '/', dirname($scriptName));
$scriptDir = rtrim($scriptDir, '/');


$scriptFilename = str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME'] ?? '');
$isRootScript = (basename($scriptFilename) === 'index.php' && strpos($scriptFilename, '/public/') === false);

if ($isRootScript) {
    $basePath = $scriptDir . '/public';
} else {
    $basePath = $scriptDir;
}

$baseUrl = $scheme . '://' . $host . $basePath;
define('BASEURL', rtrim($baseUrl, '/'));
