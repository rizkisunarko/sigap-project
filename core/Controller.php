<?php
class Controller {
    // Base class untuk semua controller
    public function view($name, $data = []) { require_once __DIR__ . '/../app/views/' . $name . '.php'; }
}
