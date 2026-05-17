<?php
// Front controller at project root to serve the app from /public
// This makes http://localhost/sigap-project/ load the same application as /public/

// Prevent direct directory listing
if (php_sapi_name() !== 'cli') {
    // Delegate to public/index.php
    require_once __DIR__ . '/public/index.php';
}
